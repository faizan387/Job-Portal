<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{route('dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link" href="{{route('job.create')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                    Create job
                </a>
                <a class="nav-link" href="{{route('job.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Your jobs
                </a>
                <a class="nav-link" href="{{route('applicants')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-group"></i></div>
                    Applicants
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{auth()->user()->name}}
        </div>
    </nav>
</div>
