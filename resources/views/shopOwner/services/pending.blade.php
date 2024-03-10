@extends('layouts.admin')

@section('title', 'Pending Availed')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Pending Services</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Shop</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Your Estimated Arrival</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($services) > 0)
                                        @foreach ($services as $service)
                                            @php
                                                $user = (new \App\Models\User())
                                                    ->where('id', $service->user_id)
                                                    ->where('role', 'driver')
                                                    ->where('status', true)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex gap-3 px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset((new \App\Helper\Helper())->userAvatar($user->avatar)) }}"
                                                                class="avatar avatar-sm me-3" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-capitalize">
                                                                {{ $user->firstName . ' ' . $user->middleName . ' ' . $user->lastName }}
                                                            </h6>
                                                            <p>$ {{ $service->service_price }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-3 px-2 py-1">
                                                        <div>
                                                            <i class="icon rb-gear-2 text-success text-sm opacity-10"></i>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-capitalize">
                                                                {{ $service->service_name }}
                                                            </h6>
                                                            <p>$ {{ $service->service_price }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $service->shop_name }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $arrivalDateTime = new DateTime($service->arrival);
                                                        $formattedArrival = $arrivalDateTime->format(
                                                            'F j, Y | g:i A | l',
                                                        );
                                                    @endphp
                                                    <p class="text-xs font-weight-bold mb-0">{{ $formattedArrival }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-xs font-weight-bold mb-0 badge bg-danger">
                                                        {{ $service->status }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($service->status)
                                                        <form
                                                            action="{{ route('shop.owners.update.services.status', $service->id) }}"
                                                            method="POST" id="formServiceStatus" class="w-75">
                                                            @csrf
                                                            <select name="status" class="form-select"
                                                                aria-label="Default select example"
                                                                onchange="document.getElementById('formServiceStatus').submit()">
                                                                <option selected>Choose</option>
                                                                <option value="Approved">Accept</option>
                                                                <option value="Reject">Reject</option>
                                                            </select>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center p-5">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('assets_auth/img/pending.png') }}"
                                                        class="no-message mb-5" alt="messages">
                                                    <p>No Pending Service yet</p>
                                                </div>
                                            </td>
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
@endsection
