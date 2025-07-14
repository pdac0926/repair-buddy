<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @auth
        <link href="{{ asset('/assets_auth/css/icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('/dashboard/dashboard.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('/assets/leaflet/leaflet.css')}}" />
        <link rel="stylesheet" href="{{asset('/assets/leaflet/leaflet-routing.css')}}" />
        <link rel="stylesheet" href="{{asset('/assets/leaflet/geocontrol.css')}}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    @endauth

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
@php
    $path = request()->path();
    $slug = strtolower(str_replace('/', '-', $path));
@endphp

<body class="g-sidenav-show bg-gray-100 {{ $slug }}" >
    <div class="min-height-300 bg-rep position-absolute w-100"></div>
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs bg-white border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
                <img src="{{ asset('./assets_auth/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100"
                    alt="main_logo">
                <span class="ms-1 font-weight-bold">Repair Buddy</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <style>
        #sidenav-collapse-main {
            height: 80vh; /* Adjust the height value as needed */
            overflow-y: auto; /* Add scrollbars if content exceeds the height */
        }
    </style>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <nav class="navbar navbar-main navbar-expand-lg px-2 shadow-none border-radius-l " id="navbarBlur"
                            data-scroll="false">
                            <div class="container-fluid py-1 px-1 d-flex align-items-center justify-content-center">
                                <!-- Avatar -->
                                <!-- User Name -->
                                <h3 class="text-capitalize mb-0" style="font-size: 15px; margin-top: -14px;">
                                    @if (Auth::check())
                                        {{ Auth::user()->firstName . ' ' . Auth::user()->lastName }}
                                    @else
                                        Guest
                                    @endif
                                </h3>
                            </div>
                        </nav>
                    </li>
                    <hr class="horizontal dark mt-0">

                @endauth

                @if (Auth::user()->role == 'admin')
              
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"
                            href="{{ route('admin.shop.owners') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-users text-lg  text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Registered Accounts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.shop.owners') || request()->routeIs('admin.add.shop.owners') || request()->routeIs('admin.edit.shop.owners') ? 'active' : '' }}"
                            href="{{ route('admin.shop.owners') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-shop text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Shop Owners</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.drivers') || request()->routeIs('admin.add.drivers') || request()->routeIs('admin.edit.drivers') ? 'active' : '' }}"
                            href="{{ route('admin.drivers') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-gear-2 text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Pending / Approved</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 'driver')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-user-laptop text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Locate Shop</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.messages') ? 'active' : '' }}"
                            href="{{ route('driver.messages') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-tasks-2-1 text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.service.availed') ? 'active' : '' }}"
                            href="{{ route('driver.service.availed') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-forklift text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Appointment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.maintenance.history') || request()->routeIs('driver.maintenance.history') || request()->routeIs('driver.maintenance.history') ? 'active' : '' }}"
                            href="{{ route('driver.maintenance.history') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-gauge-3-1 text-primary text-sm opacity-10"></i>
                                
                            </div>
                            <span class="nav-link-text ms-1">History</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 'shopOwner')
                
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.messages') || request()->routeIs('shop.owners.messages') || request()->routeIs('shop.owners.messages') ? 'active' : '' }}"
                            href="{{ route('shop.owners.messages') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-tasks-2-1 text-info text-sm opacity-10"></i> 
                            </div>
                            <span class="nav-link-text ms-1">Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.pending.avail') ? 'active' : '' }}"
                            href="{{ route('shop.owners.pending.avail') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                        <i class="icon rb-arrow-door-out-3 text-dark text-sm opacity-10"></i> 
                            </div>
                            <span class="nav-link-text ms-1">Pending Appointments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.ongoing.avail') ? 'active' : '' }}"
                            href="{{ route('shop.owners.ongoing.avail') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-stopwatch-1 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">On Going</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.ongoing.paid') ? 'active' : '' }}"
                            href="{{ route('shop.owners.ongoing.paid') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-clipboard-check-2 text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Paid</span>
                        </a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('shop.owners.rejected.avail') ? 'active' : '' }}"
        href="{{ route('shop.owners.rejected.avail') }}">
        <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="icon rb-forklift text-danger text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">Rejected Appointments</span>
    </a>
</li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.services') || request()->routeIs('shop.owners.add.services') || request()->routeIs('shop.owners.edit.services') ? 'active' : '' }}"
                            href="{{ route('shop.owners.services') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-sliders text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Services Offered</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.mechanics') || request()->routeIs('shop.owners.edit.mechanics') ? 'active' : '' }}"
                            href="{{ route('shop.owners.mechanics') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-users text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Mechanics</span>
                        </a>
                    </li>
                @endif
                <li>
                    <hr>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="document.querySelector('#logoutForm').submit()">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="icon rb-msgs text-success text-sm opacity-10"></i>
   
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        </div>
        </nav>
        @yield('content')
    </main>
    @auth
        <script src="{{ asset('/assets_auth/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('/assets_auth/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets_auth/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('/assets_auth/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="{{ asset('/assets_auth/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
        <script src="{{ asset('/assets/js/axios.js') }}"></script>
    @endauth
    @include('alerts.alert')
    <script>
        function closeNotificationPopup() {
            const notificationDialog = document.querySelector('[role="notification"]');
            notificationDialog.classList.add('hide-popup');
        }
    </script>
    <script src="{{asset('assets/leaflet/leaflet.js')}}"></script>
    <script src="{{asset('assets/leaflet/routing-machine.js')}}"></script>
    <script src="{{asset('assets/leaflet/geocoder.js')}}"></script>
    @yield('scripts')
</body>

</html>
