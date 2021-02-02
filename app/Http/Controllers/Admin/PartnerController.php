<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\PartnerCategory;
use App\Models\Partner;
use App\Models\User;
use App\Notifications\PartnerStatus;
use Image;
use Hash;
use Validator;
use Auth;
use DB;
use Excel;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.partner.index')
        ->with('model', 'Partner')
        ->with('sts_link', action('Admin\PartnerController@setSts'))
        ->with('index_link', action('Admin\PartnerController@index'))
        ->with('api_link', action('Admin\PartnerController@api'))
        ->with('create_link', action('Admin\PartnerController@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partner.create')
        ->with('model', 'Partner')
        ->with('store_link', action('Admin\PartnerController@store'))
        ->with('index_link', action('Admin\PartnerController@index'));
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
            'email' => 'required|email|max:255',
            'description' => 'required',
            'hours' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerController@create')->withErrors($validator)->withInput();

        $partner = new Partner;
        $partner->name = $request->input('name');
        $partner->slug = preg_replace('/[^a-z0-9]/i', '-', strtolower($request->input('name')));
        $partner->description = $request->input('description');
        $partner->metadesc = $request->input('description');
        $partner->address = $request->input('address');
        $partner->city = $request->input('city');
        $partner->hours = $request->input('hours');
        $partner->email = $request->input('email');
        $partner->phone = $request->input('phone');
        $partner->website = $request->input('website');
        $partner->instagram = $request->input('instagram');
        $partner->facebook = $request->input('facebook');
        $partner->status = $request->input('status');

        if ($request->hasFile('image')) {
            $partner->image = $partner->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';
            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partner->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partner->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partner->image));
        }

        $partner->save();

        $partner->categories()->sync($request->input('categories'));

        return redirect()->action('Admin\PartnerController@edit', $partner->id)->withMessages('New Partner has been submitted');
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
        $partner = Partner::find($id);

        return view('admin.partner.update')
        ->with('model', 'Partner')
        ->with('partner', $partner)
        ->with('update_link', action('Admin\PartnerController@update', [$id]))
        ->with('index_link', action('Admin\PartnerController@index'));
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
            'email' => 'required|email|max:255',
            'description' => 'required',
            'hours' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->action('Admin\PartnerController@create')->withErrors($validator)->withInput();

        $partner = Partner::find($id);
        $partner->name = $request->input('name');
        $partner->slug = preg_replace('/[^a-z0-9]/i', '-', strtolower($request->input('name')));
        $partner->description = $request->input('description');
        $partner->metadesc = $request->input('description');
        $partner->address = $request->input('address');
        $partner->city = $request->input('city');
        $partner->hours = $request->input('hours');
        $partner->email = $request->input('email');
        $partner->phone = $request->input('phone');
        $partner->website = $request->input('website');
        $partner->instagram = $request->input('instagram');
        $partner->facebook = $request->input('facebook');
        $partner->status = $request->input('status');

        if ($request->hasFile('image')) {
            $partner->image = $partner->slug.'-'.uniqid().'.'.$request->file('image')->extension();
            $storage_path = '/app/public/kuliner/';

            File::delete(storage_path($storage_path.'/'.$partnercat->image));
            File::delete(storage_path($storage_path.'/square/'.$partnercat->image));
            File::delete(storage_path($storage_path.'/small/'.$partnercat->image));

            Image::make($request->file('image'))->save(storage_path($storage_path.'/'.$partner->image));
            Image::make($request->file('image'))->fit(500,500)->save(storage_path($storage_path.'/square/'.$partner->image));
            Image::make($request->file('image'))->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$partner->image));
        }

        $partner->save();

        $partner->categories()->sync($request->input('categories'));

        $user = User::find($partner->user_id);
        $user->notify(new PartnerStatus($user, $partner));

        return redirect()->action('Admin\PartnerController@edit', $partner->id)->withMessages('Partner has been updated');
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
     * Change status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setSts(Request $request)
    {
    	$partner = Partner::withTrashed()->find($request->input('id'));

        $user = User::find($partner->user_id);
        $user->notify(new PartnerStatus($user, $partner));
 
        $stsc = 'btn-danger';
        if($partner->status=='approved')
        	$stsc = 'btn-success';
        if($partner->status=='pending') 
        	$stsc = 'btn-warning';

        $response['old_class'] = $stsc;

        $partner->status = $request->input('status');
    	$partner->save();

        $stsc = 'btn-danger';
        if($partner->status=='approved')
        	$stsc = 'btn-success';
        if($partner->status=='pending') 
        	$stsc = 'btn-warning';

    	$response['new_class'] = $stsc;

        $response['v'] = ucfirst($partner->status);
        $response['status'] = '200';
        return response()->json($response);
    }

    public function excel() {
        Excel::create('Prochiz-Partner', function($excel) {

            // Set the title
            $excel->setTitle('All Partner Data');

            // Chain the setters
            $excel->setCreator('Pentacode Digital')
                  ->setCompany('Prochiz');

            // Call them separately
            $excel->setDescription('All Registered Partner Data');

            $data = [];

            $excel->sheet('Partner', function($sheet) use($data) {

                $data = [];

                $header= [
                    'No',
                    'Name',
                    'Phone',
                    'Email',
                    'Website',
                    'Description',
                    'Open Hour',
                    'Facebook',
                    'Instagram',
                    'Status',
                ];

                $data[] = $header;

                $i=0;
                foreach (Partner::get() as $partner) {
                    $i++;
                    $data[] = [
                        $i,
                        $partner->name,
                        $partner->phone,
                        $partner->email,
                        $partner->website,
                        $partner->description,
                        $partner->hour,
                        $partner->facebook,
                        $partner->instagram,
                        $partner->status,
                    ];
                }

                $sheet->fromArray($data, null, 'A1', false);
                //$sheet->fromArray($data, null, 'A2', true);

            });

        })->download('xlsx');
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
            'partners.id',
            'partners.name',
            'partners.city',
            'partners.email',
            'partners.status',
        ];
        
        $raw = DB::table('partners')
            ->select(DB::raw(
                'partners.id,'.
                'partners.name,'.
                'partners.city,'.
                'partners.facebook,'.
                'partners.instagram,'.
                'partners.website,'.
                'partners.phone,'.
                'partners.hours,'.
                'partners.address,'.
                'partners.image,'.
                'partners.status,'.
                'partners.metadesc,'.
                'partners.email'
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

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('partners')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {
            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/kuliner/'.$r->image).'"><img src="'.asset('storage/kuliner/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="">'.$r->name.'</a><br>'.
            '<table class="tab-only"><tr>'.
            '<td width="80"><i class="icon md-pin"></i> '.$r->address.'</td>'.
            '<td width="80"><i class="icon md-phone"></i> '.$r->phone.'</td>'.
            '<td width="80"><i class="icon md-alarm"></i> '.$r->hours.'</td>'.
            '</tr><tr>'.
            '<td width="80"><i class="icon md-facebook-box"></i> '.$r->facebook.'</td>'.
            '<td width="80"><i class="icon md-instagram"></i> '.$r->instagram.'</td>'.
            '<td width="80"><i class="icon md-globe-alt"></i> '.$r->website.'</td>'.
            '</tr></table>'.
            '<p class="article-desc">'.$r->metadesc.'</p>';

            $data['data'][$x][] =  $r->city;
            $data['data'][$x][] =  $r->email;
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
            $data['data'][$x][] =  
            '<script type="text/javascript">'.
                'jsonDel'.$r->id.' = '.json_encode($r).';'.
            '</script>'.
            '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action('Admin\PartnerController@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
            '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform('.$r->id.', \''.$r->name.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }
}
