<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ asset('dist/admin/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src='' class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::check() ? Auth::user()->name : '' }}

                    <span class="right badge badge-success">
                        @hasrole('admin')
                            Admin
                        @else
                            Student
                        @endhasrole
                    </span>
                </a>

            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <form action="" method="GET">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="@lang('lg.search')"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                @role('admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-window-maximize"></i>
                            <p>
                                @lang('lg.manage')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ Route('faculties.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('lg.faculties')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('subjects.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('lg.subjects')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route('students.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('lg.students')
                                </a>
                            </li>

                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ Route('faculties.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang('lg.student-list-faculty')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ Route('subjects.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang('lg.student-list-subject')</p>
                        </a>
                    </li>
                @endrole

                {{-- <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-apple-whole"></i>
                        <p>
                            Products
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li> --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
