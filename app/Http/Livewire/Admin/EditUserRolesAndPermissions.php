<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Stringable;
use Livewire\Component;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\stringContains;

class EditUserRolesAndPermissions extends Component
{
    public $user;
    public $roles;
    public $permissions;
    public $categories;
    public $userRoles= [];
    public $selectedRoles= [];
    public $selectedPermissions= [];
    public $directPermissions = [];
    public $selectedCategory = [];

    public function mount()
    {
        $userDirectPermissionsStrIds = implode(',' , userDirectPermissionsArray($this->user->id));
        $userDirectPemissionsStrIdsArray = explode(",", $userDirectPermissionsStrIds);
        $this->directPermissions = $userDirectPemissionsStrIdsArray;

        $userRolesStrIds = implode(',' , userRolesArray($this->user->id));
        $userRolesStrIdsArray = explode(",", $userRolesStrIds);
        $this->selectedRoles = $userRolesStrIdsArray;
        $this->selectedPermissions = permissionsOfRole(userRolesArray($this->user->id));
    }

    public function render()
    {
        return view('livewire.admin.edit-user-roles-and-permissions', [
            'user' => $this->user,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'userRoles' => $this->userRoles
        ]);
    }
}
