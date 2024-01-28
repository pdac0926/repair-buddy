<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isOwner']);
    }

    public function index()
    {
        $user_id = Messages::join('users', 'messages.user_id', 'users.id')
            ->where('referenceID', Auth::id())
            ->select('users.firstName', 'users.lastName', 'users.avatar', 'users.created_at', 'messages.user_id', 'messages.referenceID', 'messages.message', 'messages.created_at as msg_date')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->groupBy('user_id');

        return view('admin-authenticated.messages.index', compact('user_id'));
    }
}
