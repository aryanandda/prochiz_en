@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
.img-title{
    text-align: center;
    font-size: 1em;
}    
</style>
@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')

<div class="page">

    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content Header -->

        <div class="page-header">
            <h1 class="page-title">{{ $model }} <span id="t-text" style="display: none;">- Trash</span></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $model }}</li>
            </ol>
            <div class="page-header-actions">
                <a href="{{ $create_link }}" class="btn btn-success pull-xs-right m-l-10">
                    <i class="icon md-plus" aria-hidden="true"></i> Create {{ $model }}
                </a>
            </div>
        </div>

        {!! AdminHelper::throwMessage('messages', null, 'success') !!}
        {!! AdminHelper::throwMessage('errors', null, 'danger') !!}

        <!-- Contacts Content -->
        <div class="page-content">
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-md-3">
                <div class="panel">
                    <a href="">
                        <img style="width: 100%;" src="{{ asset('storage/img/square/'.$banner->image) }}">
                    </a>
                    <div style="padding: 10px;">
                        <div class="img-title">{{ $banner->name }}</div>
                        <hr style="width: 50px; border-width: 4px; border-color: #c32c30;">
                        <p style="font-size: 0.9em; color: #666;">{{ $banner->caption }}</p>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="icon md-link" aria-hidden="true"></i>
                            </span>
                            <input type="text" value="{{ $banner->url }}" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        <button class="btn btn-pure btn-lg btn-icon btn-danger pull-xs-right" 
                        onclick="deletePerform('{{ action('Admin\BannerController@destroy', [$banner->id]) }}', '{{ $banner->name }}')"><i class="icon md-delete" aria-hidden="true"></i></button>
                        <a class="btn btn-pure btn-lg btn-icon btn-primary pull-xs-right" href="{{ action('Admin\BannerController@edit', [$banner->id]) }}"><i class="icon md-edit" aria-hidden="true"></i></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>

    </div>

</div>

<!-- Modal -->
<div class="modal fade modal-danger" id="deleteModal" aria-hidden="true"
    aria-labelledby="deleteModal" role="dialog" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Delete {{ $model }}</h4>
            </div>
            <div class="modal-body">

                <p>Are you sure want to delete <strong id="del-name"></strong>?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="delete-act" type="button" class="pull-left btn btn-danger">Yes, Delete it!</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<input type="hidden" name="status" id="status" value="all">
<input type="hidden" name="trashed" id="trashed" value="all">
<input type="hidden" name="type" id="type" value="prochiz">

@stop

@section('bottomExtraScript')
<script type="text/javascript"> 

function deletePerform(x, nm) 
{
    $('#deleteModal').modal('show');
    $('#deleteModal #del-name').html(nm);
    $('#delete-act').attr('onclick', 'deleteDo(\''+x+'\')');
}

function deleteDo(x)
{
    $.ajax({
        url: x,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        data: { 
            _method:'DELETE'
        },
        dataType: "json"
    }).done(function( res ) {
        if(res.status==200){
            $('#deleteModal').modal('hide');
            location.reload();
            return 0;
        }
    });
}
</script>
@stop