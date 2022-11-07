<?php

namespace App\Http\Livewire\Erp\ProductsSettings;

use App\Exports\SectionsExport;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\Section as SectionModel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Sections extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $addMore = [1];
    public $count = 0;
    public $name, $status, $edit_id;
    public $checked = [], $selectPage = false, $selectAll = false;
    public $search = '', $perPage = 10, $sortField = 'id', $sortAsc = true;
    public $filterByStatus;

    protected $listeners = ['recordDeleted' => 'deleteSection', 'forcedCloseModal', 'CancelDeleted'];

    protected $rules = [
        'name' => 'required|unique:sections,name',
    ];

    public function AddMore()
    {
        $countable = $this->count++;
        if ($countable < 4) {
            $this->addMore[] = count($this->addMore) + 1;
        }
    }

    public function Remove($index)
    {
//        dd($index);
        $this->count--;
        unset($this->addMore[$index]);
    }

    public function store()
    {
        $this->validate();

        foreach ($this->name as $key => $section){
            if(!empty($section)){
                SectionModel::create([
                    'name' => $this->name[$key],
                    'status' => $this->status[$key] ?? 0 //if the status is empty give 0 else 1
                ]);
            }
        }
        $this->formReset();
        $this->toasterMessage(trans('applang.section_added_successfully'));
    }

    public function editSection($section_id)
    {
        $this->edit_id = $section_id;
        $section = SectionModel::findOrFail($section_id);
        $this->name = $section->name;
        $this->status = $section->status;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', Rule::unique('sections','name')->ignore($this->edit_id)],
        ]);

        SectionModel::updateOrCreate(['id' => $this->edit_id],[
            'name' => $this->name,
            'status' => empty($this->status) ? 0 : 1, //if the status is empty give 0 else 1
        ]);

        $this->formReset();
        $this->toasterMessage(trans('applang.section_updated_successfully'));
    }

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->sectionsQuery->pluck('id')->map(function ($item) {
                return (string)$item;
            })->toArray();
        }else{
            $this->checked = [];
        }
    }
    public function updatedChecked()
    {
        $this->selectPage = false;
        $this->selectAll = false;
    }
    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->sectionsQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }
    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($section_id, $section_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$section_name .")</span>"."</span>",
            'id'    => $section_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deleteSection($section_id)
    {
        if($this->checked){ //Bulk Delete
            SectionModel::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $section =SectionModel::find($section_id); //Single Delete
            $section->delete();
            $this->resetPage();
        }
    }

    public function CancelDeleted($product_id)
    {
        $this->checked = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function formReset()
    {
        $this->status = '';
        $this->name = '';
        $this->count = 0;
        $this->addMore = [1];
        $this->dispatchBrowserEvent('closeModal');
    }

    public function forcedCloseModal()
    {
        $this->status = '';
        $this->name = '';
        $this->count = 0;
        $this->addMore = [1];
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function toasterMessage($message)
    {
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => $message,
        ]);
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->perPage = 10;
        $this->sortField = 'id';
        $this->sortAsc = true;
        $this->filterByStatus = '';
    }

    public function render()
    {
        return view('livewire.erp.products-settings.sections',[
            'sections' => $this->sections,
        ]);
    }

    public function getSectionsProperty(){
        return $this->sectionsQuery->paginate($this->perPage);
    }

    public function getSectionsQueryProperty()
    {
        return SectionModel::search(trim($this->search))
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
        return (new SectionsExport($this->checked))->download('sections.xlsx');
    }
}
