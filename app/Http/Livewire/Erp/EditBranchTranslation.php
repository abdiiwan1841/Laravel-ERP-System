<?php

namespace App\Http\Livewire\Erp;

use Livewire\Component;

class EditBranchTranslation extends Component
{
    public $name;
    public $address;
    public $translated_ar;
    public $translated_en;

    public function render()
    {
        return view('livewire.erp.edit-branch-translation');
    }
}
