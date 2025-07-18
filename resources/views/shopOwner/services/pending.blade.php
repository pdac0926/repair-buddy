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
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Your Estimated Arrival</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Details</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($services) > 0)
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($services as $service)
                                            @php
                                                $count++;
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
                                                            {{-- <p>₱ {{ $service->service_price }}</p> --}}
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
                                                            <p>₱ {{ $service->service_price }}</p>
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
                                                <td class="align-middle text-center" style="max-width: 600px;text-wrap: initial;">
                                                    <button type="button" class="btn btn-primary btn-xs mb-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">View</button>
                                                    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                    <p><strong>Notes:</strong> {{ $service->notes }}</p>
                    <p><strong>Last Odometer Reading:</strong> {{ $service->last_odometer_reading }}</p>
                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-xs font-weight-bold mb-0 badge bg-danger">
                                                        {{ $service->status }}</p>
                                                </td>
                                                <td class="align-middle text-center" style="width: 200px;">
                                                    @if ($service->status)
                                                        <form
                                                            action="{{ route('shop.owners.update.services.status', $service->id) }}"
                                                            method="POST" id="formServiceStatus{{$count}}" class="w-75">
                                                            @csrf
                                                            <input type="hidden" name="message" class="d-none formServiceStatus{{$count}}"></input>
                                                            <select name="status" class="form-select select-status"
                                                                aria-label="Default select example" target-id="formServiceStatus{{$count}}">
                                                                <option value="" selected>Choose</option>
                                                                <option value="Approved">Accept</option>
                                                                <option value="Rejected">Reject</option>
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

<div class="modal fade" id="formNotesReject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control messageChurvaness" rows="3" placeholder="Leave a message why you reject the service."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary submitCuchu" >Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = ()=>{
        const selectStatus = document.querySelector('.select-status');
        const modal = new bootstrap.Modal(document.getElementById('formNotesReject'));

        let targetID = '';
        selectStatus.addEventListener('change', ()=>{
            targetID = selectStatus.getAttribute('target-id');
            if(selectStatus.value == '') {return};
            if(selectStatus.value != 'Rejected'){
                document.getElementById(targetID).submit()
            }
            modal.show();
        });

        // submit chuchuness
        const submitChuchuness = document.querySelector('.submitCuchu');
        submitChuchuness.addEventListener('click', ()=>{
            const messageChurvaness = document.querySelector('.messageChurvaness');
            const formMessageChurvaness = document.querySelector(`.${targetID}`);
            formMessageChurvaness.value = messageChurvaness.value;
            document.getElementById(targetID).submit();
        });
    };
</script>