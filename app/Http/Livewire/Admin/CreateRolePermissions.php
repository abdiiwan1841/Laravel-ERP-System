<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class CreateRolePermissions extends Component
{
    public $categories;
    public $selectedCategory = [];

    public function render()
    {
        return view('livewire.admin.create-role-permissions');
    }
}
