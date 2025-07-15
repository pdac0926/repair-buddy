@extends('layouts.admin')

@section('title', 'Maintenance History')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Maintenance History</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Price change note</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Shop</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
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
                                                                {{ $service->service_name }}
                                                            </h6>
                                                            <p>₱ {{ $service->service_price }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">

                                                @if ($service->status !== 'Rejected')
                                                    <button type="button"
                                                        class="btn btn-sm px-3 py-1 border-0 text-secondary bg-transparent"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewPriceModal{{ $service->service_id }}">
                                                        View changes
                                                    </button>

                                                    <div class="modal fade" id="viewPriceModal{{ $service->service_id }}" tabindex="-1" aria-labelledby="viewPriceModalLabel{{ $service->service_id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewPriceModalLabel{{ $service->service_id }}">Price Change Note</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Service:</strong> {{ $service->service_name }}</p>

                                                                    <p>
                                                                        <strong>Original Price:</strong>
                                                                        ₱ {{ $service->service_old_price ?? 'N/A' }}
                                                                    </p>

                                                                    <p>
                                                                        <strong>Updated Price:</strong>
                                                                        ₱ {{ $service->service_price }}
                                                                    </p>

                                                                    <p>
                                                                        <strong>Note:</strong>
                                                                        {{ $service->service_price_notes ?? 'No note provided.' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

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
                                                    @if($service->status == 'Rejected')
                                                        <button type="button" class="btn btn-primary btn-xs mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Rejected | View Reason</button>
                                                        <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $service->message }}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p class="text-xs font-weight-bold mb-0">{{ ($service->status) }}</p>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @php
                                                        $review = (new \App\Models\ShopRating())
                                                            ->where('user_id', Auth::id())
                                                            ->where('shop_id', $service->shop_id)
                                                            ->where('service_id', $service->service_id)
                                                            ->latest('created_at')
                                                            ->first();
                                                    @endphp

                                                    @if($service->status == 'Rejected')
                                                        <p class="text-xs font-weight-bold mb-0 badge bg-warning ">
                                                            Unable to Review</p>
                                                    @else 
                                                        @if ($review)
                                                        <p class="text-xs font-weight-bold mb-0 badge bg-warning ">
                                                            Reviewed</p>
                                                        @else
                                                            <a href="/review/{{ $service->shop_id }}/{{ $service->service_id }}"
                                                                class="btn">Rate Service</a>
                                                        @endif
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center p-5">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('assets_auth/img/pending.png') }}"
                                                        class="no-message mb-5" alt="messages">
                                                    <p>No Maintenance History yet</p>
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
