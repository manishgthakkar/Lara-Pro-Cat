@extends('layouts.app')

@section('content')
<div class="container mt-2">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('categories.index') }}" enctype="multipart/form-data"> Back</a>
            </div>
        </div>
    </div>
   
  @if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
  @endif
  
    <form action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category Name:</strong>
                    <input type="text" name="cat_name" value="{{ $category->cat_name }}" class="form-control" placeholder="Category name" id="name">
                    @error('name')
                     <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category Image : </strong>
                     <input type="file" name="image" class="form-control" placeholder="Category Image" id="image">
                     <img src="{{asset('category/'.$category->image)}}" alt=""  height="100" width="100">
                    @error('email')
                      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                   @enderror
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Parent Category:</strong>
                    <select name="parent_cat" id="parent_cat" class="form-control">
                        <option value="1" @if($category->parent_cat == '1') selected @endif>Mobile</option>
                        <option value="2" @if($category->parent_cat == '2') selected @endif>Laptop</option>
                        <option value="3" @if($category->parent_cat == '3') selected @endif>Computer</option>
                    </select>
                    @error('address')
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