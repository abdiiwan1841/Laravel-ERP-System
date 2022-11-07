<?php

namespace App\Http\Controllers\ERP\Purchases;

use App\Http\Controllers\Controller;
use App\Mail\SendPurchaseInvoice;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoiceAttachments;
use App\Models\ERP\Purchases\PurchaseInvoiceDetails;
use App\Models\ERP\Purchases\PurchaseInvoicePayment;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PDF;

class PurchaseInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.purchase_invoices') ],
        ];

        return view('erp.purchases.purchase_invoices.index')->with([
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.purchase_invoices'), "link" => route('purchase-invoices.index') ],
            ["name" => trans('applang.add_purchase_invoice')],
        ];
        return view('erp.purchases.purchase_invoices.create')->with([
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "supplier_id" => ['required'],
            "issue_date" => ['required'],
            "due_date" => ['required','date', 'date_format:Y-m-d' ,'after_or_equal:issue_date'],
            "discount" => [],
            "discount_type" => ['required_with:discount'],
            "down_payment" => [],
            "down_payment_type" => ['required_with:down_payment'],
            "deposit_payment_method" => ['required_with:down_payment'],
            "deposit_transaction_id" => ['required_with:down_payment'],
            "warehouse_id" => ['required'],
            "paid_to_supplier_inv" => [],
            "payment_payment_method" => ['required_with:paid_to_supplier_inv'],
            "payment_transaction_id" => ['required_with:payment_payment_method'],
        ],[
            "due_date.after_or_equal"=> trans('applang.due_date_validation'),
            "supplier_id.required" => trans('applang.supplier_validation'),
            "warehouse_id.required" => trans('applang.warehouses_validation'),
            "discount_type.required_with" => trans('applang.discount_type_validation'),
            "down_payment_type.required_with" => trans('applang.down_payment_type_validation'),
            "deposit_payment_method.required_with" => trans('applang.deposit_payment_method_validation'),
            "deposit_transaction_id.required_with" => trans('applang.deposit_transaction_id_validation'),
            "payment_payment_method.required_with" => trans('applang.payment_payment_method_validation'),
            "payment_transaction_id.required_with" => trans('applang.payment_transaction_id_validation'),
        ]);

        $data["supplier_id"] = $request->supplier_id;
        $data["inv_number"] = $request->inv_number;
        $data["issue_date"] = $request->issue_date;
        $data["due_date"] = $request->due_date;
        $data["subtotal"] = $request->subtotal;
        $data["discount_inv"] = $request->discount_inv;
        $data["shipping_expense_inv"] = $request->shipping_expense_inv;
        $data["total_inv"] = $request->total_inv;
        $data["down_payment_inv"] = $request->down_payment_inv;
        $data["due_amount"] = $request->due_amount;
        $data["discount"] = $request->discount;
        $data["discount_type"] = $request->discount_type;
        $data["down_payment"] = $request->down_payment;
        $data["down_payment_type"] = $request->down_payment_type;
        $data["deposit_payment_method"] = $request->deposit_payment_method;
        $data["deposit_transaction_id"] = $request->deposit_transaction_id;
        $data["warehouse_id"] = $request->warehouse_id;
        $data["shipping_expense"] = $request->shipping_expense;
        $data["notes"] = $request->notes;
        $data["payment_payment_method"] = $request->payment_payment_method;
        $data["payment_transaction_id"] = $request->payment_transaction_id;
        $data["paid_to_supplier_inv"] = $request->paid_to_supplier_inv;
        $data["due_amount_after_paid"] = $request->due_amount_after_paid;
        $data["user_id"] = auth()->user()->id;
        $data["payment_status"] = $request->payment_status;
        $data["receiving_status"] = $request->receiving_status;

        $intSubTotal = (int)preg_replace("/[^0-9]/", "", $request->subtotal);

        if($intSubTotal > 0){
            $invoice = PurchaseInvoice::create($data);

            $products_data = [];
            for ($i = 0; $i < count($request->product_id); $i++) {
                $request->validate([
                    'product_id.'.$i => ['required'],
                    'description.'.$i => ['required'],
                    'quantity.'.$i => ['required'],
                    'unit_price.'.$i => ['required'],
                ], [
                    'product_id.'.$i.'.required' => trans('applang.product_id_required_item_number'). ($i+1),
                    'description.'.$i.'.required' => trans('applang.description_required_item_number'). ($i+1),
                    'quantity.'.$i.'.required' => trans('applang.quantity_required_item_number'). ($i+1),
                    'unit_price.'.$i.'.required' => trans('applang.unit_price_required_item_number'). ($i+1),
                ]);
                if($request->row_total[$i] != 0 || $request->row_total[$i] != '' && $request->unit_price[$i] != ''){
                    $products_data[$i]['product_id'] = $request->product_id[$i];
                    $products_data[$i]['description'] = $request->description[$i];
                    $products_data[$i]['unit_price'] = $request->unit_price[$i];
                    $products_data[$i]['quantity'] = $request->quantity[$i];
                    $products_data[$i]['first_tax_id'] = $request->first_tax_id[$i];
                    $products_data[$i]['second_tax_id'] = $request->second_tax_id[$i];
                    $products_data[$i]['row_total'] = $request->row_total[$i];
                }

                WarehousePurchaseDetail::create([
                   'warehouse_id' => $request->warehouse_id,
                   'purchase_invoice_id' => $invoice->id,
                   'product_id' => $request->product_id[$i],
                   'quantity' => $request->quantity[$i],
                   'unit_price' => $request->unit_price[$i],
                   'receiving_status' => 1
                ]);

                Product::where('id',$request->product_id[$i])->update([
                    'purchase_price' => $request->unit_price[$i]
                ]);
            }

            if(!empty($products_data)){
                $invoice->purchaseInvoiceDetails()->createMany($products_data);
            }

            $taxes_totals_data = [];
            for ($i = 0; $i < count($request->total_tax_inv); $i++) {
                if($request->total_tax_inv_sum[$i] != '0.00' && $request->total_tax_inv[$i] != '') {
                    $taxes_totals_data[$i]['total_tax_inv'] = $request->total_tax_inv[$i];
                    $taxes_totals_data[$i]['total_tax_inv_sum'] = $request->total_tax_inv_sum[$i];

                }
            }
            if(!empty($taxes_totals_data)){
                $invoice->purchaseInvoiceTaxes()->createMany($taxes_totals_data);
            }

            if($request->hasFile('attachments')){
                $files_data = [];
                for ($i = 0; $i < count($request->attachments); $i++) {
                    $file[$i] = $request->attachments[$i];
                    $file_name[$i] = $file[$i]->getClientOriginalName();
                    $files_data[$i]['attachments'] = $file_name[$i];

                    $invoice_number = $request->inv_number;
                    $date_folder = date('m-Y');

                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('uploads/purchase_invoices_attachments/'. $date_folder.'/'.$invoice_number);
                    $dateFolder = Storage::disk('public_uploads')->path('uploads/purchase_invoices_attachments/'.$date_folder);

                    //Check if the invoiceNumberFolder and dateFolder exists.
                    if (!File::exists($invoiceNumberFolder)) {
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }elseif(!File::exists($dateFolder)) {
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }else{
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }
                }

                $invoice->purchaseInvoiceAttachments()->createMany($files_data);
            }

            $warehouse = Warehouse::where('id',$request->warehouse_id)->first();
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

            return redirect()->route('purchase-invoices.index')->with('success', trans('applang.purchase_invoice_created_success'));
        }else{
            return redirect()->back()->with('MsgError', trans('applang.none_value_invoice'));
        }


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.purchase_invoices'), "link" => route('purchase-invoices.index') ],
            ["name" => trans('applang.show_purchase_invoice').' # ('.$purchaseInvoice->inv_number.')'],
        ];

        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }

        $employees = User::all();

        return view('erp.purchases.purchase_invoices.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'purchaseInvoice' => $purchaseInvoice,
            'currency_symbol' => $currency_symbol,
            'employees' => $employees
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.purchase_invoices'), "link" => route('purchase-invoices.index') ],
            ["name" => trans('applang.edit_purchase_invoice')],
        ];

        if($purchaseInvoice->receiving_status == '1'){
            return view('erp.purchases.purchase_invoices.edit')->with([
                'breadcrumbs' => $breadcrumbs,
                'purchaseInvoice' => $purchaseInvoice
            ]);
        }else{
            return redirect()->back()->with('MsgError', trans('applang.purchase_invoice_received'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchaseInvoice = PurchaseInvoice::whereId($id)->first();

            $request->validate([
            "supplier_id" => ['required'],
            "issue_date" => ['required'],
            "due_date" => ['required','date', 'date_format:Y-m-d' ,'after_or_equal:issue_date'],
            "discount" => [],
            "discount_type" => ['required_with:discount'],
            "down_payment" => [],
            "down_payment_type" => ['required_with:down_payment'],
            "deposit_payment_method" => ['required_with:down_payment'],
            "deposit_transaction_id" => ['required_with:down_payment'],
            "warehouse_id" => ['required'],
            "paid_to_supplier_inv" => [],
            "payment_payment_method" => ['required_with:paid_to_supplier_inv'],
            "payment_transaction_id" => ['required_with:payment_payment_method'],
        ],[
            "due_date.after_or_equal"=> trans('applang.due_date_validation'),
            "supplier_id.required" => trans('applang.supplier_validation'),
            "warehouse_id.required" => trans('applang.warehouses_validation'),
            "discount_type.required_with" => trans('applang.discount_type_validation'),
            "down_payment_type.required_with" => trans('applang.down_payment_type_validation'),
            "deposit_payment_method.required_with" => trans('applang.deposit_payment_method_validation'),
            "deposit_transaction_id.required_with" => trans('applang.deposit_transaction_id_validation'),
            "payment_payment_method.required_with" => trans('applang.payment_payment_method_validation'),
            "payment_transaction_id.required_with" => trans('applang.payment_transaction_id_validation'),
        ]);

        $data["supplier_id"] = $request->supplier_id;
        $data["inv_number"] = $request->inv_number;
        $data["issue_date"] = $request->issue_date;
        $data["due_date"] = $request->due_date;
        $data["subtotal"] = $request->subtotal;
        $data["discount_inv"] = $request->discount_inv;
        $data["shipping_expense_inv"] = $request->shipping_expense_inv;
        $data["total_inv"] = $request->total_inv;
        $data["down_payment_inv"] = $request->down_payment_inv;
        $data["due_amount"] = $request->due_amount;
        $data["discount"] = $request->discount;
        $data["discount_type"] = $request->discount_type;
        $data["down_payment"] = $request->down_payment;
        $data["down_payment_type"] = $request->down_payment_type;
        $data["deposit_payment_method"] = $request->deposit_payment_method;
        $data["deposit_transaction_id"] = $request->deposit_transaction_id;
        $data["warehouse_id"] = $request->warehouse_id;
        $data["shipping_expense"] = $request->shipping_expense;
        $data["notes"] = $request->notes;
        $data["payment_payment_method"] = $request->payment_payment_method;
        $data["payment_transaction_id"] = $request->payment_transaction_id;
        $data["paid_to_supplier_inv"] = $request->paid_to_supplier_inv;
        $data["due_amount_after_paid"] = $request->due_amount_after_paid;
        $data["user_id"] = auth()->user()->id;
        $data["payment_status"] = $request->payment_status;
        $data["receiving_status"] = $request->receiving_status;

        $intSubTotal = (int)preg_replace("/[^0-9]/", "", $request->subtotal);
        if($intSubTotal > 0) {
            $purchaseInvoice->update($data);
            $purchaseInvoice->purchaseInvoiceDetails()->delete();
            $purchaseInvoice->purchaseInvoiceTaxes()->delete();

            $products_data = [];
            for ($i = 0; $i < count($request->product_id); $i++) {
                $request->validate([
                    'product_id.'.$i => ['required'],
                    'description.'.$i => ['required'],
                    'quantity.'.$i => ['required'],
                    'unit_price.'.$i => ['required'],
                ], [
                    'product_id.'.$i.'.required' => trans('applang.product_id_required_item_number'). ($i+1),
                    'description.'.$i.'.required' => trans('applang.description_required_item_number'). ($i+1),
                    'quantity.'.$i.'.required' => trans('applang.quantity_required_item_number'). ($i+1),
                    'unit_price.'.$i.'.required' => trans('applang.unit_price_required_item_number'). ($i+1),
                ]);
                if($request->row_total[$i] != 0 || $request->row_total[$i] != '' && $request->unit_price[$i] != ''){
                    $products_data[$i]['product_id'] = $request->product_id[$i];
                    $products_data[$i]['description'] = $request->description[$i];
                    $products_data[$i]['unit_price'] = $request->unit_price[$i];
                    $products_data[$i]['quantity'] = $request->quantity[$i];
                    $products_data[$i]['first_tax_id'] = $request->first_tax_id[$i];
                    $products_data[$i]['second_tax_id'] = $request->second_tax_id[$i];
                    $products_data[$i]['row_total'] = $request->row_total[$i];

                }

                WarehousePurchaseDetail::where('warehouse_id', $request->warehouse_id)->firstOrCreate([
                    'warehouse_id' => $request->warehouse_id,
                    'purchase_invoice_id' => $purchaseInvoice->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'receiving_status' => 1
                ]);

                Product::where('id',$request->product_id[$i])->update([
                    'purchase_price' => $request->unit_price[$i]
                ]);
            }


            if(!empty($products_data)){
                $purchaseInvoice->purchaseInvoiceDetails()->createMany($products_data);
            }

            $taxes_totals_data = [];
            for ($i = 0; $i < count($request->total_tax_inv); $i++) {
                if($request->total_tax_inv_sum[$i] != '0.00' && $request->total_tax_inv[$i] != '') {
                    $taxes_totals_data[$i]['total_tax_inv'] = $request->total_tax_inv[$i];
                    $taxes_totals_data[$i]['total_tax_inv_sum'] = $request->total_tax_inv_sum[$i];
                }
            }
            if(!empty($taxes_totals_data)){
                $purchaseInvoice->purchaseInvoiceTaxes()->createMany($taxes_totals_data);
            }

            if($request->hasFile('attachments')){
                $invAttachments = $purchaseInvoice->purchaseInvoiceAttachments()->get()->pluck('attachments')->toArray();
                foreach($invAttachments as $invDoc){
                    foreach($request->attachments as $reqFile){
                        if($reqFile->getClientOriginalName() == $invDoc){
//                        PurchaseInvoiceAttachments::where('attachments' , $invDoc)->delete();
                            return redirect()->back()->with('MsgError', trans('applang.same_file_name'));
                        }
                    }
                }

                $files_data = [];
                for ($i = 0; $i < count($request->attachments); $i++) {
                    $file[$i] = $request->attachments[$i];
                    $file_name[$i] = $file[$i]->getClientOriginalName();
                    $files_data[$i]['attachments'] = $file_name[$i];

                    $invoice_number = $request->inv_number;
                    $date_folder = date('m-Y');

                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('uploads/purchase_invoices_attachments/'. $date_folder.'/'.$invoice_number);
                    $dateFolder = Storage::disk('public_uploads')->path('uploads/purchase_invoices_attachments/'.$date_folder);

                    //Check if the invoiceNumberFolder and dateFolder exists.
                    if (!File::exists($invoiceNumberFolder)) {
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }elseif(!File::exists($dateFolder)) {
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }else{
                        $file[$i]->move(public_path('uploads/purchase_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }
                }

                $purchaseInvoice->purchaseInvoiceAttachments()->createMany($files_data);
            }

            $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
            $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
            if($purchaseInvoice->paid_to_supplier_inv == null){
                $completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
                $allPayments = $down_payment+(int)array_sum($completedPayments);
                $invoiceValue = (int)$purchaseInvoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
                $purchaseInvoice->update([
                    'payments_total' => (int)array_sum($completedPayments),
                    'due_amount_after_payments' => $due_after_payments
                ]);
            }else{
                $allPayments = $paid_to_supplier_inv;
                $invoiceValue = (int)$purchaseInvoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
            }

            if($purchaseInvoice->due_amount_after_payments == $purchaseInvoice->total_inv){
                $purchaseInvoice->update([
                    'payment_status' => 1,
                ]);
            }elseif($purchaseInvoice->due_amount_after_payments > 0.00 && $purchaseInvoice->due_amount_after_payments < $purchaseInvoice->total_inv){
                $purchaseInvoice->update([
                    'payment_status' => 2,
                ]);
            }elseif($purchaseInvoice->due_amount_after_payments == 0.00){
                $purchaseInvoice->update([
                    'payment_status' => 3,
                ]);
            }

            $warehouse = Warehouse::where('id',$request->warehouse_id)->first();
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
            return redirect()->back()->with('success', trans('applang.purchase_invoice_updated_success'));
        }else{
            return redirect()->back()->with('MsgError', trans('applang.none_value_invoice'));
        }

    }

    public function filePreview($folderDate, $invoiceNumber, $fileName)
    {
//        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
//        return response()->file($file);
        $file = Storage::disk('public_uploads')->path('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
        return response()->file($file);
    }

    public function fileDownload($folderDate, $invoiceNumber, $fileName)
    {
//        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
        return Storage::disk('public_uploads')->download('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
    }

    public function invoicePreview($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.purchases.purchase_invoices.purchase_invoice_preview')->with([
            'purchaseInvoice' => $purchaseInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function invoicePrint($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.purchases.purchase_invoices.purchase_invoice_print')->with([
            'purchaseInvoice' => $purchaseInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function invoicePDF($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['purchaseInvoice'] = $purchaseInvoice;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $image = $companyData->logo;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $logo = file_get_contents(base_path('public/uploads/logo_image/'.$image));
        $logoPath = 'data:image/' . $type . ';base64,' . base64_encode($logo);
        $data['logoPath'] = $logoPath;

        $pdf = PDF::loadView('erp.purchases.purchase_invoices.purchase_invoice_pdf', $data);
        return $pdf->stream($purchaseInvoice->inv_number.'.pdf');
    }

    public function createInvoiceBarcodePDF($id)
    {
        $purchaseInvoice = PurchaseInvoice::whereId($id)->with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->first();
//        dd($purchaseInvoice);
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') , 'link' => route('purchase-invoices.index')],
            ["name" => trans('applang.show_purchase_invoice'). '# (' . $purchaseInvoice->inv_number . ')', "link" => route('purchase-invoices.show', $id) ],
            ["name" => trans('applang.create_purchase_invoice_barcode_pdf').trans('applang.purchase_invoice') . ' # (' . $purchaseInvoice->inv_number . ')'],
        ];

        return view('erp.purchases.purchase_invoices.purchase_invoice_create_pdf_barcode')->with([
            'breadcrumbs' => $breadcrumbs,
            'purchaseInvoice' => $purchaseInvoice
        ]);
    }

    public function invoiceBarcodePDF(Request $request)
    {
        $companyData = GeneralSetting::all()->first();
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $product_id = $request->product_id;
        $product= Product::whereId($product_id)->first();
        $barcode = $product->barcode;
        $type = pathinfo($barcode, PATHINFO_EXTENSION);
        $image = file_get_contents(base_path('public/uploads/products/barcodes/'.$barcode));
        $barcodePath = 'data:image/' . $type . ';base64,' . base64_encode($image);
        $data['barcodePath'] = $barcodePath;
        $data['product_sku'] = $product->sku;
        $data['product_name'] = $product->name;
        $data['print_qty'] = $request->print_qty;

        $pdf = PDF::loadView('erp.purchases.purchase_invoices.purchase_invoice_barcode_pdf', $data);
        return $pdf->stream($product->sku.'-barcode.pdf');
    }

    public function sentToEmail($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['purchaseInvoice'] = $purchaseInvoice;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $image = $companyData->logo;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $logo = file_get_contents(base_path('public/uploads/logo_image/'.$image));
        $logoPath = 'data:image/' . $type . ';base64,' . base64_encode($logo);
        $data['logoPath'] = $logoPath;

        $pdf = PDF::loadView('erp.purchases.purchase_invoices.purchase_invoice_pdf', $data);
        $pdf->save(public_path('uploads/purchase-invoices-pdf/').$purchaseInvoice->inv_number.'.pdf');

        Mail::to($purchaseInvoice->supplier->email)->locale(config('app.locale'))->send(new SendPurchaseInvoice($purchaseInvoice));
        return redirect()->route('purchase-invoices.index')->with('success', trans('applang.purchase_invoice_send_success'));
    }

    public function addPaymentTransaction($id)
    {
        $purchaseInvoice = PurchaseInvoice::whereId($id)->with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes', 'payments')->first();

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        if($purchaseInvoice->paid_to_supplier_inv == null){
            $completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        $employees = User::all();
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') , 'link' => route('purchase-invoices.index')],
            ["name" => trans('applang.show_purchase_invoice'). '# (' . $purchaseInvoice->inv_number . ')', "link" => route('purchase-invoices.show', $id) ],
            ["name" => trans('applang.add_payment_transaction').' '.trans('applang.purchase_invoice') . ' # (' . $purchaseInvoice->inv_number . ')'],
        ];

        return view('erp.purchases.purchase_invoices.purchase_invoice_add_payment')->with([
            'breadcrumbs' => $breadcrumbs,
            'purchaseInvoice' => $purchaseInvoice,
            'employees' => $employees,
            'due_after_payments' => $due_after_payments
        ]);
    }

    public function storePaymentTransaction(Request $request)
    {
        $purchaseInvoice = PurchaseInvoice::whereId($request->purchaseInvoice_id)->first();
//        $due_amount = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->due_amount);

        $request->validate([
           'deposit_payment_method' => ['required'],
           'payment_amount' => ['required'],
           'payment_date' => ['required'],
           'payment_status' => ['required'],
           'collected_by_id' => ['required'],
           'transaction_id' => ['required'],
        ]);
        $data = [];
        $data['purchase_invoice_id'] = $request->purchaseInvoice_id;
        $data['deposit_payment_method'] = $request->deposit_payment_method;
        $data['payment_amount'] = $request->payment_amount;
        $data['payment_date'] = $request->payment_date;
        $data['payment_status'] = $request->payment_status;
        $data['collected_by_id'] = $request->collected_by_id;
        $data['transaction_id'] = $request->transaction_id;
        $data['receipt_notes'] = $request->receipt_notes;

        $payment = PurchaseInvoicePayment::create($data);

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        if($purchaseInvoice->paid_to_supplier_inv == null){
            $completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $purchaseInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($purchaseInvoice->due_amount_after_payments == $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments > 0.00 && $purchaseInvoice->due_amount_after_payments < $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments == 0.00){
            $purchaseInvoice->update([
                'payment_status' => 3,
            ]);
        }

        return redirect()->route('purchase-invoices.show', $purchaseInvoice->id)->with('success', trans('applang.payment_added_success'));
    }

    public function showDownPaymentResponse($id)
    {
        $purchaseInvoice = PurchaseInvoice::find($id);
        return response()->json([
            'purchaseInvoice' => $purchaseInvoice,
            'down_payment_amount' => (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv),
            'user' => $purchaseInvoice->user->first_name .' '.$purchaseInvoice->user->last_name
        ]);
    }

    public function showPaymentTransactionResponse($id)
    {
        $payment = PurchaseInvoicePayment::find($id);
        return response()->json([
            'payment' => $payment,
            'user' => $payment->employee->first_name .' '.$payment->employee->last_name
        ]);
    }

    public function editPaymentTransactionResponse($id)
    {
        $payment = PurchaseInvoicePayment::find($id);
        return response()->json([
            'paymentEdit' => $payment,
            'userEdit' => $payment->employee->first_name .' '.$payment->employee->last_name
        ]);
    }

    public function updatePaymentTransaction(Request $request)
    {
        $purchaseInvoice = PurchaseInvoice::find($request->purchase_invoice_id);
//        dd($purchaseInvoice);
        $payment = PurchaseInvoicePayment::find($request->id);
        $request->validate([
            'deposit_payment_method' => ['required'],
            'payment_amount' => ['required'],
            'payment_date' => ['required'],
            'payment_status' => ['required'],
            'collected_by_id' => ['required'],
            'transaction_id' => ['required'],
        ]);
        $data = [
            'deposit_payment_method' => $request->deposit_payment_method,
            'payment_amount' => $request->payment_amount,
            'payment_date' => $request->payment_date,
            'payment_status' => $request->payment_status,
            'collected_by_id' => $request->collected_by_id,
            'transaction_id' => $request->transaction_id,
            'receipt_notes' => $request->receipt_notes,
        ];
        $payment->update($data);

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        if($purchaseInvoice->paid_to_supplier_inv == null){
            $completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $purchaseInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($purchaseInvoice->due_amount_after_payments == $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments > 0.00 && $purchaseInvoice->due_amount_after_payments < $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments == 0.00){
            $purchaseInvoice->update([
                'payment_status' => 3,
            ]);
        }
        return redirect()->back()->with('success', trans('applang.payment_updated_success'));
    }

    public function completePaymentTransaction($id)
    {
        $payment = PurchaseInvoicePayment::find($id);
        $purchaseInvoice = $payment->purchaseInvoice;
        $payment->update([
           'payment_status'  => 'completed'
        ]);

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        if($purchaseInvoice->paid_to_supplier_inv == null){
            $completedPayments = PurchaseInvoicePayment::where(['purchase_invoice_id'=> $purchaseInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $purchaseInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$purchaseInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($purchaseInvoice->due_amount_after_payments == $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments > 0.00 && $purchaseInvoice->due_amount_after_payments < $purchaseInvoice->total_inv){
            $purchaseInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($purchaseInvoice->due_amount_after_payments == 0.00){
            $purchaseInvoice->update([
                'payment_status' => 3,
            ]);
        }

        return response()->json([
            'paymentEdit' => $payment,
            'userEdit' => $payment->employee->first_name .' '.$payment->employee->last_name,
            'purchaseInvoice' => $purchaseInvoice
        ]);
    }

    public function paymentReceiptPrint($id)
    {
        $payment = PurchaseInvoicePayment::with('employee', 'purchaseInvoice')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.purchases.purchase_invoices.purchase_invoice_payment_receipt_print')->with([
            'payment' => $payment,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function paymentReceiptPrintResponse($id)
    {
        $payment = PurchaseInvoicePayment::with('employee', 'purchaseInvoice')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return response()->json([
            'status'=>true,
            "redirect_url"=>url('/'.app()->getLocale().'/erp/purchases/purchase-payment-receipt-print/'.$payment->id),
            'payment' => $payment,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function paymentReceiptPdf($id)
    {
        $payment = PurchaseInvoicePayment::with('employee', 'purchaseInvoice')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['payment'] = $payment;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;


        $pdf = PDF::loadView('erp.purchases.purchase_invoices.purchase_invoice_payment_receipt_pdf', $data);
        return $pdf->stream($payment->purchaseInvoice->inv_number.'_payment#'.$payment->id.'.pdf');
    }

    public function downPaymentReceiptPrint($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.purchases.purchase_invoices.purchase_invoice_down_payment_receipt_print')->with([
            'purchaseInvoice' => $purchaseInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol,
            'down_payment' => $down_payment
        ]);
    }

    public function downPaymentReceiptPdf($id)
    {
        $purchaseInvoice = PurchaseInvoice::with('supplier', 'purchaseInvoiceDetails', 'purchaseInvoiceTaxes')->find($id);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $purchaseInvoice->down_payment_inv);
        $companyData = GeneralSetting::all()->first();
        $data['purchaseInvoice'] = $purchaseInvoice;
        $data['companyData'] = $companyData;
        $data['down_payment'] = $down_payment;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;


        $pdf = PDF::loadView('erp.purchases.purchase_invoices.purchase_invoice_down_payment_receipt_pdf', $data);
        return $pdf->stream($purchaseInvoice->inv_number.'_down-payment#'.$purchaseInvoice->number.'.pdf');
    }
}
