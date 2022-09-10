@extends('layouts.mainapp')

@section('title','Create Product')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Products</h1>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="producttop">Products Top</label>
                    <input type="checkbox" name="producttop" id="producttop" @if(old('producttop')==1) checked @endif value="1">
                </div>
                <div class="form-group">
                    <label for="">Products Category</label>
                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @forelse ($category as $singlecategory)
                        <option value="{{$singlecategory->id}}" {{ old('category')==$singlecategory->id ? "selected" : "" }} >{{$singlecategory->name}}</option>
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
                    <label for="">Products Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Products Title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Description</label>
                    <textarea name="description" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Products Description"></textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Products Price</label>
                    <input type="text" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="Enter Products Price">
                    @error('price')
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
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
