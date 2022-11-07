<?php

namespace App\Http\Livewire\Erp\Inventory;

use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Settings\GeneralSetting;
use Livewire\Component;

class ShowProduct extends Component
{
    public $product, $currency_symbol, $price_after_discount, $measurementUnit, $discount_type;
    public $total_quantity_sold;
    public $total_weighted_average_cost;

    public function mount($product)
    {
        //get general settings currency
        $gs = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $gs->basic_currency_symbol;
        }else{
            $this->currency_symbol = $gs->basic_currency;
        }
        //get discount
        if($product->discount_type == '1'){
            $sell_price  = $product->sell_price;
            $discount = $product->discount / 100;
            $this->price_after_discount = $sell_price - ($sell_price * $discount);
            $this->discount_type = '%' ;
        }else{
            $sell_price  = $product->sell_price;
            $discount = $product->discount;
            $this->price_after_discount = ($sell_price - $discount);
            $this->discount_type = $this->currency_symbol ;
        }

        //get measurementUnit
        if(app()->getLocale() == 'ar'){
            $this->measurementUnit = $product->measurementUnit->largest_unit_ar;
        }else{
            $this->measurementUnit = $product->measurementUnit->largest_unit_en;
        }

        $this->total_quantity_sold = array_sum(WarehouseTotal::where('product_id', $product->id)->pluck('total_quantity_sold')->toArray());
        $this->total_weighted_average_cost = number_format(WarehouseTotal::where('product_id', $product->id)->pluck('weighted_average_cost')->first(), 0, ',', '');
     }

    public function render()
    {

        return view('livewire.erp.inventory.show-product');
    }
}
