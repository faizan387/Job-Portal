@extends('layouts.admin.main')

@section('title', 'Edit')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <h1>{{$listing->title}}</h1>
            @if (Session::has('successMessage'))
            <div class="alert alert-success">{{Session::get('successMessage')}}</div>
            @endif
            <form action="{{route('job.update', [$listing->id])}}" method="POST" enctype="multipart/form-data">@csrf
                @method('PUT')
                <div class="form-group">
                    <label for="feature_image">Image</label>
                    <input type="file" name="feature_image" id="feature_image" class="form-control" />
                    @if ($errors->has('feature_image'))
                    <div class="error">{{ $errors->first('feature_image') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{$listing->title}}" />
                    @if ($errors->has('title'))
                    <div class="error">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control summernote">{{$listing->description}}</textarea>
                    @if ($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="roles">Roles & responsibility</label>
                    <textarea name="roles" id="roles" class="form-control summernote">{{$listing->roles}}</textarea>
                    @if ($errors->has('roles'))
                    <div class="error">{{ $errors->first('roles') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Job types</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job_type" id="fulltime" value="fulltime" {{$listing->job_type === 'fulltime' ? 'checked' : ''}} />
                        <label for="fulltime" class="form-check-label">Full-time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job_type" id="parttime" value="parttime" {{$listing->job_type === 'parttime' ? 'checked' : ''}} />
                        <label for="parttime" class="form-check-label">Part-time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job_type" id="contract" value="contract" {{$listing->job_type === 'contract' ? 'checked' : ''}} />
                        <label for="contract" class="form-check-label">Contract</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="job_type" id="internship" value="internship" {{$listing->job_type === 'internship' ? 'checked' : ''}} />
                        <label for="internship" class="form-check-label">Internship</label>
                    </div>
                    @if ($errors->has('job_type'))
                    <div class="error">{{ $errors->first('job_type') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{$listing->address}}" />
                    @if ($errors->has('address'))
                    <div class="error">{{ $errors->first('address') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="text" name="salary" id="salary" class="form-control" value="{{$listing->salary}}" />
                    @if ($errors->has('salary'))
                    <div class="error">{{ $errors->first('salary') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="application_close">Application close date</label>
                    <input type="text" name="application_close" id="datepicker" class="form-control" value="{{$listing->application_close}}" />
                    @if ($errors->has('application_close'))
                    <div class="error">{{ $errors->first('application_close') }}</div>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .note-insert {
        display: none !important;
    }

    .error {
        color: red;
    }
</style>
@endsection
