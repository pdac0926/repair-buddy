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
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    @endauth

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
@php
    $path = request()->path();
    $slug = strtolower(str_replace('/', '-', $path));
@endphp

<body class="g-sidenav-show bg-gray-100 {{ $slug }}">
    <div class="min-height-300 bg-rep position-absolute w-100"></div>
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs bg-white border-0 border-radius-xl my-3 fixed-start ms-4 "
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
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="icon rb-gauge-3-1 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
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
                        <a class="nav-link {{ request()->routeIs('driver.service.availed') ? 'active' : '' }}"
                            href="{{ route('driver.service.availed') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-forklift text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Service Availed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.maintenance.history') || request()->routeIs('driver.maintenance.history') || request()->routeIs('driver.maintenance.history') ? 'active' : '' }}"
                            href="{{ route('driver.maintenance.history') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-tasks-2 text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Maintenance History</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 'shopOwner')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.services') || request()->routeIs('shop.owners.add.services') || request()->routeIs('shop.owners.edit.services') ? 'active' : '' }}"
                            href="{{ route('shop.owners.services') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-sliders text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Services</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.services.avail') || request()->routeIs('ashop.owners.services.avail') || request()->routeIs('shop.owners.services.avail') ? 'active' : '' }}"
                            href="{{ route('shop.owners.services.avail') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-tasks-2-1 text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Services Avail</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.mechanics') || request()->routeIs('ashop.owners.mechanics') || request()->routeIs('shop.owners.mechanics') ? 'active' : '' }}"
                            href="{{ route('shop.owners.mechanics') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-users text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Mechanics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shop.owners.messages') || request()->routeIs('ashop.owners.messages') || request()->routeIs('shop.owners.messages') ? 'active' : '' }}"
                            href="{{ route('shop.owners.messages') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="icon rb-msgs text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Messages</span>
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
                            <i class="icon rb-arrow-door-out-3 text-dark text-sm opacity-10"></i>
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
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                            <h3 class="text-capitalize text-light">
                                {{ Auth::user()->firstName . ' ' . Auth::user()->lastName }}
                            </h3>
                        </li>
                    </ol>
                </nav>
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
        @if (Auth::user()->role == 'admin')
            <script src="{{ asset('/assets/js/plugins/chartjs.min.js') }}"></script>
            <script>
                var ctx1 = document.getElementById("chart-line").getContext("2d");

                var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

                gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
                gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
                gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
                new Chart(ctx1, {
                    type: "line",
                    data: {
                        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Mobile apps",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#5e72e4",
                            backgroundColor: gradientStroke1,
                            borderWidth: 3,
                            fill: true,
                            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                            maxBarThickness: 6

                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#fbfbfb',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#ccc',
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            </script>
        @endif
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.3/axios.min.js"></script>
    @endauth
    @include('alerts.alert')
    <script>
        function closeNotificationPopup() {
            const notificationDialog = document.querySelector('[role="notification"]');
            notificationDialog.classList.add('hide-popup');
        }
    </script>
    @yield('scripts')
</body>

</html>
