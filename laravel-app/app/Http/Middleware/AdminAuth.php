<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $adminId = $request->session()->get('admin_id');
        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::query()->find($adminId);
        if (!$admin) {
            $request->session()->forget('admin_id');
            return redirect()->route('admin.login');
        }

        view()->share('currentAdmin', $admin);

        return $next($request);
    }
}

