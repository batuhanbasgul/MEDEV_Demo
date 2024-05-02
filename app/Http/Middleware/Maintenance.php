<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Maintenance
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
        if(0 == Setting::all()->count()){
            $setting = new Setting();
            $setting->save();
        }
        $setting = Setting::first();
        if($setting->is_maintenance){
            if(Gate::allows('admin')){
                return $next($request);
            }else{
                Auth::logout();
                return redirect()->route('maintenance');
            }
        }else{
            return $next($request);
        }
    }
}
