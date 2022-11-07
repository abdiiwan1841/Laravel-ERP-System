<?php

namespace App\Http\Livewire\Erp\Inventory;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\ERP\Settings\Tax;
use App\Models\ERP\Settings\UnitsTemplate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Picqer;

class CreateProduct extends Component
{
    public $brands = [], $categories = [], $subcategories = [], $measurement_units = [];
    public $section_id, $brand_id, $category_id, $subcategory_id, $unit_template_id, $measurement_unit_id;
    public $product_sku = null, $product_barcode = null, $product_name = null, $product_sell_price = null, $currency_symbol = null;
    public $product_image;
    use WithFileUploads;

    public function updatedSectionId($section_id)
    {
        $section = Section::find($section_id);
        $this->brands = $section->brands;
        $this->categories = $section->categories;
    }

    public function updatedCategoryId($category_id)
    {
        $category = Category::find($category_id);
        $this->subcategories = $category->subCategories;
    }

    public function updatedUnitTemplateId($template_id)
    {
        $template = UnitsTemplate::find($template_id);
        $this->measurement_units = $template->measurement_units;
    }

    public function generateSKU()
    {
        //generate SKU
        $sequential_code_id = SequentialCode::where('model', 'products')->pluck('id')->first();
        $sequential_code_prefix = SequentialCode::where('model', 'products')->pluck('prefix')->first();
        $number = Product::where('sequential_code_id', $sequential_code_id)->max('number') + 1 ;
        $numbers_length =  SequentialCode::where('model', 'products')->pluck('numbers_length')->first();
        $section_id = $this->section_id;
        $brand_id = $this->brand_id;
        $category_id = $this->category_id;
        $subcategory_id = $this->subcategory_id;
        $product_name = $this->product_name;
        $product_sell_price = $this->product_sell_price;
        if($section_id && $brand_id && $category_id && $product_name && $product_sell_price){
            $this->product_sku = $sequential_code_prefix.'-'.
                $section_id.$brand_id.$category_id.$subcategory_id.'-'.
                str_pad($number, $numbers_length, '0', STR_PAD_LEFT);
        }

        //Preview Barcode
        if($this->product_sku != null){
            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            $this->product_barcode = $generator->getBarcode($this->product_sku, $generator::TYPE_CODE_128, 2, 40);
        }

        //get general settings currency
        $gs = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $gs->basic_currency_symbol;
        }else{
            $this->currency_symbol = $gs->basic_currency;
        }

    }

    public function render()
    {
        $sections = Section::all();
        $units_templates = UnitsTemplate::all();
        $suppliers = Supplier::all();
        $taxes = Tax::all();
        return view('livewire.erp.inventory.create-product',[
            'sections' => $sections,
            'units_templates'  => $units_templates,
            'suppliers' => $suppliers,
            'taxes'     => $taxes
        ]);
    }
}
