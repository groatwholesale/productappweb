@extends('layouts.mainapp')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Products</h1>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Products Title</label>
                    <input type="text" name="title" value="{{ $product->title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Products Title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Products Description">{{ $product->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Price</label>
                    <input type="number" name="price" value="{{ $product->price }}" class="form-control @error('price') is-invalid @enderror" placeholder="Enter Products Price">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Category</label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @forelse ($category as $singlecategory)
                        <option value="{{$singlecategory->id}}" {{ $product->category_id==$singlecategory->id ? "selected" : "" }} >{{$singlecategory->name}}</option>
                    @empty
                        <option value="">No category found</option>
                    @endforelse
                    </select>
                    @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Images</label>
                    <input type="file" name="images[]" class="form-control @error('description') is-invalid @enderror" multiple>
                    @error('images')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    @forelse ($product->attachments as $image)
                        <div class="col-3">
                            <img src="{{$image->file_name}}" width="100">
                        </div>
                    @empty
                        <p>No images found</p>                        
                    @endforelse
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
