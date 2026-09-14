<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(route('admin.home'));
            }
        }

        $theme = Themes::query();
        $adminLoginTheme = json_decode((clone @$theme)->loginDashboard()->get()->first()? (clone @$theme)->loginDashboard()->get()->first()->value: '');
        view()->share('adminLoginTheme' , $adminLoginTheme);
        // The tab icon on the login page uses the same icon as the dashboard (Themes > Dashboard theme).
        view()->share('adminDashboardTheme', json_decode((clone $theme)->dashboard()->first()?->value ?? ''));

        return $next($request);
    }
}
