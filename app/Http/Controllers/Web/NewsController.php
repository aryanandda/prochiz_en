<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Article::type('news')->status('published')->orderBy('published_at', 'desc')->paginate(12);
        $banner = Banner::name('news')->status('published')->first();

        $currents = ['artikel', 'news'];

        return view('web.news', compact('news', 'currents', 'banner'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $news = Article::type('news')->slug($slug)->status('published')->first();

        if (!$news) {
            return abort(404);
        }

        $related = Article::type('news')
                    ->status('published')
                    ->where('id', '<>', $news->id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        $currents = ['artikel', 'news'];

        return view('web.news-detail', compact('news', 'related', 'currents'));
    }
}
