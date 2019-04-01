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
                <button id="t-item" onclick="trashed()" type="button" class="btn btn-danger m-l-10">
                    <i class="icon md-delete"></i> Trashed {{ $model }}
                </button>
                <button id="t-empty" onclick="emptyTrash()" type="button" class="btn btn-danger m-l-10" style="display: none;">
                    <i class="icon md-delete"></i> Empty Trash
                </button>
                <div class="btn-group" role="group" style="margin-left: 7px;" id="status-btn">
                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="exampleGroupDrop1" data-toggle="dropdown" aria-expanded="false">
                    Status
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exampleGroupDrop1" role="menu">
                        <a class="dropdown-item" onclick="setAll()" role="menuitem">Show All</a>
                        <a class="dropdown-item" onclick="setDraft()" role="menuitem">Draft Only</a>
                        <a class="dropdown-item" onclick="setPublished()" role="menuitem">Published Only</a>
                    </div>
                </div>
                <a href="{{ $create_link }}" class="btn btn-success pull-xs-right m-l-10">
                    <i class="icon md-plus" aria-hidden="true"></i> Create {{ $model }}
                </a>
            </div>
        </div>

        {!! AdminHelper::throwMessage('messages', null, 'success') !!}
        {!! AdminHelper::throwMessage('errors', null, 'danger') !!}

        <!-- Contacts Content -->
        <div class="page-content">

            <div class="panel">
                <div class="panel-body">

                    <!-- Contacts -->
                    <table class="table table-default dataTable">
                        <thead>
                            <tr>
                                @if($model=='Video')
                                <th class="text-center">Video</th>
                                <th scope="col"></th>
                                @else
                                <th class="cell-50 text-center" scope="col">Detail</th>
                                <th scope="col"></th>
                                @endif
                                <th class="cell-80" scope="col">Published At</th>
                                <th class="cell-50" scope="col">Status</th>
                                <th class="cell-50 text-center" scope="col">Act</th>
                            </tr>
                        </thead>
                    </table>

                </div>
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

<!-- Modal -->
<div class="modal fade modal-success" id="restoreModal" aria-hidden="true"
    aria-labelledby="restoreModal" role="dialog" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Restore {{ $model }}</h4>
            </div>
            <div class="modal-body">

                <p>Are you sure want to restore <strong id="res-name"></strong>?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="restore-act" type="button" class="pull-left btn btn-success">Yes, Restore it!</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade modal-danger" id="emptyModal" aria-hidden="true"
    aria-labelledby="emptyModal" role="dialog" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Empty {{ $model }}</h4>
            </div>
            <div class="modal-body">

                <p>Are you sure want to delete all of trashed {{ $model }}?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="empty-act" type="button" class="pull-left btn btn-danger">Yes, Delete all!</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<input type="hidden" name="status" id="status" value="all">
<input type="hidden" name="trashed" id="trashed" value="all">
<input type="hidden" name="type" id="type" value="{{ strtolower($model) }}">

@stop

@section('bottomExtraScript')
<script type="text/javascript">
var tab = $('.dataTable').DataTable({
    "processing": false,
    "serverSide": true,
    "ajax": {
        "url": "{{ $api_link }}",
        "data": function ( d ) {
            d.trashed = $( "#trashed" ).val();
            d.type = $( "#type" ).val();
            d.status = $( "#status" ).val();
        }
    },
    "aaSorting": [[2, 'desc']],
    "bJQueryUI": false,
    "bAutoWidth": true,
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "fnDrawCallback":   function( oSettings ) {
        $(".article-thumb").magnificPopup({
            type: "image"
        });
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [0,4] }, 
        { "sClass": "text-center", "aTargets": [0,4] },  
        {"sType": "numeric", "aTargets": [0] } 
    ]

});  

function setAll()
{ 
    $("#status").val('all');
    tab.draw();
}

function setDraft()
{ 
    $("#status").val('draft');
    tab.draw();
}

function setPublished()
{ 
    $("#status").val('published');
    tab.draw();
}

function trashed()
{
    $('#status-btn').hide();
    $("#status").val('all');

    $("#t-text").show();
    $("#t-empty").show();
    $("#trashed").val('trashed');
    tab.draw();
    var htm = '<button id="t-item" onclick="untrashed()" type="button" class="btn btn-primary m-l-10" style="margin-right:-3px;">'+
              '<i class="icon md-arrow-left"></i> Back to {{ $model }}'+
              '</button>';
    $("#t-item").replaceWith(htm);
} 

function untrashed()
{
    $('#status-btn').show();
    $("#status").val('all');

    $("#t-empty").hide();
    $("#t-text").hide();
    $("#trashed").val('all');
    tab.draw();
    var htm = '<button id="t-item" onclick="trashed()" type="button" class="btn btn-danger m-l-10">'+
              '<i class="icon md-delete"></i> Trashed {{ $model }}'+
              '</button>';
    $("#t-item").replaceWith(htm);
}


function emptyTrash()
{
    $('#emptyModal').modal('show');
    $('#empty-act').click(function(event){
        event.stopPropagation();
        $.ajax({
            url: '{{ $empty_link }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            dataType: "json"
        }).done(function( res ) {
            if(res.status==200){
                $('#emptyModal').modal('hide');
                return tab.draw();
            }
        });
    });
}

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
            return tab.draw();
        }
    });
}

function restorePerform(x, nm) 
{
    $('#restoreModal').modal('show');
    $('#restoreModal #res-name').html(nm);
    $('#restore-act').attr('onclick', 'restoreDo(\''+x+'\')');
}

function restoreDo(x)
{
    $.ajax({
        url: x,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        dataType: "json"
    }).done(function( res ) {
        if(res.status==200){
            $('#restoreModal').modal('hide');
            return tab.draw();
        }
    });    
}
</script>
@stop