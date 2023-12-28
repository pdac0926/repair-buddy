@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Users</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $users->count() }}
                                    </h5>
                                    <small class="mb-0">
                                        Overall Users.
                                    </small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Drivers</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $users->where('role', 'driver')->count() }}
                                    </h5>
                                    <small class="mb-0">
                                        Overall Drivers (Pending/Approved).
                                    </small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Shop Owners</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $users->where('role', 'shopOwner')->count() }}
                                    </h5>
                                    <small class="mb-0">
                                        Overall Shop Owners.
                                    </small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Mechanics</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $mechanics->count() }}
                                    </h5>
                                    <small class="mb-0">
                                        Overall Shop Owners mechanics.
                                    </small>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @if (Auth::user()->role == 'admin')
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Sales overview</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold">4% more</span> in 2021
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-carousel overflow-hidden h-100 p-0">
                        <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner border-radius-lg h-100">
                                <div class="carousel-item h-100 active"
                                    style="background-image: url('./assets/img/carousel-1.jpg');background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Get started with Argon</h5>
                                        <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.
                                        </p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100"
                                    style="background-image: url('./assets/img/carousel-2.jpg');background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Faster way to create web pages</h5>
                                        <p>That’s my skill. I’m not really specifically talented at anything except for the
                                            ability to learn.</p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100"
                                    style="background-image: url('./assets/img/carousel-3.jpg');background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-trophy text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Share with us your design tips!</h5>
                                        <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev w-5 me-3" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next w-5 me-3" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth::user()->role == 'driver')
                <div class="col-lg-12">
                    <div class="card z-index-2">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">List Shop Locations</h6>
                        </div>
                        <div class="card-body p-0" style="height: 700px;">
                            <div id="listShopLocation" style="height: 100%;width:100%;"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection


@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        var map = L.map('listShopLocation').setView([16.41122194797963, 120.59623719046016], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var currentLocationIcon = L.icon({
            iconUrl: "{{asset('assets_auth/img/icons/marker/spaceship.png')}}",
            iconSize: [80, 80], 
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        // Define custom icon for other locations car-repair-shop
        var locationIcon = L.icon({
            iconUrl: "{{asset('assets_auth/img/icons/marker/car-repair-shop.png')}}",
            iconSize: [80, 80], 
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        var currentRouteControl = null;

        async function loadShopLocations() {
            await axios.get("{{ route('driver.load.shop.locations') }}")
                .then(function(response) {
                    // console.log(response);
                    setMapProperties(response.data)
                })
                .catch(function(error) {
                    console.log(error);
                })
        }

        loadShopLocations();

        function setMapProperties(data) {
            var markerCoordinates = data.map(location => {
                return {
                    coords: location.coords,
                    popupText: location.popupText
                };
            });

            for (var i = 0; i < markerCoordinates.length; i++) {
                var marker = L.marker(markerCoordinates[i].coords, {
                    draggable: false,
                    icon: locationIcon
                }).addTo(map);

                marker.bindPopup(markerCoordinates[i].popupText);

                marker.on('click', function(e) {
                    clearRoute();
                    calculateRoute(e.latlng);

                    var intervalId = setInterval(function() {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                var userLocation = [position.coords.latitude, position.coords
                                    .longitude
                                ];
                                var destination = currentRouteControl.getWaypoints()[1].latLng;
                                clearRoute();
                                calculateRoute(destination);
                            },
                            function(error) {
                                onLocationError({
                                    message: "Error getting location: " + error.message
                                });
                            }
                        );
                    }, 10000);

                    marker.intervalId = intervalId;
                });
            }

            function onLocationFound(e) {
                var radius = e.accuracy / 2;

                L.marker(e.latlng, {icon: currentLocationIcon}).addTo(map)
                    .bindPopup("You are here now.").openPopup();

                L.circle(e.latlng, radius).addTo(map);
            }

            function onLocationError(e) {
                alert(e.message);
            }

            function calculateRoute(destination) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLocation = [position.coords.latitude, position.coords.longitude];
                        currentRouteControl = L.Routing.control({
                            waypoints: [
                                L.latLng(userLocation), // current location
                                destination
                            ],
                            routeWhileDragging: true
                        }).addTo(map);
                    },
                    function(error) {
                        onLocationError({
                            message: "Error getting location: " + error.message
                        });
                    }
                );
            }

            function clearRoute() {
                if (currentRouteControl !== null) {
                    map.removeControl(currentRouteControl);
                    currentRouteControl = null;
                }
            }

            // Request permission for geolocation
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var userLocation = [position.coords.latitude, position.coords.longitude];
                        map.setView(userLocation, 20);
                        onLocationFound({
                            latlng: L.latLng(userLocation),
                            accuracy: 0
                        });
                    },
                    function(error) {
                        onLocationError({
                            message: "Error getting location: " + error.message
                        });
                    }
                );
            } else {
                alert("Geolocation not supported in this browser");
            }
        }
    </script>
@endsection
