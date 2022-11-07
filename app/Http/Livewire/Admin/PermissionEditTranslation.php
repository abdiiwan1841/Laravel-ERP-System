<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class PermissionEditTranslation extends Component
{
    public $name;
    public $translated_ar;
    public $translated_en;
    public function render()
    {
        return view('livewire.admin.permission-edit-translation');
    }
}
