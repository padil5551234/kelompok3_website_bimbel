<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="UKM Bimbel" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
-------
-------
-------
        <!-- Sidebar user panel (optional) -->
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ \App\Helpers\AuthHelper::getUserPhotoUrl() }}"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \App\Helpers\AuthHelper::getUserName() }}</a>
            </div>
        </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @role('admin')
                <li class="nav-item">
                    <a href="{{ route('admin.faq.index') }}" class="nav-link {{ request()->segment(2) == 'faq' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            FAQ
                        </p>
                    </a>
                </li>
                @endrole
                @role('admin')
                <li class="nav-header">Data Pengguna</li>
                <li class="nav-item ">
                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->segment(2) == 'user' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.admin.index') }}" class="nav-link {{ request()->segment(2) == 'admin' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-gear"></i>
                        <p>
                            Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.tutor.index') }}" class="nav-link {{ request()->segment(2) == 'tutor' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Tutor
                        </p>
                    </a>
                </li>
                @endrole
                <li class="nav-header">Data Ujian & Course</li>
                @role('admin')
                <li class="nav-item">
                    <a href="{{ route('admin.paket.index') }}" class="nav-link {{ request()->segment(2) == 'paket' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Paket Kedinasan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.integrated-dashboard') }}" class="nav-link {{ request()->segment(2) == 'integrated-dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Integrated Course
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.material.chapters') }}" class="nav-link {{ request()->segment(2) == 'material' && request()->segment(3) == 'chapters' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>
                            Chapter Pagination
                        </p>
                    </a>
                </li>
                @endrole
                <li class="nav-item">
                    <a href="{{ route('admin.ujian.index') }}" class="nav-link {{ request()->segment(2) == 'ujian' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Ujian
                        </p>
                    </a>
                </li>
                @hasrole('admin')
                <li class="nav-item">
                    <a href="{{ route('admin.voucher.index') }}" class="nav-link {{ request()->segment(2) == 'voucher' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket"></i>
                        <p>
                            Voucher
                        </p>
                    </a>
                </li>
                @endrole

                <li class="nav-header">Data Peserta Ujian</li>
                <li class="nav-item">
                    <a href="{{ route('admin.peserta_ujian.index') }}" class="nav-link {{ request()->segment(2) == 'peserta_ujian' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-pen"></i>
                        <p>
                            Peserta Ujian
                        </p>
                    </a>
                </li>
                @role('admin')
                <li class="nav-item {{ request()->segment(2) == 'pembelian' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->segment(2) == 'pembelian' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Pembelian Paket
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.pembelian.index') }}" class="nav-link {{ request()->url() == route('admin.pembelian.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pembelian.verifikasi') }}" class="nav-link {{ request()->url() == route('admin.pembelian.verifikasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Verifikasi Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                
                <li class="nav-header">Konten & Informasi</li>
                @role('admin')
                <li class="nav-item">
                    <a href="{{ route('admin.article.index') }}" class="nav-link {{ request()->segment(2) == 'article' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Artikel
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.testimonial.index') }}" class="nav-link {{ request()->segment(2) == 'testimonial' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Testimonial
                        </p>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
