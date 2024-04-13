@extends('layouts.app')

@section('title', 'Email Verification')

@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="card">
            <div class="card-header">Verify account</div>
            <div class="card-body">
                <p>
                    Your account is not verified. Kindly verify your account first
                    <a href="{{route('resend.email')}}">Resend link to verify email</a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
