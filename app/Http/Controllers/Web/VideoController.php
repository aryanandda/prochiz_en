<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Article::type('video')->status('published')->orderBy('published_at', 'desc')->paginate(12);

        $currents = ['video'];

        return view('web.video', compact('videos', 'currents'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $video = Article::type('video')->slug($slug)->status('published')->first();

        if (!$video) {
            return abort(404);
        }

        $related = Article::type('video')
                    ->status('published')
                    ->where('id', '<>', $video->id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        $currents = ['video'];

        return view('web.video-detail', compact('video', 'related', 'currents'));
    }
}
