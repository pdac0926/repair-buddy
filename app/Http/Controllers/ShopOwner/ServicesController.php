<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isOwner']);
    }

    public function index()
    {
        $services = Services::where('shop_id', Auth::user()->shopOwnerInfo->id)->orderBy('created_at', 'desc')->get();
        return view('shopOwner.services.index', compact('services'));
    }

    public function addServices()
    {
        return view('shopOwner.services.add');
    }

    public function storeServices(Request $request)
    {
        $serviceData = $request->validate(
            [
                'service_name' => ['required', 'string', 'max:255'],
                'service_description' => ['required', 'string', 'max:255'],
                'service_price' => ['required', 'numeric']
            ]
        );

        $storeService = Services::create([
            'shop_id' => Auth::user()->shopOwnerInfo->id,
            'service_name' => $serviceData['service_name'],
            'service_description' => $serviceData['service_description'],
            'service_price' => $serviceData['service_price'],
        ]);

        if (!$storeService) {
            return back()->with('error', 'Something went wrong.');
        }
        return redirect()->route('shop.owners.services')->with('success', 'Successfully added ' . $serviceData['service_name']);
    }

    public function editServices($id)
    {
        $service = Services::findOrFail($id);
        return view('shopOwner.services.edit', compact('service'));
    }

    public function updateServices($id, Request $request, Services $services)
    {
        $service = $services->findOrFail($id);

        $serviceData = $request->validate(
            [
                'service_name' => ['required', 'string', 'max:255'],
                'service_description' => ['required', 'string', 'max:255'],
                'service_price' => ['required', 'numeric']
            ]
        );
        try {
            $updateService = $service->update([
                'service_name' => $serviceData['service_name'],
                'service_description' => $serviceData['service_description'],
                'service_price' => $serviceData['service_price'],
            ]);

            if (!$updateService) {
                return back()->with('error', 'Something went wrong.');
            }
            return back()->with('success', 'Successfully update ' . $serviceData['service_name']);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deleteServices($id, Services $services)
    {
        $service = $services->findOrFail($id);
        try {
            $deleted = $service->delete();

            if (!$deleted) {
                return back()->with('error', 'Something went wrong while processing your deletion.');
            }

            return redirect()->route('shop.owners.services')->with('success', 'Service deleted permanently.');
        } catch (\Throwable $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function avail()
    {
        $services = Avail::where('shop_id', Auth::user()->shopOwnerInfo->id)->where('status', false)->orderBy('created_at', 'DESC')->get();

        return view('shopOwner.services.avail', compact('services'));
    }

    public function paidAvail()
    {
        $services = Avail::where('shop_id', Auth::user()->shopOwnerInfo->id)->where('status', true)->orderBy('created_at', 'DESC')->get();
        return view('shopOwner.services.paid', compact('services'));
    }

    public function updateServiceStatus($id, Avail $avails)
    {
        $avail = $avails->findOrFail($id);

        $updated = $avail->update([
            'status' => $avail->status ? false : true
        ]);

        if (!$updated) {
            return back()->with('error', 'Something went wrong while updating the service.');
        }

        return back()->with('success', 'Service status updated.');
    }
}
