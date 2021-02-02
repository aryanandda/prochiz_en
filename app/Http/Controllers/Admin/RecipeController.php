<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeDirection;
use App\Models\RecipeCategory;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class RecipeController extends Controller
{
    public $type = null;

    public function __construct()
    {
        $this->type = 'prochiz';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.recipe.index')
        ->with('model', 'Recipe')
        ->with('type', $this->type)
        ->with('empty_link', action('Admin\RecipeController@emptyTrash'))
        ->with('index_link', action('Admin\RecipeController@index'))
        ->with('api_link', action('Admin\RecipeController@api'))
        ->with('create_link', action('Admin\RecipeController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.recipe.create')
        ->with('model', 'Recipe')
        ->with('store_link', action('Admin\RecipeController@store'))
        ->with('index_link', action('Admin\RecipeController@index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'published_at' => 'required|date',
            'category' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\RecipeController@create')->withErrors($validator)->withInput();

        $recipe = new Recipe;
        $recipe->recipe_category_id = $request->input('category');
        $recipe->type = "prochiz";
        $recipe->name = $request->input('name');
        $recipe->slug = $request->input('slug');
        $recipe->metadesc = $request->input('metadesc');
        $recipe->status = $request->input('status');
        $recipe->time = $request->input('time');
        $recipe->servings = $request->input('servings');
        $recipe->description = $request->input('description');
        $recipe->chef = $request->input('chef');

        $check = Recipe::type('prochiz')->where('slug', '=', $request->input('slug'))->count();
        if($check>0)
            $recipe->slug = $recipe->slug."-".($check+1);
        
        $recipe->published_at = date('Y-m-d H:i:s', strtotime($request->input('published_at')));

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

        return redirect()->action('Admin\RecipeController@edit', [$recipe->id])->withMessages('Your Recipe has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);
        return view('admin.recipe.update')
        ->with('recipe', $recipe)
        ->with('model', 'Recipe')
        ->with('update_link', action('Admin\RecipeController@update', [$id]))
        ->with('index_link', action('Admin\RecipeController@index'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'published_at' => 'required|date',
            'category' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\RecipeController@edit', [$id])->withErrors($validator)->withInput();

        $recipe = Recipe::find($id);
        $recipe->recipe_category_id = $request->input('category');
        $recipe->name = $request->input('name');
        $recipe->slug = $request->input('slug');
        $recipe->metadesc = $request->input('metadesc');
        $recipe->status = $request->input('status');
        $recipe->time = $request->input('time');
        $recipe->servings = $request->input('servings');
        $recipe->description = $request->input('description');
        $recipe->chef = $request->input('chef');

        $check = Recipe::type('prochiz')->where('slug', '=', $request->input('slug'))->where('id', '<>', $id)->count();
        if($check>0)
            $recipe->slug = $recipe->slug."-".($check+1);

        $recipe->published_at = date('Y-m-d H:i:s', strtotime($request->input('published_at')));

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$recipe->image));
            File::delete(storage_path($storage_path.'/square/'.$recipe->image));
            File::delete(storage_path($storage_path.'/small/'.$recipe->image));

            $recipe->image = $recipe->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$recipe->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$recipe->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$recipe->image));
        }

        $recipe->save();

        $recipe->directions()->delete();
        $recipe->ingredients()->delete();

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

        return redirect()->action('Admin\RecipeController@edit', [$recipe->id])->withMessages('Your Recipe has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Recipe::destroy($id);

        $response['status'] = '200';
        return response()->json($response);
    }

    /**
     * Empty the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function emptyTrash()
    {
        $storage_path = '/app/public/img/';
        $reciped = Recipe::onlyTrashed()->where('type', '=', $this->type)->get();

        foreach ($reciped as $recipe) {
            File::delete(storage_path($storage_path.'/'.$recipe->image));
            File::delete(storage_path($storage_path.'/square/'.$recipe->image));
            File::delete(storage_path($storage_path.'/small/'.$recipe->image));
        }

        Recipe::onlyTrashed()->where('type', '=', $this->type)->forceDelete();

        $response['status'] = '200';
        return response()->json($response);
    }

    /**
     * Restore remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreTrash($id)
    {        
        Recipe::where('id', '=', $id)->restore();

        $response['status'] = '200';
        return response()->json($response);
    }


    /**
     * API for DataTable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function api(Request $request)
    {
        $srch       = $request->input('search');
        $search     = $srch['value'];

        $ord        = $request->input('order');
        $order      = $ord[0]['column'];
        $by         = $ord[0]['dir'];

        if($request->input('draw')==1){
            $search = null;
        }

        $col = [
            'recipes.name',
            'recipes.name',
            'recipes.chef',
            'recipes.recipe_category_id',
            'recipes.published_at',
            'recipes.status',
        ];
        
        $raw = DB::table('recipes')
            ->select(DB::raw(
                'recipes.id,'.
                'recipes.recipe_category_id,'.
                'recipes.published_at,'.
                'recipes.slug,'.
                'recipes.image,'.
                'recipes.name,'.
                'recipes.status,'.
                'recipes.description,'.
                'recipes.metadesc,'.
                'recipes.chef'
            ));

        $hv = [];

        if(!empty($search)){
            $i = 0;
            foreach ($col as $val) {
                if(!in_array($i, $hv)){
                    if($i==0)
                        $raw = $raw->whereRaw($val." like '%".$search."%'");
                    else
                        $raw = $raw->orWhereRaw($val." like '%".$search."%'");
                    $i++;
                }
            }
        }

        if($request->input('status')!='all'){
            if($request->input('status') == 'published'){
                $raw = $raw->where('status', '=', 'published');
            }
            else{
                $raw = $raw->where('status', '=', 'draft');
            }
        }

        if($request->input('product')>0){
            $ids = DB::table('product_recipe')->where('product_id', '=', $request->input('product'))->pluck('recipe_id');
            $raw = $raw->whereIn('recipes.id', $ids);
        }

        if($request->input('category')>0){
            $raw = $raw->where('recipe_category_id', '=', $request->input('category'));
        }


        if($request->input('type')=='prochiz')
            $raw = $raw->where('type', '=', 'prochiz');
        else
            $raw = $raw->where('type', '=', 'prochizlover');

        if($request->input('trashed')=='all')
            $raw = $raw->whereNull('deleted_at');
        else
            $raw = $raw->whereNotNull('deleted_at');

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('recipes')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            $rec = Recipe::withTrashed()->find($r->id);
            $rec_cat = RecipeCategory::find($r->recipe_category_id);
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/img/'.$r->image).'"><img src="'.asset('storage/img/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $prod = '';
            if($rec->products){
                foreach ($rec->products as $product) {
                    $prod = $prod.'<span class="tag tag-outline tag-default"><a href="'.action('Admin\ProductController@edit', [$product->id]).'">'.$product->name.'</a></span> ';
                }
            }

            $data['data'][$x][] =  '<a class="article-title" href="'.action('Admin\RecipeController@edit', [$r->id]).'">'.$r->name.'</a><br>'.
            '<span class="tag tag-default">'.$r->slug.'</span><p class="article-desc">'.$r->metadesc.'</p>'.$prod;

            $data['data'][$x][] = ($r->chef) ? $r->chef : 'Prochiz';

            $data['data'][$x][] = $rec_cat->name;
            $data['data'][$x][] =  date('d-m-Y', strtotime($r->published_at));
            if($r->status=='published')
                $data['data'][$x][] =  '<span class="tag tag-outline tag-success">Published</span>';
            else
                $data['data'][$x][] =  '<span class="tag tag-outline tag-default">Draft</span>';

            if($request->input('trashed')=='all'){
                $data['data'][$x][] =  
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\RecipeController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\RecipeController@destroy', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
            }else {
                $data['data'][$x][] = 
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-success" onclick="restorePerform(\''.action('Admin\RecipeController@restoreTrash', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-time-restore-setting" aria-hidden="true"></i></button>';
            }
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
