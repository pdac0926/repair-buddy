<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\MechanicInfo;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $services = Services::where('shop_id', $shopOwner->shopOwnerInfo->id)->get();
        $avail = Avail::where('user_id', Auth::id())->where('shop_id', $shopOwner->shopOwnerInfo->id)->select('service_id')->get();

        return view('driver-authenticated.show-shop-owner-info', compact('shopOwner', 'mechanics', 'services', 'avail'));
    }
}
