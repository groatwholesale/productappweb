@extends('layouts.mainapp')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('category.update',$category->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <input type="text" name="categoryname" value="{{ $category->name }}" class="form-control @error('categoryname') is-invalid @enderror" placeholder="Enter Category Name">
                    @error('categoryname')
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
