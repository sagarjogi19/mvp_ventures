@extends('adminlte::page')
@section('title', 'Inventory System - Product Add')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{isset($product)?'Edit':'Add'}} Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmProd" id="frmProd" method="post" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                                {{ session()->get('success') }}
                        </div>
                @endif
                @if (!empty($errors->toarray()))
                 <div class="alert alert-danger">
                        <span>{{ $errors->first() }}</span>
                </div>
                @endif
                    <input type="hidden" id="prod_id" name="prod_id" value="{{ isset($product)?be64($product->id):'' }}">
                   
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ isset($product)?$product->name:old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="uuid" class="col-sm-2 control-label">UUID<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uuid" name="uuid" placeholder="UUID" value="{{ isset($product)?$product->uuid:old('uuid') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Category<span class="required"> * </span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="category_id" id="category_id">
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
                            <textarea class="form-control" id="description" name="description" placeholder="Description">{{ isset($product)?$product->description:old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="images" class="col-sm-2 control-label">Product Images</label>
                        <div class="col-sm-8">
                            <input type="file" id="images" name="images[]" class="form-control-file" accept="image/*" multiple>
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
                            <input type="checkbox" id="name" name="is_active" {{isset($product)?($product->is_active==1)?'checked':'':''}}>
                        </label>
                      </div>
                    </div>


                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary submit">Submit</button>
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