@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
.featured-container{
    height: auto;
}    
.featured-container canvas{
    border: 1px solid #ddd;
    cursor: pointer;
    border-radius: 4px;
}
</style>
@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')

<?php 
    $title = $article->title;
    $slug = $article->slug;
    $metadesc = $article->metadesc;
    $video = $article->video;
    $content = $article->content;
    $image =  $article->image;
    $published_at =  $article->published_at;

    if(!empty(old('title'))){
        $title = old('title');
        $slug = old('slug');
        $metadesc = old('metadesc');
        $video = old('video');
        $content = old('content');
        $published_at =  old('published_at');    
    }

    $published_at = date("Y-m-d", strtotime($published_at));
?>

<div class="page">
{!! Form::open(['url' => $update_link, 'id' => 'the-form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content Header -->

        <div class="page-header">
            <h1 class="page-title">Update {{ $model }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ $index_link }}">{{ $model }}</a></li>
                <li class="breadcrumb-item active">Update {{ $model }}</li>
            </ol>
            <div class="page-header-actions">
                <a href="{{ $index_link }}" class="btn btn-warning ">
                    <i class="icon md-arrow-left"></i> Back
                </a>
                <button onclick="submitDraft()" type="button" class="btn btn-info m-l-5">
                    <i class="icon md-assignment"></i> Draft
                </button>
                <button onclick="submitPublish()" type="button" class="btn btn-primary m-l-5">
                    <i class="icon md-mail-send"></i> Publish
                </button>
            </div>
        </div>

        <!-- Contacts Content -->
        <div class="page-content">
            <div class="row">

                <div class="col-md-12">
                    {!! AdminHelper::throwMessage('messages', null, 'success') !!}
                    {!! AdminHelper::throwMessage('errors', null, 'danger') !!}
                </div>

                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        {!! Form::text('title', $title, ['class' => 'form-control', 'id' => 'title']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Slug</label>
                                        {!! Form::text('slug', $slug, ['class' => 'form-control', 'id' => 'slug']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        {!! Form::textarea('metadesc', $metadesc, ['class' => 'form-control', 'rows' => '3']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Video Embed</label>
                                        {!! Form::textarea('video', $video, ['class' => 'form-control', 'rows' => '3']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Featured Image (Slider)</label>
                                        <input type="file" id="filey" onchange="changePhoto('y')" style="display:none;" name="imagey">
                                        <input type="hidden" name="photoy">
                                        <div class="featured-container">
                                            <canvas onclick="triggerFile('y');" width="1024" height="1024" id="photo2y" style="width: 100%;"></canvas>
                                            <canvas class="img-thumbnail" width="1024" height="1024" style="display:none;" id="photoy">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Featured Image (Square)</label>
                                        <input type="file" id="filex" onchange="changePhoto('x')" style="display:none;" name="imagex">
                                        <input type="hidden" name="photox">
                                        <div class="featured-container">
                                            <canvas onclick="triggerFile('x');" width="1024" height="1024" id="photo2x" style="width: 100%;"></canvas>
                                            <canvas class="img-thumbnail" width="1024" height="1024" style="display:none;" id="photox">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">    
                                    <div class="form-group">
                                        <label>Published At</label>
                                        <div class="input-group">
                                            {!! Form::text('published_at', $published_at, ['class' => 'datepicker form-control', 'id' => 'published_at']) !!}
                                            <span class="input-group-addon">
                                                <span class="icon md-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        {!! Form::textarea('content', $content, ['class' => 'form-control', 'id' => 'content']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input name="status" id="status" type="hidden">
{!! Form::close() !!}
</div>

@stop

@section('bottomExtraScript')
<script type="text/javascript" src="{{ asset('assets/admin/js/speakingurl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/slugify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/ckeditor/ckeditor.js?v=1') }}"></script>
<script type="text/javascript">
function submitPublish()
{
    $("#status").val('published');
    $("#the-form").submit();
}
function submitDraft()
{
    $("#status").val('draft');
    $("#the-form").submit();
}

function triggerFile(k){
    $("#file"+k).trigger("click");
}    
function changePhoto(k) {
    var file = $('#file'+k)[0];

    var canvas = $('#photo'+k)[0];
    var context = canvas.getContext('2d');

    var canvas2 = $('#photo2'+k)[0];
    var context2 = canvas2.getContext('2d');

    var img = new Image;
    img.src = URL.createObjectURL(file.files[0]);
    img.onload = function() {
        var w = 1024;
        var h = parseInt(1024/(img.width/img.height));
        $('#photo2'+k).attr('width', 1024);
        $('#photo2'+k).attr('height', h);
        context.drawImage(img, 0, 0, 1024, 1024);
        context2.drawImage(img, 0, 0, w, h);
        var dataURL = canvas2.toDataURL("image/jpg");
        $('input[name=photo'+k+']').val(dataURL);     
    }
}

function drawPhoto(im, k) {
    var canvas = $('#photo'+k)[0];
    var context = canvas.getContext('2d');

    var canvas2 = $('#photo2'+k)[0];
    var context2 = canvas2.getContext('2d');

    var img = new Image;
    img.src = im;
    img.onload = function() {
        var w = 1024;
        var h = parseInt(1024/(img.width/img.height));
        $('#photo2'+k).attr('width', 1024);
        $('#photo2'+k).attr('height', h);
        context.drawImage(img, 0, 0, 1024, 1024);
        context2.drawImage(img, 0, 0, w, h);
        //var dataURL = canvas2.toDataURL("image/jpg");
        //$('input[name=photo]').val(dataURL);              
    }
}   

$(function(){
    $("#published_at").datepicker({
        format: 'yyyy-mm-dd'
    });
    
    // $('#slug').slugify('#title');

    resz();
    $(window).resize(function(){
        resz();
    });

    @if(!empty(old('photo')))
        drawPhoto('{{ old('photox') }}', 'x');
        drawPhoto('{{ old('photoy') }}', 'y');
    @else
        drawPhoto('{{ asset('storage/img/square/'.$image) }}', 'x');
        drawPhoto('{{ asset('storage/img/'.$image) }}', 'y');
    @endif
});

function resz()
{
    $('#featured-container').height($('#featured-container').width());    
}

var options = {
    height: 600,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
};

CKEDITOR.replace( 'content', options );
</script>
@stop