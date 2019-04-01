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
            <h1 class="page-title">{{ $model }}  By User <span id="t-text" style="display: none;">- Trash</span></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $model }} By User</li>
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
                        <a class="dropdown-item" onclick="setPending()" role="menuitem">Pending</a>
                        <a class="dropdown-item" onclick="setApproved()" role="menuitem">Approved</a>
                        <a class="dropdown-item" onclick="setRejected()" role="menuitem">Rejected</a>
                    </div>
                </div>
                <div class="btn-group" role="group" style="margin-left: 7px;" id="category-btn">
                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="exampleGroupDrop2" data-toggle="dropdown" aria-expanded="false">
                    Categories
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exampleGroupDrop2" role="menu">
                        <a class="dropdown-item" onclick="setCategory(0)" role="menuitem">Show All</a>
                        @foreach(App\Models\RecipeCategory::get() as $cat)
                        <a class="dropdown-item" onclick="setCategory({{ $cat->id }})" role="menuitem">{{ $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="btn-group" role="group" style="margin-left: 7px;" id="product-btn">
                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" id="exampleGroupDrop3" data-toggle="dropdown" aria-expanded="false">
                    Products
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exampleGroupDrop3" role="menu">
                        <a class="dropdown-item" onclick="setProduct(0)" role="menuitem">Show All</a>
                        @foreach(App\Models\Product::get() as $product)
                        <a class="dropdown-item" onclick="setProduct({{ $product->id }})" role="menuitem">{{ $product->name }}</a>
                        @endforeach
                    </div>
                </div>
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
                                <th class="cell-40" scope="col">ID</th>
                                <th class="cell-50 text-center" scope="col">Detail</th>
                                <th scope="col"></th>
                                <th class="cell-80" scope="col">Submited By</th>
                                <th class="cell-80" scope="col">KTP</th>
                                <th class="cell-80" scope="col">Category</th>
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

<input type="hidden" name="product" id="product" value="all">
<input type="hidden" name="category" id="category" value="all">
<input type="hidden" name="status" id="status" value="all">
<input type="hidden" name="trashed" id="trashed" value="all">
<input type="hidden" name="type" id="type" value="prochizlover">

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
            d.product = $( "#product" ).val();
            d.category = $( "#category" ).val();
        }
    },
    "aaSorting": [[3, 'desc']],
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
        { "bSortable": false, "aTargets": [1,7] }, 
        { "sClass": "text-center", "aTargets": [1,6,7] },    
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

function setProduct(x)
{
    $("#product").val(x);
    tab.draw();    
}

function setCategory(x)
{
    $("#category").val(x);
    tab.draw();    
}

function trashed()
{
    $('#category-btn').hide();
    $('#product-btn').hide();
    $('#status-btn').hide();
    $("#status").val('all');

    $("#t-text").show();
    $("#t-empty").show();
    $("#trashed").val('trashed');
    tab.draw();
    var htm = '<button id="t-item" onclick="untrashed()" type="button" class="btn btn-primary" style="margin-right:-3px;">'+
              '<i class="icon md-arrow-left"></i> Back to {{ $model }}'+
              '</button>';
    $("#t-item").replaceWith(htm);
} 

function untrashed()
{
    $('#status-btn').show();
    $('#category-btn').show();
    $('#product-btn').show();
    $("#status").val('all');
    
    $("#t-empty").hide();
    $("#t-text").hide();
    $("#trashed").val('all');
    tab.draw();
    var htm = '<button id="t-item" onclick="trashed()" type="button" class="btn btn-danger">'+
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