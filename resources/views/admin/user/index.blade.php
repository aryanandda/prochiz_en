@extends('admin.base')

@section('bodyClass')  @stop

@section('extraStyle')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
.table td, .table th {
    vertical-align: middle;
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
            <h1 class="page-title">User</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
            <div class="page-header-actions">
            <?php /*
                <button" class="btn btn-success pull-xs-right ml-1" onclick="createAction()">Create User</button>
            */ ?>
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
                                <th scope="col">Name</th>
                                <th class="cell-250" scope="col">Email</th>
                                <th class="cell-250" scope="col">KTP</th>
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
<div class="modal fade" id="createModal" aria-hidden="true"
    aria-labelledby="createModal" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Create User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label">Nama </label>
                        <input type="text" class="form-control" name="name" />
                        <div class="error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Email </label>
                        <input type="text" class="form-control" name="email" />
                        <div class="error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Password </label>
                        <input type="password" class="form-control" name="password" />
                        <div class="error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" />
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick="createPerform()" type="button" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="updateModal" aria-hidden="true"
    aria-labelledby="updateModal" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Update User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label">Nama </label>
                        <input type="text" class="form-control" name="name" />
                        <div class="error"></div>
                    </div>
	                <div class="form-group col-md-12">
	                    <label class="form-label">Email </label>
	                    <input type="text" class="form-control" name="email" />
	                    <div class="error"></div>
	                </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Password </label>
                        <input type="password" class="form-control" name="password" />
                        <div class="error"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" />
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick="updatePerform()" type="button" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade modal-danger" id="deleteModal" aria-hidden="true"
    aria-labelledby="deleteModal" role="dialog" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Delete User</h4>
            </div>
            <div class="modal-body">

                <p>Are you sure want to delete <strong id="del-name"></strong>?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="delete-act" type="submit" class="pull-left btn btn-danger">Yes, Delete it!</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

@stop

@section('bottomExtraScript')
<script type="text/javascript">
var tab = $('.dataTable').DataTable({
    "processing": false,
    "serverSide": true,
    "ajax": {
        "url": "{{ action('Admin\UserController@api') }}"
    },
    "aaSorting": [[0, 'asc']],
    "bJQueryUI": false,
    "bAutoWidth": true,
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "fnDrawCallback":   function( oSettings ) {

    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [4] },
        { "sClass": "text-right", "aTargets": [4] },  
        {"sType": "numeric", "aTargets": [0] } 
    ]

});  

function createAction()
{
    $('#createModal .error').empty();
    $('#createModal').modal('show');
    $('#createModal select').val('');
}

function createPerform()
{
    $('#createModal .error').empty();

    var in_name = $('#createModal input[name=name]').val();
    var in_password = $('#createModal input[name=password]').val();
    var in_password_confirmation = $('#createModal input[name=password_confirmation]').val();
    var in_email = $('#createModal input[name=email]').val();

    var request = $.ajax({
        url: "{{ action('Admin\UserController@store') }}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        data: { 
            name:in_name,
            password:in_password,
            password_confirmation:in_password_confirmation,
            email:in_email
        },
        dataType: "json"
    });

    request.done(function( res ) {
        $.each(res.data, function(k,v) {
            console.log(k);
            $('#createModal input[name='+k+']').next().empty();
            $('#createModal select[name='+k+']').next().empty();
        });
        if(res.status>=400){
            $.each(res.errors, function(k,v) {
                $('#createModal input[name='+k+']').next().append(v);
                $('#createModal select[name='+k+']').next().append(v);
            });
        }
        tab.draw(false);
        if(res.status==200){
            $('#createModal').modal('hide');
            $('#createModal input').val('');
            $('#createModal select').val('');
            toastr.success('Data has been submitted');
        }
    });
}


function updateAction(ob)
{

    $('#updateModal .error').empty();

    $('#updateModal input[name=name]').val(ob.name);
    $('#updateModal input[name=phone]').val(ob.phone);
    $('#updateModal input[name=email]').val(ob.email);
    $('#updateModal select[name=city]').val(ob.city);

    $('#updateModal input[name=id]').val(ob.id);

    $('#updateModal').modal('show');
}

function updatePerform()
{
    var x = $('#updateModal input[name=id]').val();
    var urlx = '{{ action('Admin\UserController@index') }}/'+x;

    var in_name = $('#updateModal input[name=name]').val();
    var in_password = $('#updateModal input[name=password]').val();
    var in_password_confirmation = $('#updateModal input[name=password_confirmation]').val();
    var in_email = $('#updateModal input[name=email]').val();

    var request = $.ajax({
        url: urlx,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        data: { 
            _method:'PUT',
            name:in_name,
            password:in_password,
            password_confirmation:in_password_confirmation,
            email:in_email
        },
        dataType: "json"
    });

    request.done(function( res ) {
        $.each(res.data, function(k,v) {
            $('#updateModal input[name='+k+']').next().empty();
            $('#updateModal select[name='+k+']').next().empty();
        });
        if(res.status>=400){
            $.each(res.errors, function(k,v) {
                $('#updateModal input[name='+k+']').next().append(v);
                $('#updateModal select[name='+k+']').next().append(v);
            });
        }
        tab.draw(false);
        if(res.status==200){
            $('#updateModal').modal('hide');
            toastr.success('Data has been updated');
        }
    });
}

function deletePerform(x, nm) 
{
    var urlx = '{{ action('Admin\UserController@index') }}/'+x;
    $('#deleteModal').modal('show');
    $('#deleteModal #del-name').html(nm);
    $('#deleteModal #delete-act').click(function(){
        var request = $.ajax({
            url: urlx,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            data: { 
                _method:'DELETE'
            },
            dataType: "json"
        });

        request.done(function( res ) {
            if(res.status==200){
                $('#deleteModal').modal('hide');
            }
            tab.draw();
        });
    });
}
</script>
@stop