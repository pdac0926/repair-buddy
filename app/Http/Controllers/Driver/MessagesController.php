<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function messages()
    {
        $shopOwnerIDs = Messages::where('sender_id', Auth::id())
        ->pluck('receiver_id')->toArray();

        $ShopOwner = User::where('role', 'shopOwner')->whereIn('id', $shopOwnerIDs)->get();

        // dd($ShopOwner);
        return view('driver-authenticated.messages', compact('ShopOwner'));
    }
}
