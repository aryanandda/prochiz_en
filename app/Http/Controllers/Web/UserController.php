<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Validator;
use Image;
use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Show the form for editing the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::status('published')->orderBy('id', 'asc')->get();
        $success = session()->get('success');

        return view('web.user', compact('user', 'products', 'success'));
    }

    /**
     * Show the user's recipes.
     *
     * @return \Illuminate\Http\Response
     */
    public function recipe()
    {
        $user = Auth::user();
        $recipes = $user->recipes()
                        ->type('prochizlover')
                        ->orderBy('published_at', 'desc')
                        ->paginate(12);

        return view('web.user-recipe', compact('recipes'));
    }

    /**
     * Update the user profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'image' => 'image',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'job' => 'required',
            'hobby' => 'required',
            'product_id' => 'required',
            'ktp' => 'required',
        ];

        $messages = [
            'required' => 'Harus diisi.',
            'image' => 'Jenis file harus berupa gambar.',
            'unique' => 'Email sudah dipakai.',
            'email' => 'Format email salah.',
        ];

        $this->validate($request, $rules, $messages);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->birthday = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->job = $request->input('job');
        $user->hobby = $request->input('hobby');
        $user->product_id = $request->input('product_id');
        $user->ktp = $request->input('ktp');

        if ($request->hasFile('image')) {
            $user->image = md5($user->email).'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = 'app/public/users';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$user->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$user->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$user->image));
        }

        $user->save();

        session()->flash('success', 'Profil telah diubah.');

        return redirect('/my-account');
    }

    /**
     * Show the form for editing the user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $user = Auth::user();

        $success = session()->get('success');
        
        return view('web.user-password', compact('user', 'success'));
    }

    /**
     * Update the user password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|min:6|same:new_password',
        ];

        $messages = [
            'required' => 'Harus diisi.',
            'min' => 'Minimal 6 karakter.',
            'new_password_confirmation.same' => 'Tidak sama dengan Password Baru.',
        ];

        if ($user->password) {
            Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) use ($user) {
                return Hash::check($value, $user->password);
            });

            $rules['old_password'] = 'required|old_password';
            $messages['old_password'] = 'Password Lama salah.';
        }

        $this->validate($request, $rules, $messages);

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        session()->flash('success', 'Password telah diubah.');

        return redirect('/my-account/password');
    }

}
