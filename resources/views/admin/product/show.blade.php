@extends('adminlte::page')
@section('title', 'Inventory System - Product View')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmProd" id="frmProd">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $product->name}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="uuid" class="col-sm-2 control-label">UUID<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uuid" name="uuid" placeholder="UUID" value="{{ $product->uuid}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Category<span class="required"> * </span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="category_id" id="category_id" disabled>
                                <option value="">Select Category</option>
                                @foreach($category as $k=>$v)
                                @php echo $v; @endphp
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="description" name="description" placeholder="Description" readonly>{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images" class="col-sm-2 control-label">Product Images</label>
                        <div class="col-sm-8">
                            @if(isset($product))
                                @if(!$product->images->isEmpty())
                                    @foreach($product->images as $v)
                                     <img id="iconImage" src="{{Storage::disk('public')->url('products/'.$v->image)}}" style="width: 100px;height: 100px;">
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="images" class="col-sm-2 control-label">Is Active</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="name" disabled name="is_active" {{($product->is_active==1)?'checked':''}}>
                        </label>
                      </div>
                    </div>


                </div>
                <div class="box-footer">
                    <a href="{{route('admin.products.index')}}" class="btn btn-info">Back</a>
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
@if(isset($product))
    var cat_id='{{$product->category_id}}';
    $('#category_id').val(cat_id);
@endif
</script>
@stop