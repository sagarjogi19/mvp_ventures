@extends('adminlte::page')
@section('title', 'Inventory System - Category View')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Category</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmCat" id="frmCat">
                <div class="box-body">
                   
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $category->name }}" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-sm-2 control-label">Parent Category</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="parent_id" id="parent_id" readonly disabled>
                                <option value="">Select Parent Category</option>
                                @foreach($parent as $k=>$v)
                                @php echo $v; @endphp
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                    <a href="{{route('admin.category.index')}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>

        <!-- /.box-body -->

        <!-- /.box-footer -->

    </div>
    <!-- /.box -->
    <!-- general form elements disabled -->

    <!-- /.box -->
</div>

@endsection
@section('css')

@stop
@section('js')
<script>
@if(isset($category))
    var cat_id='{{$category->parent_id}}';
    $('#parent_id').val(cat_id);
@endif
</script>
@stop