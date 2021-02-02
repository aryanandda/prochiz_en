<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PartnerCategory;
use App\Models\Partner;
use App\Models\Banner;
use Auth;

class KulinerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::status('approved')->orderBy('name', 'asc')->paginate(12);
        $categories = PartnerCategory::orderBy('name', 'asc')->whereHas('partners', function ($query) {
            $query->where('status', 'approved');
        })->get();
        $banner = Banner::name('kuliner')->status('published')->first();

        $currents = ['kuliner-all', 'kuliner'];

        return view('web.kuliner', compact('partners', 'currents', 'categories', 'banner'));
    }

    /**
     * Display a listing of the resource for the specified category.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function category($slug)
    {
        $category = PartnerCategory::slug($slug)->first();

        if (!$category) {
            return abort(404);
        }

        $partners = $category->partners()->status('approved')->orderBy('name', 'asc')->paginate(12);
        $categories = PartnerCategory::orderBy('name', 'asc')->whereHas('partners', function ($query) {
            $query->where('status', 'approved');
        })->get();

        $currents = ['kuliner'];

        return view('web.kuliner-category', compact('category', 'partners', 'currents', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
        $partner = Partner::slug($slug)->where('id', $id)->first();

        if (!Auth::check() || Auth::id() != $partner->user_id) {
            $partner = ($partner->status == 'approved') ? $partner : false;
        }

        if (!$partner) {
            return abort(404);
        }

        $categories = PartnerCategory::orderBy('name', 'asc')->whereHas('partners', function ($query) {
            $query->where('status', 'approved');
        })->get();

        $galleries = $partner->galleries()->orderBy('id', 'desc')->get();

        $currents = ['kuliner'];

        return view('web.kuliner-detail', compact('partner', 'currents', 'categories', 'galleries'));
    }
}
