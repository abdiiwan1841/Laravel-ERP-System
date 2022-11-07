<?php

use App\Models\PermissionsCategory;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TranslatedRole;
use Spatie\Permission\Models\Role;
use App\Models\TranslatedPermission;
use Spatie\Permission\Models\Permission;

//Get all permissions ids related to specific role
function permissionsOfRole($id)
{
    return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
        ->whereIn("role_has_permissions.role_id", $id)
        ->pluck('permissions.id')
        ->toArray();
}

//Get all permissions names related to specific role
function permissionsOfRoleName($id)
{
    return TranslatedPermission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "translated_permissions.permission_id")
        ->where("role_has_permissions.role_id", $id)
        ->pluck('translated_permissions.name_' . app()->getLocale())
        ->toArray();
}

//count all users related to specific role
function usersOfRole($role_name)
{
    return User::role($role_name)->pluck('id')->count();
}

//Get all ids related to specific user role
function userRolesIds($user_id)
{
    return DB::table('model_has_roles')
                ->where('model_id', '=', $user_id)  // $id is correctly passed id of user.
                ->pluck('role_id');
}

//Get all ids related to specific user role in array
function userRolesArray($user_id)
{
    return DB::table('model_has_roles')
                ->where('model_id', '=', $user_id)  // $id is correctly passed id of user.
                ->pluck('role_id')
                ->toArray();
}

//Get all user roles names
function userRolesName($user_id)
{
    $user_roles_ids = userRolesArray($user_id);
    $roles = TranslatedRole::whereIn('role_id', $user_roles_ids)->pluck('name_'.app()->getLocale())->all();
    return $roles;
}

//get translated roles names
function transRoleName($role_id)
{
    $trsnRoleName = TranslatedRole::where('role_id', $role_id)->pluck('name_'.app()->getLocale())->all();
    return implode(',', $trsnRoleName);
}

//Get all ids of direct permissions related to specific user
function userDirectPermissionsArray($user_id)
{
    return DB::table('model_has_permissions')
                ->where('model_id', '=', $user_id)  // $id is correctly passed id of user.
                ->pluck('permission_id')
                ->toArray();
}

//Get names of direct permissions related to specific user
function userDirectPermissionsNames($user_id)
{
    $user = User::find($user_id);
    $permissionsId = $user->getDirectPermissions()->pluck('id');
    $permissions = TranslatedPermission::whereIn('permission_id', $permissionsId)->pluck('name_'.app()->getLocale())->all();
    return $permissions;
}

//Get names of direct permissions related to specific user
function userPermissionsNamesViaRoles($user_id)
{
    $user = User::find($user_id);
    $permissionsId = $user->getPermissionsViaRoles()->pluck('id');
    $permissions = TranslatedPermission::whereIn('permission_id', $permissionsId)->pluck('name_'.app()->getLocale())->all();
    return $permissions;
}

//Get user first and lst names first letters
function subUserName($first_name, $last_name)
{
    $first = strtoupper(mb_substr($first_name, 0, 1, 'utf8'));
    $last = strtoupper(mb_substr($last_name, 0, 1, 'utf8'));
    if(mb_detect_encoding($first_name) != 'UTF-8') {
        return $first.$last;
    }else{
        return $first.' '.$last;
    }
}

//get date
function dateHelper($date)
{
    // Carbon::setLocale('ar'); applay with diffForHumans();
    $date = Carbon::parse($date)->format('Y-m-d');
    return $date;
}

function cat_Permissions($cat_id)
{
    $permissions_cat = TranslatedPermission::where('category_id', $cat_id)->pluck('name_'.app()->getLocale(), 'permission_id')->all();

    return $permissions_cat;
}

function permissionsOfCategory($cat_id)
{
    return TranslatedPermission::whereIn('category_id', $cat_id)->pluck('permission_id')->toArray();
}


function RoleCategoriesArray($role_id)
{
    return TranslatedPermission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "translated_permissions.permission_id")
        ->where("role_has_permissions.role_id", $role_id)
        ->pluck('translated_permissions.category_id')
        ->toArray();
}



