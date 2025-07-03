<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\Services;
use Carbon\Carbon;
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

    public function pendingAvail()
    {
        $services = Avail::where('shop_id', Auth::user()->shopOwnerInfo->id)->where('status', 'Pending')->orderBy('created_at', 'DESC')->get();

        return view('shopOwner.services.pending', compact('services'));
    }

    public function ongoingAvail()
    {
        $services = Avail::where('shop_id', Auth::user()->shopOwnerInfo->id)->where('status', 'Approved')->orderBy('created_at', 'DESC')->get();

        return view('shopOwner.services.ongoing', compact('services'));
    }

    public function rejectedAvail()
    {

        $services = Avail::where('shop_id', Auth::user()->shopOwnerInfo->id)->where('status', 'Rejected')->orderBy('created_at', 'DESC')->get();

        return view('shopOwner.services.rejected', compact('services'));
    }


    public function paidAvail(Request $request)
    {
        $query = Avail::query()->where('status', '!=', 'Rejected');
    
        if ($request->filled('start_day') && $request->filled('end_day') && $request->start_day <= $request->end_day) {
            $query->whereDate('created_at', '>=', $request->start_day)
                  ->whereDate('created_at', '<=', $request->end_day);
        }
    
        $services = $query->get();
    
        return view('shopOwner.services.paid', compact('services'));
    }
    
    

    public function updateServiceStatus($id, Request $request, Avail $avails)
    {
        $field = $request->validate([
            'status' => ['required', 'string', 'in:Rejected,Approved,Pending,Paid'],
            'message' => 'nullable'
        ]);

        $avail = $avails->findOrFail($id);

        $data = [
            'status' => $field['status']
        ];

        if ($request->has('message')) {
            $data['message'] = $field['message'];
        }

        $updated = $avail->update($data);

        if (!$updated) {
            return back()->with('error', 'Something went wrong while updating the service.');
        }

        return back()->with('success', 'Service status updated.');
    }

    public function updatePrice($serviceID, Request $request, Avail $services)
    {
        $field = $request->validate([
            'price_to_update' => ['required'],
            'description_to_update' => ['required'],
        ]);

        $service = $services->where('service_id', $serviceID)->firstOrFail();

        $isPriceUpdated = $service->update([
            'service_price' => $field['price_to_update'],
            'service_description' => $field['description_to_update'],
        ]);

        if (!$isPriceUpdated) {
            return back()->with('error', 'Something went wrong.');
        }

        return back()->with('success', 'Service Avail price update successfully.');
    }
}
