<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PartnerGallery;
use Image;
use Auth;

class PartnerGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $partner = $user->partners()->where('id', $id)->first();

        if (!$partner) {
            return redirect('/my-account/kuliner');
        }

        $success = session()->get('success');

        $galleries = $partner->galleries()->orderBy('id', 'desc')->paginate(48);

        return view('web.partner-gallery', compact('galleries', 'partner', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $rules = [
            'image' => 'image',
        ];

        $messages = [
            'image' => 'Jenis file harus berupa gambar.',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('image')) {
            $gallery = new PartnerGallery;
            $gallery->partner_id = $id;

            $gallery->image = md5(time()).'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$gallery->image));
            Image::make($request->file('image'))->fit(300,300)->save(storage_path($storage_path.'/square/'.$gallery->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$gallery->image));

            $gallery->save();
        }

        session()->flash('success', 'Galeri sudah ditambahkan.');

        return redirect('/my-account/kuliner/'.$id.'/galeri');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $gallery_id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $gallery_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  int  $gallery_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $gallery_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $gallery_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $gallery_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $gallery_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $gallery_id)
    {
        $user = Auth::user();
        $partner = $user->partners()->where('id', $id)->first();

        if (!$partner) {
            return redirect('/my-account/kuliner');
        }

        $gallery = $partner->galleries()->where('id', $gallery_id)->first();

        if (!$gallery) {
            return redirect('/my-account/kuliner/'.$id.'/galeri');
        }

        $gallery->delete();

        session()->flash('success', 'Galeri telah dihapus.');

        return redirect('/my-account/kuliner/'.$id.'/galeri');
    }
}
