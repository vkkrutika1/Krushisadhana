@props(['activePage'])
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Dashboard</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          @if(auth()->user())
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'products' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('products.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">list_alt</i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'primaries' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('primaries.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">list_alt</i>
                    </div>
                    <span class="nav-link-text ms-1">Primary Labels</span>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white {{ $activePage == 'secondaries' ? ' active bg-gradient-primary' : '' }} "
                  href="{{ route('secondaries.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">list_alt</i>
                </div>
                <span class="nav-link-text ms-1">Secondary Labels</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white {{ $activePage == 'user-profile' ? 'active bg-gradient-primary' : '' }} "
                  href="{{ route('users.edit', auth()->user()->id) }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <!-- <i style="font-size: 1.2rem;" class="fas fa-user-circle ps-2 pe-2 text-center"></i> -->
                  <i class="material-icons opacity-10">account_box</i>
                </div>
                <span class="nav-link-text ms-1">User Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white {{ $activePage == 'status' ? 'active bg-gradient-primary' : '' }} "
                  href="{{ route('status') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">check_circle_outline</i>
                </div>
                <span class="nav-link-text ms-1">Status Check</span>
              </a>
            </li>
            @endif
            @if(auth()->user() && auth()->user()->role_id)
            <li class="nav-item">
              <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-primary' : '' }} "
                  href="{{ route('users.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <!-- <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i> -->
                  <i class="material-icons opacity-10">manage_accounts</i>
                </div>
                <span class="nav-link-text ms-1">User Management</span>
              </a>
            </li>
            @endif
            <!-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'tables' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'billing' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('billing') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'virtual-reality' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('virtual-reality') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'rtl' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('rtl') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notifications' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('notifications') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li> -->
            <!-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('static-sign-in') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('static-sign-up') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> -->
        </ul>
    </div>
</aside>
