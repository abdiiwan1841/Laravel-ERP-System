<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserRolesAndPermissions extends Component
{
    public $roles;
    public $permissions;
    public $categories;
    public $selectedRoles = [];
    public $selectedCategory = [];

    public function render()
    {
        return view('livewire.admin.create-user-roles-and-permissions', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ]);
    }
}
