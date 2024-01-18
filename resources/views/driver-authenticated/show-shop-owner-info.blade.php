@extends('layouts.admin')

@section('title', 'Shop - ' . $shopOwner->shopOwnerInfo->shopName)

@section('content')
    <div class="container-fluid py-4 driver-panel">
        <div class="card shadow-lg mx-3 @error('avatar') border border-danger @enderror ">
            <div class="card-body p-3 ">
                <div class="row gx-4">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h1 class="mb-1">
                                {{ $shopOwner->shopOwnerInfo->shopName }}
                            </h1>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ $shopOwner->shopOwnerInfo->shopPhone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Owner and Shop Information</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 s-owner">
                                    <img src="{{ asset((new \App\Helper\Helper())->userAvatar($shopOwner->avatar)) }}"
                                        alt="profile image" class="border-radius-lg shadow-sm img-fluid shopOwnerAvatar">
                                    <h4 class="my-3">
                                        {{ $shopOwner->firstName . ' ' . $shopOwner->middleName . ' ' . $shopOwner->lastName }}
                                    </h4>
                                    <p>{{ $shopOwner->email }}</p>
                                    <p>{{ $shopOwner->email }}</p>
                                </div>
                                <div class="col-lg-6">
                                    {{ $shopOwner->shopOwnerInfo->shopName }}
                                    <hr>
                                    {{ $shopOwner->shopOwnerInfo->shopPhone }}
                                    <hr>
                                    {{ $shopOwner->shopOwnerInfo->shopAddress }}
                                    <hr>
                                    {{ $shopOwner->shopOwnerInfo->shopDescription }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Mechanics</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Phone</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Rating</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Mechanics</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mechanics) > 0)
                                            @foreach ($mechanics as $mechanic)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{asset((new \App\Helper\Helper())->userAvatar($mechanic->avatar))}}" class="avatar avatar-sm me-3"
                                                                alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-capitalize">{{$mechanic->firstName . ' ' . $mechanic->lastName . ' ' . $mechanic->middleName}}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{$mechanic->email}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><small>{{$mechanic->phoneNumber}}</small></td>
                                                <td><small>{{$mechanic->mechanicRating}}</small></td>
                                                <td><small>{{$mechanic->phoneNumber}}</small></td>
                                                
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center p-5">No Mechanic found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div
                        class="card card-profile mb-4 mb-3
                        @error('shopLong') border border-danger @enderror
                        @error('shopLat') border border-danger @enderror
                        @error('shopAddress') border border-danger @enderror">
                        <div class="card-header">
                            <p class="mb-0">Shop Location on the Map</p>
                            <small>The exact shop location is pinned on the map, which you can use to track our
                                whereabouts.</small>
                        </div>
                        <div id="map" style="height: 500px"></div>
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
                                            <p><small id="shopAddress">{{ $shopOwner->shopOwnerInfo->shopAddress }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{ $shopOwner->shopOwnerInfo->shopLat }},
            {{ $shopOwner->shopOwnerInfo->shopLong }}
        ], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([{{ $shopOwner->shopOwnerInfo->shopLat }}, {{ $shopOwner->shopOwnerInfo->shopLong }}], {
            draggable: false
        }).addTo(map);
    </script>
@endsection
