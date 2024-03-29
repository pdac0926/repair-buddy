<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == 'shopOwner'){
                return $next($request);
            }else{
                return back()->with('warning', 'You do not have sufficient permissions to access this area (Shop Owner will).');
            }
        }else{
            return redirect(route('welcome'))->with('warning', 'Login first.');
        }
    }
}
