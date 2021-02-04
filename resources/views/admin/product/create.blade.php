@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/clockpicker/bootstrap-clockpicker.min.css') }}">
@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')
<div class="page">
{!! Form::open(['url' => $store_link, 'id' => 'the-form', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content Header -->

        <div class="page-header">
            <h1 class="page-title">Create {{ $model }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ $index_link }}">{{ $model }}</a></li>
                <li class="breadcrumb-item active">Create {{ $model }}</li>
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Name</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Slug</label>
                                        {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'id' => 'slug']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Tagline</label>
                                        {!! Form::text('tagline', old('tagline'), ['class' => 'form-control', 'id' => 'tagline']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        {!! Form::textarea('metadesc', old('metadesc'), ['class' => 'form-control', 'rows' => '3']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Bahan</label>
                                        {!! Form::textarea('ingredients', old('ingredients'), ['class' => 'form-control', 'id' => 'ingredients', 'rows' => '3']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Karakteristik</label>
                                        {!! Form::text('characteristics', old('characteristics'), ['class' => 'form-control', 'id' => 'characteristics']) !!}
                                    </div>

                                    <div class="form-group">
                                        <div><label class="control-label">Sizes</label></div>

                                        <div class="sizes">
                                            <div class="size row" style="padding-bottom: 10px; display: flex">
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="size[]" placeholder="Size" required="">
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="ecomm-name[]" class="form-control" >
                                                        <option value="Alfacart">Alfacart</option>
                                                        <option value="Blibli">Blibli</option>
                                                        <option value="Hypermart Online">Hypermart Online</option>
                                                        <option value="JD.ID">JD.ID</option>
                                                        <option value="Klik Indogrosir">Klik Indogrosir</option>
                                                        <option value="Klik Indomaret">Klik Indomaret</option>
                                                        <option value="Shopee">Shopee</option>
                                                        <option value="Tokopedia">Tokopedia</option>
                                                        <option value="Yogya Online">Yogya Online</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="ecomm-link[]" placeholder="Ecommerce Link" required="">
                                                </div>
                                                <div class="col-md-3" style="margin: auto">
                                                    <label style="margin: 0 !important">
                                                        <input type="checkbox" name="ecomm-status[]" value="0">
                                                        <span class="slider round">Active</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="size row" style="padding-bottom: 10px; display: flex">
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="size[]" placeholder="Size" required="">
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="ecomm-name[]" class="form-control" >
                                                        <option value="Alfacart">Alfacart</option>
                                                        <option value="Blibli">Blibli</option>
                                                        <option value="Hypermart Online">Hypermart Online</option>
                                                        <option value="JD.ID">JD.ID</option>
                                                        <option value="Klik Indogrosir">Klik Indogrosir</option>
                                                        <option value="Klik Indomaret">Klik Indomaret</option>
                                                        <option value="Shopee">Shopee</option>
                                                        <option value="Tokopedia">Tokopedia</option>
                                                        <option value="Yogya Online">Yogya Online</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="ecomm-link[]" placeholder="Ecommerce Link" required="">
                                                </div>
                                                <div class="col-md-3" style="margin: auto">
                                                    <label style="margin: 0 !important">
                                                        <input type="checkbox" name="ecomm-status[]" value="1">
                                                        <span class="slider round">Active</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div><button id="add-size" type="button" class="btn btn-success">+</button></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Storage</label>
                                        {!! Form::text('storage', old('storage'), ['class' => 'form-control', 'id' => 'storage']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Functionality</label>
                                        {!! Form::text('functionality', old('functionality'), ['class' => 'form-control', 'id' => 'functionality']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Featured Image</label>
                                        <input type="file" id="file" onchange="changePhoto()" style="display:none;" name="image">
                                        <input type="hidden" name="photo">
                                        <div id="featured-container"">
                                            <canvas onclick="triggerFile();" width="1024" height="1024" id="photo2"></canvas>
                                            <canvas class="img-thumbnail" width="1024" height="1024" style="display:none;" id="photo">
                                            </canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description']) !!}
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

<template id="size-template">
    <div class="size row" style="padding-bottom: 10px; display: flex">
        <div class="col-md-3">
            <input type="text" class="form-control" name="size[]" placeholder="Size" required="">
        </div>
        <div class="col-md-3">
            <select name="ecomm-name[]" class="form-control" >
                <option value="Alfacart">Alfacart</option>
                <option value="Blibli">Blibli</option>
                <option value="Hypermart Online">Hypermart Online</option>
                <option value="JD.ID">JD.ID</option>
                <option value="Klik Indogrosir">Klik Indogrosir</option>
                <option value="Klik Indomaret">Klik Indomaret</option>
                <option value="Shopee">Shopee</option>
                <option value="Tokopedia">Tokopedia</option>
                <option value="Yogya Online">Yogya Online</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="ecomm-link[]" placeholder="Ecommerce Link" required="">
        </div>
        <div class="col-md-3" style="margin: auto">
            <label style="margin: 0 !important">
                <input type="checkbox" name="ecomm-status[]" >
                <span class="slider round">Active</span>
            </label>
        </div>
    </div>
</template>

@stop

@section('bottomExtraScript')
<script type="text/javascript" src="{{ asset('assets/admin/js/speakingurl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/slugify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
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

function triggerFile(){
    $("#file").trigger("click");
}    
function changePhoto() {
    var file = $('#file')[0];

    var canvas = $('#photo')[0];
    var context = canvas.getContext('2d');

    var canvas2 = $('#photo2')[0];
    var context2 = canvas2.getContext('2d');

    var img = new Image;
    img.src = URL.createObjectURL(file.files[0]);
    img.onload = function() {
        var w = 1024;
        var h = parseInt(1024/(img.width/img.height));
        $('#photo2').attr('width', 1024);
        $('#photo2').attr('height', h);
        context.drawImage(img, 0, 0, 1024, 1024);
        context2.drawImage(img, 0, 0, w, h);
        var dataURL = canvas2.toDataURL("image/jpg");
        $('input[name=photo]').val(dataURL);     
    }
}

function drawPhoto(im) {
    var canvas = $('#photo')[0];
    var context = canvas.getContext('2d');

    var canvas2 = $('#photo2')[0];
    var context2 = canvas2.getContext('2d');

    var img = new Image;
    img.src = im;
    img.onload = function() {
        var w = 1024;
        var h = parseInt(1024/(img.width/img.height));
        $('#photo2').attr('width', 1024);
        $('#photo2').attr('height', h);
        context.drawImage(img, 0, 0, 1024, 1024);
        context2.drawImage(img, 0, 0, w, h);
        //var dataURL = canvas2.toDataURL("image/jpg");
        //$('input[name=photo]').val(dataURL);              
    }
}   

$(function(){

    $('#slug').slugify('#name');

    resz();
    $(window).resize(function(){
        resz();
    });

    @if(!empty(old('photo')))
        drawPhoto('{{ old('photo') }}');
    @endif
});

var sizeCount = 2,
    sizeTemplate = $('#size-template').html();

$('#add-size').on('click', function(){
    var template = $('#size-template').prop('content');
    var checkbox = $(template).find('input[type="checkbox"]')[0];
    $(checkbox).attr("value", sizeCount)
    // console.log($(checkbox).attr("name"));
    // $('#size-template > div > div:nth-child(4) > label > input[type="checkbox"]')[0].setAttribute("value", `${sizeCount}`);
    // console.log($('#size-template > div > div:nth-child(4) > label > input[type="checkbox"]'))

    sizeCount++;
    $('.sizes').append($('#size-template').html());
    // $('#the-form > div > div.page-content > div > div:nth-child(2) > div > div > div > div.col-md-8 > div:nth-child(7) > div.sizes > div:nth-child(sizeCount) > div:nth-child(4) > label > input[type="checkbox"]')[0].setAttribute("value", `${sizeCount-1}`);
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

CKEDITOR.replace( 'description', options );
</script>
@stop