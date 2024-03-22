@extends('layouts.admin')

@section('title', 'Shop Owner - ' . $shopOwner->firstName . ' ' . $shopOwner->lastName)

@section('content')
    <div class="container-fluid py-4">
        <form action="{{ route('admin.approve.shop.owner', $shopOwner->id) }}" method="post" id="approval">
            @csrf
        </form>
        <form action="{{ route('admin.delete.shop.owner', $shopOwner->id) }}" method="post" id="deletion">
            @csrf
        </form>
        <form action="{{ route('admin.update.shop.owners', $shopOwner->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shopLong" value="{{ $shopOwner->shopOwnerInfo->shopLong }}">
            <input type="hidden" name="shopLat" value="{{ $shopOwner->shopOwnerInfo->shopLat }}">
            <input type="hidden" name="shopAddress" value="{{ $shopOwner->shopOwnerInfo->shopAddress }}">
            <div class="card shadow-lg mx-3 @error('avatar') border border-danger @enderror ">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ asset((new \App\Helper\Helper())->userAvatar($shopOwner->avatar)) }}"
                                    alt="profile_image" class="border-radius-lg shadow-sm avatarphoto">
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
                                            <i class="ni ni-app"></i>
                                            <span class="ms-2">Choose Profile</span>
                                        </button>
                                        <input type="file" id="avatar" class="d-none" name="avatar"
                                            onchange="selectedImage(this, 'avatarphoto')" value="{{ $shopOwner->avatar }}">
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
                                    <button class="btn btn-primary btn-sm ms-auto">Update Shop Owner</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">First Name</label>
                                            <input class="form-control @error('firstName') is-invalid @enderror"
                                                type="text" name="firstName"
                                                value="{{ old('firstName', $shopOwner->firstName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Middle Name</label>
                                            <input class="form-control @error('middleName') is-invalid @enderror"
                                                type="text" name="middleName"
                                                value="{{ old('middleName', $shopOwner->middleName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Last Name</label>
                                            <input class="form-control @error('lastName') is-invalid @enderror"
                                                type="text" name="lastName"
                                                value="{{ old('lastName', $shopOwner->lastName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                                name="email" value="{{ old('email', $shopOwner->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                type="password" name="password"
                                                value="{{ old('password', 'Laravel@123') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password Confirmation</label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                                type="password" name="password_confirmation"
                                                value="{{ old('password_confirmation', 'Laravel@123') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Contact Information</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input class="form-control @error('address') is-invalid @enderror"
                                                type="text" name="address"
                                                value="{{ old('address', $shopOwner->address) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Phone Number</label>
                                            <input class="form-control @error('phoneNumber') is-invalid @enderror"
                                                type="text" name="phoneNumber"
                                                value="{{ old('phoneNumber', $shopOwner->phoneNumber) }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Shop Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Name</label>
                                            <input class="form-control @error('shopName') is-invalid @enderror"
                                                type="text" name="shopName"
                                                value="{{ old('shopName', $shopOwner->shopOwnerInfo->shopName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Phone Number</label>
                                            <input class="form-control @error('shopPhone') is-invalid @enderror"
                                                type="text" name="shopPhone"
                                                value="{{ old('shopPhone', $shopOwner->shopOwnerInfo->shopPhone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Shop Description</label>
                                            <textarea class="form-control @error('shopDescription') is-invalid @enderror" name="shopDescription"
                                                value="{{ old('shopDescription', $shopOwner->shopOwnerInfo->shopDescription) }}" cols="30" rows="4">{{ $shopOwner->shopOwnerInfo->shopDescription }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="card card-profile mb-4 
                        @error('shopLong') border border-danger @enderror
                        @error('shopLat') border border-danger @enderror
                        @error('shopAddress') border border-danger @enderror">
                            <div class="card-header">
                                <p class="mb-0">Indicate the Shop Location on the Map</p>
                                <small>Use the pin icon to precisely mark the shop's location on the map. Simply click or tap on the map to drop the pin, ensuring accurate placement for easy navigation.</small>
                            </div>
                            <div id="map"></div>
                            <div class="card-body p-3">
                                <div class="text-center mt-4">
                                    <div class="h6 font-weight-300">
                                        <div class="row">
                                            <div class="col-lg-6 text-center">
                                                <p>Longitude</p>
                                                <small id="shopLong">{{ $shopOwner->shopOwnerInfo->shopLong }}</small>
                                            </div>
                                            <div class="col-lg-6 text-center">
                                                <p>Latitude</p>
                                                <small id="shopLat">{{ $shopOwner->shopOwnerInfo->shopLat }}</small>
                                            </div>
                                            <div class="col-lg-12 mt-5">
                                                <p><small
                                                        id="shopAddress">{{ $shopOwner->shopOwnerInfo->shopAddress }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <p class="mb-0">Approval</p>
                            </div>
                            <div class="card-body">
                                <p>After obtaining approval, the user was granted access to system properties, allowing them
                                    to leverage advanced functionalities and configurations.</p>
                                <button type="button" role="button"
                                    class="btn @if ($shopOwner->status == true) btn-success @else btn-warning @endif btn-sm ms-auto"
                                    onclick="document.getElementById('approval').submit()">
                                    @if ($shopOwner->status == true)
                                        Make it Pending
                                    @else
                                        Approve
                                        {{ $shopOwner->firstName }} as Owner
                                    @endif
                                </button>
                            </div>
                        </div>
                        <div class="card mb-3 border border-danger">
                            <div class="card-header">
                                <p class="mb-0">Danger Zone</p>
                            </div>
                            <div class="card-body">
                                <p>Proceeding with the deletion of this user may result in irretrievable data loss, as all
                                    data associated with this user will also be deleted.</p>
                                <button type="button" role="button" class="btn btn-primary btn-sm ms-auto"
                                    onclick="document.getElementById('deletion').submit()">Delete permanently</button>
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
        var map = L.map('map').setView([{{ $shopOwner->shopOwnerInfo->shopLat }},
            {{ $shopOwner->shopOwnerInfo->shopLong }}
        ], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([{{ $shopOwner->shopOwnerInfo->shopLat }}, {{ $shopOwner->shopOwnerInfo->shopLong }}], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            var marker = event.target;
            var position = marker.getLatLng();

            document.querySelector('#shopLong').innerHTML = position.lng;
            document.querySelector('#shopLat').innerHTML = position.lat;
            document.querySelector('[name="shopLong"]').value = position.lng;
            document.querySelector('[name="shopLat"]').value = position.lat;

            fetch('https://api.opencagedata.com/geocode/v1/json?q=' + position.lat + '+' + position.lng +
                    '&key=84b8f8b5b31c450485b329c38cad5c23')
                .then(response => response.json())
                .then(data => {
                    var address = data.results[0].formatted;
                    document.querySelector('#shopAddress').innerHTML = address;
                    document.querySelector('[name="shopAddress"]').value = address;
                });
        });

        function selectedImage(input, target) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector(`.${target}`).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
