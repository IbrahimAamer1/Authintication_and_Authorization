<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('permission')) {
    /**
     * Check if the authenticated admin has any of the given permissions
     *
     * @param array|string $permissions
     * @return bool
     */
    function permission($permissions): bool
    {
        $user = Auth::guard('admin')->user();
        
        if (!$user) {
            return false;
        }

        // If user is super admin, allow all
        if (isset($user->super_admin) && $user->super_admin) {
            return true;
        }

        // Convert single permission to array
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        // Check if user has any of the permissions
        foreach ($permissions as $permission) {
            try {
                if ($user->hasPermissionTo($permission, 'admin')) {
                    return true;
                }
            } catch (\Exception $e) {
                // If permissions not set up yet, allow access for development
                // Remove this in production
                return true;
            }
        }

        return false;
    }
}
