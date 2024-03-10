<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Models\ShopOwnerInfo;
use App\Models\ShopRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function addReview($shopID, $serviceID)
    {
        $shop = ShopOwnerInfo::where('id', $shopID)->first();
        $service = Services::where('id', $serviceID)->first();

        if (!$shop && !$service) {
            return back()->with('warning', 'This shop is not exist.');
        }

        return view('driver-authenticated.review', compact(['shop', 'service']));
    }

    public function storeReview(Request $request)
    {
        $fields = $request->validate([
            'star' => ['required', 'in:1,2,3,4,5'],
            'shopId' => ['required', 'exists:shop_owner_infos,id'],
            'serviceId' => ['required', 'exists:services,id'],
            'serviceName' => ['required'],
            'comment' => ['required']
        ]);

        $storeReview = ShopRating::create([
            'shop_id' => $fields['shopId'],
            'service_id' => $fields['serviceId'],
            'user_id' => Auth::id(),
            'service_name' => $fields['serviceName'],
            'service_rate' => $fields['star'],
            'comment' => $fields['comment']
        ]);

        if(!$storeReview){
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('driver.maintenance.history')->with('success', 'Successfully reviewed.');
    }
}
