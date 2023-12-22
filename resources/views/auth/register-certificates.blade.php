@extends('layouts.app')

@section('title', 'Sign up | Certificates/License')

@section('content')
    <div class="container-fluid certificate">
        <div class="card bg-transparent border-0">
            <div class="card-body">
                <form method="POST" action="{{ route('store.register.certificate') }}" enctype="multipart/form-data">
                    @csrf
                    <h1 class="text-light mb-3">Certificates/License</h1>
                    <div class="form-group mt-5 mb-2">
                        <input class="d-none" type="file" id="driversLicensePhoto"
                            onchange="selectedImage(this, 'driversLicensePhoto')" name="driversLicensePhoto">
                        <div class="cert-image-container" onclick="handleUpload('driversLicensePhoto')">
                            <img class="driversLicensePhoto"
                                data-old-img="{{ asset('assets/img/certificates/drivers-license.png') }}"
                                src="{{ asset('assets/img/certificates/drivers-license.png') }}" alt="Driver's License">
                            <p>Upload License</p>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <input class="d-none" type="file" id="driverCertificatePhoto"
                            onchange="selectedImage(this, 'driverCertificatePhoto')" name="driverCertificatePhoto">
                        <div class="cert-image-container" onclick="handleUpload('driverCertificatePhoto')">
                            <img class="driverCertificatePhoto"
                                data-old-img="{{ asset('assets/img/certificates/certificate.png') }}"
                                src="{{ asset('assets/img/certificates/certificate.png') }}" alt="Driver's Certificate">
                            <p>Upload Certificate</p>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <input class="d-none" type="file" id="driverAvatar"
                            onchange="selectedImage(this, 'driverAvatar')" name="driverAvatar">
                        <div class="cert-image-container" onclick="handleUpload('driverAvatar')">
                            <img class="driverAvatar" data-old-img="{{ asset('assets/img/certificates/avatar.png') }}"
                                src="{{ asset('assets/img/certificates/avatar.png') }}" alt="Driver's Avatar">
                            <p>Upload Avatar</p>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-check text-start text-light">
                            <input class="form-check-input" type="checkbox" name="privacyPolicy" id="privacyPolicy">
                            <label class="form-check-label" for="privacyPolicy">
                                Agree to Terms and Condition
                            </label>
                          </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function handleUpload(value) {
            document.getElementById(value).click();
        }

        function selectedImage(input, target) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector(`.${target}`).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
