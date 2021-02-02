<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class TipsTrickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tips = Article::type('tips')->status('published')->orderBy('published_at', 'desc')->paginate(12);

        $currents = ['artikel', 'tips'];

        return view('web.tips', compact('tips', 'currents'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $tips = Article::type('tips')->slug($slug)->status('published')->first();

        if (!$tips) {
            return abort(404);
        }

        $related = Article::type('tips')
                    ->status('published')
                    ->where('id', '<>', $tips->id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        $currents = ['artikel', 'tips'];

        return view('web.tips-detail', compact('tips', 'related', 'currents'));
    }
}
