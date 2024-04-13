@extends('layouts.app')

@section('title', 'Upload Resume')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <h2>Upload Resume</h2>
        @if (Session::has('successMessage'))
        <div class="alert alert-success">{{Session::get('successMessage')}}</div>
        @endif
        @if (Session::has('errorMessage'))
        <div class="alert alert-danger">{{Session::get('errorMessage')}}</div>
        @endif
        <form action="{{route('user.updateResume')}}" method="POST" enctype="multipart/form-data">@csrf
            <div class="col-md-8">
                <div class="form-group">
                    <label for="resume">Upload a resume</label>
                    <input type="file" id="resume" name="resume" class="form-control" />
                    @if ($errors->has('resume'))
                    <div class="error">{{ $errors->first('resume') }}</div>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <button class="btn btn-success" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .error {
        color: red;
    }
</style>

@endsection
