<?php

namespace App\Http\Livewire\Erp\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\ERP\Settings\Tax;
use Livewire\Component;

class CreatePurchaseInvoice extends Component
{
    public $suppliers = [], $supplier_id = null, $supp, $inv_number;
    public $products = [], $currency_symbol, $warehouses;
    public $taxes = [], $first_tax_ids = [], $second_tax_ids = [], $total_taxes_ids =[];
    public $total_tax_inv, $first_tax_items_val=[], $second_tax_items_val=[], $total_tax_inv_sum = [];
    public $addProduct=[1], $descriptions=[], $unit_prices=[], $quantities=[], $row_total=[];
    public $subtotal;
    public $showAddMoreBtn = false;
    public $discount_inv= null ,$discount = null, $discount_type = null;
    public $down_payment_inv= null ,$down_payment = null, $down_payment_type = null;
    public $deposit_is_paid = false, $deposit_payment_method = null, $deposit_transaction_id = null;
    public $shipping_expense_inv= null ,$shipping_expense = null;
    public $total_inv = null;
    public $due_amount = null;
    public $paid_to_supplier_checkbox = false, $payment_payment_method = null, $payment_transaction_id = null, $paid_to_supplier_inv = null;
    public $payment_status = 1, $receiving_status = 1;

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->taxes = Tax::all();
        $this->products = Product::all();
        $this->warehouses = Warehouse::all();

        //set invoice number
        $model = PurchaseInvoice::all();
        $model->sequential_code_id = SequentialCode::where('model', 'purchase_invoices')->pluck('id')->first();
        $model->number = PurchaseInvoice::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
        $numbers_length =  SequentialCode::where('model', 'purchase_invoices')->pluck('numbers_length')->first();
        $prefix = SequentialCode::where('id', $model->sequential_code_id)->pluck('prefix')->first();
        $model->full_code = $prefix.'-'.str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        $this->inv_number = $model->full_code;

        //get general settings currency
        $gs = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $gs->basic_currency_symbol;
        }else{
            $this->currency_symbol = $gs->basic_currency;
        }

