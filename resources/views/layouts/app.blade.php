<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('css/favicon.ico') }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
</head>

<body>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="/">TechJobs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->user()->profile_pic)
                            <img src="{{Storage::url(auth()->user()->profile_pic)}}" width="40" class="rounded-circle" alt="Profile picture" />
                            @else
                            <img src="https://placehold.co/400" class="rounded-circle" width="40">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('user.editseeker')}}">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="{{route('user.editPassword')}}">Change Password</a></li>
                            <li><a class="dropdown-item" href="{{route('user.editResume')}}">Upload Resume</a></li>
                            <li><a class="dropdown-item" href="{{route('user.jobsapplied')}}">View applied jobs</a></li>
                            <li><a class="dropdown-item" id="logout" href="#">Logout</a></li>
                        </ul>
                    </li>
                    @endif
                    @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('create.seeker')}}">Job seeker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('create.employer')}}">Employer</a>
                    </li>
                    @endif
                    <form id="form-logout" action="{{route('logout')}}" method="POST">@csrf</form>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</body>

<script>
    let logout = document.getElementById('logout');
    let form = document.getElementById('form-logout');
    if (logout) {
        logout.addEventListener('click', function() {
            form.submit();
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
