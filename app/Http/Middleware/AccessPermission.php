<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(Auth::user()){
            if(Auth::user()->hasAnyRoles(['admin','author'])){
                return $next($request);
            }else{
                return redirect('/dashboard')->with('message', 'you don\'t have access');
            }
        }
        return redirect('/login-auth')->with('message', 'Please login');
    }
} 