<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\PartnerGallery;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class PartnerGalleryController extends Controller
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
        return view('admin.partner.gallery.index')
        ->with('model', 'PartnerGallery')
        ->with('index_link', action('Admin\PartnerGalleryController@index'))
        ->with('api_link', action('Admin\PartnerGalleryController@api'))
        ->with('create_link', action('Admin\PartnerGalleryController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partner.gallery.create')
        ->with('model', 'PartnerGallery')
        ->with('store_link', action('Admin\PartnerGalleryController@store'))
        ->with('index_link', action('Admin\PartnerGalleryController@index'));
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
            'caption' => 'required',
            'partner_id' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerGalleryController@create')->withErrors($validator)->withInput();

        $partnergallery = new PartnerGallery;
        $partnergallery->caption = $request->input('caption');
        $partnergallery->name = $request->input('caption');
        $partnergallery->partner_id = $request->input('partner_id');

        if ($request->hasFile('image')) {
            $partnergallery->image = $partnergallery->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partnergallery->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$partnergallery->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partnergallery->image));
        }

        $partnergallery->save();

        return redirect()->action('Admin\PartnerGalleryController@edit', [$partnergallery->id])->withMessages('Your Post has been submitted');
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
        $partnergallery = PartnerGallery::find($id);
        return view('admin.partner.gallery.update')
        ->with('partnergallery', $partnergallery)
        ->with('model', 'PartnerGallery')
        ->with('update_link', action('Admin\PartnerGalleryController@update', [$id]))
        ->with('index_link', action('Admin\PartnerGalleryController@index'));
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
            'caption' => 'required',
            'partner_id' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerGalleryController@edit', [$id])->withErrors($validator)->withInput();

        $partnergallery = PartnerGallery::find($id);
        $partnergallery->caption = $request->input('caption');
        $partnergallery->name = $request->input('caption');
        $partnergallery->partner_id = $request->input('partner_id');

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/kuliner/';
            File::delete(storage_path($storage_path.'/'.$partnergallery->image));
            File::delete(storage_path($storage_path.'/square/'.$partnergallery->image));
            File::delete(storage_path($storage_path.'/small/'.$partnergallery->image));

            $partnergallery->image = $partnergallery->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partnergallery->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$partnergallery->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partnergallery->image));
        }

        $partnergallery->save();

        return redirect()->action('Admin\PartnerGalleryController@edit', [$partnergallery->id])->withMessages('Your Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = PartnerGallery::find($id);

        $storage_path = '/app/public/kuliner/';
        File::delete(storage_path($storage_path.'/'.$event->image));
        File::delete(storage_path($storage_path.'/square/'.$event->image));
        File::delete(storage_path($storage_path.'/small/'.$event->image));

        PartnerGallery::destroy($id);

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
            'partner_galleries.image',
            'partners.name',
            'partner_galleries.caption',
        ];
        
        $raw = DB::table('partner_galleries')
            ->join('partners', 'partners.id', '=', 'partner_galleries.partner_id')
            ->select(DB::raw(
                'partner_galleries.id,'.
                'partner_galleries.image,'.
                'partners.name as partner_name,'.
                'partner_galleries.caption'
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

        if(!empty($request->input('partner_id')))
            $raw = $raw->where('partners.id', '=', $request->input('partner_id'));

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('partner_galleries')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/kuliner/'.$r->image).'"><img src="'.asset('storage/kuliner/square/'.$r->image).'" class="img-circle" /></a>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->partner_name.'</a>';
            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->caption.'</a>';
            $data['data'][$x][] =  
            '<script type="text/javascript">'.
                'jsonDel'.$r->id.' = '.json_encode($r).';'.
            '</script>'.
            '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\PartnerGalleryController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
            '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\PartnerGalleryController@destroy', [$r->id]).'\', \''.$r->caption.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
