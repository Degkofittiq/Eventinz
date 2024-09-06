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
        <div class="image" style="position: relative; display: inline-block;">
          <img src="{{ asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}" class="img-circle elevation-2 bg-white" alt="User Image" style="border: none"> 
          <span style="position: absolute; bottom: 1px; right: 1px; background-color: #00ff00; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;"></span>
        </div>
        <div class="info">
          <a href="{{ route('admin.dashboard') }}" class="d-block">@UserAdmin</a>
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
          <li class="nav-item">
            <a href="{{ route('admin.list.events') }}" class="nav-link  {{ request()->url() == route('admin.list.events') ? "active" : "" }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Events List
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
            <a href="{{ route('admin.list.subscriptionplans') }}" class="nav-link {{ request()->url() == route('admin.list.subscriptionplans') ? "active" : "" }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Subscriptions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.list.payments') }}" class="nav-link {{ request()->url() == route('admin.list.payments') ? "active" : "" }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Payments Stories
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>