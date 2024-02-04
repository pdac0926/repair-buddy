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
        $sender_id = Messages::join('users', 'messages.sender_id', 'users.id')
            ->where('shopID', Auth::id())
            ->select('users.firstName', 'users.lastName', 'users.avatar', 'users.created_at', 'messages.sender_id', 'messages.shopID', 'messages.message', 'messages.created_at as msg_date')
            ->orderBy('messages.updated_at', 'DESC')
            ->get()
            ->groupBy('sender_id');

        return view('admin-authenticated.messages.index', compact('sender_id'));
    }

    public function sendMessage($driverID, Request $request){
        User::findOrFail($driverID);

        $validatedData = $request->validate(
            [
                'message' => ['required', 'string'],
            ]
        );
        $sender = auth()->user();
        $sendMessage = Messages::create([
            'sender_id' => $sender->id,
            'receiver_id' => $driverID,
            'shopID' => $sender->id,
            'convoID' => $driverID . '-' . $sender->id,
            'message' => $validatedData['message']
        ]);

        if(!$sendMessage){
            return back()->with('error', 'Something went wrong, message not sent. please try again next year.');
        }
        return back();
    }
}
