@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')

<?php 
    $name = $recipe->name;
    $slug = $recipe->slug;
    $metadesc = $recipe->metadesc;
    $content = $recipe->content;
    $image =  $recipe->image;
    $published_at =  $recipe->published_at;
    $category = $recipe->recipe_category_id;
    $time = $recipe->time;
    $servings = $recipe->servings;
    $description = $recipe->description;
    $chef = $recipe->chef;

    if(!empty(old('name'))){
        $name = old('name');
        $slug = old('slug');
        $metadesc = old('metadesc');
        $video = old('video');
        $content = old('content');
        $published_at =  old('published_at');  
        $category = old('category');  
        $time = old('time');  
        $servings = old('servings');  
        $description = old('description');  
        $chef = old('chef');  
    }

    $published_at = date("Y-m-d", strtotime($published_at));
?>

<div class="page">
{!! Form::open(['url' => $update_link, 'id' => 'the-form', 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content Header -->

        <div class="page-header">
            <h1 class="page-name">Update {{ $model }}</h1>
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
                                        <label>Product</label>
                                        <div class="row">
                                        @foreach(App\Models\Product::get() as $pro)
                                            <?php 
                                                $fcheck = false;
                                                foreach ($recipe->products as $pro2) {
                                                    if($pro2->name==$pro->name)
                                                        $fcheck = true;
                                                }
                                            ?>
                                            <div class="checkbox col-md-6">
                                                <label>
                                                {!! Form::checkbox('product[]', $pro->id, $fcheck) !!}
                                                {{ $pro->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        {!! Form::select('category', App\Models\RecipeCategory::pluck('name', 'id'), $category, ['class' => 'form-control', 'id' => 'category']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Recipe Name</label>
                                        {!! Form::text('name', $name, ['class' => 'form-control', 'id' => 'name']) !!}
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
                                        <label>Minute</label>
                                        {!! Form::text('time', $time, ['class' => 'form-control', 'id' => 'time']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Servings</label>
                                        {!! Form::text('servings', $servings, ['class' => 'form-control', 'id' => 'servings']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Chef</label>
                                        {!! Form::text('chef', $chef, ['class' => 'form-control', 'id' => 'chef']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4"">
                                    <div class="form-group">
                                        <label>Published At</label>
                                        <div class="input-group">
                                            {!! Form::text('published_at', $published_at, ['class' => 'datepicker form-control', 'id' => 'published_at']) !!}
                                            <span class="input-group-addon">
                                                <span class="icon md-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
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
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        {!! Form::textarea('description', $description, ['class' => 'form-control', 'id' => 'description']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-b-0">
                                        <div><label class="control-label">Ingredients</label></div>

                                        <div class="ingredients">
                                            <?php $i=0; ?>
                                            @foreach($recipe->ingredients as $ingredient)
                                            <?php $i++; ?>
                                            <div class="ingredient row" style="padding-bottom: 10px">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="ingredient-name[]" placeholder="Ingredient {{ $i }}" required="" value="{{ $ingredient->name }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="ingredient-amount[]" placeholder="Amount {{ $i }}" required="" value="{{ $ingredient->amount }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <br>
                                        <div><button id="add-ingredient" type="button" class="btn btn-success">+</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group m-b-0">
                                <div><label class="control-label">Steps</label></div>

                                <div class="directions">
                                    <?php $i=0; ?>
                                    @foreach($recipe->directions as $direction)
                                    <?php $i++; ?>
                                    <div class="direction" style="padding-bottom: 10px">
                                        <textarea type="text" class="form-control" name="direction-name[]" placeholder="Step {{ $i }}" required="">{{ $direction->name }}</textarea>
                                    </div>
                                    @endforeach
                                </div>

                                <div><button id="add-direction" type="button" class="btn btn-success">+</button></div>
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

<template id="ingredient-template">
    <div class="ingredient row" style="padding-bottom: 10px">
        <div class="col-md-6">
            <input type="text" class="form-control" name="ingredient-name[]" placeholder="Ingredient 1">
        </div>

        <div class="col-md-6">
            <input type="text" class="form-control" name="ingredient-amount[]" placeholder="Amount 1">
        </div>
    </div>
</template>

<template id="direction-template">
    <div class="direction" style="padding-bottom: 10px">
        <textarea type="text" class="form-control" name="direction-name[]" placeholder="Step 1"></textarea>
    </div>
</template>

@stop

@section('bottomExtraScript')
<script type="text/javascript" src="{{ asset('assets/admin/js/speakingurl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/slugify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/ckeditor/ckeditor.js?v=1') }}"></script>
<script type="text/javascript">

var ingredientCount = {{ $recipe->ingredients->count() }},
    directionCount = {{ $recipe->directions->count() }},
    ingredientTemplate = $('#ingredient-template').html();
    directionTemplate = $('#direction-template').html();

$('#add-ingredient').on('click', function(){
    ingredientCount++;
    ingredientHTML = ingredientTemplate.replace(/Ingredient 1/g, 'Ingredient ' + ingredientCount);
    ingredientHTML = ingredientHTML.replace(/Amount 1/g, 'Amount ' + ingredientCount);

    $('.ingredients').append(ingredientHTML);
});

$('#add-direction').on('click', function(){
    directionCount++;
    directionHTML = directionTemplate.replace(/Step 1/g, 'Step ' + directionCount);

    $('.directions').append(directionHTML);
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

    $('#category').select2();

    $("#published_at").datepicker({
        format: 'yyyy-mm-dd'
    });

    // $('#slug').slugify('#name');

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
    height: 400,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
};

CKEDITOR.replace( 'description', options );
</script>
@stop