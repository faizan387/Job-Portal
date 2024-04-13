@extends('layouts.admin.main')

@section('title', 'Applicants')

@section('content')

<div class="container mt-1">
    <div class="row">
        <div class="col-md-8 mt-4">
            <h1>{{$listing->title}}</h1>
            @if (Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
        </div>
        @foreach ($listing->users as $user)
        <div class="card mt-5 {{$user->pivot->shortlisted ? 'card-bg' : ''}}">
            <div class="row g-0">
                <div class="col-auto">
                    @if ($user->profile_pic)
                    <img src="{{Storage::url($user->profile_pic)}}" alt="Profile picture" class="rounded-circle" style="width: 150px;">
                    @else
                    <img src="https://placehold.co/400" alt="Profile picture" class="rounded-circle" style="width: 150px;">
                    @endif
                </div>
                <div class="col">
                    <div class="card-body">
                        <p class="fw-bold">{{$user->name}}</p>
                        <p class="card-text">{{$user->email}}</p>
                        <p class="card-text">{{$user->pivot->created_at}}</p>
                    </div>
                </div>
                <div class="col-auto align-self-center">
                    <form method="POST" action="{{route('applicants.shortlist', [$listing->id, $user->id])}}">@csrf
                        <a href="{{Storage::url($user->resume)}}" class="btn btn-primary" target="_blank">Download resume</a>
                        <button type="submit" class="btn {{$user->pivot->shortlisted ? 'btn-success' : 'btn-dark'}}">
                            {{$user->pivot->shortlisted ? 'Shortlisted' : 'Shortlist'}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .card-bg {
        background-color: green;
    }
</style>
@endsection
