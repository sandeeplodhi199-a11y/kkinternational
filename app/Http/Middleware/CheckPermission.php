<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {

          
            if ($user->type == 'admin') {
                return $next($request);
            }

       
            if ($user->type == 'subadmin') {
                
                
                $currentPath = $request->path();

           
                $urlPermissionMap = [
                   
                    'admin/company'          => '1_1',
                    'admin/general'          => '1_2',
                    'admin/footer'           => '1_3',
                    'admin/editFooter'   => '1_4',
                    'admin/deleteFooter' => '1_5',
                 

                 

                 
                    'admin/users'                    => '8_1',
                    'admin/del_users'                => '8_2',
                ];

                $allowed = [];

                if ($user->permission_menu) {
                    $allowed = array_merge($allowed, explode(',', $user->permission_menu));
                }

                if ($user->permission_submenu) {
                    $allowed = array_merge($allowed, explode(',', $user->permission_submenu));
                }

                // Check permission
                if (isset($urlPermissionMap[$currentPath])) {
                    $requiredPermission = $urlPermissionMap[$currentPath];

                    if (!in_array($requiredPermission, $allowed)) {
                        abort(403, 'Unauthorized action.');
                    }
                }
            }



           
            if ($user->type == 'teacher') {
                
                
                $currentPath = $request->path();

                $urlPermissionMap = [
                    'admin/teacher'               => '2_1',
                    'admin/mark-evaluation'  => '2_3',
                ];

                $allowed = [];

                if ($user->permission_menu) {
                    $allowed = array_merge($allowed, explode(',', $user->permission_menu));
                }

                if ($user->permission_submenu) {
                    $allowed = array_merge($allowed, explode(',', $user->permission_submenu));
                }

                if (isset($urlPermissionMap[$currentPath])) {
                    $requiredPermission = $urlPermissionMap[$currentPath];

                    if (!in_array($requiredPermission, $allowed)) {
                        abort(403, 'Unauthorized action.');
                    }
                }
            }

        }

        return $next($request);
    }
}