@extends('layouts.admin')

@section('title', 'Driver - ' . $driver->firstName . ' ' . $driver->lastName)

@section('content')
    <div class="container-fluid py-4">
        <form action="{{ route('admin.approve.drivers', $driver->id) }}" method="post" id="approval">
            @csrf
        </form>
        <form action="{{ route('admin.delete.drivers', $driver->id) }}" method="post" id="deletion">
            @csrf
        </form>
        <form action="{{ route('admin.update.drivers', $driver->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-lg mx-3 @error('avatar') border border-danger @enderror ">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ asset((new \App\Helper\Helper())->userAvatar($driver->avatar)) }}"
                                    alt="profile_image" class="border-radius-lg shadow-sm avatarphoto">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    User Profile
                                </h5>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="mb-0">Profile Information</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Update Driver</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">First Name</label>
                                            <input class="form-control @error('firstName') is-invalid @enderror"
                                                type="text" name="firstName"
                                                value="{{ old('firstName', $driver->firstName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Middle Name</label>
                                            <input class="form-control @error('middleName') is-invalid @enderror"
                                                type="text" name="middleName"
                                                value="{{ old('middleName', $driver->middleName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Last Name</label>
                                            <input class="form-control @error('lastName') is-invalid @enderror"
                                                type="text" name="lastName"
                                                value="{{ old('lastName', $driver->lastName) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                                name="email" value="{{ old('email', $driver->email) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                type="password" name="password"
                                                value="{{ old('password', 'Laravel@123') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password Confirmation</label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                                type="password" name="password_confirmation"
                                                value="{{ old('password_confirmation', 'Laravel@123') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Contact Information</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input class="form-control @error('address') is-invalid @enderror"
                                                type="text" name="address"
                                                value="{{ old('address', $driver->address) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Phone Number</label>
                                            <input class="form-control @error('phoneNumber') is-invalid @enderror"
                                                type="text" name="phoneNumber"
                                                value="{{ old('phoneNumber', $driver->phoneNumber) }}">
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <p class="mb-0">Approval</p>
                            </div>
                            <div class="card-body">
                                <p>After obtaining approval, the user was granted access to system properties, allowing them to leverage advanced functionalities and configurations.</p>
                                <button type="button" role="button" class="btn @if($driver->status == true) btn-success @else btn-warning @endif btn-sm ms-auto"
                                            onclick="document.getElementById('approval').submit()">@if($driver->status == true) Make it Pending @else Approve
                                            {{ $driver->firstName }} as Driver @endif</button>
                            </div>
                        </div>
                        <div class="card mb-3 border border-danger">
                            <div class="card-header">
                                <p class="mb-0">Deletion of Account</p>
                            </div>
                            <div class="card-body">
                                <p>Proceeding with the deletion of this user may result in irretrievable data loss, as all
                                    data associated with this user will also be deleted.</p>
                                <button type="button" role="button" class="btn btn-primary btn-sm ms-auto"
                                    onclick="document.getElementById('deletion').submit()">Delete permanently</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        function selectedImage(input, target) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector(`.${target}`).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
