<?php

namespace App\Http\Livewire\Erp\Inventory;

use App\Exports\ProductsExport;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $checked = [], $selectPage = false, $selectAll = false;
    public $currency_symbol = null;
    public $search = '', $perPage = 5, $sortField = 'id', $sortAsc = true;
    public $filterBySection = null, $filterByBrand = null, $filterByCategory = null, $filterBySubCategory = null, $filterBySKU = null, $filterByStatus = null;

    protected $listeners = ['recordDeleted' => 'deleteProduct', 'CancelDeleted'];

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->products->pluck('id')->map(function ($item) {
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
        $this->checked = $this->productsQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }
    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function confirmDelete($product_id, $product_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$product_name .")</span>"."</span>",
            'id'    => $product_id
        ]);
    }

    public function deleteProduct($product_id)
    {
        if($this->checked){ //Bulk Delete
            foreach ($this->checked as $productCheckedId){
                $product = Product::find($productCheckedId);
                if($product->total_quantity == 0.00) {
                    $product->delete();
                    $barcode_path = public_path() . '/uploads/products/barcodes/' . $product->barcode;
                    unlink($barcode_path);
                    if ($product->product_image != 'defaultProduct.png') {
                        Storage::disk('public_uploads')->delete('/products/images//' . $product->product_image);
                    }
                }else{
                    $this->dispatchBrowserEvent('MsgError', [
                        'title' => trans('applang.product_quantity_not_empty'),
                        'id'    => $this->checked
                    ]);
                }
            }
//            Product::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $product = Product::find($product_id); //Single Delete
            if($product->total_quantity == 0.00){
                $product->delete();
                $barcode_path = public_path() . '/uploads/products/barcodes/' . $product->barcode;
                unlink($barcode_path);
                if($product->product_image != 'defaultProduct.png'){
                    Storage::disk('public_uploads')->delete('/products/images//'.$product->product_image);
                }
                $this->resetPage();
            }else{
                $this->dispatchBrowserEvent('MsgError', [
                    'title' => trans('applang.product_quantity_not_empty'),
                    'id'    => $this->checked
                ]);
            }
        }
    }

    public function CancelDeleted($product_id)
    {
        $this->checked = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->perPage = 5;
        $this->sortField = 'id';
        $this->sortAsc = true;
        $this->filterBySection = null;
        $this->filterByStatus = '';
        $this->filterByBrand = null;
        $this->filterByCategory = null;
        $this->filterBySubCategory = null;
        $this->filterBySKU = null;
//        $this->resetPage();
    }

    public function mount()
    {
        $this->brands = [];
        $this->categories = [];
        $this->subcategories = [];
    }

    public function updatedFilterBySection($sectionId)
    {
        $section = Section::find($sectionId);
        $this->brands = $section->brands;
        $this->categories = $section->categories;
    }

    public function updatedFilterByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $this->subcategories = $category->subcategories;
    }


    public function render()
    {
        //get general settings currency
        $gs = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $gs->basic_currency_symbol;
        }else{
            $this->currency_symbol = $gs->basic_currency;
        }

        return view('livewire.erp.inventory.products',[
            'products' => $this->products,
            'currency_symbol' => $this->currency_symbol,
            'sections' => Section::all(),
//            'brands'   => Brand::all(),
//            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ]);
    }

    public function getProductsProperty(){
        return $this->productsQuery->paginate($this->perPage);
    }

    public function getProductsQueryProperty()
    {
        return Product::with('section', 'brand', 'category', 'subcategory', 'unitTemplate', 'measurementUnit', 'supplier', 'sequential_code')
            ->when($this->filterBySection, function ($query){
                $query->whereHas('section', function ($q){
                    $q->where('section_id', $this->filterBySection);
                });
            })
            ->when($this->filterByBrand, function ($query){
                $query->whereHas('brand', function ($q){
                    $q->where('brand_id', $this->filterByBrand);
                });
            })
            ->when($this->filterByCategory, function ($query){
                $query->whereHas('category', function ($q){
                    $q->where('category_id', $this->filterByCategory);
                });
            })
            ->when($this->filterBySubCategory, function ($query){
                $query->whereHas('subcategory', function ($q){
                    $q->where('subcategory_id', $this->filterBySubCategory);
                });
            })
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->when($this->filterBySKU, function ($query){
                $query->where('sku', 'like' , '%'.$this->filterBySKU.'%');
            })
            ->search(trim($this->search))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
        return (new ProductsExport($this->checked))->download('products.xlsx');
    }
}
