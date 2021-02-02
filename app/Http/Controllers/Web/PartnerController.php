<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PartnerStatus;
use App\Models\PartnerCategory;
use App\Models\Partner;
use Image;
use Auth;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $partners = $user->partners()->orderBy('name', 'asc')->paginate(12);

        if ($partners->count() <= 0) {
            return redirect('/partner');
        }

        return view('web.user-partner', compact('partners'));
    }

    /**
     * Display a landing page of partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function landing()
    {
        $currents = ['kuliner-all', 'partner'];

        return view('web.partner', compact('currents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currents = ['kuliner-all', 'partner'];

        $user = Auth::user();
        $categories = PartnerCategory::orderBy('name', 'asc')->get();

        $success = session()->get('success');

        return view('web.partner-register', compact('currents', 'user', 'success', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'description' => 'required',
            'hours' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'image' => 'image',
        ];

        $messages = [
            'required' => 'Harus diisi.',
            'image' => 'Jenis file harus berupa gambar.',
            'email' => 'Format email salah.',
        ];

        $this->validate($request, $rules, $messages);

        $partner = new Partner;
        $partner->user_id = $user->id;
        $partner->name = $request->input('name');
        $partner->slug = preg_replace('/[^a-z0-9]/i', '-', strtolower($request->input('name')));
        $partner->description = $request->input('description');
        $partner->metadesc = $request->input('description');
        $partner->address = $request->input('address');
        $partner->city = $request->input('city');
        $partner->hours = $request->input('hours');
        $partner->email = $request->input('email');
        $partner->phone = $request->input('phone');
        $partner->website = $request->input('website');
        $partner->instagram = $request->input('instagram');
        $partner->facebook = $request->input('facebook');
        $partner->status = 'pending';

        if ($request->hasFile('image')) {
            $partner->image = $partner->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partner->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partner->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partner->image));
        }

        $partner->save();

        $partner->categories()->sync($request->input('categories'));

        $user->notify(new PartnerStatus($user, $partner));

        session()->flash('success', 'Terima kasih sudah mendaftar sebagai partner.');

        return redirect('/partner/register');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $partner = $user->partners()->where('id', $id)->first();

        if (!$partner) {
            return redirect('/my-account/kuliner');
        }

        $categories = PartnerCategory::orderBy('name', 'asc')->get();

        $success = session()->get('success');
        $partner_categories = $partner->categories()->pluck('partner_categories.id')->toArray();

        return view('web.partner-edit', compact('partner', 'success', 'categories', 'partner_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'description' => 'required',
            'hours' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'image' => 'image',
        ];

        $messages = [
            'required' => 'Harus diisi.',
            'image' => 'Jenis file harus berupa gambar.',
            'email' => 'Format email salah.',
        ];

        $this->validate($request, $rules, $messages);

        $partner = $user->partners()->where('id', $id)->first();

        if (!$partner) {
            return redirect('/my-account/kuliner');
        }

        $partner->name = $request->input('name');
        $partner->description = $request->input('description');
        $partner->metadesc = $request->input('description');
        $partner->address = $request->input('address');
        $partner->city = $request->input('city');
        $partner->hours = $request->input('hours');
        $partner->email = $request->input('email');
        $partner->phone = $request->input('phone');
        $partner->website = $request->input('website');
        $partner->instagram = $request->input('instagram');
        $partner->facebook = $request->input('facebook');

        if ($request->hasFile('image')) {
            $partner->image = $partner->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partner->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partner->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partner->image));
        }

        $partner->save();

        $partner->categories()->sync($request->input('categories'));

        session()->flash('success', 'Kuliner telah diedit.');

        return redirect('/my-account/kuliner/'.$id);
    }
}
