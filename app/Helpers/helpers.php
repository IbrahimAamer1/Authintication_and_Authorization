<?php

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Check if the user has a permission
 * @param string $permission
 * @return bool
 */
function hasPermission($permission)
{
    return Auth::guard('admin')->user()->hasPermissionTo($permission) ? true : false;
}