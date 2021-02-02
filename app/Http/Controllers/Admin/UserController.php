<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Hash;
use Validator;
use Auth;
use DB;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Admin::find($id);
        $user->delete();

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
            'users.id',
            'users.name',
            'users.ktp',
            'users.email',
        ];
        
        $raw = DB::table('users')
            ->select(DB::raw(
                'users.id,'.
                'users.name,'.
                'users.ktp,'.
                'users.email'
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
        $data['recordsTotal'] = DB::table('users')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            $data['data'][$x][] =  $r->id;
            $data['data'][$x][] =  $r->name;
            $data['data'][$x][] =  $r->email;
            $data['data'][$x][] =  $r->ktp;
            $data['data'][$x][] =  
            '<script type="text/javascript">'.
                'jsonDel'.$r->id.' = '.json_encode($r).';'.
            '</script>'.
            /*
            '<button class="btn btn-pure btn-sm btn-icon btn-primary" onclick="updateAction(jsonDel'.$r->id.')"><i class="icon md-edit" aria-hidden="true"></i></button>'.
            */
            '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform('.$r->id.', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }
}
