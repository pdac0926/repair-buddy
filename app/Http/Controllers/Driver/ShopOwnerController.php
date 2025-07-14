<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\Services;
use App\Models\ShopRating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShopOwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function index($id, User $user)
    {
        $shopOwner = $user->findOrFail($id);
        $mechanics = User::where('role', 'mechanic')
            ->join('mechanic_infos', 'users.id', 'mechanic_infos.user_id')
            ->where('mechanic_infos.mechanicShopOwnerId', $shopOwner->id)->get();
        $services = Services::where('shop_id', $shopOwner->shopOwnerInfo->id)->get();
        $avail = Avail::where('user_id', Auth::id())->where('shop_id', $shopOwner->shopOwnerInfo->id)->where('status', 'Pending')->select('service_id')->get();
        $reviews = ShopRating::where('shop_id', $shopOwner->shopOwnerInfo->id)->get();

        $shopInfo = $shopOwner->shopOwnerInfo()->first();

        return view('driver-authenticated.show-shop-owner-info', compact('shopOwner', 'mechanics', 'services', 'avail', 'reviews', 'shopInfo'));
    }
}
