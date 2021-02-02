<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Event;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class EventController extends Controller
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
        return view('admin.event.index')
        ->with('model', 'Event')
        ->with('index_link', action('Admin\EventController@index'))
        ->with('api_link', action('Admin\EventController@api'))
        ->with('create_link', action('Admin\EventController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create')
        ->with('model', 'Event')
        ->with('store_link', action('Admin\EventController@store'))
        ->with('index_link', action('Admin\EventController@index'));
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
            'date_start_at' => 'required|date',
            'date_end_at' => 'required|date',
            'time_start_at' => 'required',
            'time_end_at' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\EventController@create')->withErrors($validator)->withInput();

        $event = new Event;
        $event->name = $request->input('name');
        $event->slug = $request->input('slug');

        $check = Event::where('slug', '=', $request->input('slug'))->count();
        if($check>0)
            $event->slug = $event->slug."-".($check+1);

        $event->metadesc = $request->input('metadesc');
        $event->status = $request->input('status');
        $event->description = $request->input('description');
        $event->start_at = date('Y-m-d h:i:s', strtotime($request->input('date_start_at').' '.$request->input('time_start_at')));
        $event->end_at = date('Y-m-d h:i:s', strtotime($request->input('date_end_at').' '.$request->input('time_end_at')));

        if ($request->hasFile('image')) {
            $event->image = $event->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/img/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$event->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$event->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$event->image));
        }

        $event->save();

        return redirect()->action('Admin\EventController@edit', [$event->id])->withMessages('Your Post has been submitted');
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
        $event = Event::find($id);
        return view('admin.event.update')
        ->with('event', $event)
        ->with('model', 'Event')
        ->with('update_link', action('Admin\EventController@update', [$id]))
        ->with('index_link', action('Admin\EventController@index'));
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
            'date_start_at' => 'required|date',
            'date_end_at' => 'required|date',
            'time_start_at' => 'required',
            'time_end_at' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\EventController@edit', [$id])->withErrors($validator)->withInput();

        $event = Event::find($id);
        $event->name = $request->input('name');
        $event->slug = $request->input('slug');

        $check = Event::where('slug', '=', $request->input('slug'))->where('id', '<>', $id)->count();
        if($check>0)
            $event->slug = $event->slug."-".($check+1);

        $event->metadesc = $request->input('metadesc');
        $event->status = $request->input('status');
        $event->description = $request->input('description');
        $event->start_at = date('Y-m-d h:i:s', strtotime($request->input('date_start_at').' '.$request->input('time_start_at')));
        $event->end_at = date('Y-m-d h:i:s', strtotime($request->input('date_end_at').' '.$request->input('time_end_at')));

        if ($request->hasFile('image')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$event->image));
            File::delete(storage_path($storage_path.'/square/'.$event->image));
            File::delete(storage_path($storage_path.'/small/'.$event->image));

            $event->image = $event->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$event->image));
            Image::make($request->file('image'))->fit(200,200)->save(storage_path($storage_path.'/square/'.$event->image));
            Image::make($request->file('image'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$event->image));
        }

        $event->save();

        return redirect()->action('Admin\EventController@edit', [$event->id])->withMessages('Your Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        $storage_path = '/app/public/img/';
        File::delete(storage_path($storage_path.'/'.$event->image));
        File::delete(storage_path($storage_path.'/square/'.$event->image));
        File::delete(storage_path($storage_path.'/small/'.$event->image));

        Event::destroy($id);

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
            'events.image',
            'events.name',
            'events.start_at',
            'events.end_at',
            'events.created_at',
            'events.metadesc',
            'events.status',
        ];
        
        $raw = DB::table('events')
            ->select(DB::raw(
                'events.id,'.
                'events.start_at,'.
                'events.end_at,'.
                'events.created_at,'.
                'events.slug,'.
                'events.image,'.
                'events.name,'.
                'events.status,'.
                'events.description,'.
                'events.metadesc'
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
        $data['recordsTotal'] = DB::table('events')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/img/'.$r->image).'"><img src="'.asset('storage/img/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->name.'</a><span class="tag tag-default">'.$r->slug.'</span><br><p class="article-desc">'.$r->metadesc.'</p>';
            $data['data'][$x][] =  date('d-m-Y H:i', strtotime($r->start_at));
            $data['data'][$x][] =  date('d-m-Y H:i', strtotime($r->end_at));
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
                '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\EventController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action('Admin\EventController@destroy', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
            }else {
                $data['data'][$x][] = 
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-success" onclick="restorePerform(\''.action('Admin\EventController@restoreTrash', [$r->id]).'\', \''.$r->name.'\')"><i class="icon md-time-restore-setting" aria-hidden="true"></i></button>';
            }
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
