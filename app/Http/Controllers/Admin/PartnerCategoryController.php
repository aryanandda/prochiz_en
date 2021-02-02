<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\PartnerCategory;
use App\Models\Partner;
use Image;
use File;
use Hash;
use Validator;
use Auth;
use DB;

class PartnerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.partner.category.index')
        ->with('model', 'Partner Category')
        ->with('index_link', action('Admin\PartnerCategoryController@index'))
        ->with('api_link', action('Admin\PartnerCategoryController@api'))
        ->with('create_link', action('Admin\PartnerCategoryController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partner.category.create')
        ->with('model', 'PartnerCategory')
        ->with('store_link', action('Admin\PartnerCategoryController@store'))
        ->with('index_link', action('Admin\PartnerCategoryController@index'));
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
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerCategoryController@create')->withErrors($validator)->withInput();

        $partnercat = new PartnerCategory;
        $partnercat->name = $request->input('name');
        $partnercat->slug = $request->input('slug');

        $check = PartnerCategory::where('slug', '=', $request->input('slug'))->count();
        if($check>0)
            $article->slug = $article->slug."-".($check+1);

        $partnercat->description = $request->input('description');
        $partnercat->metadesc = $request->input('metadesc');

        if ($request->hasFile('image')) {
            $partnercat->image = $partnercat->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partnercat->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partnercat->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partnercat->image));
        }

        $partnercat->save();

        return redirect()->action('Admin\PartnerCategoryController@edit', $partnercat->id)
            ->withMessages('New Partner Category has been submitted');
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
        $partnercat = PartnerCategory::find($id);

        return view('admin.partner.category.update')
        ->with('model', 'PartnerCategory')
        ->with('partnercat', $partnercat)
        ->with('update_link', action('Admin\PartnerCategoryController@update', [$partnercat->id]))
        ->with('index_link', action('Admin\PartnerCategoryController@index'));
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
            'metadesc' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerCategoryController@update')->withErrors($validator)->withInput();

        $partnercat = PartnerCategory::find($id);
        $partnercat->name = $request->input('name');
        $partnercat->description = $request->input('description');
        $partnercat->metadesc = $request->input('metadesc');

        if ($request->hasFile('image')) {
            $partnercat->image = $partnercat->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';

            File::delete(storage_path($storage_path.'/'.$partnercat->image));
            File::delete(storage_path($storage_path.'/square/'.$partnercat->image));
            File::delete(storage_path($storage_path.'/small/'.$partnercat->image));

            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partnercat->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partnercat->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partnercat->image));
        }

        $partnercat->save();

        return redirect()->action('Admin\PartnerCategoryController@edit', $partnercat->id)
            ->withMessages('New Partner Category has been submitted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

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
            'partner_categories.id',
            'partner_categories.name',
            'partner_categories.metadesc',
        ];
        
        $raw = DB::table('partner_categories')
            ->select(DB::raw(
                'partner_categories.id,'.
                'partner_categories.image,'.
                'partner_categories.name,'.
                'partner_categories.metadesc'
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

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('partner_categories')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/kuliner/'.$r->image).'"><img src="'.asset('storage/kuliner/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->name.'</a><br>'.
            '<p class="article-desc">'.$r->metadesc.'</p>';
            $data['data'][$x][] =  
            '<script type="text/javascript">'.
                'jsonDel'.$r->id.' = '.json_encode($r).';'.
            '</script>'.
            '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\PartnerCategoryController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
            '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform('.$r->id.', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }
}
