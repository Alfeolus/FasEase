@extends('layouts.app')
@section('auth')

    {{-- FLASH MESSAGE GLOBAL --}}
    @if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        class="position-fixed top-50 start-50 translate-middle z-index-3"
        style="min-width: 320px;"
    >
        <div class="alert alert-success text-center shadow">
        {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- STATIC AUTH PAGES --}}
    @if(\Request::is('static-sign-up') || \Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')

    {{-- PROFILE PAGE --}}
    @elseif (\Request::is('profile'))  
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>

    {{-- DEFAULT AUTH LAYOUT --}}
    @else
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
    @endif

    @include('components.fixed-plugin')
    @stack('js')

@endsection
