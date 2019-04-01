<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Article;
use Hash;
use Validator;
use Auth;
use DB;
use Image;
use File;

class ArticleController extends Controller
{
    public $type = null;
    public $cont_name = null;

    public function __construct()
    {
        $this->type = "tips";
        $this->cont_name = 'Admin\TipsTrickController';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.article.index')
        ->with('model', ucfirst($this->type))
        ->with('empty_link', action($this->cont_name.'@emptyTrash'))
        ->with('index_link', action($this->cont_name.'@index'))
        ->with('api_link', action($this->cont_name.'@api'))
        ->with('create_link', action($this->cont_name.'@create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create')
        ->with('model', ucfirst($this->type))
        ->with('store_link', action($this->cont_name.'@store'))
        ->with('index_link', action($this->cont_name.'@index'));
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
            'title' => 'required',
            'published_at' => 'required|date',
            'slug' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action($this->cont_name.'@create')->withErrors($validator)->withInput();

        $article = new Article;
        $article->type = $this->type;
        $article->title = $request->input('title');
        $article->slug = $request->input('slug');
        $article->metadesc = $request->input('metadesc');
        $article->content = $request->input('content');
        $article->video = $request->input('video');
        $article->status = $request->input('status');
        $article->published_at = date('Y-m-d', strtotime($request->input('published_at')));

        $check = Article::type($this->type)->where('slug', '=', $request->input('slug'))->count();
        if($check>0)
            $article->slug = $article->slug."-".($check+1);

        if ($request->hasFile('imagex') && $request->hasFile('imagey')) {
            $article->image = $article->slug.'-'.uniqid().'.'.$request->file('imagex')->extension();
            $storage_path = '/app/public/img/';
            Image::make($request->file('imagey'))->save(storage_path($storage_path.'/'.$article->image));
            Image::make($request->file('imagex'))->save(storage_path($storage_path.'/square/'.$article->image));
            Image::make($request->file('imagex'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$article->image));
        }

        $article->save();

        return redirect()->action($this->cont_name.'@edit', [$article->id])->withMessages('Your Post has been submitted');
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
        $article = Article::find($id);
        return view('admin.article.update')
        ->with('article', $article)
        ->with('model', ucfirst($this->type))
        ->with('update_link', action($this->cont_name.'@update', [$id]))
        ->with('index_link', action($this->cont_name.'@index'));
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
            'title' => 'required',
            'published_at' => 'required|date',
            'slug' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        if ($validator->fails())
            return redirect()->action($this->cont_name.'@edit', [$id])->withErrors($validator)->withInput();

        $article = Article::find($id);
        $article->type = $this->type;
        $article->title = $request->input('title');
        $article->slug = $request->input('slug');
        $article->metadesc = $request->input('metadesc');
        $article->content = $request->input('content');
        $article->video = $request->input('video');
        $article->status = $request->input('status');
        $article->published_at = date('Y-m-d', strtotime($request->input('published_at')));

        $check = Article::type($this->type)->where('slug', '=', $request->input('slug'))->where('id', '<>', $id)->count();
        if($check>0)
            $article->slug = $article->slug."-".($check+1);

        if ($request->hasFile('imagex') && $request->hasFile('imagey')) {
            $storage_path = '/app/public/img/';
            File::delete(storage_path($storage_path.'/'.$article->image));
            File::delete(storage_path($storage_path.'/square/'.$article->image));
            File::delete(storage_path($storage_path.'/small/'.$article->image));

            $article->image = $article->slug.'-'.uniqid().'.'.$request->file('imagex')->extension();
            Image::make($request->file('imagey'))->save(storage_path($storage_path.'/'.$article->image));
            Image::make($request->file('imagex'))->save(storage_path($storage_path.'/square/'.$article->image));
            Image::make($request->file('imagex'))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$article->image));
        }

        $article->save();

