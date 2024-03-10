<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Avail;
use App\Models\ShopRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isDriver']);
    }

    public function index(){
        $services = Avail::where('user_id', Auth::id())->where('status', 'Paid')->orderBy('created_at', 'DESC')->get();
        return view('driver-authenticated.maintenance-history', compact('services'));
    }
}

