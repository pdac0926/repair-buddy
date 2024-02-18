<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\Services;
use App\Models\ShopOwnerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function serviceAvailed()
    {
        $services = Avail::where('user_id', Auth::id())->where('status', false)->get();

        return view('driver-authenticated.service-availed', compact('services'));
    }

    public function availService($id, $shopId, Services $services)
    {
        $service = $services->findOrFail($id);

        $currentShopAvail = Avail::where('user_id', Auth::id())
            ->where('shop_id', $shopId)
            ->where('status', false)
            ->first();

        if (!$currentShopAvail && Avail::where('user_id', Auth::id())->first()) {
            return back()->with('info', 'Currently, you are exclusively associated to another shop. Concurrent availabilities at different shops are not permitted. <br> Kindly cancel your existing availability with the current shop before attempting to avail service elsewhere.');
        }

        return view('driver-authenticated.avail-service', compact('service'));
    }

    public function storeService($id, Request $request, Services $services, Avail $avail)
    {
        $service = $services->findOrFail($id);

        $availData = $request->validate(
            [
                'arrival' => ['required', 'string', 'max:255'],
                'odometer_type' => ['required', 'string', 'max:255'],
                'last_odometer_reading' => ['required', 'numeric']
            ]
        );
        $shop = ShopOwnerInfo::where('id', $service->shop_id)->first();

        $isServiceAvailExist = $avail->where('shop_id', $service->shop_id)
            ->where('user_id', Auth::id())
            ->where('shop_name', $shop->shopName)
            ->where('service_name', $service->service_name)
            ->where('service_price', $service->service_price)->exists();

        if ($isServiceAvailExist) {
            return back()->with('info', 'It appears that you have already availed of this service.');
        }

        try {
            $storeAvail = $avail->create([
                'shop_id' => $service->shop_id,
                'service_id' => $service->id,
                'user_id' => Auth::id(),
                'shop_name' => $shop->shopName,
                'service_name' => $service->service_name,
                'service_price' => $service->service_price,
                'last_odometer_reading' => $availData['last_odometer_reading'] . ' ' . $availData['odometer_type'],
                'notes' => $request->notes,
                'arrival' => $availData['arrival'],
                'status' => false
            ]);

            if (!$storeAvail) {
                return back()->with('error', 'Something went wrong while processing your data.');
            }

            return redirect()->route('driver.view.shop.owner', $shop->user_id)->with('success', 'Your service request has been successfully received and is currently undergoing a thorough review by the shop owner. We appreciate your patience as we diligently assess your requirements. Your prompt attention to this matter is highly valued, and we look forward to your arrival. Thank you for selecting our services; we are committed to providing you with exceptional service.');
        } catch (\Throwable $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function cancelService($id, Services $services, Avail $avails)
    {
        $service = $services->findOrFail($id);
        $avail = $avails->where('service_id', $service->id)->firstOrFail();

        $canceled = $avail->delete();

        if (!$canceled) {
            return back()->with('error', 'Something went wrong while processing your cancellation.');
        }

        return back()->with('success', 'Successfully canceled service.');
    }
}
