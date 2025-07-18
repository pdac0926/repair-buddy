@extends('layouts.admin')

@section('title', 'Shop Owner - Add')

@section('content')
    <div class="container-fluid py-4">
        <form action="{{route('admin.store.shop.owners')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shopLong">
            <input type="hidden" name="shopLat">
            <input type="hidden" name="shopAddress">
            <div class="card shadow-lg mx-3 @error('avatar') border border-danger @enderror ">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{asset('assets_auth/img/profile.png')}}" alt="profile_image"
                                    class="border-radius-lg shadow-sm avatarphoto">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    Profile avatar
                                </h5>
                                <p class="mb-0 font-weight-bold text-sm">
                                    Choose a profile from your device.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item" onclick="document.getElementById('avatar').click()">
                                        <button role="button" type="button"
                                            class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center">
                                            Choose Profile
                                        </button>
                                        <input type="file" id="avatar" class="d-none" name="avatar" onchange="selectedImage(this, 'avatarphoto')">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Profile Information</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Add Shop Owner</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">First Name</label>
                                            <input class="form-control @error('firstName') is-invalid @enderror" type="text" name="firstName"
                                                value="{{ old('firstName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Middle Name</label>
                                            <input class="form-control @error('middleName') is-invalid @enderror" type="text" name="middleName"
                                                value="{{ old('middleName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Last Name</label>
                                            <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName"
                                                value="{{ old('lastName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                                                value="{{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password Confirmation</label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Contact Information</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Phone Number</label>
                                            <input class="form-control @error('phoneNumber') is-invalid @enderror" type="text" name="phoneNumber"
                                                value="{{ old('phoneNumber') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Shop Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Name</label>
                                            <input class="form-control @error('shopName') is-invalid @enderror" type="text" name="shopName"
                                                value="{{ old('shopName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Phone Number</label>
                                            <input class="form-control @error('shopPhone') is-invalid @enderror" type="text" name="shopPhone"
                                                value="{{ old('shopPhone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Description</label>
                                            <textarea class="form-control @error('shopDescription') is-invalid @enderror" name="shopDescription"
                                                value="{{ old('shopDescription') }}" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Business</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Business Permit</label>
                                            <input class="form-control @error('permit') is-invalid @enderror" type="file" name="permit">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Permit number</label>
                                            <input class="form-control @error('permitNumber') is-invalid @enderror" type="text" name="permitNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Expiration</label>
                                            <input id="expiration" class="form-control @error('expiration') is-invalid @enderror" type="text" name="expiration" maxlength="7" placeholder="Ex. 01/2025">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-profile 
                        @error('shopLong') border border-danger @enderror
                        @error('shopLat') border border-danger @enderror
                        @error('shopAddress') border border-danger @enderror">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-danger mb-0 rounded-0" id="searchButton" type="button" id="button-addon2">Search</button>
                        </div>
                            <div id="map"></div>
                            <div class="card-body p-3">
                                <div class="text-center mt-4">
                                    <h5>
                                        Pin the shop location
                                    </h5>
                                    <div class="h6 font-weight-300">
                                        <div class="row">
                                            <div class="col-lg-6 text-center">
                                                <p>Longitude</p>
                                                <small id="shopLong">---------</small>
                                            </div>
                                            <div class="col-lg-6 text-center">
                                                <p>Latitude</p>
                                                <small id="shopLat">---------</small>
                                            </div>
                                            <div class="col-lg-12 mt-5">
                                                <p><small id="shopAddress">---------</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        var map = L.map('map').setView([16.41122194797963, 120.59623719046016], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Create single marker
        var marker = L.marker([16.41122194797963, 120.59623719046016], {
            draggable: true
        }).addTo(map);

        // Function to update location info
        function updateLocationInfo(position) {
            document.querySelector('#shopLong').innerHTML = position.lng.toFixed(6);
            document.querySelector('#shopLat').innerHTML = position.lat.toFixed(6);
            document.querySelector('[name="shopLong"]').value = position.lng;
            document.querySelector('[name="shopLat"]').value = position.lat;
            
            // Fetch address using OpenCage API
            fetch('https://api.opencagedata.com/geocode/v1/json?q=' + position.lat + '+' + position.lng +
                    '&key=84b8f8b5b31c450485b329c38cad5c23')
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        var address = data.results[0].formatted;
                        document.querySelector('#shopAddress').innerHTML = address;
                        document.querySelector('[name="shopAddress"]').value = address;
                    } else {
                        document.querySelector('#shopAddress').innerHTML = 'Address not found';
                        document.querySelector('[name="shopAddress"]').value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                    document.querySelector('#shopAddress').innerHTML = 'Error loading address';
                });
        }

        // Handle marker drag
        marker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();
            updateLocationInfo(position);
        });

        // Search functionality
        function searchLocation(query) {
            if (!query.trim()) {
                alert('Please enter a search term');
                return;
            }

            // Use OpenCage API for geocoding
            fetch('https://api.opencagedata.com/geocode/v1/json?q=' + encodeURIComponent(query) + 
                  '&key=84b8f8b5b31c450485b329c38cad5c23&limit=1')
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        var result = data.results[0];
                        var lat = result.geometry.lat;
                        var lng = result.geometry.lng;
                        
                        // Update marker position
                        marker.setLatLng([lat, lng]);
                        
                        // Center map on new location
                        map.setView([lat, lng], 16);
                        
                        // Update location info
                        updateLocationInfo({lat: lat, lng: lng});
                    } else {
                        alert('Location not found. Please try a different search term.');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    alert('Error searching for location. Please try again.');
                });
        }

        // Search button event listener
        document.getElementById('searchButton').addEventListener('click', function() {
            var query = document.getElementById('searchInput').value;
            searchLocation(query);
        });

        // Initialize address on page load
        updateLocationInfo({lat: 16.41122194797963, lng: 120.59623719046016});
        

        function selectedImage(input, target) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector(`.${target}`).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('expiration').addEventListener('input', function (e) {
            let v = e.target.value;
            v = v.replace(/[^0-9]/g, '');
            if (v.length === 0) {
                e.target.value = '';
                return;
            }
            if (v.length === 1 && v > '1') {
                v = '0' + v;
            }
            if (v.length > 2) {
                v = v.slice(0, 2) + '/' + v.slice(2);
            }
            let m = v.slice(0, 2);
            if (parseInt(m) > 12) {
                m = '12';
            }
            const y = new Date().getFullYear();
            const cm = new Date().getMonth() + 1;
            let yr = v.slice(3, 7);
            if (yr.length === 4) {
                if (parseInt(yr) < y) {
                    yr = y.toString();
                } else if (parseInt(yr) === y) {
                    const im = parseInt(m);
                    if (im < cm) {
                        m = cm < 10 ? '0' + cm : cm.toString();
                    }
                }
            }
            v = m + '/' + yr;
            if (v.length > 7) {
                v = v.slice(0, 7);
            }
            e.target.value = v;
        });

    </script>
@endsection
