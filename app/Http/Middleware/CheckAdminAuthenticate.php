<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Themes;
use Illuminate\Http\Request;

class CheckAdminAuthenticate
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
     
        if(! auth()->check()){
            return redirect()->route('admin.login');
        }
        if(@auth()->user()->status != 1){
            auth()->logout();
            session()->flash('error' , trans('message.admin.account_not_active') );
            return redirect()->route('admin.login');
        }
       
        $theme = Themes::query();
        $adminDashboardTheme = json_decode((clone @$theme)->dashboard()?->get()?->first()?->value);
        view()->share('adminDashboardTheme' , $adminDashboardTheme);
        
        return $next($request);
    
    }
}
