@extends('layouts.admin')

@section('title', 'Shop Owner : List')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Shop Owners</h6>
                        <a href="{{ route('admin.add.shop.owners') }}" class="btn btn-primary btn-sm">Add Shop Owner</a>
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
                                            Shop Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Mechanics</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shopOwners as $shopOwner)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{asset((new \App\Helper\Helper())->userAvatar($shopOwner->avatar))}}" class="avatar avatar-sm me-3"
                                                            alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm text-capitalize">{{$shopOwner->firstName . ' ' . $shopOwner->lastName . ' ' . $shopOwner->middleName}}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{$shopOwner->email}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$shopOwner->shopOwnerInfo->shopName}}</p>
                                                <p class="text-xs text-secondary mb-0">{{$shopOwner->shopOwnerInfo->shopAddress}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">{{$shopOwner->shopOwnerInfo->shopPhone}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">4</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{route('admin.edit.shop.owners', $shopOwner->id)}}" class="text-secondary font-weight-bold text-xs"
                                                    title="Edit Shop Owner">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
