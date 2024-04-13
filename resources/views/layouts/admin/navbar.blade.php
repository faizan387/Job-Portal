<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/dashboard">TechJobs</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (auth()->user()->profile_pic)
                <img src="{{Storage::url(auth()->user()->profile_pic)}}" width="40" class="rounded-circle" alt="Profile picture" />
                @else
                <img src="https://placehold.co/400" class="rounded-circle" width="40">
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{route('user.editemployer')}}">Edit Profile</a></li>
                <li><a class="dropdown-item" href="{{route('user.editPassword')}}">Edit Password</a></li>
                <li><a class="dropdown-item" href="{{route('subscribe')}}">Subscription</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" id="logout" href="#">Logout</a></li>
                <form id="form-logout" action="{{route('logout')}}" method="POST">@csrf</form>
            </ul>
        </li>
    </ul>
</nav>

<script>
    let logout = document.getElementById('logout');
    let form = document.getElementById('form-logout');
    if (logout) {
        logout.addEventListener('click', function() {
            form.submit();
        });
    }
</script>
