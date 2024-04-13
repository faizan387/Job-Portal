@extends('layouts.admin.main')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="container-fluid px-4">
            @if (Session::has('successMessage'))
            <div class="alert alert-success">{{ Session::get('successMessage') }}</div>
            @endif
            @if (Session::has('errorMessage'))
            <div class="alert alert-danger">{{ Session::get('errorMessage') }}</div>
            @endif
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                Hello, {{ auth()->user()->name }}.&nbsp;
                @if (Auth::check() && auth()->user()->user_type === 'employer')
                @if (!auth()->user()->billing_ends)
                <p>Your trial {{ now()->format('Y-m-d') > auth()->user()->user_trial ? 'was expired' : 'will expire'}} on {{ auth()->user()->user_trial }}</p>
                @else
                <p>Your membership {{ now()->format('Y-m-d') > auth()->user()->billing_ends ? 'was expired' : 'will expire'}} on {{ auth()->user()->billing_ends }}</p>
                @endif
                @endif
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Jobs ({{\App\Models\Listing::where('user_id', auth()->user()->id)->count()}})</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{route('job.index')}}">View</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Profile</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{route('user.editemployer')}}">View</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Plan ({{\App\Models\User::where('id', auth()->user()->id)->first()->plan}})</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{route('subscribe')}}">View</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection('content')