        return redirect()->action($this->cont_name.'@edit', [$article->id])->withMessages('Your Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->status = 'draft';
        $article->save();

        Article::destroy($id);

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
        $articles = Article::onlyTrashed()->where('type', '=', $this->type)->get();

        foreach ($articles as $article) {
            File::delete(storage_path($storage_path.'/'.$article->image));
            File::delete(storage_path($storage_path.'/square/'.$article->image));
            File::delete(storage_path($storage_path.'/small/'.$article->image));
        }

        Article::onlyTrashed()->where('type', '=', $this->type)->forceDelete();

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
        Article::where('id', '=', $id)->restore();

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
            'articles.image',
            'articles.title',
            'articles.published_at',
            'articles.status',
        ];
        
        $raw = DB::table('articles')
            ->select(DB::raw(
                'articles.id,'.
                'articles.type,'.
                'articles.published_at,'.
                'articles.image,'.
                'articles.slug,'.
                'articles.metadesc,'.
                'articles.title,'.
                'articles.status,'.
                'articles.metadesc'
            ));

        if(!empty($search)){
            $raw = $raw->where(function ($query) use ($col, $search) {
                $hv = [];
            
                $i = 0;
                foreach ($col as $val) {
                    if(!in_array($i, $hv)){
                        if($i==0)
                            $query = $query->whereRaw($val." like '%".$search."%'");
                        else
                            $query = $query->orWhereRaw($val." like '%".$search."%'");
                        $i++;
                    }
                }

            });
        }

        if($request->input('status')!='all'){
            if($request->input('status') == 'published'){
                $raw = $raw->where('status', '=', 'published');
            }
            else{
                $raw = $raw->where('status', '=', 'draft');
            }
        }

        if(!empty($request->input('type')))
            $raw = $raw->where('type', '=', $request->input('type'));

        if($request->input('trashed')=='all')
            $raw = $raw->whereNull('deleted_at');
        else
            $raw = $raw->whereNotNull('deleted_at');

        $filtered = count($raw->get());

        $raw = $raw->orderBy($col[$order], $by);

        $raw = $raw->skip($request->input('start'))->take($request->input('length'))->get();

        $data['draw'] = $request->input('draw');
        $data['recordsTotal'] = DB::table('articles')->count();
        $data['recordsFiltered'] = $filtered;

        $x=0;
        foreach ($raw as $r) {

            if(!empty($r->image))
                $data['data'][$x][] =  '<a class="article-thumb" href="'.asset('storage/img/'.$r->image).'"><img src="'.asset('storage/img/square/'.$r->image).'" class="img-circle" /></a>';
            else
                $data['data'][$x][] = '<i class="icon md-image-alt" style="font-size: 2.5em; color: #ccc;"></i>';

            $data['data'][$x][] =  '<a class="article-title" href="'.action($this->cont_name.'@edit', [$r->id]).'">'.$r->title.'</a><br>'.
            '<span class="tag tag-default">'.$r->slug.'</span><p class="article-desc">'.$r->metadesc.'</p>';
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
                '<a class="btn btn-pure btn-sm btn-icon btn-primary" href="'.action($this->cont_name.'@edit', [$r->id]).'"><i class="icon md-edit" aria-hidden="true"></i></a>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-danger" onclick="deletePerform(\''.action($this->cont_name.'@destroy', [$r->id]).'\', \''.$r->title.'\')"><i class="icon md-close" aria-hidden="true"></i></button>';
            }else {
                $data['data'][$x][] = 
                '<script type="text/javascript">'.
                    'jsonDel'.$r->id.' = '.json_encode($r).';'.
                '</script>'.
                '<button class="btn btn-pure btn-sm btn-icon btn-success" onclick="restorePerform(\''.action($this->cont_name.'@restoreTrash', [$r->id]).'\', \''.$r->title.'\')"><i class="icon md-time-restore-setting" aria-hidden="true"></i></button>';
            }
                
            $x++;
        }

        if($filtered==0)
            $data['data'] = array();

        return response()->json($data);
    }    
}
