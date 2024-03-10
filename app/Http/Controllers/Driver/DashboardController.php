<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\ShopRating;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function loadShopLocations() {
        $users = User::where('role', 'shopOwner')->with('shopOwnerInfo')->get();
        if ($users->count() > 0) {
            $data = [];
            foreach ($users as $user) {
                $coords = [
                    $user->shopOwnerInfo->shopLat,
                    $user->shopOwnerInfo->shopLong
                ];

                $reviews = ShopRating::where('shop_id', $user->shopOwnerInfo->id)->count();

                $popupText = '<div class="d-flex flex-column align-items-center text-center">
                <h4>' . $user->shopOwnerInfo->shopName . '</h4>
                <p class="p-0 m-0">' . $user->shopOwnerInfo->shopAddress . '</p>
                <p class="p-0 m-0">' . $user->shopOwnerInfo->shopPhone . '</p>
                <p class="p-0 m-0">Reviews: '.$reviews.'</p>
                <a class="btn btn-sm btn-primary text-white" href="' . route('driver.view.shop.owner', $user->id) . '">View Shop</a>
                <a class="btn btn-sm btn-primary text-white" href="' . route('driver.view.contact.shop.owner', $user->id) . '">Contact</a></div>';

                $data[] = [
                        'coords' => $coords,
                        'popupText' => $popupText
                    ];
            }
            return response()->json($data, JsonResponse::HTTP_OK);
        }
    }
}
