@extends(auth()->user()->user_type === 'seeker' ? 'layouts.app' : 'layouts.admin.main')

@section('title', 'Update Password')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <h2>Change Password</h2>
        @if (Session::has('successMessage'))
        <div class="alert alert-success">{{Session::get('successMessage')}}</div>
        @endif
        @if (Session::has('errorMessage'))
        <div class="alert alert-danger">{{Session::get('errorMessage')}}</div>
        @endif
        <form action="{{route('user.updatePassword')}}" method="POST">@csrf
            <div class="col-md-8">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" class="form-control" />
                    @if ($errors->has('current_password'))
                    <div class="error">{{ $errors->first('current_password') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" class="form-control" />
                    @if ($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" />
                    @if ($errors->has('password_confirmation'))
                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <button class="btn btn-success" type="submit">Update</button>
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
