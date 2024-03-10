@extends('layouts.admin')

@section('title', 'Review - ' . $shop->shopName)

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Add Review</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{route('driver.store.review')}}" method="POST">
                            @csrf
                            <input type="hidden" name="shopId" value="{{$shop->id}}">
                            <input type="hidden" name="serviceId" value="{{$service->id}}">
                            <input type="hidden" name="serviceName" value="{{$service->service_name}}">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" cols="30" rows="5" placeholder="Write something"></textarea>
                                <div class="d-flex align-items-center justify-content-between w-100 p-2">
                                    <div class="d-flex mt-2 start-rating">
                                        <input type="radio" name="star" value="5" class="mr-1 star1" id="for1">
                                        <label for="for1"></label>
                                        <input type="radio" name="star" value="4" class="mr-1 star2" id="for2">
                                        <label for="for2"></label>
                                        <input type="radio" name="star" value="3" class="mr-1 star3" id="for3">
                                        <label for="for3"></label>
                                        <input type="radio" name="star" value="2" class="mr-1 star4" id="for4">
                                        <label for="for4"></label>
                                        <input type="radio" name="star" value="1" class="mr-1 star5" id="for5">
                                        <label for="for5"></label>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary mt-5" style="margin-bottom: 0;">Submit Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
