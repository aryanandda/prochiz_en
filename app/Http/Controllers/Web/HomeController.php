<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Recipe;
use App\Models\Event;
use App\Models\Banner;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prochiz_recipes = Recipe::type('prochiz')->status('published')->orderBy('published_at', 'desc')->limit(4)->get();

        $event = Event::status('published')->orderBy('created_at', 'desc')->first();
        if ($event) {
            $prochizlover_recipes = $event->recipes()->type('prochizlover')->status('approved')->with('user', 'category')->orderBy('published_at', 'desc')->limit(4)->get();
            $prochizlover_recipes_title = strtoupper('Resep '.$event->name);
            $prochizlover_recipes_link = url('/event/'.$event->slug.'/resep');
        }else {
            $prochizlover_recipes = Recipe::type('prochizlover')->status('approved')->with('user', 'category')->orderBy('published_at', 'desc')->limit(4)->get();
            $prochizlover_recipes_title = strtoupper('Resep Prochizlovers');
            $prochizlover_recipes_link = url('/resep/prochizlover');
        }

        $tips = Article::type('tips')->status('published')->orderBy('published_at', 'desc')->limit(2)->get();
        $news = Article::type('news')->status('published')->orderBy('published_at', 'desc')->limit(2)->get();
        $videos = Article::type('video')->status('published')->orderBy('published_at', 'desc')->limit(2)->get();

        $sliders = Banner::where('name', 'like', 'slider-%')->status('published')->orderBy('name', 'asc')->get();
        $homebanner = Banner::name('home-banner')->status('published')->first();

        $footer_text = Article::type('footertext')->slug('home')->status('published')->orderBy('published_at', 'desc')->first();

        $currents = ['home'];

        return view('web.index', compact('prochiz_recipes', 'prochizlover_recipes', 'prochizlover_recipes_title', 'prochizlover_recipes_link', 'tips', 'news', 'videos', 'currents', 'sliders', 'footer_text', 'homebanner'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $s = $request->input('s');

        $recipes = Recipe::whereIn('status', ['published', 'approved'])
                    ->where(function ($query) use ($s) {
                        $query->orWhere('name', 'like', '%'.$s.'%')
                            ->orWhere('metadesc', 'like', '%'.$s.'%')
                            ->orWhere('description', 'like', '%'.$s.'%');
                    })
                    ->with('user', 'category')
                    ->orderBy('published_at', 'desc')
                    ->paginate(12);

        $recipes->appends(['s' => $s]);

        $currents = ['resep'];

        return view('web.recipe-search', compact('recipes', 's', 'currents'));
    }
        
}
