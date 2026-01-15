<!DOCTYPE html>

@if (\Request::is('rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en">
@endif

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @if (env('IS_DEMO'))
      <x-demo-metas></x-demo-metas>
  @endif

  <!-- Icons -->
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

  <title>
  FasEase
  @if(app()->bound('currentOrganization'))
      x 
      {{ app('currentOrganization')->name }}
  @else
      - Main
  @endif
  @hasSection('title')
      | @yield('title')
  @endif
</title>


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }}">

  @auth
    @yield('auth')
  @endauth

  @guest
    @yield('guest')
  @endguest

  @if(session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0">{{ session('success') }}</p>
    </div>
  @endif

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


  @stack('dashboard')

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>
  <script src="{{ asset('assets/js/sidebar.js') }}"></script>



  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Soft UI Dashboard -->
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
</body>
</html>
