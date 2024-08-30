<aside class="main-sidebar sidebar-dark-primary elevation-4"  style="background-color: rgba(39, 40, 34, 1)">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('eventinz_logo.png') }}" alt="AdminLTE Logo" class="bg-white brand-image img-circle elevation-3" style="opacity: 1">
      <span class="brand-text font-weight-light">EvenTinz</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('AdminTemplate/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('admin.dashboard') }}" class="d-block">@UserAdmin</a>
          <div class="small">
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('admin.userslist.index') }}" class="nav-link  {{ request()->url() == route('admin.userslist.index') ? "active" : "" }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Hosts & Vendors List
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Vendors Functionalities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.list.category') }}" class="nav-link {{ request()->url() == route('admin.list.category') ? "active" : "" }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Categories Management</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.list.companies') }}" class="nav-link {{ request()->url() == route('admin.list.companies') ? "active" : "" }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Companies List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.list.servicescategories') }}" class="nav-link {{ request()->url() == route('admin.list.servicescategories') ? "active" : "" }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>Services Categories List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link {{ request()->url() == "#" ? "active" : "" }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Another Link
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>