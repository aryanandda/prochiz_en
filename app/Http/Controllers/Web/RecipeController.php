<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\RecipeStatus;
use App\Models\RecipeIngredient;
use App\Models\RecipeDirection;
use App\Models\RecipeCategory;
use App\Models\Recipe;
use App\Models\Event;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Article;
use Image;
use Auth;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $status = ($type == 'prochiz') ? 'published' : 'approved';

        $recipes = Recipe::type($type)
                    ->status($status)
                    ->with('user', 'category')
                    ->orderBy('published_at', 'desc')
                    ->paginate(12);

        $categories = RecipeCategory::orderBy('id', 'asc')->get();

        $banner = Banner::name('resep-'.$type.'-all')->status('published')->first();

        if ($recipes->currentPage() === 1) {
            $footer_text = Article::type('footertext')->slug($type.'-all')->status('published')->orderBy('published_at', 'desc')->first();
        }

        $currents = ['resep', $type];

        return view('web.recipe', compact('recipes', 'type', 'categories', 'currents', 'banner', 'footer_text'));
    }

    /**
     * Display a listing of the resource for the specified category.
     *
     * @param  string  $type
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function category($type, $slug)
    {
        $status = ($type == 'prochiz') ? 'published' : 'approved';

        $category = RecipeCategory::slug($slug)->first();
        $categories = RecipeCategory::orderBy('id', 'asc')->get();

        if (!$category) {
            return abort(404);
        }

        $recipes = $category->recipes()
                            ->type($type)
                            ->status($status)
                            ->with('user', 'category')
                            ->orderBy('published_at', 'desc')
                            ->paginate(12);

        $banner = Banner::name('resep-'.$type.'-'.$slug)->status('published')->first();

        if ($recipes->currentPage() === 1) {
            $footer_text = Article::type('footertext')->slug($type.'-'.$slug)->status('published')->orderBy('published_at', 'desc')->first();
        }

        $currents = ['resep', $type];

        return view('web.recipe-category', compact('category', 'recipes', 'type', 'slug', 'categories', 'currents', 'banner', 'footer_text'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $type
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id, $slug)
    {
        $status = ($type == 'prochiz') ? 'published' : 'approved';
        $recipe = Recipe::type($type)->slug($slug)->where('id', $id)->first();

        if (!Auth::check() || Auth::id() != $recipe->user_id) {
            $recipe = ($recipe->status == $status) ? $recipe : false;
        }

        if (!$recipe) {
            return abort(404);
        }

        $related = Recipe::type($type)
                    ->status($status)
                    ->where('recipe_category_id', $recipe->recipe_category_id)
                    ->where('id', '<>', $recipe->id)
                    ->with('user', 'category')
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        $currents = ['resep', $type];

        return view('web.recipe-detail', compact('recipe', 'related', 'type', 'currents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** /
        if (!Auth::check()) {
            $redirect = url('/upload-resep');

            return view('web.recipe-upload-login', compact('redirect'));
        }
        /**/

        $success = session()->get('success');
        $categories = RecipeCategory::orderBy('id', 'asc')->get();
        $products = Product::status('published')->orderBy('id', 'asc')->get();
        $event = Event::status('published')->orderBy('created_at', 'desc')->first();
        $user = Auth::user();

        return view('web.recipe-upload', compact('categories', 'success', 'products', 'event', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** / 
        if (!Auth::check()) {
            $redirect = url('/upload-resep');

            return view('web.recipe-upload-login', compact('redirect'));
        }
        /**/

        $user = Auth::user();

        $rules = [
            'image' => 'required|image',
            'name' => 'required',
            'category' => 'required',
            'product' => 'required',
            'ktp' => 'required',
        ];

        $messages = [
            'required' => 'Harus diisi.',
            'image' => 'Jenis file harus berupa gambar.',
        ];

        $this->validate($request, $rules, $messages);

        $recipe = new Recipe;
        $recipe->user_id = $user->id;
        $recipe->recipe_category_id = $request->input('category');
        $recipe->event_id = $request->input('event');
        $recipe->name = $request->input('name');
        $recipe->slug = preg_replace('/[^a-z0-9]/i', '-', strtolower($request->input('name')));
        $recipe->metadesc = $request->input('description');
        $recipe->description = $request->input('description');
        $recipe->type = 'prochizlover';
        $recipe->status = 'pending';
        $recipe->published_at = date('Y-m-d H:i:s');

        $check = Recipe::type('prochizlover')->slug($recipe->slug)->count();
        if($check > 0)
            $recipe->slug = $recipe->slug.'-'.($check+1);

        if ($request->hasFile('image')) {
            $recipe->image = $recipe->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/img/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$recipe->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$recipe->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$recipe->image));
        }

        $recipe->save();

        $ingredients = [];
        $ingredient_names = $request->input('ingredient-name');
        $ingredient_amounts = $request->input('ingredient-amount');

        foreach ($ingredient_names as $key => $value) {
            if ($value) {
                $ingredients[] = new RecipeIngredient(['name' => $value, 'amount' => $ingredient_amounts[$key]]);
            }
        }

        $directions = [];
        foreach ($request->input('direction-name') as $key => $value) {
            if ($value) {
                $directions[] = new RecipeDirection(['name' => $value]);
            }
        }

        $recipe->directions()->saveMany($directions);
        $recipe->ingredients()->saveMany($ingredients);

        $recipe->products()->sync($request->input('product'));

        $user->ktp = $request->input('ktp');
        $user->save();

        $user->notify(new RecipeStatus($user, $recipe));

        session()->flash('success', 'Terima kasih sudah mengupload resep Anda.');

        return redirect('/upload-resep');
    }
}
