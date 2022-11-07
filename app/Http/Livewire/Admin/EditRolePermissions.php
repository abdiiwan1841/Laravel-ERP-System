<?php

namespace App\Http\Livewire\Admin;

use App\Models\PermissionsCategory;
use Livewire\Component;

class EditRolePermissions extends Component
{
    public $categories;
    public $transRole;
    public $editedroleId;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->selectedPermissions = permissionsOfRole([$this->transRole->role_id]);
    }

    public function render()
    {
        return view('livewire.admin.edit-role-permissions');
    }
}
