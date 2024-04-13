@extends('layouts.admin.main')

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
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control" id="logo" name="profile_pic" />
                    @if (auth()->user()->profile_pic)
                    <img src="{{Storage::url(auth()->user()->profile_pic)}}" alt="Profile" width="150" class="mt-3">
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Company name</label>
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
