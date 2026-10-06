<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Crm\CrmAuthController;
use App\Models\User;

class CrmAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $role
     */
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('crm.login')->with('error', 'Please login to access the CRM.');
        }

        $user = Auth::user();
        $isImpersonating = $request->session()->has('impersonated_by_admin');

        // Always allow leaving impersonation
        if ($request->is('*leave-impersonate*')) {
            return $next($request);
        }

        $isAdmin = CrmAuthController::isUserAdmin($user);
        $isEmployee = CrmAuthController::isUserEmployee($user);

        if ($role === 'admin') {
            if (!$isAdmin) {
                // If a Super Admin is currently impersonating an employee and accesses an admin route,
                // seamlessly restore their admin session without throwing Access Denied!
                if ($isImpersonating) {
                    $adminId = $request->session()->get('impersonated_by_admin');
                    $adminUser = User::find($adminId);
                    if ($adminUser && CrmAuthController::isUserAdmin($adminUser)) {
                        $request->session()->forget(['impersonated_by_admin', 'impersonated_employee_name', 'impersonated_employee_role']);
                        Auth::login($adminUser);
                        return $next($request);
                    }
                }

                if ($isEmployee) {
                    return redirect()->route('crm.employee.dashboard')->with('error', 'Access denied. You do not have administrator privileges.');
                }
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('crm.login')->with('error', 'Your account does not have CRM administrator privileges.');
            }
        } elseif ($role === 'employee') {
            // Administrators or impersonating admins always have employee portal access
            if ($isAdmin || $isImpersonating || $isEmployee) {
                return $next($request);
            }

            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('crm.login')->with('error', 'Your account does not have CRM access privileges.');
        }

        return $next($request);
    }
}
