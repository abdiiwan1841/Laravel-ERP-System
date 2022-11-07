<?php

namespace App\Http\Livewire\Erp\ProductsSettings;

use App\Exports\BrandsExport;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\Brand as BrandModel;
use App\Models\ERP\Settings\Products\BrandSection;
use App\Models\ERP\Settings\Products\Section;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $status, $section_id = [], $edit_id;
    public $checked = [], $selectPage = false, $selectAll = false;
    public $search = '', $perPage = 10, $sortField = 'id', $sortAsc = true;
    public $filterBySection = null;
    public $filterByStatus;

    protected $listeners = ['recordDeleted' => 'deleteBrand', 'forcedCloseModal', 'CancelDeleted'];

    protected $rules = [
        'name' => 'required|unique:brands,name',
        'section_id' => 'required|array|min:1'
    ];

    public function store()
    {
        $this->validate();
        $sections = Section::find($this->section_id);
        $brand = BrandModel::create([
            'name' => $this->name,
            'status' => empty($this->status) ? 0 : 1, //if the status is empty give 0 else 1
        ]);
        $brand->sections()->attach($sections);
        $this->formReset();
        $this->toasterMessage(trans('applang.brand_added_successfully'));
    }

    public function editBrand($brand_id)
    {
        $this->edit_id = $brand_id;
        $brand = BrandModel::findOrFail($brand_id);
        $this->name = $brand->name;
        $this->status = $brand->status;
        $sectionsIds = BrandSection::where('brand_id', $brand_id)->pluck('section_id')->toArray();
        $sectionsStrIds = implode(',' , $sectionsIds);
        $sectionsStrIdsArray = explode(",", $sectionsStrIds);
        $this->section_id = $sectionsStrIdsArray;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', Rule::unique('brands','name')->ignore($this->edit_id)],
            'section_id' => ['required', 'array', 'min:1']
        ]);

        $sections = Section::find($this->section_id);
        $brand =BrandModel::updateOrCreate(['id' => $this->edit_id],[
            'name' => $this->name,
            'status' => empty($this->status) ? 0 : 1,//if the status is empty give 0 else 1
        ]);
        $brand->sections()->sync($sections);
        $this->formReset();
        $this->toasterMessage(trans('applang.brand_updated_successfully'));
    }

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->brands->pluck('id')->map(function ($item) {
                return (string)$item;
            })->toArray();
        }else{
            $this->checked = [];
            $this->selectAll = false;
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
        $this->checked = $this->brandsQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }
    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($brand_id, $brand_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$brand_name .")</span>"."</span>",
            'id'    => $brand_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deleteBrand($brand_id)
    {
        if($this->checked){ //Bulk Delete
            BrandModel::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $brand = BrandModel::find($brand_id); //Single Delete
            $brand->delete();
            $this->resetPage();
        }
    }

    public function CancelDeleted($brand_id)
    {
        $this->checked = [];
        $this->selectPage = false;
        $this->resetPage();
    }

    public function formReset()
    {
        $this->status = '';
        $this->name = '';
        $this->section_id = [];
        $this->count = 0;
        $this->addMore = [1];
        $this->dispatchBrowserEvent('closeModal');
    }

    public function forcedCloseModal()
    {
        $this->status = '';
        $this->name = '';
        $this->section_id = [];
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
        $this->filterBySection = null;
        $this->filterByStatus = '';
    }

    public function render()
    {
        return view('livewire.erp.products-settings.brands',[
            'brands' => $this->brands,
            'sections' => Section::all(),
        ]);
    }

    public function getBrandsProperty(){
        return $this->brandsQuery->paginate($this->perPage);
    }

    public function getBrandsQueryProperty()
    {
        return BrandModel::with('sections')
            ->search(trim($this->search))
            ->when($this->filterBySection, function ($query){
                $query->whereHas('sections', function ($q){
                    $q->where('section_id', $this->filterBySection);
                });
            })
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
        return (new BrandsExport($this->checked))->download('brands.xlsx');
    }
}
