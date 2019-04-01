<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Banner;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class BannerController extends Controller
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
        $banners = Banner::paginate(24);

        return view('admin.banner.index')
        ->with('model', 'Banner')
        ->with('banners', $banners)
        ->with('index_link', action('Admin\BannerController@index'))
        ->with('api_link', action('Admin\BannerController@api'))
        ->with('create_link', action('Admin\BannerController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create')
        ->with('model', 'Banner')
        ->with('store_link', action('Admin\BannerController@store'))
        ->with('index_link', action('Admin\BannerController@index'));
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
            'caption' => 'required',
            'url' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\BannerController@create')->withErrors($validator)->withInput();

        $banner = new Banner;
        $banner->name = $request->input('name');
        $banner->caption = $request->input('caption');
        $banner->url = $request->input('url');
        $banner->status = $request->input('status');

        if ($request->hasFile('image')) {
            $banner->image = $banner->name.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/img/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$banner->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$banner->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$banner->image));
        }

        $banner->save();

        return redirect()->action('Admin\BannerController@edit', [$banner->id])->withMessages('Your Post has been submitted');
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
        $banner = Banner::find($id);
        return view('admin.banner.update')
        ->with('banner', $banner)
        ->with('model', 'Banner')
        ->with('update_link', action('Admin\BannerController@update', [$id]))
        ->with('index_link', action('Admin\BannerController@index'));
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
            'caption' => 'required',
            'url' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\BannerController@edit', [$id])->withErrors($validator)->withInput();

        $banner = Banner::find($id);
        $banner->name = $request->input('name');
        $banner->status = $request->input('status');
        $banner->caption = $request->input('caption');

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$banner->image));

            $banner->image = $banner->name.'-'.uniqid().'.'.$request->file('image')->extension();
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$banner->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$banner->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$banner->image));
        }

        $banner->save();

        return redirect()->action('Admin\BannerController@edit', [$banner->id])->withMessages('Your Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::destroy($id);

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
            'banners.id',
            'banners.image',
            'banners.name',
            'banners.start_at',
            'banners.end_at',
            'banners.created_at',
            'banners.metadesc',
            'banners.status',
        ];
        
        $raw = DB::table('banners')
            ->select(DB::raw(
                'banners.id,'.
                'banners.start_at,'.
                'banners.end_at,'.
                'banners.created_at,'.
                'banners.image,'.
                'banners.name,'.
                'banners.status,'.
                'banners.description,'.
                'banners.metadesc'
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
        $data['recordsTotal'] = DB::table('banners')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            $data['data'][$x][] =  $r->id;
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/img/'.$r->image).'"><img src="'.asset('storage/img/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->name.'</a><br><p class="article-desc">'.$r->metadesc.'</p>';
            $data['data'][$x][] =  date('d-m-Y H:i', strtotime($r->start_at));
            $data['data'][$x][] =  date('d-m-Y H:i', strtotime($r->end_at));
            $data['data'][$x][] =  date('d-m-Y', strtotime($r->created_at));
            if($r->status=='published')
                $data['data'][$x][] =  '<span class="tag tag-outline tag-success">Published</span>';
            else
                $data['data'][$x][] =  '<span class="tag tag-outline tag-default">Draft</span>';

          
            $data['data'][$x][] =  
            '<script type="text/javascript">'.
                'jsonDel'.$r->id.' = '.json_encode($r).';'.
            '</script>'.
            '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\BannerController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
            '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\BannerController@destroy', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';

                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
