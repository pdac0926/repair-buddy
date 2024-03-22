@extends('layouts.admin')

@section('title', 'Drivers - Add')

@section('content')
    <div class="container-fluid py-4">
        <form action="{{route('admin.store.drivers')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-lg mx-3 @error('avatar') border border-danger @enderror ">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{asset('assets_auth/img/profile.png')}}" alt="profile_image"
                                    class="border-radius-lg shadow-sm avatarphoto">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    Profile avatar
                                </h5>
                                <p class="mb-0 font-weight-bold text-sm">
                                    Choose a profile from your device.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item" onclick="document.getElementById('avatar').click()">
                                        <button role="button" type="button"
                                            class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center">
                                            <i class="ni ni-app"></i>
                                            <span class="ms-2">Choose Profile</span>
                                        </button>
                                        <input type="file" id="avatar" class="d-none" name="avatar" onchange="selectedImage(this, 'avatarphoto')">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Profile Information</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Add Driver</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">First Name</label>
                                            <input class="form-control @error('firstName') is-invalid @enderror" type="text" name="firstName"
                                                value="{{ old('firstName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Middle Name</label>
                                            <input class="form-control @error('middleName') is-invalid @enderror" type="text" name="middleName"
                                                value="{{ old('middleName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Last Name</label>
                                            <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName"
                                                value="{{ old('lastName') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                                                value="{{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Password Confirmation</label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Contact Information</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Phone Number</label>
                                            <input class="form-control @error('phoneNumber') is-invalid @enderror" type="text" name="phoneNumber"
                                                value="{{ old('phoneNumber') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Certificates</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Driver's License</label>
                                            <input class="form-control @error('driversLicensePhoto') is-invalid @enderror" type="file" name="driversLicensePhoto"
                                                value="{{ old('driversLicensePhoto') }}">
                                        </div>
                                    </div>
                                </div>
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
