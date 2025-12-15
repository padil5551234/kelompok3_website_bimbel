<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps ps--active-y bg-white" id="sidenav-main" data-color="dark">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Utama</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Tryout & Ujian</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}" href="{{ route('pembelian.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shopping-cart text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Paket Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('tryout*') || request()->is('ujian*') ? 'active' : '' }}" href="{{ route('tryout.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-edit text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tryout</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pembelajaran</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('live-zoom*') ? 'active' : '' }}" href="{{ route('user.live-zoom.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-video text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Live Class</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('materials*') ? 'active' : '' }}" href="{{ route('user.materials.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book text-primary"></i>
                        <i class="fas fa-book text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Materi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('progress*') ? 'active' : '' }}" href="{{ route('progress.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chart-line text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Progress Belajar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('raport*') ? 'active' : '' }}" href="{{ route('raport.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-graduation-cap text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Raport Belajar</span>
                </a>
            </li>
            
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Informasi</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('pengumuman*') ? 'active' : '' }}" href="{{ route('pengumuman.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-bullhorn text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengumuman</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('articles*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-newspaper text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Artikel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('faq*') ? 'active' : '' }}" href="{{ route('faq.index') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-question-circle text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">FAQ</span>
                </a>
            </li>
        </ul>
    </div>
    @auth
    <div class="sidenav-footer mx-3">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url('{{ asset('softUI') }}/assets/img/curved-images/white-curved.jpg')"></div>
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="fas fa-user text-dark text-gradient text-lg top-0" aria-hidden="true" id="sidenavCardIcon"></i>
                </div>
                <div class="docs-info">
                    <h6 class="text-white up mb-0">{{ auth()->user()->name }}</h6>
                    <p class="text-xs font-weight-bold">{{ auth()->user()->email }}</p>
                    <a href="{{ route('profile.show') }}" class="btn btn-white btn-sm w-100 mb-0">Profil</a>
                </div>
            </div>
        </div>
        <a class="btn bg-gradient-primary mt-3 w-100" onclick="document.getElementById('logoutForm').submit()" style="cursor: pointer;">Logout</a>
    </div>
    @endauth
</aside>

<form action="{{ route('logout') }}" id="logoutForm" method="post" style="display: none;">
    @csrf
</form>
