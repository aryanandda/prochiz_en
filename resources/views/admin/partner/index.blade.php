@extends('admin.base')

@section('bodyClass') @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
.tab-only{
    width: 100%;
    border:none;
    margin-bottom: 5px;
}   
.tab-only tr td{
    border: none;
    padding: 0; 
    padding-right: 10px;    
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
                <a href="{{ action('Admin\PartnerController@excel') }}" class="btn btn-primary waves-effect">Export</a>
                <div class="btn-group" role="group" style="margin-left: 7px;" id="status-btn">
                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="exampleGroupDrop1" data-toggle="dropdown" aria-expanded="false">
                    Status
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exampleGroupDrop1" role="menu">
                        <a class="dropdown-item" onclick="setAll()" role="menuitem">Show All</a>
                        <a class="dropdown-item" onclick="setPending()" role="menuitem">Pending</a>
                        <a class="dropdown-item" onclick="setApproved()" role="menuitem">Approved</a>
                        <a class="dropdown-item" onclick="setRejected()" role="menuitem">Rejected</a>
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
                                <th class="cell-40" scope="col">Name</th>
                                <th scope="col"></th>
                                <th class="cell-100" scope="col">City</th>
                                <th class="cell-150" scope="col">Email</th>
                                <th class="cell-80" scope="col">Status</th>
                                <th class="cell-40" scope="col">Action</th>
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

<input type="hidden" name="status" id="status" value="all">
<input type="hidden" name="trashed" id="trashed" value="all">
<input type="hidden" name="type" id="type" value="prochiz">

@stop

@section('bottomExtraScript')
<script type="text/javascript">
var tab = $('.dataTable').DataTable({
    "processing": false,
    "serverSide": true,
    "ajax": {
        "url": "{{ action('Admin\PartnerController@api') }}",
        "data": function ( d ) {
            d.status = $( "#status" ).val();
        }
    },
    "aaSorting": [[1, 'asc']],
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
        { "bSortable": false, "aTargets": [0,5] },
        { "sClass": "text-right", "aTargets": [5] },  
        {"sType": "numeric", "aTargets": [0] } 
    ]

}); 

function setAll()
{ 
    $("#status").val('all');
    tab.draw();
}

function setPending()
{ 
    $("#status").val('pending');
    tab.draw();
}

function setApproved()
{ 
    $("#status").val('approved');
    tab.draw();
}

function setRejected()
{ 
    $("#status").val('rejected');
    tab.draw();
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

function setSts(ids, x)
{
    $.ajax({
        url: '{{ $sts_link }}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 
            id: ids,
            status: x
        },
        method: "POST",
        dataType: "json"
    }).done(function( res ) {
        if(res.status==200){
            $('#statusOpt_'+ids).removeClass(res.old_class);
            $('#statusOpt_'+ids).addClass(res.new_class);
            $('#statusOpt_'+ids).html(res.v);
        }
    });
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