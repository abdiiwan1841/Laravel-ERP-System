<?php

namespace App\Http\Livewire\Erp\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoiceAttachments;
use App\Models\ERP\Purchases\PurchaseInvoicePayment;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use File;
use phpDocumentor\Reflection\Types\AbstractList;

class ShowPurchaseInvoice extends Component
{
    public $purchaseInvoice;
    public $companyData;
    public $currency_symbol;
    public $basic_currency;
    public $invoiceValue;
    public $completedPayments;
    public $allPayments;
    public $due_after_payments;
    public $down_payment;
    public $receiving_status = 1;

    protected $listeners = ['recordDeleted' => 'deleteFile', 'invoiceDeleted' => 'deletePurchaseInvoice', 'paymentDeleted' => 'deletePayment'];

    public function mount($purchaseInvoice)
    {
        $this->purchaseInvoice = $purchaseInvoice;
        //get general settings currency
        $this->companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $this->companyData->basic_currency_symbol;
        }else{
            $this->currency_symbol = $this->companyData->basic_currency;
        }

        $this->basic_currency = $this->companyData->basic_currency;

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
        $this->down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        if($purchaseInvoice->paid_to_supplier_inv == null){
            $this->completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $this->allPayments = $this->down_payment+(int)array_sum($this->completedPayments);
            $this->invoiceValue = (int)$purchaseInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }else{
            $this->allPayments = $paid_to_supplier_inv;
            $this->invoiceValue = (int)$purchaseInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }
    }

    public function confirmDelete($file_id, $file_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$file_name .")</span>"."</span>",
            'id'    => $file_id
        ]);
    }
    public function deleteFile($file_id)
    {
        $file = PurchaseInvoiceAttachments::find($file_id); //Single Delete

        $purchaseInvoice = $file->purchaseInvoice;
        $folder_date = $purchaseInvoice->created_at->format('m-Y');
        $filePath = 'uploads/purchase_invoices_attachments/'. $folder_date.'/'.$purchaseInvoice->inv_number.'/'.$file->attachments;
        $invoiceNumberFolder = Storage::disk('public_uploads')->path('purchase_invoices_attachments/'.$folder_date.'/'.$purchaseInvoice->inv_number);
        $dateFolder = Storage::disk('public_uploads')->path('purchase_invoices_attachments/'.$folder_date);

        File::delete(public_path($filePath));

        $FileSystem = new Filesystem();
        //Check if the invoiceNumberFolder exists.
        if ($FileSystem->exists($invoiceNumberFolder)) {
            // Get all files in this invoiceNumberFolder.
            $files = $FileSystem->files($invoiceNumberFolder);
            // Check if invoiceNumberFolder is empty.
            if (empty($files)) {
                // Yes, delete the invoiceNumberFolder.
                $FileSystem->deleteDirectory($invoiceNumberFolder);
            }
        }

        //Check if the dateFolder exists.
        if ($FileSystem->exists($dateFolder )) {
            // Get all folders in this dateFolder.
            $folders = $FileSystem->directories($dateFolder);
            // Check if dateFolder is empty.
            if (empty($folders)) {
                // Yes, delete the dateFolder.
                $FileSystem->deleteDirectory($dateFolder);
            }
        }
        $file->delete();
        $this->dispatchBrowserEvent('refresh-page');
    }

    public function confirmDeleteInvoice($invoice_id, $invoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeleteInvoiceConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$invoice_number .")</span>"."</span>",
            'id'    => $invoice_id
        ]);
    }
    public function deletePurchaseInvoice($purchaseInvoice_id)
    {
        $purchaseInvoice = PurchaseInvoice::find($purchaseInvoice_id); //Single Delete
        if($purchaseInvoice->receiving_status == '1'){
            $purchaseInvoice->delete();
            return redirect()->route('purchase-invoices.index');
        }else{
            $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.purchase_invoice_received')]);
        }
    }

    public function confirmDeletePayment($payment_id, $invoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeletePaymentConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_payment_msg')."<span class='text-danger'>(".$payment_id .")</span>".trans('applang.for_invoice_number')."<span class='text-danger'>(".$invoice_number .")</span>"."</span>",
            'id'    => $payment_id
        ]);
    }
    public function deletePayment($payment_id)
    {
        $payment = PurchaseInvoicePayment::find($payment_id); //Single Delete
        $payment->delete();

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $this->purchaseInvoice->paid_to_supplier_inv);
        $this->down_payment = (int)preg_replace("/[^0-9]/", "", $this->purchaseInvoice->down_payment_inv);
        if($this->purchaseInvoice->paid_to_supplier_inv == null){
            $this->completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $this->purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $this->allPayments = $this->down_payment+(int)array_sum($this->completedPayments);
            $this->invoiceValue = (int)$this->purchaseInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
            $this->purchaseInvoice->update([
                'payments_total' => (int)array_sum($this->completedPayments),
                'due_amount_after_payments' => $this->due_after_payments
            ]);
        }else{
            $this->allPayments = $paid_to_supplier_inv;
            $this->invoiceValue = (int)$this->purchaseInvoice->total_inv;
            $this->due_after_payments = ($this->invoiceValue-$this->allPayments);
        }

        if($this->purchaseInvoice->due_amount_after_payments == $this->purchaseInvoice->total_inv){
            $this->purchaseInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($this->purchaseInvoice->due_amount_after_payments > 0.00 && $this->purchaseInvoice->due_amount_after_payments < $this->purchaseInvoice->total_inv){
            $this->purchaseInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($this->purchaseInvoice->due_amount_after_payments == 0.00){
            $this->purchaseInvoice->update([
                'payment_status' => 3,
            ]);
        }

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function receiptConfirmation()
    {
        $this->receiving_status = 2;
        $this->purchaseInvoice->update([
            'receiving_status' => 2
        ]);

        WarehousePurchaseDetail::where('purchase_invoice_id', $this->purchaseInvoice->id)->update([
            'receiving_status' => 2
        ]);

        $warehouse = Warehouse::where('id',$this->purchaseInvoice->warehouse_id)->first();
        $allProducts = Product::all();
        $product_id_purchases = WarehousePurchaseDetail::where(['warehouse_id'=> $warehouse->id, 'receiving_status' => 2])->pluck('product_id')->toArray();
        $quantities_purchases = WarehousePurchaseDetail::where(['warehouse_id'=> $warehouse->id, 'receiving_status' => 2])->pluck('quantity')->toArray();
        $array_purchases = array_map(function($key, $val) {return array($key=>$val);}, $product_id_purchases, $quantities_purchases);
        $products_purchases_price = WarehousePurchaseDetail::where(['warehouse_id'=> $warehouse->id, 'receiving_status' => 2])->pluck('unit_price')->toArray();
        $array_purchases_price = array_map(function($key, $val) {return array($key=>$val);}, $product_id_purchases, $products_purchases_price);

        $product_id_purchases_all = WarehousePurchaseDetail::where('receiving_status' , 2)->pluck('product_id')->toArray();
        $quantities_purchases_all = WarehousePurchaseDetail::where('receiving_status' , 2)->pluck('quantity')->toArray();
        $array_purchases_all = array_map(function($key, $val) {return array($key=>$val);}, $product_id_purchases_all, $quantities_purchases_all);
        $products_purchases_price_all = WarehousePurchaseDetail::where('receiving_status' , 2)->pluck('unit_price')->toArray();
        $array_purchases_price_all = array_map(function($key, $val) {return array($key=>$val);}, $product_id_purchases_all, $products_purchases_price_all);
        $array_purchases_qp_all = [];
        foreach ($product_id_purchases_all as $key=>$product_id) {
            $array_purchases_qp_all[] = array($product_id => ($products_purchases_price_all[$key] * $quantities_purchases_all[$key]));
        }
        $array_qp_totals_all = [];
        foreach ($allProducts as $key => $product){
            $array_qp_totals_all[] = array ($product->id => array_sum(array_column($array_purchases_qp_all, $product->id)));
        }
        $array_weighted_price_all = [];
        foreach ($array_qp_totals_all as $qp_total){
            $product_id = array_key_first($qp_total);
            $total_p = array_values($qp_total)[0];
            $total_q = array_sum(array_column($array_purchases_all, $product_id));
            if($total_q > 0){
                $array_weighted_price_all[] = array($product_id => ((int)number_format(($total_p/$total_q), 2, '.', '')));
            }else{
                $array_weighted_price_all[] = array($product_id => ((int)number_format(($total_p/1), 2, '.', '')));
            }
        }

        $product_id_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('product_id')->toArray();
        $quantities_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('quantity')->toArray();
        $array_sales = array_map(function($key, $val) {return array($key=>$val);}, $product_id_sales, $quantities_sales);

        $totals = [];
        foreach ($allProducts as $key => $product) {
            $purchasePrice = WarehousePurchaseDetail::where(['product_id'=> $product->id, 'warehouse_id' => $warehouse->id])->pluck('unit_price')->first();
            $sellPrice = WarehouseSalesDetail::where(['product_id'=> $product->id, 'warehouse_id' => $warehouse->id])->pluck('unit_price')->first();

            $totals[$key]['warehouse_id'] = $warehouse->id;
            $totals[$key]['product_id'] = $product->id;

            $totals[$key]['total_quantity_purchased'] = array_sum(array_column($array_purchases, $product->id));
            $totals[$key]['total_purchases_cost'] = ($totals[$key]['total_quantity_purchased'] * $purchasePrice);
            $totals[$key]['total_sales_value_of_purchases'] = ($totals[$key]['total_quantity_purchased'] * (isset($sellPrice)?$sellPrice:$product->sell_price));
            $totals[$key]['expected_profit'] = ($totals[$key]['total_sales_value_of_purchases'] - $totals[$key]['total_purchases_cost']);

            $totals[$key]['total_quantity_sold'] = array_sum(array_column($array_sales, $product->id));
            $totals[$key]['total_sold_cost'] = ($totals[$key]['total_quantity_sold'] * $purchasePrice);
            $totals[$key]['total_value_of_sales'] = ($totals[$key]['total_quantity_sold'] * $sellPrice);
            $totals[$key]['actual_profit'] = ($totals[$key]['total_value_of_sales'] - $totals[$key]['total_sold_cost']);

            $totals[$key]['weighted_average_cost'] = $array_weighted_price_all[$key][$product->id];
            $totals[$key]['total_quantity_remain'] = ($totals[$key]['total_quantity_purchased'] - $totals[$key]['total_quantity_sold']);
            $totals[$key]['total_remain_cost'] = ($totals[$key]['total_quantity_remain'] * $totals[$key]['weighted_average_cost']);
            $totals[$key]['total_sales_value_of_remain'] = ($totals[$key]['total_quantity_remain'] * (isset($sellPrice)?$sellPrice:$product->sell_price));
            $totals[$key]['expected_profit_of_remain'] = ($totals[$key]['total_sales_value_of_remain'] - $totals[$key]['total_remain_cost']);
        }

        if(count($warehouse->totals()->get()) > 0){
            $warehouse->totals()->delete();
            $warehouse->totals()->createMany($totals);
        }elseif(count($warehouse->totals()->get()) == 0){
            $warehouse->totals()->createMany($totals);
        }

        foreach ( $totals as $key => $total){
            $product = Product::where('id', $total['product_id'])->get()->first();
            $warehouseTotal = WarehouseTotal::where(['product_id'=> $total['product_id'], 'warehouse_id' => $total['warehouse_id']])->pluck('id');
            $product->warehouseTotal()->attach($warehouseTotal);

            $warehouseTotalProducts = array_sum(WarehouseTotal::where('product_id', $total['product_id'])->pluck('total_quantity_remain')->toArray());
            $product->update([
                'total_quantity' => $warehouseTotalProducts
            ]);

            WarehouseTotal::where('product_id', $total['product_id'])->update([
                'weighted_average_cost' => $array_weighted_price_all[$key][$total['product_id']],
            ]);
        }


        foreach (WarehouseTotal::all() as $total_all){
            $productSellPrice = Product::where('id', $total_all->product_id)->pluck('sell_price')->first();
            $sellPrice = WarehouseSalesDetail::where(['product_id'=>$total_all->product_id, 'warehouse_id' => $total_all->warehouse_id])->pluck('unit_price')->first();
            $data = [
                'total_remain_cost' => ($total_all->total_quantity_remain * $total_all->weighted_average_cost),
                'total_sales_value_of_remain' => ($total_all->total_quantity_remain * (isset($sellPrice)?$sellPrice:$productSellPrice)),
            ];
            $total_all->update($data);
            $total_all->update([
                'expected_profit_of_remain' => ($total_all->total_sales_value_of_remain - $total_all->total_remain_cost),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.erp.purchases.show-purchase-invoice');
    }
}