//        $this->due_amount = '0.00'.' '.$this->currency_symbol;
    }

    public function addMoreProduct()
    {
        $this->addProduct[] = count($this->addProduct) + 1;
        $this->showAddMoreBtn = false;
    }

    public function removeProduct($index)
    {
        unset($this->addProduct[$index]);
        unset($this->descriptions[$index]);
        unset($this->unit_prices[$index]);
        unset($this->quantities[$index]);
        unset($this->first_tax_ids[$index]);
        unset($this->second_tax_ids[$index]);
        unset($this->first_tax_items_val[$index]);
        unset($this->second_tax_items_val[$index]);
        unset($this->total_tax_inv_sum[$index]);
        unset($this->row_total[$index]);

        $this->addProduct =array_values($this->addProduct);
        $this->descriptions =array_values($this->descriptions);
        $this->unit_prices =array_values($this->unit_prices);
        $this->quantities =array_values($this->quantities);
        $this->first_tax_ids =array_values($this->first_tax_ids);
        $this->second_tax_ids =array_values($this->second_tax_ids);
        $this->first_tax_items_val = array_values($this->first_tax_items_val);
        $this->second_tax_items_val = array_values($this->second_tax_items_val);
        $this->total_tax_inv_sum = array_values($this->total_tax_inv_sum);
        $this->row_total = array_values($this->row_total);

        $this->subtotal = array_sum($this->row_total);


        $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
        $this->total_taxes_ids = array_keys(array_count_values($all));
        foreach($this->total_taxes_ids as $key => $total_tax) {
            $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
        }
        $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
        $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

        $this->showAddMoreBtn = true;

        $this->calculateDueAmount();
    }

    public function updated ($key, $value)
    {
        $parts = explode(".", $key);
        if(count($parts) === 3 && $parts[0] === "addProduct") {
            if($value){
                $description = $this->products->where('id', $value)->first()->description;
                if($description) {
                    $this->descriptions[$parts[1]] = $description;
                }

                $unit_price = $this->products->where('id', $value)->first()->purchase_price;
                $this->unit_prices[$parts[1]] =  $unit_price;

                $first_tax_id = $this->products->where('id', $value)->first()->first_tax_id;
                $this->first_tax_ids[$parts[1]] =  (string)$first_tax_id;

                $second_tax_id = $this->products->where('id', $value)->first()->second_tax_id;
                $this->second_tax_ids[$parts[1]] =  (string)$second_tax_id;

                if(isset($this->quantities[$parts[1]])){

                    $this->row_total[$parts[1]] = ((int)$this->quantities[$parts[1]] * (int)$this->unit_prices[$parts[1]]);

                    if($this->first_tax_ids[$parts[1]]){
                        $rate = ($this->taxes->where('id',$this->first_tax_ids[$parts[1]])->first()->tax_value)/100;
                        $this->first_tax_items_val[$parts[1]] = number_format($this->row_total[$parts[1]] * $rate, 2, '.', '');
                    }

                    if($this->second_tax_ids[$parts[1]])
                    {
                        $rate = ($this->taxes->where('id',$this->second_tax_ids[$parts[1]])->first()->tax_value)/100;
                        $this->second_tax_items_val[$parts[1]] = number_format($this->row_total[$parts[1]] * $rate, 2, '.', '');
                    }

                    $this->subtotal = array_sum($this->row_total);

                    $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
                    $this->total_taxes_ids = array_keys(array_count_values($all));
                    foreach($this->total_taxes_ids as $key => $total_tax) {
                        $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
                    }
                    $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
                    $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);
                }

                foreach($this->second_tax_ids as $key => $second_tax){
                    if($this->second_tax_ids[$key] == $this->first_tax_ids[$key]){
                        $second_tax = '';
                        $this->second_tax_ids[$key] = '';
                    }
                    if($second_tax && isset($this->quantities[$key])) {
                        $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                        $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                    }else{
                        $this->second_tax_items_val[$key] = '';
                    }
                }
            }else{
                if(count($this->addProduct) > 1){
                    unset($this->addProduct[$parts[1]]);
                    unset($this->descriptions[$parts[1]]);
                    unset($this->unit_prices[$parts[1]]);
                    unset($this->quantities[$parts[1]]);
                    unset($this->first_tax_ids[$parts[1]]);
                    unset($this->second_tax_ids[$parts[1]]);
                    unset($this->first_tax_items_val[$parts[1]]);
                    unset($this->second_tax_items_val[$parts[1]]);
                    unset($this->total_tax_inv_sum[$parts[1]]);
                    unset($this->row_total[$parts[1]]);

                    $this->addProduct =array_values($this->addProduct);
                    $this->descriptions =array_values($this->descriptions);
                    $this->unit_prices =array_values($this->unit_prices);
                    $this->quantities =array_values($this->quantities);
                    $this->first_tax_ids =array_values($this->first_tax_ids);
                    $this->second_tax_ids =array_values($this->second_tax_ids);
                    $this->first_tax_items_val = array_values($this->first_tax_items_val);
                    $this->second_tax_items_val = array_values($this->second_tax_items_val);
                    $this->total_tax_inv_sum = array_values($this->total_tax_inv_sum);
                    $this->row_total = array_values($this->row_total);

                    $this->subtotal = array_sum($this->row_total);

                    $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
                    $this->total_taxes_ids = array_keys(array_count_values($all));
                    foreach($this->total_taxes_ids as $key => $total_tax) {
                        $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
                    }
                    $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
                    $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);
                    $this->showAddMoreBtn = true;
                }else{
                    unset($this->descriptions[$parts[1]]);
                    unset($this->unit_prices[$parts[1]]);
                    unset($this->quantities[$parts[1]]);
                    unset($this->first_tax_ids[$parts[1]]);
                    unset($this->second_tax_ids[$parts[1]]);
                    unset($this->first_tax_items_val[$parts[1]]);
                    unset($this->second_tax_items_val[$parts[1]]);
                    unset($this->total_tax_inv_sum[$parts[1]]);
                    unset($this->row_total[$parts[1]]);

                    $this->descriptions =array_values($this->descriptions);
                    $this->unit_prices =array_values($this->unit_prices);
                    $this->quantities =array_values($this->quantities);
                    $this->first_tax_ids =array_values($this->first_tax_ids);
                    $this->second_tax_ids =array_values($this->second_tax_ids);
                    $this->first_tax_items_val = array_values($this->first_tax_items_val);
                    $this->second_tax_items_val = array_values($this->second_tax_items_val);
                    $this->total_tax_inv_sum = array_values($this->total_tax_inv_sum);
                    $this->row_total = array_values($this->row_total);

                    $this->subtotal = array_sum($this->row_total);

                    $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
                    $this->total_taxes_ids = array_keys(array_count_values($all));
                    foreach($this->total_taxes_ids as $key => $total_tax) {
                        $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
                    }
                    $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
                    $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);
                    $this->showAddMoreBtn = true;
                }
            }
        }

        $this->calculateDueAmount();
    }

    public function updatedSupplierId($value)
    {
        $this->supp = Supplier::find($value);
    }

    public function updatedFirstTaxIds($value)
    {
        foreach($this->first_tax_ids as $key => $first_tax){
            if($this->second_tax_ids[$key] == $this->first_tax_ids[$key]){
                $first_tax = '';
                $this->first_tax_ids[$key] = '';
            }
            if($first_tax && isset($this->quantities[$key])) {
                $rate = ($this->taxes->where('id', $this->first_tax_ids[$key])->first()->tax_value) / 100;
                $this->first_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
            }else{
                $this->first_tax_items_val[$key] = '';
            }
        }

        foreach($this->second_tax_ids as $key => $second_tax){
            if($this->second_tax_ids[$key] == $this->first_tax_ids[$key]){
                $second_tax = '';
                $this->second_tax_ids[$key] = '';
            }
            if($second_tax && isset($this->quantities[$key])) {
                $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
            }else{
                $this->second_tax_items_val[$key] = '';
            }
        }

        $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
        $this->total_taxes_ids = array_keys(array_count_values($all));
        foreach($this->total_taxes_ids as $key => $total_tax) {
            $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
        }
        $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
        $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

        $this->calculateDueAmount();

    }

    public function updatedSecondTaxIds($value)
    {
        foreach($this->second_tax_ids as $key => $second_tax){
            if($this->second_tax_ids[$key] == $this->first_tax_ids[$key]){
                $second_tax = '';
                $this->second_tax_ids[$key] = '';
            }
            if($second_tax && isset($this->quantities[$key])) {
                $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
            }else{
                $this->second_tax_items_val[$key] = '';
            }
        }

        $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
        $this->total_taxes_ids = array_keys(array_count_values($all));
        foreach($this->total_taxes_ids as $key => $total_tax) {
            $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
        }
        $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
        $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

        $this->calculateDueAmount();

    }

    public function updatedQuantities($value)
    {
        if($value){
            foreach ($this->quantities as $key => $product)
            {
                $this->row_total[$key] = ((int)$this->quantities[$key] * (int)$this->unit_prices[$key]);

                if($this->first_tax_ids[$key]){
                    $rate = ($this->taxes->where('id',$this->first_tax_ids[$key])->first()->tax_value)/100;
                    $this->first_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }

                if($this->second_tax_ids[$key])
                {
                    $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                    $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }
            }

            $this->subtotal = array_sum($this->row_total);

            $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
            $this->total_taxes_ids = array_keys(array_count_values($all));
            foreach($this->total_taxes_ids as $key => $total_tax) {
                $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
            }
            $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
            $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

            $this->showAddMoreBtn = true;
        }else{
            foreach ($this->quantities as $key => $product){
                $this->row_total[$key] = ((int)$this->quantities[$key] * (int)$this->unit_prices[$key]);

                if($this->first_tax_ids[$key]){
                    $rate = ($this->taxes->where('id',$this->first_tax_ids[$key])->first()->tax_value)/100;
                    $this->first_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }

                if($this->second_tax_ids[$key])
                {
                    $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                    $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }
            }

            $this->subtotal = array_sum($this->row_total);

            $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
            $this->total_taxes_ids = array_keys(array_count_values($all));
            foreach($this->total_taxes_ids as $key => $total_tax) {
                $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
            }
            $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
            $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

            $this->showAddMoreBtn = false;

            $this->discount = '';
            $this->discount_type = '';
            $this->discount_inv = '';
            $this->discount_type = '';
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedUnitPrices($value)
    {
        if($value){
            foreach ($this->unit_prices as $key => $price)
            {
                $this->row_total[$key] = ((int)$this->quantities[$key] * (int)$this->unit_prices[$key]);

                if($this->first_tax_ids[$key]){
                    $rate = ($this->taxes->where('id',$this->first_tax_ids[$key])->first()->tax_value)/100;
                    $this->first_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }

                if($this->second_tax_ids[$key])
                {
                    $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                    $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }
            }

            $this->subtotal = array_sum($this->row_total);

            $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
            $this->total_taxes_ids = array_keys(array_count_values($all));
            foreach($this->total_taxes_ids as $key => $total_tax) {
                $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
            }
            $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
            $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

            $this->showAddMoreBtn = true;
        }else{
            foreach ($this->unit_prices as $key => $price)
            {
                $this->row_total[$key] = ((int)$this->quantities[$key] * (int)$this->unit_prices[$key]);

                if($this->first_tax_ids[$key]){
                    $rate = ($this->taxes->where('id',$this->first_tax_ids[$key])->first()->tax_value)/100;
                    $this->first_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }

                if($this->second_tax_ids[$key])
                {
                    $rate = ($this->taxes->where('id',$this->second_tax_ids[$key])->first()->tax_value)/100;
                    $this->second_tax_items_val[$key] = number_format($this->row_total[$key] * $rate, 2, '.', '');
                }
            }

            $this->subtotal = array_sum($this->row_total);

            $all = array_merge($this->first_tax_ids, $this->second_tax_ids);
            $this->total_taxes_ids = array_keys(array_count_values($all));
            foreach($this->total_taxes_ids as $key => $total_tax) {
                $this->total_tax_inv[$key] = $this->taxes->where('id', $total_tax)->first();
            }
            $allTaxValues = array_merge($this->first_tax_items_val, $this->second_tax_items_val);
            $this->total_tax_inv_sum = array_map(function($key, $val) {return array($key=>$val);}, $all, $allTaxValues);

            $this->showAddMoreBtn = false;

            $this->discount = '';
            $this->discount_type = '';
            $this->discount_inv = '';
            $this->discount_type = '';
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedDiscount($value)
    {
        $this->discount = $value;

        if($this->down_payment_type != null && $this->subtotal != ''){
            if($this->discount_type == 1)
            {
                $this->discount_inv = ((int)$this->discount/100) * (int)$this->subtotal;
            }elseif ($this->discount_type == 0)
            {
                $this->discount_inv = (int)$this->discount;
            }else{
//                $this->discount = '';
                $this->discount_inv = '';
                $this->discount_type = '';
            }
        }else{
//            $this->discount = '';
            $this->discount_inv = '';
            $this->discount_type = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedDiscountType($value)
    {
        if($value == 1 && $this->subtotal != '')
        {
            $this->discount_inv = ((int)$this->discount/100) * (int)$this->subtotal;
        }
        elseif ($value == 0 && $this->subtotal != '')
        {
            $this->discount_inv = (int)$this->discount;
        }
        else{
            $this->discount = '';
            $this->discount_inv = '';
            $this->discount_type = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedDownPayment($value)
    {
        $this->down_payment = $value;

        if($this->deposit_is_paid == true && $this->subtotal != '' && $this->down_payment != '')
        {
            if($this->down_payment_type != null ) {
                if($this->down_payment_type == 1)
                {
                    $this->down_payment_inv = ((int)$this->down_payment/100) * (int)$this->subtotal;
                }elseif ($this->down_payment_type == 0)
                {
                    $this->down_payment_inv = (int)$this->down_payment;
                }else{
                    $this->down_payment = '';
                    $this->down_payment_inv = '';
                    $this->down_payment_type = '';
                    $this->deposit_payment_method = '';
                    $this->deposit_transaction_id = '';
                }
            }
        }
        else{
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
            $this->deposit_payment_method = '';
            $this->deposit_transaction_id = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedDownPaymentType($value)
    {
        if($this->deposit_is_paid == true && $this->subtotal != '')
        {

            if($value == 1 && $this->down_payment != '')
            {
                $this->down_payment_inv = ((int)$this->down_payment/100) * (int)$this->subtotal;
            }
            elseif ($value == 0 && $this->down_payment != '')
            {
                $this->down_payment_inv = (int)$this->down_payment;
            }
            else{
                $this->down_payment = '';
                $this->down_payment_inv = '';
                $this->down_payment_type = '';
                $this->deposit_payment_method = '';
                $this->deposit_transaction_id = '';
            }

        }
        else
        {
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
            $this->deposit_payment_method = '';
            $this->deposit_transaction_id = '';
        }

        $this->calculateDueAmount();
    }

    public function updatedDepositIsPaid($value)
    {
        if($value == true)
        {
            if($this->down_payment_type != null && $this->down_payment != '' && $this->subtotal != '')
            {
                if($this->down_payment_type == 1)
                {
                    $this->down_payment_inv = ((int)$this->down_payment/100) * (int)$this->subtotal;
                }
                elseif ($this->down_payment_type == 0)
                {
                    $this->down_payment_inv = (int)$this->down_payment;
                }
                else
                {
                    $this->down_payment = '';
                    $this->down_payment_inv = '';
                    $this->down_payment_type = '';
                    $this->deposit_payment_method = '';
                    $this->deposit_transaction_id = '';
                }
            }
            else
            {
                $this->down_payment = '';
                $this->down_payment_inv = '';
                $this->down_payment_type = '';
                $this->deposit_payment_method = '';
                $this->deposit_transaction_id = '';
            }
        }
        else
        {
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
            $this->deposit_payment_method = '';
            $this->deposit_transaction_id = '';
        }
        $this->calculateDueAmount();
    }

    public function updatedDepositPaymentMethod($value)
    {
        if($this->down_payment != '' && $this->down_payment_type != '')
        {
            $this->deposit_payment_method = $value;
        }else{
            $this->deposit_payment_method = '';
        }
    }

    public function updatedDepositTransactionId($value)
    {
        if($this->down_payment != '' && $this->down_payment_type != '' && $this->deposit_payment_method != '')
        {
            $this->deposit_transaction_id = $value;
        }else{
            $this->deposit_transaction_id = '';
        }
    }

    public function updatedShippingExpense($value)
    {
        $this->shipping_expense = $value;
        if($this->subtotal != ''){
            $this->shipping_expense_inv = $this->shipping_expense;
        }else{
            $this->shipping_expense = '';
            $this->shipping_expense_inv = '';
        }

        $this->calculateDueAmount();
    }

    public function calculateDueAmount()
    {
        if($this->subtotal != ''){
            $subtotal = (int)$this->subtotal ?? 0;
            $discount = (int)$this->discount_inv ?? 0;
            $allTaxSum = (int)array_sum(array_merge($this->first_tax_items_val, $this->second_tax_items_val)) ?? 0;
            $shippingExpenses = (int)$this->shipping_expense_inv ?? 0;
            $downPayment = (int)$this->down_payment_inv ?? 0;

            $total_inv = (($subtotal-$discount)+($allTaxSum+$shippingExpenses));
            $dueAmount = (($subtotal-$discount)+($allTaxSum+$shippingExpenses))-$downPayment;

            $this->total_inv = $total_inv;
            $this->due_amount = $dueAmount;

            if($downPayment > 0){
                $this->payment_status = 2;
            }else{
                $this->payment_status = 1;
            }

            if($this->paid_to_supplier_inv != ''){
                $this->paid_to_supplier_inv = $this->due_amount;
            }
        }
    }

    public function updatedPaidToSupplierCheckbox($value)
    {
        if($value == true && $this->due_amount != '')
        {
            $this->down_payment = '';
            $this->down_payment_inv = '';
            $this->down_payment_type = '';
            $this->deposit_payment_method = '';
            $this->deposit_transaction_id = '';
            $this->calculateDueAmount();

            $this->paid_to_supplier_inv = $this->due_amount;
            $this->payment_status = 3;
        }
        elseif($value == false && $this->due_amount != '')
        {
            $this->paid_to_supplier_inv = '';
            $this->payment_payment_method = '';
            $this->payment_transaction_id = '';
            $this->payment_status = 1;
            $this->calculateDueAmount();
        }
    }

    public function updatedPaymentPaymentMethod($value)
    {
        if($this->due_amount != '')
        {
            $this->payment_payment_method = $value;
            $this->payment_status = 3;
        }else{
            $this->payment_payment_method = '';
            $this->payment_status = 1;
        }
    }

    public function updatedPaymentTransactionId($value)
    {
        if($this->due_amount != '')
        {
            $this->payment_transaction_id = $value;
            $this->payment_status = 3;
        }else{
            $this->payment_transaction_id = '';
            $this->payment_status = 1;
        }
    }


    public function render()
    {
        return view('livewire.erp.purchases.create-purchase-invoice');
    }
}
