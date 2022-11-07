<?php

namespace App\Http\Livewire\Erp\Sales\SalesInvoices;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Sales\Client;
use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SalesInvoices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $checked = [], $selectPage = false, $selectAll = false;
    public $currency_symbol = null;
    public $search = '', $perPage = 5, $sortField = 'id', $sortAsc = true;
    public $filterByPaymentStatus = null, $filterByReceivingStatus = null, $filterByWarehouse = null, $filterByClient = null;
    public $filterByIssueDateStart = null, $filterByIssueDateEnd = null;


    protected $listeners = ['recordDeleted' => 'deleteSalesInvoice', 'CancelDeleted'];



    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->salesInvoices->pluck('id')->map(function ($item) {
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
        $this->checked = $this->salesInvoicesQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }

    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmDelete($salesInvoice_id, $salesInvoice_number)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$salesInvoice_number .")</span>"."</span>",
            'id'    => $salesInvoice_id
        ]);
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function deleteSalesInvoice($salesInvoice_id)
    {
        if($this->checked){ //Bulk Delete
            $salesInvoices = SalesInvoice::whereIn('id', $this->checked)->get();
            foreach ($salesInvoices as $invoice){
                if($invoice->receiving_status == '1'){
                    if(count($invoice->salesInvoiceAttachments) >= 1){
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

                    $product_id_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('product_id')->toArray();
                    $quantities_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('quantity')->toArray();
                    $array_sales = array_map(function($key, $val) {return array($key=>$val);}, $product_id_sales, $quantities_sales);

                    $totals = [];
                    foreach ($allProducts as $key => $product) {
                        $totals[$key]['warehouse_id'] = $warehouse->id;
                        $totals[$key]['product_id'] = $product->id;

                        $totals[$key]['total_quantity_purchased'] = array_sum(array_column($array_purchases, $product->id));
                        $totals[$key]['total_purchases_cost'] = ($totals[$key]['total_quantity_purchased'] * $product->purchase_price);
                        $totals[$key]['total_sales_value_of_purchases'] = ($totals[$key]['total_quantity_purchased'] * $product->sell_price);
                        $totals[$key]['expected_profit'] = ($totals[$key]['total_sales_value_of_purchases'] - $totals[$key]['total_purchases_cost']);

                        $totals[$key]['total_quantity_sold'] = array_sum(array_column($array_sales, $product->id));
                        $totals[$key]['total_sold_cost'] = ($totals[$key]['total_quantity_sold'] * $product->purchase_price);
                        $totals[$key]['total_value_of_sales'] = ($totals[$key]['total_quantity_sold'] * $product->sell_price);
                        $totals[$key]['actual_profit'] = ($totals[$key]['total_value_of_sales'] - $totals[$key]['total_sold_cost']);

                        $totals[$key]['total_quantity_remain'] = ($totals[$key]['total_quantity_purchased'] - $totals[$key]['total_quantity_sold']);
                        $totals[$key]['total_remain_cost'] = ($totals[$key]['total_quantity_remain'] * $product->purchase_price);
                        $totals[$key]['total_sales_value_of_remain'] = ($totals[$key]['total_quantity_remain'] * $product->sell_price);
                        $totals[$key]['expected_profit_of_remain'] = ($totals[$key]['total_sales_value_of_remain'] - $totals[$key]['total_remain_cost']);
                    }

                    if(count($warehouse->totals()->get()) > 0){
                        $warehouse->totals()->delete();
                        $warehouse->totals()->createMany($totals);
                    }elseif(count($warehouse->totals()->get()) == 0){
                        $warehouse->totals()->createMany($totals);
                    }

                    foreach ( $totals as $total){
                        $product = Product::where('id', $total['product_id'])->get()->first();
                        $warehouseTotal = WarehouseTotal::where(['product_id'=> $total['product_id'], 'warehouse_id' => $total['warehouse_id']])->pluck('id');
                        $product->warehouseTotal()->attach($warehouseTotal);
                    }
                }else{
                    $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.purchase_invoice_received')]);
                }
            }
        }else{
            $salesInvoice = SalesInvoice::find($salesInvoice_id); //Single Delete

            if($salesInvoice->receiving_status == '1'){
                if(count($salesInvoice->salesInvoiceAttachments) >= 1){

                    $folder_date = $salesInvoice->created_at->format('m-Y');
                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folder_date.'/'.$salesInvoice->inv_number);
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
                $salesInvoice->delete();
                $this->resetPage();

                $warehouse = Warehouse::where('id',$salesInvoice->warehouse_id)->first();
                $allProducts = Product::all();
                $product_id_purchases = WarehousePurchaseDetail::where(['warehouse_id'=> $warehouse->id, 'receiving_status' => 2])->pluck('product_id')->toArray();
                $quantities_purchases = WarehousePurchaseDetail::where(['warehouse_id'=> $warehouse->id, 'receiving_status' => 2])->pluck('quantity')->toArray();
                $array_purchases = array_map(function($key, $val) {return array($key=>$val);}, $product_id_purchases, $quantities_purchases);

                $product_id_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('product_id')->toArray();
                $quantities_sales = WarehouseSalesDetail::where('warehouse_id', $warehouse->id)->pluck('quantity')->toArray();
                $array_sales = array_map(function($key, $val) {return array($key=>$val);}, $product_id_sales, $quantities_sales);

                $totals = [];
                foreach ($allProducts as $key => $product) {
                    $totals[$key]['warehouse_id'] = $warehouse->id;
                    $totals[$key]['product_id'] = $product->id;

                    $totals[$key]['total_quantity_purchased'] = array_sum(array_column($array_purchases, $product->id));
                    $totals[$key]['total_purchases_cost'] = ($totals[$key]['total_quantity_purchased'] * $product->purchase_price);
                    $totals[$key]['total_sales_value_of_purchases'] = ($totals[$key]['total_quantity_purchased'] * $product->sell_price);
                    $totals[$key]['expected_profit'] = ($totals[$key]['total_sales_value_of_purchases'] - $totals[$key]['total_purchases_cost']);

                    $totals[$key]['total_quantity_sold'] = array_sum(array_column($array_sales, $product->id));
                    $totals[$key]['total_sold_cost'] = ($totals[$key]['total_quantity_sold'] * $product->purchase_price);
                    $totals[$key]['total_value_of_sales'] = ($totals[$key]['total_quantity_sold'] * $product->sell_price);
                    $totals[$key]['actual_profit'] = ($totals[$key]['total_value_of_sales'] - $totals[$key]['total_sold_cost']);

                    $totals[$key]['total_quantity_remain'] = ($totals[$key]['total_quantity_purchased'] - $totals[$key]['total_quantity_sold']);
                    $totals[$key]['total_remain_cost'] = ($totals[$key]['total_quantity_remain'] * $product->purchase_price);
                    $totals[$key]['total_sales_value_of_remain'] = ($totals[$key]['total_quantity_remain'] * $product->sell_price);
                    $totals[$key]['expected_profit_of_remain'] = ($totals[$key]['total_sales_value_of_remain'] - $totals[$key]['total_remain_cost']);
                }

                if(count($warehouse->totals()->get()) > 0){
                    $warehouse->totals()->delete();
                    $warehouse->totals()->createMany($totals);
                }elseif(count($warehouse->totals()->get()) == 0){
                    $warehouse->totals()->createMany($totals);
                }

                foreach ( $totals as $total){
                    $product = Product::where('id', $total['product_id'])->get()->first();
                    $warehouseTotal = WarehouseTotal::where(['product_id'=> $total['product_id'], 'warehouse_id' => $total['warehouse_id']])->pluck('id');
                    $product->warehouseTotal()->attach($warehouseTotal);
                }
            }else{
                $this->dispatchBrowserEvent('MsgError', ['title' => trans('applang.purchase_invoice_received')]);
            }
        }
    }

    public function CancelDeleted($salesInvoice_id)
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
        $this->filterByClient = null;
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

        return view('livewire.erp.sales.sales-invoices.sales-invoices',[
            'salesInvoices' => $this->salesInvoices,
            'warehouses' => Warehouse::all(),
            'clients' => Client::all(),
            'currency_symbol' => $this->currency_symbol,
        ]);
    }

    public function getSalesInvoicesProperty(){
        return $this->salesInvoicesQuery->paginate($this->perPage);
    }

    public function getSalesInvoicesQueryProperty()
    {
        return SalesInvoice::with(['user','salesInvoiceDetails','salesInvoiceTaxes','salesInvoiceAttachments'])
            ->when($this->filterByPaymentStatus, function ($query){
                $query->where('payment_status', $this->filterByPaymentStatus);
            })
            ->when($this->filterByReceivingStatus, function ($query){
                $query->where('receiving_status', $this->filterByReceivingStatus);
            })
            ->when($this->filterByWarehouse, function ($query){
                $query->whereHas('warehouse', function ($q){
                    $q->where('warehouse_id', $this->filterByWarehouse);
                });
            })
            ->when($this->filterByClient, function ($query){
                $query->whereHas('client', function ($q){
                    $q->where('client_id', $this->filterByClient);
                });
            })
            ->when($this->filterByIssueDateStart, function ($query){
                $query->whereBetween('issue_date', [$this->filterByIssueDateStart, $this->filterByIssueDateEnd]);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }
}
