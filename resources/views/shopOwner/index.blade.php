@extends('layouts.admin')

@section('title', 'Shop Owner - Mechanics')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Mechanics</h6>
                        <a href="{{ route('shop.owners.add.mechanics') }}" class="btn btn-primary btn-sm">Add Mechanics</a>
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
                                            Mechanics Info</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Rating</th>
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
                                                            <p class="text-xs text-secondary mb-0">{{ $mechanic->email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $mechanic->mechanicAddress }}</p>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $mechanic->mechanicPhone }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $mechanic->status == true ? 'Approved' : 'pending' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $mechanic->mechanicRating }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('shop.owners.edit.mechanics', $mechanic->id) }}"
                                                        class="text-secondary font-weight-bold text-xs"
                                                        title="Edit Shop Owner">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center p-5">No Mechanic yet</td>
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
