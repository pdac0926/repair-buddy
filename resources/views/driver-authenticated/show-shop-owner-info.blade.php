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
                            {{ $shopOwner->shopOwnerInfo->shopName }} Shop
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-12">
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
                
                <div class="col-md-6">
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
                                                                <img src="{{ asset((new \App\Helper\Helper())->userAvatar($mechanic->avatar)) }}"
                                                                    class="avatar avatar-sm me-3" alt="user1">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm text-capitalize">
                                                                    {{ $mechanic->firstName . ' ' . $mechanic->lastName . ' ' . $mechanic->middleName }}
                                                                </h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $mechanic->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><small>{{ $mechanic->phoneNumber }}</small></td>
                                                    <td><small>{{ $mechanic->mechanicRating }}</small></td>
                                                    <td><small>{{ $mechanic->phoneNumber }}</small></td>

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
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Services</p>
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
                                                SERVICE INFO</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                SERVICE PRICE</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($services) > 0)
                                            @foreach ($services as $service)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex gap-3 px-2 py-1">
                                                            <div>
                                                                <i
                                                                    class="icon rb-gear-2 text-success text-sm opacity-10"></i>
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm text-capitalize">
                                                                    {{ $service->service_name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><small>{{ $service->service_description }}</small></td>
                                                    <td class="align-middle text-center">
                                                        <small>{{ $service->service_price }}</small>
                                                    </td>
                                                    <td>
                                                        @if (in_array($service->id, $avail->pluck('service_id')->toArray()))
                                                            <form
                                                                action="{{ route('driver.cancel.service', $service->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-secondary font-weight-bold text-xs btn btn-sm btn-secondary text-light"
                                                                    title="Edit Shop Owner">
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="/avail-service/{{$service->id}}/{{$shopOwner->shopOwnerInfo->id}}"
                                                                class="text-secondary font-weight-bold text-xs btn btn-sm btn-success text-light"
                                                                title="Edit Shop Owner">
                                                                Avail
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center p-5">No Services found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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
