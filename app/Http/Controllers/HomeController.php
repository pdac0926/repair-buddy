<?php

namespace App\Http\Controllers;

use App\Models\MechanicInfo;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::get();
        $mechanics = MechanicInfo::get();
        return view('home', compact('users', 'mechanics'));
    }
}
