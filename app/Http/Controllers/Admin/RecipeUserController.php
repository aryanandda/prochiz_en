<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeDirection;
use App\Models\RecipeCategory;
use App\Models\User;
use App\Notifications\RecipeStatus;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class RecipeUserController extends Controller
{
    public $type = null;

    public function __construct()
    {
        $this->type = 'prochizlover';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.recipe_user.index')
        ->with('model', 'Recipe')
        ->with('type', $this->type)
        ->with('sts_link', action('Admin\RecipeUserController@setSts'))
        ->with('empty_link', action('Admin\RecipeUserController@emptyTrash'))
        ->with('index_link', action('Admin\RecipeUserController@index'))
        ->with('api_link', action('Admin\RecipeUserController@api'))
        ->with('create_link', action('Admin\RecipeUserController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.recipe_user.create')
        ->with('model', 'Recipe')
        ->with('store_link', action('Admin\RecipeUserController@store'))
        ->with('index_link', action('Admin\RecipeUserController@index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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
        return view('admin.recipe_user.update')
        ->with('recipe', $recipe)
        ->with('model', 'Recipe')
        ->with('update_link', action('Admin\RecipeUserController@update', [$id]))
        ->with('index_link', action('Admin\RecipeUserController@index'));
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
            return redirect()->action('Admin\RecipeUserController@edit', [$id])->withErrors($validator)->withInput();

        $recipe = Recipe::find($id);
        $recipe->recipe_category_id = $request->input('category');
        $recipe->name = $request->input('name');
        $recipe->slug = $request->input('slug');
        $recipe->metadesc = $request->input('metadesc');
        $recipe->time = $request->input('time');
        $recipe->servings = $request->input('servings');
        $recipe->description = $request->input('description');

        $check = Recipe::type('prochizlover')->where('slug', '=', $request->input('slug'))->where('id', '<>', $id)->count();
        if($check>0)
            $recipe->slug = $recipe->slug."-".($check+1);

        $recipe->published_at = date('Y-m-d H:i:s', strtotime($request->input('published_at')));

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$recipe->image));

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

        return redirect()->action('Admin\RecipeUserController@edit', [$recipe->id])->withMessages('Your Recipe has been updated');
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
        Recipe::onlyTrashed()->where('type', '=', $this->type)->forceDelete();

        $response['status'] = '200';
        return response()->json($response);
    }

    /**
     * Change status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setSts(Request $request)
    {
    	$recipe = Recipe::withTrashed()->find($request->input('id'));

        $user = User::find($recipe->user_id);
        $user->notify(new RecipeStatus($user, $recipe));
 
        $stsc = 'btn-danger';
        if($recipe->status=='approved')
        	$stsc = 'btn-success';
        if($recipe->status=='pending') 
        	$stsc = 'btn-warning';

        $response['old_class'] = $stsc;

        $recipe->status = $request->input('status');
    	$recipe->save();

        $stsc = 'btn-danger';
        if($recipe->status=='approved')
        	$stsc = 'btn-success';
        if($recipe->status=='pending') 
        	$stsc = 'btn-warning';

    	$response['new_class'] = $stsc;

        $response['v'] = ucfirst($recipe->status);
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
            'recipes.id',
            'recipes.created_at',
            'recipes.name',
            'users.name',
            'users.ktp',
            'recipe_categories.name',
            'recipes.published_at',
            'recipes.status',
        ];
        
        $raw = DB::table('recipes')
            ->leftJoin('users', 'users.id', '=', 'recipes.user_id')
            ->leftJoin('recipe_categories', 'recipe_categories.id', '=', 'recipes.recipe_category_id')
            ->select(DB::raw(
                'recipes.id,'.
                'recipes.recipe_category_id,'.
                'recipes.created_at,'.
                'recipes.published_at,'.
                'recipes.slug,'.
                'recipes.image,'.
                'recipes.name,'.
                'users.id as user_id,'.
                'users.name as user_name,'.
                'users.ktp as user_ktp,'.
                'recipes.status,'.
                'recipes.description,'.
                'recipes.metadesc'
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
            if($request->input('status') == 'pending'){
                $raw = $raw->where('status', '=', 'pending');
            }
            if($request->input('status') == 'approved'){
                $raw = $raw->where('status', '=', 'approved');
            }
            if($request->input('status') == 'rejected'){
                $raw = $raw->where('status', '=', 'rejected');
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
            $raw = $raw->whereNull('recipes.deleted_at');
        else
            $raw = $raw->whereNotNull('recipes.deleted_at');

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

            $data['data'][$x][] =  $r->id;
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

            $data['data'][$x][] =  '<a class="article-title" href="'.action('Admin\RecipeUserController@edit', [$r->id]).'">'.$r->name.'</a><br><span class="tag tag-default">'.$r->slug.'</span><p class="article-desc">'.$r->metadesc.'</p>'.$prod;

            $data['data'][$x][] = '<a class="article-owner" href="'.action('Admin\UserController@edit', [$r->user_id]).'">'.$r->user_name.'</a>';
            $data['data'][$x][] = $r->user_ktp;
            $data['data'][$x][] = $rec_cat->name;
            $data['data'][$x][] =  date('d-m-Y', strtotime($r->published_at));

            $sts = 'Rejected';
            $stsc = 'danger';
            if($r->status=='approved'){            
            	$sts = 'Approved';
            	$stsc = 'success';
            }
            if($r->status=='pending'){          
            	$sts = 'Pending';
            	$stsc = 'warning';
            }

            $data['data'][$x][] =  '<div class="btn-group" role="group">'.
                '<button type="button" class="btn btn-xs btn-'.$stsc.' btn-block dropdown-toggle" id="statusOpt_'.$r->id.'" data-toggle="dropdown" aria-expanded="false"> '.$sts.
                '</button>'.
                    '<div class="dropdown-menu" aria-labelledby="statusOpt_'.$r->id.'" role="menu">'.
                        '<a style="max-width: 124px;" class="dropdown-item" onclick="setSts('.$r->id.',\'approved\')" role="menuitem">Approved</a>'.
                        '<a style="max-width: 124px;" class="dropdown-item" onclick="setSts('.$r->id.',\'rejected\')" role="menuitem">Rejected</a>'.
                        '<a style="max-width: 124px;" class="dropdown-item" onclick="setSts('.$r->id.',\'pending\')" role="menuitem">Pending</a>'.
                    '</div>'.
                '</div>';

            if($request->input('trashed')=='all'){
                $data['data'][$x][] =  
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\RecipeUserController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\RecipeUserController@destroy', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
            }else {
                $data['data'][$x][] = 
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-success" onclick="restorePerform(\''.action('Admin\RecipeUserController@restoreTrash', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-time-restore-setting" aria-hidden="true"></i></button>';
            }
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
