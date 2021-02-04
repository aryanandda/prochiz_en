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

<?php 
    $name = $event->name;
    $slug = $event->slug;
    $metadesc = $event->metadesc;
    $description = $event->description;
    $tagline = $event->tagline;
    $ingredients = $event->ingredients;
    $characteristics = $event->characteristics;
//    $size = $event->size;
    $storage = $event->storage;
    $functionality = $event->functionality;
    $image =  $event->image;

    if(!empty(old('name'))){
        $name = old('name');
        $slug = old('slug');
        $metadesc = old('metadesc');
        $description = old('description');
        $tagline = old('tagline');
        $ingredients = old('ingredients');
        $characteristics = old('characteristics');
//        $size = old('size');
        $storage = old('storage');
        $functionality = old('functionality');
    }
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Title</label>
                                        {!! Form::text('name', $name, ['class' => 'form-control', 'id' => 'name']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Slug</label>
                                        {!! Form::text('slug', $slug, ['class' => 'form-control', 'id' => 'slug']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Tagline</label>
                                        {!! Form::text('tagline', $tagline, ['class' => 'form-control', 'id' => 'tagline']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        {!! Form::textarea('metadesc', $metadesc, ['class' => 'form-control', 'rows' => '3']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Bahan</label>
                                        {!! Form::textarea('ingredients', $ingredients, ['class' => 'form-control', 'id' => 'ingredients', 'rows' => '3']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Karakteristik</label>
                                        {!! Form::text('characteristics', $characteristics, ['class' => 'form-control', 'id' => 'characteristics']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Size</label>
                                        <div class="sizes">
                                            <?php $i=0; ?>
                                            @foreach($event->sizes as $size)

                                                <div class="size row" style="padding-bottom: 10px; display: flex">
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="size[]" placeholder="Size" required="" value="{{ $size->size }}">
                                                        {{--                                                            <input type="text" class="form-control" name="productSizeId[]" placeholder="Size" required="" value="{{ $size->id }}" style="display: none">--}}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="ecomm-name[]" class="form-control">
                                                            <option value="Alfacart" <?php if($event->sizes[$i]->ecomm_name == 'Alfacart'){echo("selected");}?>>Alfacart</option>
                                                            <option value="Blibli" <?php if($event->sizes[$i]->ecomm_name == 'Blibli'){echo("selected");}?>>Blibli</option>
                                                            <option value="Hypermart Online" <?php if($event->sizes[$i]->ecomm_name == 'Hypermart Online'){echo("selected");}?>>Hypermart Online</option>
                                                            <option value="JD.ID" <?php if($event->sizes[$i]->ecomm_name == 'JD.ID'){echo("selected");}?>>JD.ID</option>
                                                            <option value="Klik Indogrosir" <?php if($event->sizes[$i]->ecomm_name == 'Klik Indogrosir'){echo("selected");}?>>Klik Indogrosir</option>
                                                            <option value="Klik Indomaret" <?php if($event->sizes[$i]->ecomm_name == 'Klik Indomaret'){echo("selected");}?>>Klik Indomaret</option>
                                                            <option value="Shopee" <?php if($event->sizes[$i]->ecomm_name == 'Shopee'){echo("selected");}?>>Shopee</option>
                                                            <option value="Tokopedia" <?php if($event->sizes[$i]->ecomm_name == 'Tokopedia'){echo("selected");}?>>Tokopedia</option>
                                                            <option value="Yogya Online" <?php if($event->sizes[$i]->ecomm_name == 'Yogya Online'){echo("selected");}?>>Yogya Online</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="ecomm-link[]" placeholder="Ecommerce Link" required="" value="{{ $size->ecomm_link }}">
                                                    </div>
                                                    <div class="col-md-3" style="margin: auto">
                                                        <label style="margin: 0 !important">
                                                            <input type="checkbox" name="ecomm-status[]" {{ $size->is_active == 1 ? 'checked' : '' }} required="" value="{{$i}}">
                                                            <span class="slider round">Active</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php $i++; ?>

                                            @endforeach
                                        </div>
                                        <div><button id="add-size" type="button" class="btn btn-success">+</button></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Storage</label>
                                        {!! Form::text('storage', $storage, ['class' => 'form-control', 'id' => 'storage']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label>Functionality</label>
                                        {!! Form::text('functionality', $functionality, ['class' => 'form-control', 'id' => 'functionality']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4"">
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
                                        {!! Form::textarea('description', $description, ['class' => 'form-control', 'id' => 'description']) !!}
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
                <input type="checkbox" name="ecomm-status[]">
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

var sizeCount = {{ $event->sizes->count() }},
    sizeTemplate = $('#size-template').html();

$('#add-size').on('click', function(){
    var template = $('#size-template').prop('content');
    var checkbox = $(template).find('input[type="checkbox"]')[0];
    $(checkbox).attr("value", sizeCount)
    sizeCount++;

    $('.sizes').append($('#size-template').html());
});

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
    @else
        drawPhoto('{{ asset('storage/img/'.$image) }}');
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

CKEDITOR.replace( 'description', options );
</script>
@stop