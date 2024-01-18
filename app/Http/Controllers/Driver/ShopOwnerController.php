<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\MechanicInfo;
use App\Models\User;
use Illuminate\Http\Request;

class ShopOwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function index($id, User $user){
        $shopOwner = $user->findOrFail($id);
        $mechanics = User::where('role', 'mechanic')
                    ->join('mechanic_infos', 'users.id', 'mechanic_infos.user_id')
                        ->where('mechanic_infos.mechanicShopOwnerId', $shopOwner->id)->get();

        return view('driver-authenticated.show-shop-owner-info', compact('shopOwner', 'mechanics'));
    }
}
