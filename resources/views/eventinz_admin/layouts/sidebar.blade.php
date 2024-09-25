<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgba(39, 40, 34, 1); position: fixed; height: 100vh; overflow-y: auto;">
  <!-- Brand Logo -->
  <a href="{{ '/' }}" class="brand-link">
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

    <!-- SidebarMenu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('view_users_hosts_and_vendors_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.userslist.index') }}" class="nav-link  {{ request()->url() == route('admin.userslist.index') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Hosts & Vendors List
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_list_of_staff_members', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.adminusers') }}" class="nav-link {{ request()->url() == route('admin.list.adminusers') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Amin Users List</p>
                  </a>
                </li>
              @endif

              @if(in_array('resend_otp', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.resendform.otp') }}" class="nav-link {{ request()->url() == route('admin.resendform.otp') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Resend OTP
                    </p>
                  </a>
                </li>
              @endif
              
              @if(in_array('view_support_help', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  {{-- <a href="{{ route('admin.resendform.otp') }}" class="nav-link {{ request()->url() == route('admin.resendform.otp') ? "active" : "" }}"> --}}
                  <a href="#" class="nav-link ">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Support & Help
                    </p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
          <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-day"></i>
              <p>
                Events Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('view_events_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.events') }}" class="nav-link  {{ request()->url() == route('admin.list.events') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Events List
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_event_type_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.eventtypes') }}" class="nav-link {{ request()->url() == route('admin.list.eventtypes') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Events Type
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_event_subcategories_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.eventsubcategories') }}" class="nav-link {{ request()->url() == route('admin.list.eventsubcategories') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Events Subcategories
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_reviews_list	', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.reviews') }}" class="nav-link {{ request()->url() == route('admin.list.reviews') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Reviews
                    </p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Vendors Functionalities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('view_subscription_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.subscriptionplans') }}" class="nav-link {{ request()->url() == route('admin.list.subscriptionplans') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Subscriptions
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_categories_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.category') }}" class="nav-link {{ request()->url() == route('admin.list.category') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Categories Management</p>
                  </a>
                </li>
              @endif

              @if(in_array('view_companies_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.companies') }}" class="nav-link {{ request()->url() == route('admin.list.companies') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Companies List</p>
                  </a>
                </li>
              @endif

              @if(in_array('view_service_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.servicescategories') }}" class="nav-link {{ request()->url() == route('admin.list.servicescategories') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Services Categories List</p>
                  </a>
                </li>
              @endif

              @if(in_array('view_vendors_classes_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.vendorclass') }}" class="nav-link {{ request()->url() == route('admin.list.vendorclass') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Vendors Classes
                    </p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Finance Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('view_payments_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.payments') }}" class="nav-link {{ request()->url() == route('admin.list.payments') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Payments Stories
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_taxes_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.paymenttaxe') }}" class="nav-link {{ request()->url() == route('admin.list.paymenttaxe') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Taxes management
                    </p>
                  </a>
                </li>
              @endif

              @if(in_array('view_eventviewstatus_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.eventviewstatus') }}" class="nav-link {{ request()->url() == route('admin.list.eventviewstatus') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Event View Status
                    </p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Content management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(in_array('view_contents_texts_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.contenttext') }}" class="nav-link {{ request()->url() == route('admin.list.contenttext') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Content Text</p>
                  </a>
                </li>
              @endif

              @if(in_array('view_contents_images_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.contentimage') }}" class="nav-link {{ request()->url() == route('admin.list.contentimage') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Content Images / Icons</p>
                  </a>
                </li>
              @endif

              @if(in_array('view_limits_list', json_decode(Auth::user()->rights)))
                <li class="nav-item">
                  <a href="{{ route('admin.list.datalimit') }}" class="nav-link {{ request()->url() == route('admin.list.datalimit') ? "active" : "" }}">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>
                      Data limits
                    </p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
        </ul>
      </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
