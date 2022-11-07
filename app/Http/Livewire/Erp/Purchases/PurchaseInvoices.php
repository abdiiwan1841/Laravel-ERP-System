<?php

namespace App\Http\Livewire\Erp\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseInvoices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $checked = [], $selectPage = false, $selectAll = false;
    public $currency_symbol = null;
    public $search = '', $perPage = 5, $sortField = 'id', $sortAsc = true;
    public $filterByPaymentStatus = null, $filterByReceivingStatus = null, $filterByWarehouse = null, $filterBySupplier = null;
    public $filterByIssueDateStart = null, $filterByIssueDateEnd = null;
    public $receiving_status = 1;


    protected $listeners = ['recordDeleted' => 'deletePurchaseInvoice', 'CancelDeleted'];



    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->purchaseInvoices->pluck('id')->map(function ($item) {
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
        $this->checked = $this->purchaseInvoicesQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }

    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($purchaseInvoice_id, $purchaseInvoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$purchaseInvoice_number .")</span>"."</span>",
            'id'    => $purchaseInvoice_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deletePurchaseInvoice($purchaseInvoice_id)
    {
        if($this->checked){ //Bulk Delete
            $purchaseInvoices = PurchaseInvoice::whereIn('id', $this->checked)->get();
            foreach ($purchaseInvoices as $invoice){
                if($invoice->receiving_status == '1'){
                    if(count($invoice->purchaseInvoiceAttachments) >= 1){
                        $folder_date = $invoice->created_at->format('m-Y');
                        $invoiceNumberFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date.'/'.$invoice->inv_number);
                        $dateFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date);

                        $FileSystem = new Filesystem();
                        //Check if the invoiceNumberFolder exists.
                        if ($FileSystem->exists($invoiceNumberFolder)) {
                            // Yes, delete the invoiceNumberFolder.
                            $FileSystem->deleteDirectory($invoiceNumberFolder);
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
                    }
                    $invoice->delete();
                    $this->checked = [];
                    $this->selectPage = false;
                    $this->selectAll = false;
                    $this->resetPage();

                    $warehouse = Warehouse::where('id',$invoice->warehouse_id)->first();
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
                }else{
                    $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.purchase_invoice_received')]);
                }
            }


        }else{
            $purchaseInvoice = PurchaseInvoice::find($purchaseInvoice_id); //Single Delete
            if($purchaseInvoice->receiving_status == '1'){
                if(count($purchaseInvoice->purchaseInvoiceAttachments) >= 1){

                    $folder_date = $purchaseInvoice->created_at->format('m-Y');
                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date.'/'.$purchaseInvoice->inv_number);
                    $dateFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date);

                    $FileSystem = new Filesystem();
                    //Check if the invoiceNumberFolder exists.
                    if ($FileSystem->exists($invoiceNumberFolder)) {
                        // Yes, delete the invoiceNumberFolder.
                        $FileSystem->deleteDirectory($invoiceNumberFolder);
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
                }
                $purchaseInvoice->delete();
                $this->resetPage();

                $warehouse = Warehouse::where('id',$purchaseInvoice->warehouse_id)->first();
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

            }else{
                $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.purchase_invoice_received')]);
            }
        }
    }

    public function CancelDeleted($purchaseInvoice_id)
    {
        $this->checked = [];
        $this->selectPage = false;
        $this->resetPage();
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
        $this->perPage = 5;
        $this->sortField = 'id';
        $this->sortAsc = true;
        $this->filterByPaymentStatus = null;
        $this->filterByReceivingStatus = null;
        $this->filterByWarehouse = null;
        $this->filterBySupplier = null;
        $this->filterByIssueDateStart = null;
        $this->filterByIssueDateEnd = null;
        $this->resetPage();
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

        return view('livewire.erp.purchases.purchase-invoices',[
            'purchaseInvoices' => $this->purchaseInvoices,
            'warehouses' => Warehouse::all(),
            'suppliers' => Supplier::all(),
            'currency_symbol' => $this->currency_symbol,
        ]);
    }

    public function getPurchaseInvoicesProperty(){
        return $this->purchaseInvoicesQuery->paginate($this->perPage);
    }

    public function getPurchaseInvoicesQueryProperty()
    {
        return PurchaseInvoice::with(['user','supplier','purchaseInvoiceDetails','purchaseInvoiceTaxes','purchaseInvoiceAttachments', 'warehouse'])
                ->search(trim($this->search))
                ->when($this->filterByPaymentStatus, function ($query){
                    $query->where('payment_status', $this->filterByPaymentStatus);
                    $this->resetPage();
                })
                ->when($this->filterByReceivingStatus, function ($query){
                    $query->where('receiving_status', $this->filterByReceivingStatus);
                    $this->resetPage();
                })
                ->when($this->filterByWarehouse, function ($query){
                    $query->whereHas('warehouse', function ($q){
                        $q->where('warehouse_id', $this->filterByWarehouse);
                        $this->resetPage();
                    });
                })
                ->when($this->filterBySupplier, function ($query){
                    $query->whereHas('supplier', function ($q){
                        $q->where('supplier_id', $this->filterBySupplier);
                        $this->resetPage();
                    });
                })
                ->when($this->filterByIssueDateStart, function ($query){
                    $query->whereBetween('issue_date', [$this->filterByIssueDateStart, $this->filterByIssueDateEnd]);
                    $this->resetPage();
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }


    public function receiptConfirmation($purchaseInvoice_id)
    {
        $purchaseInvoice = PurchaseInvoice::find($purchaseInvoice_id);
        $this->receiving_status = 2;
        $purchaseInvoice->update([
            'receiving_status' => 2
        ]);

        WarehousePurchaseDetail::where('purchase_invoice_id', $purchaseInvoice_id)->update([
            'receiving_status' => 2
        ]);

        $warehouse = Warehouse::where('id',$purchaseInvoice->warehouse_id)->first();
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

}
