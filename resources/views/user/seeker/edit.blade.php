@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <h2>Edit Profile</h2>
        @if (Session::has('successMessage'))
        <div class="alert alert-success">{{Session::get('successMessage')}}</div>
        @endif
        <form action="{{route('user.update')}}" method="POST" enctype="multipart/form-data">@csrf
            <div class="col-md-8">
                <div class="form-group">
                    <label for="profile_pic">Profile image</label>
                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" />
                    @if (auth()->user()->profile_pic)
                    <img src="{{Storage::url(auth()->user()->profile_pic)}}" alt="Profile" width="150" class="mt-3">
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}" />
                </div>
                <div class="form-group mt-4">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection