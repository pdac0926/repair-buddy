@extends('layouts.admin')

@section('title', 'Services - Edit ' . $service->service_name)

@section('content')
    <div class="container-fluid py-4">
        <form action="{{ route('shop.owners.delete.services', $service->id) }}" method="post"
            id="deletion">
            @csrf
        </form>
        <form action="{{ route('shop.owners.update.services', $service->id) }}" method="post">
            @csrf
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Service</p>
                                    <button class="btn btn-primary btn-sm ms-auto">Update Service</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Service Name</label>
                                            <input class="form-control @error('service_name') is-invalid @enderror"
                                                type="text" name="service_name"
                                                value="{{ old('service_name', $service->service_name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Service Price</label>
                                            <input class="form-control @error('service_price') is-invalid @enderror"
                                                type="text" name="service_price"
                                                value="{{ old('service_price', $service->service_price) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Service Description</label>
                                            <textarea cols="30" rows="5" class="form-control @error('service_description') is-invalid @enderror"
                                                type="text" name="service_description">{{ old('service_description', $service->service_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border border-danger">
                            <div class="card-header">
                                <p class="mb-0">Danger Zone</p>
                            </div>
                            <div class="card-body">
                                <p>Proceeding with the deletion of this service may result in irretrievable data loss, as
                                    all
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
