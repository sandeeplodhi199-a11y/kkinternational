<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Crm\CrmEmployee;

class CrmAuthController extends Controller
{
    /**
     * Check if a user has admin privileges.
     */
    public static function isUserAdmin($user): bool
    {
        if (!$user) return false;

        $type = strtolower($user->type ?? '');
        if (in_array($type, ['crm_admin', 'admin', 'super_admin'])) {
            return true;
        }

        $emp = CrmEmployee::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();
        if ($emp && in_array(strtolower($emp->role ?? ''), ['admin', 'super admin', 'manager'])) {
            return true;
        }

        return false;
    }

    /**
     * Check if a user has employee privileges.
     */
    public static function isUserEmployee($user): bool
    {
        if (!$user) return false;

        // If currently impersonating from admin, always grant employee access
        if (session()->has('impersonated_by_admin')) {
            return true;
        }

        $type = strtolower($user->type ?? '');
        if (in_array($type, ['crm_employee', 'employee', 'staff', 'sales', 'executive'])) {
            return true;
        }

        // Any registered active CRM employee has employee access
        $emp = CrmEmployee::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();
        if ($emp && $emp->status !== 'Inactive') {
            return true;
        }

        return false;
    }

    /**
     * Check if an employee (or current authenticated user) has a specific granular CRM permission.
     */
    public static function employeeHasPermission(string $permissionSlug, $user = null): bool
    {
        $user = $user ?? Auth::user();
        if (!$user) return false;

        // If Super Admin or Admin logged in and NOT impersonating an employee: full access
        if (self::isUserAdmin($user) && !session()->has('impersonated_by_admin')) {
            return true;
        }

        // Cache per request for performance
        static $permCache = [];
        $cacheKey = ($user->id) . '_' . $permissionSlug;
        if (isset($permCache[$cacheKey])) {
            return $permCache[$cacheKey];
        }

        // Get Employee record
        $emp = CrmEmployee::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();

        // Resolve role: check if matching role exists by name, else default to 'employee' role
        $role = null;
        if ($emp && !empty($emp->role)) {
            $role = \App\Models\Crm\CrmRole::whereRaw('LOWER(name) = ?', [strtolower(trim($emp->role))])
                ->orWhereRaw('LOWER(slug) = ?', [strtolower(trim($emp->role))])
                ->first();
        }
        if (!$role) {
            $role = \App\Models\Crm\CrmRole::where('slug', 'employee')->first();
        }

        if (!$role) {
            return $permCache[$cacheKey] = false;
        }

        $has = $role->permissions()->where('slug', $permissionSlug)->exists();
        return $permCache[$cacheKey] = $has;
    }

    /**
     * Display the role-based login form.
     */
    public function loginForm(Request $request)
    {
        $activeRole = old('role', $request->query('role', 'employee'));
        if (!in_array($activeRole, ['admin', 'employee'])) {
            $activeRole = 'employee';
        }

        return response()
            ->view('crm.auth.login', compact('activeRole'))
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }

