@extends('layouts.admin')

@section('title', 'Drivers - List')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Drivers</h6>
                        <a href="{{ route('admin.add.drivers') }}" class="btn btn-primary btn-sm">Add Driver</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Contact Info</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Documents
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($drivers) > 0)
                                        @foreach ($drivers as $driver)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset((new \App\Helper\Helper())->userAvatar($driver->avatar)) }}"
                                                                class="avatar avatar-sm me-3" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-capitalize">
                                                                {{ $driver->firstName . ' ' . $driver->lastName . ' ' . $driver->middleName }}
                                                            </h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $driver->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $driver->phoneNumber }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ $driver->address }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-{{ $driver->status == true ? 'success' : 'warning' }}">{{ $driver->status == true ? 'Approved' : 'pending' }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#driversPreviews"
                                                            data-bs-whatever="{{ asset((new \App\Helper\Helper())->userAvatar($driver->driverInfo->driversLicensePhoto)) }}">Driver's
                                                            License</button>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('admin.edit.drivers', $driver->id) }}"
                                                        class="text-secondary font-weight-bold text-xs" title="Edit Driver">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center p-5">No Driver found</td>
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

    {{-- modal --}}
    <div class="modal fade" id="driversPreviews" tabindex="-1" aria-labelledby="driversPreviewsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <img src="" alt="Certificates Previews" id="certPrev" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var driversPreviews = document.getElementById('driversPreviews')
        driversPreviews.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-whatever')
            var modalBodyImage = driversPreviews.querySelector('#certPrev')
            modalBodyImage.src = recipient
        })
    </script>
@endsection
