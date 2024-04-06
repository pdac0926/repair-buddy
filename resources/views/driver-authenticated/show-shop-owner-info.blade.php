@extends('layouts.admin')

@section('title', 'Shop - ' . $shopOwner->shopOwnerInfo->shopName)

@section('content')
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
                            <div class="col-lg-4 s-owner">
                                <img src="{{ asset((new \App\Helper\Helper())->userAvatar($shopOwner->avatar)) }}"
                                    alt="profile image" class="border-radius-lg shadow-sm img-fluid shopOwnerAvatar"
                                    style="max-width: 400px; height: auto;">
                                <h4 class="my-3">
                                    {{ $shopOwner->firstName . ' ' . $shopOwner->middleName . ' ' . $shopOwner->lastName }}
                                </h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="my-3">
                                    {{ $shopOwner->shopOwnerInfo->shopName }}
                                </h4>
                                <hr>
                                {{ $shopOwner->shopOwnerInfo->shopPhone }}
                                <hr>
                                {{ $shopOwner->shopOwnerInfo->shopAddress }}
                                <hr>
                                {{ $shopOwner->shopOwnerInfo->shopDescription }}
                                <hr>
                                {{ $shopOwner->email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
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
                                                            <i class="icon rb-gear-2 text-success text-sm opacity-10"></i>
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
                                                        <form action="{{ route('driver.cancel.service', $service->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-secondary font-weight-bold text-xs btn btn-sm btn-secondary text-light"
                                                                title="Edit Shop Owner">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="/avail-service/{{ $service->id }}/{{ $shopOwner->shopOwnerInfo->id }}"
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
            <div class="col-md-12">
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
                                            Ratings</th>
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
                                                <td class="text-center"><small>{!! $mechanic->mechanicAvailability == 'Available'
                                                    ? '<span class="text-success">' . $mechanic->mechanicAvailability . '</span>'
                                                    : $mechanic->mechanicAvailability !!}</small></td>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Reviews ({{ $reviews->count() }})</div>
                    <div class="card-body">
                        @if ($reviews->count() > 0)
                            @foreach ($reviews as $review)
                                @php
                                    $user = (new \App\Models\User())
                                        ->where('id', $review->user_id)
                                        ->first();
                                @endphp

                                <div class="card border-0 shadow-0 mb-2">
                                    <div class="card-body border-0 shadow-0">
                                        <div class="d-flex align-items-center gap-3">
                                            <span>{{ $user->firstName }}</span>
                                            <div class="star-rate d-flex align-items-center gap-1">
                                                @for ($i = 0; $i < $review->service_rate; $i++)
                                                    <i class="bi bi-star-fill" style="color: #f82249;"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <small><strong>Service:</strong> {{$review->service_name}} | {{$review->created_at->diffForHumans()}}</small>
                                        <p class="mt-2">{{$review->comment}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div style="text-align: center;">
    <p>No Reviews yet.</p>
</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            draggable: false
        }).addTo(map);
    </script>
@endsection
