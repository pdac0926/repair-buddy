@extends('layouts.admin')

@section('title', 'Paid Service')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                     <h6>Paid Services</h6>
                     <form method="GET" class="d-flex gap-2 align-items-center mb-3">
    <input type="date" name="start_day" class="form-control" value="{{ request('start_day') }}">
    <span>to</span>
    <input type="date" name="end_day" class="form-control" value="{{ request('end_day') }}">
    <button type="submit" class="btn btn-primary">Filter</button>
</form>


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
                                            Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($services) > 0)
                                        @php
                                            $totalServicePrice = 0;
                                        @endphp
                                        @foreach ($services as $service)
    @if (strtolower(trim($service->status)) !== 'rejected')
        @php
            $totalServicePrice += $service->service_price;
            $user = (new \App\Models\User())
                ->where('id', $service->user_id)
                ->where('role', 'driver')
                ->where('status', true)
                ->first();
        @endphp
        @if ($user)
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
                                                            
                                                        </div>
                                                    </div>
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
                                                    <p class="text-xs font-weight-bold mb-0 badge bg-success">
                                                        {{ $service->status }}</p>
                                                </td>
                                                <td>
</td>
                                                <td>
                                                <p>₱ {{ number_format($service->service_price, 2) }}</p>
</td>
                                            </tr>
                                            @endif
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td>
</td>
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
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtn = document.getElementById('filterBtn');

        filterBtn.addEventListener('click', function () {
            const start = document.getElementById('startDate').value;
            const end = document.getElementById('endDate').value;

            if (start && end) {
                location.href = `?start_date=${start}&end_date=${end}`;
            } else {
                alert('Please select both start and end dates.');
            }
        });
    });
</script>

    