<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="UKM Bimbel" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->profile_photo_url }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('tutor.dashboard') }}" class="nav-link {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Live Classes -->
                <li class="nav-header">Kelas & Materi</li>
                <li class="nav-item">
                    <a href="{{ route('tutor.live-classes.index') }}" class="nav-link {{ request()->segment(2) == 'live-classes' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-video"></i>
                        <p>Live Classes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tutor.materials.index') }}" class="nav-link {{ request()->segment(2) == 'materials' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Materi</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>