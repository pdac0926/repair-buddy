@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Messages</h6>
                    </div>
                    <div class="card-body driver-messages">
                        @if ($ShopOwner->count() > 0)
                            @foreach ($ShopOwner as $owner)
                                <a href="{{route('driver.view.contact.shop.owner', $owner->id)}}" class="message-item">
                                    <img src="{{ asset((new \App\Helper\Helper())->userAvatar($owner->avatar)) }}" alt="{{$owner->name}}">
                                    <p>{{$owner->firstName . ' ' . $owner->lastName }}</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
