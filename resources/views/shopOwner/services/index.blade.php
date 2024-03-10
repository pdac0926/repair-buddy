@extends('layouts.admin')

@section('title', 'Shop Owner - Services')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Services</h6>
                        <a href="{{route('shop.owners.add.services')}}" class="btn btn-primary btn-sm">Add Services</a>
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
                                            Service Info</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Service price</th>
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
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $service->service_description }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $service->service_price }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('shop.owners.edit.services', $service->id) }}"
                                                        class="text-secondary font-weight-bold text-xs btn btn-sm btn-primary text-light"
                                                        title="Edit Shop Owner">
                                                        Manage
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" class="text-center p-5">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('assets_auth/img/pending.png') }}"
                                                        class="no-message mb-5" alt="messages">
                                                    <p>No Service yet</p>
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
