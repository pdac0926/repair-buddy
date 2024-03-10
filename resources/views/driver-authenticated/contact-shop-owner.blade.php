@extends('layouts.admin')

@section('title', 'Message - ' . $shopOwner->shopOwnerInfo->shopName)

@section('content')
    <div class="container-fluid py-4" id="messages">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Message {{ $shopOwner->shopOwnerInfo->shopName }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 msg-h">
                        <div class="p-4">
                            <div class="messages">
                                @if ($messages->count() > 0)
                                    @foreach ($messages as $message)
                                        <div class="{{($message->sender_id == Auth::id() ? 'sender' : 'receiver')}}">
                                            <div class="msg">
                                                <p>{{$message->message}}</p>
                                                <hr class="p-0 m-0">
                                                <small class="message-date">{{date('F j, Y | g:i a', strtotime($message->created_at))}}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <div class="card-body no-message-body">
                                    <img src="{{ asset('assets_auth/img/message.png') }}"
                                        class="no-message" alt="messages">
                                    <p>No conversations yet</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('driver.send.message', $shopOwner->id) }}" method="POST"
                            class="d-flex justify-content-center align-items-center gap-3">
                            @csrf
                            <textarea name="message" class="form-control" rows="1" placeholder="Message"></textarea>
                            <button class="btn btn-sm btn-primary px-5 m-0">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function scrollToBottom() {
            var container = document.querySelector(".card-body.msg-h");
            container.scrollTop = container.scrollHeight;
        }
        scrollToBottom();
    </script>
@endsection