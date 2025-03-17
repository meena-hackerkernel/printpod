<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{ asset('asset/admin-dashboard/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Printpod-AI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('asset/admin-dashboard/dist/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ strtoupper(auth()->user()->name) }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.zip-codes.index') }}"
                        class="nav-link @if (Route::is('admin.zip-codes.index')) {{ 'active' }} @endif">

                        {{-- <i class="fa fa-file-image nav-icon"></i> --}}
                        <i class="fa fa-map-pin nav-icon" aria-hidden="true"></i>


                        <p>Zip Codes</p>

                    </a>

                </li>
                <li class="nav-item">

                    <a href="{{ route('admin.vendors.index') }}"
                        class="nav-link @if (Route::is('admin.vendors.index')) {{ 'active' }} @endif">

                        {{-- <i class="fa fa-file-image nav-icon"></i> --}}
                        <i class="fa fa-store nav-icon" aria-hidden="true"></i>
                        <p>Vendors</p>

                    </a>

                </li>
                <li class="nav-item">

                    <a href="{{ route('admin.delivery-boys.index') }}"
                        class="nav-link @if (Route::is('admin.delivery-boys.index')) {{ 'active' }} @endif">

                        <i class="fas fa-shipping-fast nav-icon"></i>
                        <p>Delivery Boys</p>

                    </a>

                </li>
            </ul>
        </nav>


        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
