<?php

namespace App\Http\Livewire\Erp\ProductsSettings;

use App\Exports\CategoriesExport;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\BrandCategory;
use App\Models\ERP\Settings\Products\BrandSection;
use App\Models\ERP\Settings\Products\Category as CategoryModel;
use App\Models\ERP\Settings\Products\Section;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $status, $section_id,  $brand_id = [], $edit_id;
    public $checked = [], $selectPage = false, $selectAll = false;
    public $search = '', $perPage = 10, $sortField = 'id', $sortAsc = true;
    public $filterBySection = null;
    public $filterByBrand = null;
    public $filterByStatus;
    public $brands;

    protected $listeners = ['recordDeleted' => 'deleteCategory', 'forcedCloseModal', 'CancelDeleted'];

    protected $rules = [
        'name' => 'required|unique:categories,name',
        'section_id' => 'required',
        'brand_id' => 'required|array|min:1',
    ];

    public function store()
    {
        $this->validate();

        $brands = Brand::find($this->brand_id);
        $category = CategoryModel::create([
            'name' => $this->name,
            'status' => empty($this->status) ? 0 : 1, //if the status is empty give 0 else 1
            'section_id' => $this->section_id,
        ]);
        $category->brands()->attach($brands);
        $this->formReset();
        $this->toasterMessage(trans('applang.category_added_successfully'));
    }

    public function editCategory($category_id)
    {
        $this->edit_id = $category_id;
        $category = CategoryModel::findOrFail($category_id);
        $this->name = $category->name;
        $this->status = $category->status;
        $this->section_id = $category->section_id;

        $brandsIds = BrandCategory::where('category_id', $category_id)->pluck('brand_id')->toArray();
        $brandsStrIds = implode(',' , $brandsIds);
        $brandsStrIdsArray = explode(",", $brandsStrIds);
        $this->brand_id = $brandsStrIdsArray;

        $section = Section::find($this->section_id);
        $this->brands = $section->brands;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', Rule::unique('categories','name')->ignore($this->edit_id)],
            'section_id' => ['required'],
            'brand_id' => ['required', 'array', 'min:1']
        ]);
        $brands = Brand::find($this->brand_id);
        $category = CategoryModel::updateOrCreate(['id' => $this->edit_id],[
            'name' => $this->name,
            'status' => empty($this->status) ? 0 : 1,//if the status is empty give 0 else 1
            'section_id' => $this->section_id,
        ]);
        $category->brands()->sync($brands);
        $this->formReset();
        $this->toasterMessage(trans('applang.category_updated_successfully'));
    }

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->categories->pluck('id')->map(function ($item) {
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
        $this->checked = $this->categoriesQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }

    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($category_id, $category_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$category_name .")</span>"."</span>",
            'id'    => $category_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deleteCategory($category_id)
    {
        if($this->checked){ //Bulk Delete
            CategoryModel::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $category = CategoryModel::find($category_id); //Single Delete
            $category->delete();
            $this->resetPage();
        }
    }

    public function CancelDeleted($category_id)
    {
        $this->checked = [];
        $this->selectPage = false;
        $this->resetPage();
    }

    public function formReset()
    {
        $this->status = '';
        $this->name = '';
        $this->section_id = '';
        $this->brand_id = [];
        $this->brands = collect();
        $this->dispatchBrowserEvent('closeModal');
    }

    public function forcedCloseModal()
    {
        $this->status = '';
        $this->name = '';
        $this->section_id = '';
        $this->brand_id = [];
        $this->brands = collect();
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
        $this->filterByBrand = null;
    }

    public function mount()
    {
        $this->brands = [];
    }

    public function updatedSectionId($sectionId)
    {
        $section = Section::find($sectionId);
        $this->brands = $section->brands;
    }

    public function updatedFilterBySection($sectionId)
    {
        $section = Section::find($sectionId);
        $this->brands = $section->brands;
    }

    public function render()
    {
        return view('livewire.erp.products-settings.categories',[
            'categories' => $this->categories,
            'sections' => Section::all(),
        ]);
    }

    public function getCategoriesProperty(){
        return $this->categoriesQuery->paginate($this->perPage);
    }

    public function getCategoriesQueryProperty()
    {
        return CategoryModel::with(['section', 'brands'])
            ->when($this->filterBySection, function ($query){
                $query->where('section_id', $this->filterBySection);
            })
            ->when($this->filterByBrand, function ($query){
                $query->whereHas('brands', function ($q){
                    $q->where('brand_id', $this->filterByBrand);
                });
            })
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
        return (new CategoriesExport($this->checked))->download('categories.xlsx');
    }
}
