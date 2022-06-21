@extends('layouts.mainapp')
@section('title','Edit User')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="userid" value="{{$user->id}}">
                <div class="form-group">
                    <label for="">User Name</label>
                    <input type="text" name="username" value="{{ $user->name }}" class="form-control @error('username') is-invalid @enderror" placeholder="Enter User Name">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">BirthDate</label>
                    <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="form-control @error('birth_date') is-invalid @enderror" placeholder="Enter Birthdate">
                    @error('birth_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Gender</label>
                    <div class="form-check form-check-inline ml-3">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male"  @if($user->gender=="male") checked @endif>
                        <label class="form-check-label" for="male">Male</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" @if($user->gender=="female") checked @endif>
                        <label class="form-check-label" for="female">Female</label>
                      </div>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <textarea name="address" value="{{ $user->address }}" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address"></textarea>
                    @error('address')
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
