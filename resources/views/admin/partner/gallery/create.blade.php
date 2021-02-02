@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/clockpicker/bootstrap-clockpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/select2/select2.css') }}">
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
            <h1 class="page-title">Add Image</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ $index_link }}">Partner Gallery</a></li>
                <li class="breadcrumb-item active">Add Image</li>
            </ol>
            <div class="page-header-actions">
                <a href="{{ $index_link }}" class="btn btn-warning ">
                    <i class="icon md-arrow-left"></i> Back
                </a>
                <button onclick="submitImage()" type="button" class="btn btn-primary m-l-5">
                    Submit
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
                                        <label>Caption</label>
                                        {!! Form::text('caption', old('caption'), ['class' => 'form-control', 'id' => 'caption']) !!}
                                    </div>
                                    <div class="form-group">
                                        <?php 
                                            $partners = App\Models\Partner::orderBy('name')->pluck('name', 'id');
                                        ?>
                                        <label class="form-label">Partner </label>
                                        {!! Form::select('partner_id', $partners, null, array('class' => 'form-control', 'data-plugin' => 'select2') ) !!}
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
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
                </div>
            </div>
        </div>
    </div>

    <input name="status" id="status" type="hidden">
{!! Form::close() !!}
</div>

@stop

@section('bottomExtraScript')
<script src="{{ asset('assets/admin/theme/global/js/Plugin/select2.js') }}"></script>
<script src="{{ asset('assets/admin/theme/global/js/Plugin/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/admin/theme/global/js/Plugin/multi-select.js') }}"></script>
<script type="text/javascript">
function submitImage()
{
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
    $(".handling-select").select2();
    resz();
    $(window).resize(function(){
        resz();
    });

    @if(!empty(old('photo')))
        drawPhoto('{{ old('photo') }}');
    @endif
});

function resz()
{
    $('#featured-container').height($('#featured-container').width());    
}
</script>
@stop