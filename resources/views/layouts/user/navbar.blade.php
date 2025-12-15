<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link scrollto {{ (request()->segment(1) == '') ? 'active' : '' }}" href="{{ (request()->segment(1) == '') ? '#hero' : route('dashboard') }}">Home</a></li>
        <li><a class="nav-link scrollto" href="{{ (request()->segment(1) == '') ? '#pricing' : route('dashboard') . '/#pricing' }}">Paket Kedinasan STIS</a></li>
        <li><a class="nav-link scrollto {{ (request()->segment(1) == 'tryout' || request()->segment(2) == 'tryout') ? 'active' : '' }}" href="{{ route('tryout.index') }}">Tryout</a></li>
        @auth
        <li><a class="nav-link scrollto {{ (request()->segment(1) == 'materials') ? 'active' : '' }}" href="{{ route('user.materials.index') }}">Materi</a></li>
        <li><a class="nav-link scrollto {{ (request()->segment(1) == 'live-zoom') ? 'active' : '' }}" href="{{ route('user.live-zoom.index') }}">Live Zoom</a></li>
        @endauth
        <li><a class="nav-link scrollto {{ (request()->segment(1) == 'articles') ? 'active' : '' }}" href="{{ route('articles.index') }}">Artikel</a></li>
        <li><a class="nav-link scrollto {{ (request()->segment(1) == 'faq') ? 'active' : '' }}"  href="{{ route('faq.index') }}">FAQ</a></li>
        @hasrole('admin')
        <li><a class="nav-link scrollto" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
        @endhasrole

        @auth
            <li class="dropdown"><a href="#"><span class="user-name">{{ auth()->user()->name }}</span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                    <li><a href="{{ route('ranking.global') }}">Peringkat Global</a></li>
                    <li><a href="{{ route('progres.nilai') }}">Grafik Progres</a></li>
                    <li><a href="{{ route('raport.index') }}">Raport Belajar</a></li>
                    <li><a href="{{ route('profile.show') }}">Profile</a></li>
                    <li><a href="#" onclick="document.getElementById('logoutForm').submit()">Logout</a></li>
                </ul>
            </li>
        @else
            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endauth
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->

<form action="{{ route('logout') }}" id="logoutForm" method="post" style="display: none;">
    @csrf
</form>
