<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="logo">
            <span class="ms-3 font-weight-bold">FasEase</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard', 'org.dashboard') ? 'active' : '' }}"
                href="{{ app()->bound('currentOrganization')
                            ? route('org.dashboard', app('currentOrganization')->slug)
                            : route('dashboard') }}">
                    
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-gauge {{ request()->routeIs('dashboard', 'org.dashboard') ? 'text-white' : 'text-dark' }}"></i>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Information</h6>
            </li>

            {{-- User Profile --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('user-profile') ? 'active' : '' }}" href="{{ url('user-profile') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user {{ Request::is('user-profile') ? 'text-white' : 'text-dark' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>

            {{-- Copy link login --}}
            @if (app()->bound('currentOrganization') && auth()->user()?->login_token)
            <li class="nav-item pb-2">
                <a href="javascript:void(0)"
                class="nav-link"
                id="copy-login-link"
                data-login-url="{{ url('/login/organization/' . auth()->user()->login_token) }}">

                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-link text-dark"></i>
                    </div>

                    <span class="nav-link-text ms-1">Copy Login Link</span>
                </a>
            </li>
            @endif



            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Management</h6>
            </li>

            @if (auth()->check() && auth()->user()->role === 'superadmin')
                {{-- User Management --}}
                <li class="nav-item pb-2">
                    <a class="nav-link {{ Request::is('user-management') ? 'active' : '' }}" href="{{ url('user-management') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users {{ Request::is('user-management') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>

                {{-- Organization Management --}}
                <li class="nav-item pb-2">
                    <a class="nav-link {{ Request::is('organization-management') ? 'active' : '' }}" href="{{ url('organization-management') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-building {{ Request::is('organization-management') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Organization Management</span>
                    </a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'admin' && auth()->user()->organization)
                {{-- Category Management --}}
                <li class="nav-item pb-2">
                    <a class="nav-link {{ Request::is('category-management*') ? 'active' : '' }}"
                    href="{{ route('org.category-management-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-icons {{ Request::is('category-management*') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Category Management</span>
                    </a>
                </li>

                {{-- Item Management --}}
                <li class="nav-item pb-2">
                    <a class="nav-link {{ Request::is('item-management*') ? 'active' : '' }}"
                    href="{{ route('org.item-management-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-boxes-stacked {{ Request::is('item-management*') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Item Management</span>
                    </a>
                </li>


                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Booking Information</h6>
                </li>

                {{-- Booking Management --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('org.booking-management-index') ? 'active' : '' }}" href="{{ route('org.booking-management-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-table {{ Request::is('org.booking-management-index') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Bookings</span>
                    </a>
                </li>

                {{-- Billing --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('org.booking-history') ? 'active' : '' }}" href="{{ route('org.booking-history') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-credit-card {{ Request::is('org.booking-history') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Booking History</span>
                    </a>
                </li>
            @endif


            {{-- Sign In --}}
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('static-sign-in') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-right-to-bracket text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li> --}}

            {{-- Sign Up --}}
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('static-sign-up') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus text-dark"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}

        </ul>
    </div>
</aside>