    /**
     * Handle role-based authentication with strict server-side authorization.
     */
    public function login(Request $request)
    {
        // 1-Click Fast Demo Login for instant testing
        if ($request->has('demo_type')) {
            $demoType = $request->input('demo_type');
            if ($demoType === 'admin') {
                $user = User::where('email', 'admin@crm.com')->orWhere('email', 'admin@c.com')->first();
                if ($user && self::isUserAdmin($user)) {
                    Auth::login($user, true);
                    $request->session()->regenerate();
                    return redirect()->route('crm.admin.dashboard')->with('success', 'Logged in as CRM Administrator');
                }
            } elseif ($demoType === 'employee') {
                $user = User::where('name', 'Vipin')->orWhere('email', 'vipin@gmail.com')->first();
                if ($user && self::isUserEmployee($user)) {
                    Auth::login($user, true);
                    $request->session()->regenerate();
                    return redirect()->route('crm.employee.dashboard')->with('success', 'Logged in as Employee (' . $user->name . ')');
                }
            }
        }

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'role' => 'nullable|string',
        ]);

        $loginInput = trim($request->input('login'));
        $password = (string) $request->input('password');
        $remember = $request->boolean('remember');
        $activeRole = $request->input('role', 'employee');

        // Look up user by Email OR Employee Name OR Employee Code OR User Name
        $user = null;
        $emp = null;

        // 0. Direct Admin Identifier lookup (strictly 'admin')
        if (strtolower($loginInput) === 'admin') {
            $user = User::where('id', 135)
                ->orWhere('name', 'Admin')
                ->orWhere('email', 'admin@c.com')
                ->first();
        }

        // 1. If format is email
        if (!$user && filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
            if (!$user) {
                $emp = CrmEmployee::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
                if ($emp && $emp->user_id) {
                    $user = User::find($emp->user_id);
                }
            }
        } elseif (!$user) {
            // 2. Lookup in CrmEmployee by Name (case-insensitive), employee_code, or numeric ID
            $emp = CrmEmployee::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                ->orWhere('employee_code', $loginInput)
                ->orWhere('id', $loginInput)
                ->first();

            if ($emp && $emp->user_id) {
                $user = User::find($emp->user_id);
            }

            // 3. Lookup in User table by name (case-insensitive) or email
            if (!$user) {
                $user = User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                    ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
                    ->first();
            }
        }

        // If employee record found but user is missing, auto-create/link User
        if ($emp && !$user) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($emp->email)])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $emp->name,
                    'email' => $emp->email,
                    'password' => Hash::make('12345678'),
                    'mobile' => $emp->phone,
                    'type' => (in_array(strtolower($emp->role ?? ''), ['admin', 'super admin', 'manager'])) ? 'crm_admin' : 'crm_employee',
                    'is_deleted' => 0,
                ]);
            }
            $emp->user_id = $user->id;
            $emp->save();
        }

        // Check if employee is inactive
        if ($emp && $emp->status === 'Inactive') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'This employee account is currently inactive. Please contact your CRM Administrator.',
                ], 422);
            }
            return back()->withInput($request->only('login', 'role', 'remember'))->withErrors([
                'auth_error' => 'This employee account is currently inactive. Please contact your CRM Administrator.',
            ]);
        }

        // Check password with strict rules:
        // Admin: username MUST be 'admin' AND password MUST be 'admin123'
        // Employees: password is their set password or universal '12345678'
        $passwordMatches = false;
        if ($user) {
            $isAdmin = self::isUserAdmin($user);

            if ($isAdmin) {
                if (strtolower($loginInput) === 'admin' && $password === 'admin123') {
                    $passwordMatches = true;
                } else {
                    $passwordMatches = false;
                }
            } else {
                if (Hash::check($password, $user->password)) {
                    $passwordMatches = true;
                }
            }
        }

        if (!$user || !$passwordMatches) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid username/email or password.',
                ], 422);
            }
            return back()->withInput($request->only('login', 'role', 'remember'))->withErrors([
                'auth_error' => 'Invalid username/email or password.',
            ]);
        }

        // Authenticate User
        Auth::login($user, $remember);
        $request->session()->regenerate();
        $request->session()->forget(['impersonated_by_admin', 'impersonated_employee_name', 'impersonated_employee_role']);

        $redirectUrl = self::isUserAdmin($user) 
            ? route('crm.admin.dashboard') 
            : route('crm.employee.dashboard');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl,
            ]);
        }

        // Explicit Role Redirection: Admin -> Admin Dashboard, Employee -> Employee Dashboard
        if (self::isUserAdmin($user)) {
            return redirect()->route('crm.admin.dashboard')->with('success', 'Welcome to Admin Dashboard, ' . $user->name . '!');
        } else {
            return redirect()->route('crm.employee.dashboard')->with('success', 'Welcome back to Employee Portal, ' . $user->name . '!');
        }
    }

    /**
     * Display the Forgot Password form.
     */
    public function forgotPasswordForm()
    {
        return view('crm.auth.forgot-password');
    }

    /**
     * Process password reset directly for username or email.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'login.required' => 'Please enter your username or registered email address.',
            'password.required' => 'Please enter your new password.',
            'password.min' => 'New password must be at least 6 characters.',
            'password.confirmed' => 'New password and confirmation do not match.',
        ]);

        $loginInput = trim($request->input('login'));
        $newPassword = (string) $request->input('password');

        $user = null;
        $emp = null;

        // 1. Check by email
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
            if (!$user) {
                $emp = CrmEmployee::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
                if ($emp && $emp->user_id) {
                    $user = User::find($emp->user_id);
                }
            }
        } else {
            // 2. Check by employee name, code, or numeric ID
            $emp = CrmEmployee::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                ->orWhere('employee_code', $loginInput)
                ->orWhere('id', $loginInput)
                ->first();

            if ($emp && $emp->user_id) {
                $user = User::find($emp->user_id);
            }

            // 3. Check in users table by name
            if (!$user) {
                $user = User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                    ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
                    ->first();
            }
        }

        // If employee found but user missing, create and link
        if (!$user && $emp) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($emp->email)])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $emp->name,
                    'email' => $emp->email,
                    'password' => Hash::make($newPassword),
                    'mobile' => $emp->phone,
                    'type' => (in_array(strtolower($emp->role ?? ''), ['admin', 'super admin', 'manager'])) ? 'crm_admin' : 'crm_employee',
                    'is_deleted' => 0,
                ]);
            }
            $emp->user_id = $user->id;
            $emp->save();
        }

        if (!$user) {
            return back()->withInput($request->only('login'))->withErrors([
                'login' => 'No account found for "' . $loginInput . '". Please check your username or email.',
            ]);
        }

        // Update password
        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->route('crm.login')->with('success', 'Your password has been successfully reset! You can now sign in.');
    }

    /**
     * Check user role and credentials in real-time for login form.
     */
    public function checkUserRole(Request $request)
    {
        $loginInput = trim((string) $request->input('login'));
        $password = (string) $request->input('password');

        if ($loginInput === '') {
            return response()->json([
                'success' => false,
                'user_found' => false,
                'role' => null,
            ]);
        }

        $user = null;
        $emp = null;

        // 0. Direct Admin Identifier lookup (strictly 'admin')
        if (strtolower($loginInput) === 'admin') {
            $user = User::where('id', 135)
                ->orWhere('name', 'Admin')
                ->orWhere('email', 'admin@c.com')
                ->first();
        }

        // 1. If format is email
        if (!$user && filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
            if (!$user) {
                $emp = CrmEmployee::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
                if ($emp && $emp->user_id) {
                    $user = User::find($emp->user_id);
                }
            }
        } elseif (!$user) {
            // 2. Lookup in CrmEmployee by Name (case-insensitive), employee_code, or numeric ID
            $emp = CrmEmployee::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                ->orWhere('employee_code', $loginInput)
                ->orWhere('id', $loginInput)
                ->first();

            if ($emp && $emp->user_id) {
                $user = User::find($emp->user_id);
            }

            // 3. Lookup in User table by name (case-insensitive) or email
            if (!$user) {
                $user = User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($loginInput)])
                    ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
                    ->first();
            }
        }

        if (!$user && !$emp) {
            return response()->json([
                'success' => false,
                'user_found' => false,
                'role' => null,
            ]);
        }

        // Determine role
        $isAdmin = false;
        if ($user) {
            $isAdmin = self::isUserAdmin($user);
        } elseif ($emp) {
            $empRole = strtolower($emp->role ?? '');
            $isAdmin = in_array($empRole, ['admin', 'super admin', 'manager']);
        }

        // If an admin account was matched but the login input is NOT 'admin', deny admin recognition
        if ($isAdmin && strtolower($loginInput) !== 'admin') {
            return response()->json([
                'success' => false,
                'user_found' => false,
                'role' => null,
            ]);
        }

        $role = $isAdmin ? 'admin' : 'employee';
        $roleLabel = $isAdmin ? 'Admin' : 'Employee';
        $displayName = $user ? $user->name : ($emp ? $emp->name : '');

        // Check password if provided
        $passwordChecked = false;
        $passwordValid = false;

        if ($password !== '') {
            $passwordChecked = true;
            if ($isAdmin) {
                // Strict Admin: ONLY username 'admin' and password 'admin123'
                if (strtolower($loginInput) === 'admin' && $password === 'admin123') {
                    $passwordValid = true;
                } else {
                    $passwordValid = false;
                }
            } else {
                if ($user) {
                    if (Hash::check($password, $user->password)) {
                        $passwordValid = true;
                    }
                } elseif ($emp) {
                    if ($password === '12345678') {
                        $passwordValid = true;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'user_found' => true,
            'role' => $role,
            'role_label' => $roleLabel,
            'display_name' => $displayName,
            'password_checked' => $passwordChecked,
            'password_valid' => $passwordValid,
        ]);
    }

    /**
     * Terminate session and logout user securely.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('crm.login')->with('success', 'You have been logged out securely.');
    }
}
