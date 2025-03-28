@extends('layouts.admin')

@section('title', 'Paid Service')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                     <h6>Paid Services</h6>
                       <input type="month" id="monthFilter" class="form-control w-25">
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
                                        @php
                                            $totalServicePrice = 0;
                                        @endphp
                                        @foreach ($services as $service)
                                            @php
                                                $totalServicePrice += $service->service_price;
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
                                                            <p>₱ {{ number_format($service->service_price, 2) }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $arrivalDateTime = new DateTime($service->arrival);
                                                        $formattedArrival = $arrivalDateTime->format('F j, Y | g:i A | l');
                                                    @endphp
                                                    <p class="text-xs font-weight-bold mb-0">{{ $formattedArrival }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-xs font-weight-bold mb-0 badge bg-success">
                                                        {{ $service->status }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end font-weight-bold">Total:</td>
                                            <td class="text-center font-weight-bold">₱ {{ number_format($totalServicePrice, 2) }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center p-5">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('assets_auth/img/pending.png') }}"
                                                        class="no-message mb-5" alt="messages">
                                                    <p>No Paid Service yet</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthFilter = document.getElementById('monthFilter');
        monthFilter.addEventListener('change', function() {
            const selectedMonth = monthFilter.value; // Format: YYYY-MM
            location.href = `?filter_by_month=${selectedMonth}`;
        });
    });
</script>
    