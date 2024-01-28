<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactShopOwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function index($id){
        $shopOwner = User::findOrFail($id);

        $messages = Messages::where('user_id', Auth::id())->where('referenceID', $id)->orderBy('created_at', 'ASC')->get();
        return view('driver-authenticated.contact-shop-owner', compact('shopOwner', 'messages'));
    }

    public function sendMessage($shopOwnerId, Request $request){
        $user = User::findOrFail($shopOwnerId);
        $validatedData = $request->validate(
            [
                'message' => ['required', 'string'],
            ]
        );
        $sender = auth()->user();
        $sendMessage = $sender->messages()->create([
            'referenceID' => $shopOwnerId,
            'message' => $validatedData['message']
        ]);

        if(!$sendMessage){
            return back()->with('error', 'Something went wrong, message not sent. please try again next year.');
        }
        return back();
    }
}
