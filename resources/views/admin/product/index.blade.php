<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Inventory System - Products')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<div class="box">
    <div class="box-header">
        <div class="btn-group pull-right">
            <a href="{{route('admin.products.create')}}" class="btn btn-primary pull-right" style="margin-right:10px;">
                <i class="fa fa-fw fa-cube "></i>
                <span class="text">Add Product</span>
            </a>
        </div>


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="proddaTatable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>UUID</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
         $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
            $('#proddaTatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('/admin/products') }}',
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'name', name: 'name'},
            {data: 'uuid', name: 'uuid'},
            {data: 'category', name: 'category'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'},
            ],
            "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0, 5 ] },
            { "bSearchable": false, "aTargets": [ 0, 5 ] }
            ]
    });
            $(document).on("click", ".delete_prod", function() {
    var Id = $(this).attr('data-id');
            Swal.fire({
            title: 'Are you sure?',
                    text: "You won't delete this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
    if (result.value) {
 $.ajax({
    url: "{{url('admin/products/')}}" + '/' + Id,
            method: 'DELETE',
            success: function(result){
            Swal.fire(
                    'Deleted!',
                    '',
                    'success'
                    )
                    $('#proddaTatable').DataTable().ajax.reload();
            }
    });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
    Swal.fire(
            'Cancelled',
            '',
            'error'
            )
    }
    })
            return false;
    });
    });
</script>
@stop