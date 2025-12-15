<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <ul class="navbar-nav ml-auto">
-------
-------
-------
            @auth
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ \App\Helpers\AuthHelper::getUserPhotoUrl() }}"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ \App\Helpers\AuthHelper::getUserName() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <li class="user-header bg-gray-dark">
                        <img src="{{ \App\Helpers\AuthHelper::getUserPhotoUrl() }}"
                             class="img-circle elevation-2" alt="User Image">
                        <p>
                            {{ \App\Helpers\AuthHelper::getUserName() }}
                            <small>{{ \App\Helpers\AuthHelper::getUserRole() }}</small>
                        </p>
                    </li>

                    <li class="user-footer">
                        <a href="{{ route('profile.show') }}" class="btn btn-default">Profile</a>
                        <a class="btn btn-default float-right" onclick="document.getElementById('logoutForm').submit()">Log out</a>
                    </li>
                </ul>
            </li>
            @else
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
            </li>
            @endauth
        </ul>
    </ul>
</nav>

<form action="{{ route('logout') }}" id="logoutForm" method="post" style="display: none;">
    @csrf
</form>
