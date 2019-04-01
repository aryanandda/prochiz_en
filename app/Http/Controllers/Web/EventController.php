<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::slug($slug)->status('published')->first();

        if (!$event) {
            return abort(404);
        }

        $recipes = $event->recipes()
                    ->type('prochizlover')
                    ->status('approved')
                    ->with('user', 'category')
                    ->orderBy('published_at', 'desc')
                    ->limit(4)
                    ->get();

        return view('web.event-detail', compact('event', 'recipes', 'slug'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function recipes($slug)
    {
        $event = Event::slug($slug)->status('published')->first();

        if (!$event) {
            return abort(404);
        }

        $recipes = $event->recipes()
                    ->type('prochizlover')
                    ->status('approved')
                    ->with('user', 'category')
                    ->orderBy('published_at', 'desc')
                    ->paginate(12);

        $currents = ['resep'];

        return view('web.event-recipes', compact('event', 'recipes', 'slug', 'currents'));
    }
}
