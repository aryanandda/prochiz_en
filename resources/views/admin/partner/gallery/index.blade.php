@extends('admin.base')

@section('bodyClass')
    class="animsition app-contacts page-aside-left"
@stop

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
.page-aside .list-group.has-actions .list-group-item:hover .item-right {
    display: inline-block;
}
</style>
@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')

<div class="page">

    <div class="page-aside">
        <!-- Contacts Sidebar -->
        <div class="page-aside-switch">
            <i class="icon md-chevron-left" aria-hidden="true"></i>
            <i class="icon md-chevron-right" aria-hidden="true"></i>
        </div>
        <div class="page-aside-inner page-aside-scroll">
            <div data-role="container">
                <div data-role="content">
                    <div class="page-aside-section" id="leftsidebar">
                        <h5 class="page-aside-title">Partners</h5>
                        <div class="list-group has-actions">
                            @foreach(App\Models\Partner::orderBy('name')->get() as $partner)
                            <div class="list-group-item" data-plugin="editlist" onclick="setPartner({{ $partner->id }}, '{{ $partner->name }}')">
                                <div class="list-content">
                                    <span class="item-right">{{ $partner->galleries->count() }}</span>
                                    <span class="list-text">{{ $partner->name }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Content -->
    <div class="page-main">
        <!-- Contacts Content Header -->

        <div class="page-header">
            <h1 class="page-title">Partner Gallery <span id="t-text">{{ App\Models\Partner::first()->name }}</span></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $model }}</li>
            </ol>
            <div class="page-header-actions">
                <?php /*
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
                */ ?>
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
                                <th class="cell-40" scope="col">image</th>
                                <th class="cell-160" width="150">Partner</th>
                                <th scope="col">Caption</th>
                                <th class="cell-80" scope="col">Action</th>
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
<input type="hidden" name="partner_id" id="partner_id" value="{{ App\Models\Partner::first()->id }}">
<input type="hidden" name="type" id="type" value="prochiz">

@stop

@section('bottomExtraScript')
<script type="text/javascript">
var tab = $('.dataTable').DataTable({
    "processing": false,
    "serverSide": true,
    "ajax": {
        "url": "{{ action('Admin\PartnerGalleryController@api') }}",
        "data": function ( d ) {
            d.status = $( "#status" ).val();
            d.partner_id = $( "#partner_id" ).val();
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
        { "bSortable": false, "aTargets": [0,3] },
        { "sClass": "text-right", "aTargets": [3] },  
        {"sType": "numeric", "aTargets": [0] } 
    ]

}); 

function setPartner(idx, nm)
{ 
    $("#partner_id").val(idx);
    $("#t-text").html(' - '+nm);
    tab.draw();
}

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

$(function(){
    $("#leftsidebar").height($(window).height()-100);
    $("#leftsidebar").css('overflow-y', 'scroll');
});
</script>
@stop