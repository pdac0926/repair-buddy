@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <div class="container-fluid py-4" id="messages">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body px-0 pt-0 pb-0">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card border-0">
                                    <div class="card-header">
                                        <h6>Messages</h6>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $defaultMsgId = null;
                                        @endphp
                                        @if ($user_id->count() > 0)
                                            @foreach ($user_id as $id => $user)
                                                @php
                                                    $defaultMsgId = $id;
                                                    date_default_timezone_set('Asia/Manila');
                                                    $uniqueuser = (new \App\Models\User())->where('id', $id)->first();
                                                    $message = (new \App\Models\Messages())
                                                        ->where('user_id', $id)
                                                        ->orderBy('created_at', 'DESC')
                                                        ->first();
                                                @endphp

                                                <a href="?msg={{ $uniqueuser->id }}" class="message-list">
                                                    <img src="{{ asset((new \App\Helper\Helper())->userAvatar($uniqueuser->avatar)) }}"
                                                        alt="{{ $uniqueuser->firstName }}">
                                                    <div class="message-content">
                                                        <h6>{{ $uniqueuser->firstName . ' ' . $uniqueuser->lastName }}</h6>
                                                        <p>{{ $message->message }}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                        <h6>No Message</h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="messages">
                                            @php
                                                $msgID = (isset($_GET['msg']) ? $_GET['msg'] : $defaultMsgId);
                                                $messagelist = (new \App\Models\Messages())
                                                    ->where('user_id', $msgID)
                                                    ->where('referenceID', Auth::id())
                                                    ->orderBy('created_at', 'ASC')
                                                    ->get();
                                            @endphp
                                            @if ($msgID)
                                                @foreach ($messagelist as $msg)
                                                    <div class="{{ $msg->user_id == Auth::id() ? 'sender' : 'receiver' }}">
                                                        <div class="msg">
                                                            <p>{{ $msg->message }}</p>
                                                            <hr class="p-0 m-0">
                                                            <small
                                                                class="message-date">{{ date('F j, Y | g:i a', strtotime($msg->created_at)) }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <h6>No Message</h6>
                                            @endif
                                        </div>
                                    </div>
                                    @if (isset($_GET['msg']))
                                        <div class="card-footer">
                                            <form action="" method="POST"
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
