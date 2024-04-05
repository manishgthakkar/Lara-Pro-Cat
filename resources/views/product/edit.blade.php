@extends('layouts.app')

@section('content')
<div class="container mt-2">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}" enctype="multipart/form-data"> Back</a>
            </div>
        </div>
    </div>
   
  @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
  @endif
  
    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Name:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Product Name" id="name">
                    @error('name')
                     <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Image : </strong>
                     <input type="file" name="image" class="form-control" placeholder="Product Image" id="image">
                     <img src="{{asset('product/'.$product->image)}}" alt=""  height="100" width="100">
                     @if(!empty($product->image))
                    @error('image')
                      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                   @enderror
                   @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2" placeholder="Description">{{$product->description}}</textarea>
                        @error('description')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Parent Category:</strong>
                    <select name="cat_id" id="cat_id" class="form-control">
                        @foreach ($categories as $key=>$value)
                            <option value="{{$value->cat_id}}" @if($value->cat_id == $value->category_id) selected @endif>{{$value->cat_name}}</option>
                        @endforeach
                    </select>
                    @error('cat_id')
                     <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
              <button type="submit" class="btn btn-primary ml-3">Submit</button>
          
        </div>
   
    </form>
</div>

</body>
</html>