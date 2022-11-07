<?php

namespace App\Http\Livewire\Erp\ProductsSettings;

use App\Exports\SubcategoriesExport;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\SubCategory as SubCategoryModel;
use App\Models\ERP\Settings\Products\Section;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class SubCategories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $addMore = [1];
    public $count = 0;
    public $name, $status, $category_id, $edit_id;
    public $checked = [], $selectPage = false, $selectAll = false;
    public $search = '', $perPage = 10, $sortField = 'id', $sortAsc = true;
    public $filterByCategory = null;
    public $filterByStatus;

    protected $listeners = ['recordDeleted' => 'deleteSubCategory', 'forcedCloseModal', 'CancelDeleted'];

    protected $rules = [
        'name' => 'required|unique:sub_categories,name',
        'category_id' => 'required'
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
        $this->validate([
            'name' => ['required', Rule::unique('sub_categories','name')->ignore($this->edit_id)],
            'category_id' => ['required']
        ]);
        foreach ($this->name as $key => $subcategory){
            if(!empty($subcategory)){
                if(isset($this->category_id[$key])){
                    SubCategoryModel::create([
                        'name' => $this->name[$key],
                        'status' => $this->status[$key] ?? 0, //if the status is empty give 0 else 1
                        'category_id' => $this->category_id[$key]
                    ]);
                }
            }
        }
        $this->formReset();
        $this->toasterMessage(trans('applang.subcategory_added_successfully'));
    }

    public function editSubCategory($subcategory_id)
    {
        $this->edit_id = $subcategory_id;
        $subcategory = SubCategoryModel::findOrFail($subcategory_id);
        $this->name = $subcategory->name;
        $this->status = $subcategory->status;
        $this->category_id = $subcategory->category_id;
    }

    public function update()
    {
        SubCategoryModel::updateOrCreate(['id' => $this->edit_id],[
            'name' => $this->name,
            'status' => $this->status ?? 0,//if the status is empty give 0 else 1
            'category_id' => $this->category_id
        ]);
        $this->formReset();
        $this->toasterMessage(trans('applang.subcategory_updated_successfully'));
    }

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->subcategories->pluck('id')->map(function ($item) {
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
        $this->checked = $this->subcategoriesQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }

    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($subcategory_id, $subcategory_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$subcategory_name .")</span>"."</span>",
            'id'    => $subcategory_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deleteSubCategory($subcategory_id)
    {
        if($this->checked){ //Bulk Delete
            SubCategoryModel::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $subcategory = CategoryModel::find($subcategory_id); //Single Delete
            $subcategory->delete();
//            $this->checked = array_diff($this->checked, [$subcategory_id]);
            $this->resetPage();
        }
    }

    public function CancelDeleted($subcategory_id)
    {
        $this->checked = [];
        $this->selectPage = false;
        $this->resetPage();
    }

    public function formReset()
    {
        $this->status = '';
        $this->name = '';
        $this->category_id = '';
        $this->count = 0;
        $this->addMore = [1];
        $this->dispatchBrowserEvent('closeModal');
    }

    public function forcedCloseModal()
    {
        $this->status = '';
        $this->name = '';
        $this->category_id = '';
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
        $this->filterByCategory = null;
        $this->filterByStatus = '';
    }

    public function render()
    {
        return view('livewire.erp.products-settings.sub-categories',[
            'subcategories' => $this->subcategories,
            'categories' => Category::all()
        ]);
    }

    public function getSubcategoriesProperty(){
        return $this->subcategoriesQuery->paginate($this->perPage);
    }

    public function getSubcategoriesQueryProperty()
    {
        return SubCategoryModel::with('category')
            ->search(trim($this->search))
            ->when($this->filterByCategory, function ($query){
                $query->where('category_id', $this->filterByCategory);
            })
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
        return (new SubcategoriesExport($this->checked))->download('subcategories.xlsx');
    }
}
