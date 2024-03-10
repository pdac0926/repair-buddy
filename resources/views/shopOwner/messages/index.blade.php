@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <div class="container-fluid py-3" id="messages">
        <div class="row">
            <div class="col-12">
                <div class="card h-100 bg-transparent border-0">
                    <div class="card-body h-100 px-0 pt-0 pb-0">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card h-100 rounded-0">
                                    <div class="card-header">
                                        <h6>Messages</h6>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $defaultMsgId = null;
                                        @endphp
                                        @if ($sender_id->count() > 0)
                                            @foreach ($sender_id as $id => $user)
                                                @php
                                                    date_default_timezone_set('Asia/Manila');
                                                    $uniqueuser = (new \App\Models\User())
                                                        ->where('id', $id)
                                                        ->where('role', 'driver')
                                                        ->first();
                                                    $message = (new \App\Models\Messages())
                                                        ->where('sender_id', $id)
                                                        ->orWhere('sender_id', Auth::id())
                                                        ->orderBy('updated_at', 'DESC')
                                                        ->first();

                                                    $msgID = isset($_GET['msg']) ? $_GET['msg'] : '';
                                                @endphp
                                                @if ($id != Auth::id())
                                                    @php $defaultMsgId = $uniqueuser->id; @endphp
                                                    <a href="?msg={{ $uniqueuser->id }}"
                                                        class="message-list @if ($uniqueuser->id == $msgID) msg-active @endif">
                                                        <img src="{{ asset((new \App\Helper\Helper())->userAvatar($uniqueuser->avatar)) }}"
                                                            alt="{{ $uniqueuser->firstName }}">
                                                        <div class="message-content">
                                                            <h6>{{ $uniqueuser->firstName . ' ' . $uniqueuser->lastName }}
                                                            </h6>
                                                            <p>{{ $message->message }}</p>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                                <img src="{{ asset('assets_auth/img/chat.png') }}" class="no-message"
                                                alt="messages">
                                                <p>No Users Chat yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                @php
                                    $msgID = isset($_GET['msg']) ? $_GET['msg'] : $defaultMsgId;
                                    $messagelist = (new \App\Models\Messages())
                                        ->where('sender_id', $msgID)
                                        ->orWhere('sender_id', Auth::id())
                                        ->where('shopID', Auth::id())
                                        ->where('convoID', $msgID . '-' . Auth::id())
                                        ->orderBy('updated_at', 'ASC')
                                        ->get();

                                    $userClicked = (new \App\Models\User())->where('id', $msgID)->first();
                                @endphp
                                <div class="card rounded-0">
                                    @if ($msgID)
                                        <div class="card-header">{{ $userClicked->firstName }}</div>
                                    @endif
                                    <div class="card-body msg-h">
                                        <div class="messages">
                                            @if ($msgID)
                                                @foreach ($messagelist as $msg)
                                                    <div
                                                        class="{{ $msg->sender_id == Auth::id() ? 'sender' : 'receiver' }}">
                                                        <div class="msg">
                                                            <p>{{ $msg->message }}</p>
                                                            <hr class="p-0 m-0">
                                                            <small
                                                                class="message-date">{{ date('F j, Y | g:i a', strtotime($msg->created_at)) }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="card rounded-0">
                                                    <div class="card-header">Conversations</div>
                                                    <div class="card-body no-message-body">
                                                        <img src="{{ asset('assets_auth/img/message.png') }}"
                                                            class="no-message" alt="messages">
                                                        <p>No conversations yet</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if (isset($_GET['msg']))
                                        <div class="card-footer">
                                            <form action="{{ route('shop.owners.send.messages', $_GET['msg']) }}"
                                                method="POST"
                                                class="d-flex justify-content-center align-items-center gap-3">
                                                @csrf
                                                <textarea name="message" class="form-control" rows="1" placeholder="Message"></textarea>
                                                <button class="btn btn-sm btn-primary px-5 m-0">Send</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
