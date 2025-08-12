@extends('layouts.admin')

@section('title', 'Services - Edit ' . $service->service_name)

@section('content')
    <div class="container-fluid py-4">
        <form action="{{ route('driver.store.service', $service->id) }}" method="post">
            @csrf
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <p class="mb-0">Service Details</p>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <i class="icon rb-forklift text-danger text-lg opacity-10"></i>
                                    <h6>{{ $service->service_name }}</h6>
                                </div>
                                <h5>₱ {{ $service->service_price }}</h5>
                                <p>{{ $service->service_description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Additional Information</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Avail Service</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Date of Arrival</label>
                                            <input class="form-control @error('arrival') is-invalid @enderror"
                                                type="datetime-local" name="arrival"
                                                value="{{ old('arrival') }}"
                                                id="arrival"
                                                min="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Last Odometer Reading (e.i 100000)</label>
                                            <select name="odometer_type" class="rounded border border-danger"
                                                onchange="appendPlaceholder(this.value)">
                                                <option value="Kilometers">Kilometers</option>
                                                <option value="Miles">Miles</option>
                                            </select>
                                            <input class="form-control @error('last_odometer_reading') is-invalid @enderror"
                                                type="text" name="last_odometer_reading"
                                                value="{{ old('last_odometer_reading') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Notes to shop (Optional)</label>
                                            <textarea cols="30" rows="5" class="form-control @error('notes') is-invalid @enderror"
                                                type="text" name="notes">{{ old('notes') }}</textarea>
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
        function appendPlaceholder(value) {
            const inputOdometer = document.querySelector('input[name="last_odometer_reading"]');

            inputOdometer.setAttribute('placeholder', value);
        }
        window.onload = function() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const datetime = `${year}-${month}-${day}T${hours}:${minutes}`;

            //document.getElementById('arrival').setAttribute('min', datetime);
        }
    </script>
@endsection
