<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Product;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class ProductController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index')
        ->with('model', 'Product')
        ->with('index_link', action('Admin\ProductController@index'))
        ->with('api_link', action('Admin\ProductController@api'))
        ->with('create_link', action('Admin\ProductController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create')
        ->with('model', 'Product')
        ->with('store_link', action('Admin\ProductController@store'))
        ->with('index_link', action('Admin\ProductController@index'));
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
            'metadesc' => 'required',
            'description' => 'required',
            'tagline' => 'required',
            'ingredients' => 'required',
            'characteristics' => 'required',
            'size' => 'required',
            'storage' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\ProductController@create')->withErrors($validator)->withInput();

        $product = new Product;
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');

        $check = Product::where('slug', '=', $request->input('slug'))->count();
        if($check>0)
            $product->slug = $product->slug."-".($check+1);

        $product->metadesc = $request->input('metadesc');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->tagline = $request->input('tagline');
        $product->ingredients = $request->input('ingredients');
        $product->characteristics = $request->input('characteristics');
        $product->size = $request->input('size');
        $product->storage = $request->input('storage');

        if ($request->hasFile('image')) {
            $product->image = $product->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/img/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$product->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$product->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$product->image));
        }

        $product->save();

        return redirect()->action('Admin\ProductController@edit', [$product->id])->withMessages('Your Post has been submitted');
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
        $product = Product::find($id);
        return view('admin.product.update')
        ->with('event', $product)
        ->with('model', 'Product')
        ->with('update_link', action('Admin\ProductController@update', [$id]))
        ->with('index_link', action('Admin\ProductController@index'));
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
            'metadesc' => 'required',
            'description' => 'required',
            'tagline' => 'required',
            'ingredients' => 'required',
            'characteristics' => 'required',
            'size' => 'required',
            'storage' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\ProductController@edit', [$id])->withErrors($validator)->withInput();

        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');

        $check = Product::where('slug', '=', $request->input('slug'))->count();
        if($check>1)
            $product->slug = $product->slug."-".($check+1);

        $product->metadesc = $request->input('metadesc');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->tagline = $request->input('tagline');
        $product->ingredients = $request->input('ingredients');
        $product->characteristics = $request->input('characteristics');
        $product->size = $request->input('size');
        $product->storage = $request->input('storage');

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$product->image));
            File::delete(storage_path($storage_path.'/square/'.$product->image));
            File::delete(storage_path($storage_path.'/small/'.$product->image));

            $product->image = $product->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$product->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$product->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$product->image));
        }

        $product->save();

        return redirect()->action('Admin\ProductController@edit', [$product->id])->withMessages('Your Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $storage_path = '/app/public/img/';
        File::delete(storage_path($storage_path.'/'.$product->image));
        File::delete(storage_path($storage_path.'/square/'.$product->image));
        File::delete(storage_path($storage_path.'/small/'.$product->image));

        Product::destroy($id);

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
            'products.image',
            'products.name',
            'products.created_at',
            'products.status',
        ];
        
        $raw = DB::table('products')
            ->select(DB::raw(
                'products.id,'.
                'products.created_at,'.
                'products.image,'.
                'products.slug,'.
                'products.name,'.
                'products.status,'.
                'products.description,'.
                'products.metadesc'
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

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('products')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/img/'.$r->image).'"><img src="'.asset('storage/img/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->name.'</a><br><span class="tag tag-default">'.$r->slug.'</span><p class="article-desc">'.$r->metadesc.'</p>';
            $data['data'][$x][] =  date('d-m-Y', strtotime($r->created_at));
            if($r->status=='published')
                $data['data'][$x][] =  '<span class="tag tag-outline tag-success">Published</span>';
            else
                $data['data'][$x][] =  '<span class="tag tag-outline tag-default">Draft</span>';

            if($request->input('trashed')=='all'){
                $data['data'][$x][] =  
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\ProductController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\ProductController@destroy', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
            }else {
                $data['data'][$x][] = 
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-success" onclick="restorePerform(\''.action('Admin\ProductController@restoreTrash', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-time-restore-setting" aria-hidden="true"></i></button>';
            }
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
