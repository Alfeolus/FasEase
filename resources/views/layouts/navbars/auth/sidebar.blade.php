<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main" data-color="info">
    
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="logo">
            <span class="ms-3 font-weight-bold">FasEase</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">
    
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: calc(100vh - 330px); overflow-y: auto; overflow-x: hidden;">
        <ul class="navbar-nav">

            {{-- Dashboard --}}
            <li class="nav-item">
                @php
                    $user = auth()->user();
                @endphp

                @if($user->role === 'superadmin')
                    <a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}"
                       href="{{ route('superadmin.dashboard') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-gauge {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>

                @elseif($user->role === 'admin')
                    <a class="nav-link {{ request()->routeIs('org.dashboard-admin') ? 'active' : '' }}"
                       href="{{ route('org.dashboard-admin', app('currentOrganization')->slug ?? '') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-gauge {{ request()->routeIs('org.dashboard-admin') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>

                @elseif($user->role === 'user')
                    <a class="nav-link {{ request()->routeIs('org.dashboard-user') ? 'active' : '' }}"
                       href="{{ route('org.dashboard-user', app('currentOrganization')->slug ?? '') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-gauge {{ request()->routeIs('org.dashboard-user') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                @endif
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Information</h6>
            </li>

            {{-- User Profile --}}
            @if(auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('org.user-profile-index') ? 'active' : '' }}" 
                       href="{{ route('org.user-profile-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user {{ request()->routeIs('org.user-profile-index') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Profile</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'superadmin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('superadmin.user-profile-index') ? 'active' : '' }}" 
                       href="{{ route('superadmin.user-profile-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user {{ request()->routeIs('superadmin.user-profile-index') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Profile</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'user')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('org.user-user-profile-index') ? 'active' : '' }}" 
                       href="{{ route('org.user-user-profile-index') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user {{ request()->routeIs('org.user-user-profile-index') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Profile</span>
                    </a>
                </li>
            @endif

            {{-- Copy Login Link --}}
            @if(session('login_type') === 'tenant' && session('login_token') && auth()->user()->role == 'admin')
                <li class="nav-item pb-2">
                    <a href="javascript:void(0)" class="nav-link" id="copy-login-link"
                       data-login-url="{{ url('organization/login/' . session('login_token')) }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-link text-dark"></i>
                        </div>
                        <span class="nav-link-text ms-1">Copy Login Link</span>
                    </a>
                </li>
            @endif

            @if (auth()->check() && auth()->user()->role === 'superadmin')
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Management</h6>
                </li>
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
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Management</h6>
                </li>

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

                {{-- Booking History --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('org.booking-history') ? 'active' : '' }}" href="{{ route('org.booking-history') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-credit-card {{ Request::is('org.booking-history') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Booking History</span>
                    </a>
                </li>
            @endif
            
            @if (auth()->check() && auth()->user()->role === 'user' && auth()->user()->organization)
                <li class="nav-item mt-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Booking Information</h6>
                </li>

                {{-- Booking History --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('org.user-booking-history') ? 'active' : '' }}" href="{{ route('org.user-booking-history') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-credit-card {{ Request::is('org.user-booking-history') ? 'text-white' : 'text-dark' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">Booking History</span>
                    </a>
                </li>
            @endif
            
        </ul>
    </div>

    
    @if (auth()->check() && (auth()->user()->role === 'user' || auth()->user()->role === 'admin') )
        <div class="sidenav-footer mx-3 mt-auto pt-3"> {{-- Added mt-auto and pt-3 --}}
            <div class="card card-background shadow-none card-background-mask-info" id="sidenavCard">
                <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpeg')"></div>
                <div class="card-body text-start p-3 w-100">
                    <div class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                        <i class="fas fa-circle-question text-dark text-lg" aria-hidden="true" id="sidenavCardIcon"></i>
                    </div>
                    <div class="docs-info">
                        <h6 class="text-white up mb-0">Need help?</h6>
                        <p class="text-xs font-weight-bold">Please let us know</p>
                        <a href="#" target="_blank" class="btn btn-white btn-sm w-100 mb-0">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
</aside>