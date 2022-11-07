<?php

namespace App\Http\Controllers\ERP\Sales;

use App\Http\Controllers\Controller;
use App\Mail\SendSalesInvoice;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Sales\SalesInvoicePayment;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Picqer;

class SalesInvoicesController extends Controller
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
            ["name" => trans('applang.sales')],
            ["name" => trans('applang.sales_invoices') ],
        ];

        return view('erp.sales.sales_invoices.index')->with([
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
            ["name" => trans('applang.sales')],
            ["name" => trans('applang.sales_invoices'), "link" => route('sales-invoices.index') ],
            ["name" => trans('applang.add_sales_invoice')],
        ];
        return view('erp.sales.sales_invoices.create')->with([
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
            "client_id" => ['required'],
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
            "client_id.required" => trans('applang.client_validation'),
            "warehouse_id.required" => trans('applang.warehouses_validation'),
            "discount_type.required_with" => trans('applang.discount_type_validation'),
            "down_payment_type.required_with" => trans('applang.down_payment_type_validation'),
            "deposit_payment_method.required_with" => trans('applang.deposit_payment_method_validation'),
            "deposit_transaction_id.required_with" => trans('applang.deposit_transaction_id_validation'),
            "payment_payment_method.required_with" => trans('applang.payment_payment_method_validation'),
            "payment_transaction_id.required_with" => trans('applang.payment_transaction_id_validation'),
        ]);

        $data["client_id"] = $request->client_id;
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
            $invoice = SalesInvoice::create($data);

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

                    WarehouseSalesDetail::create([
                        'warehouse_id' => $request->warehouse_id,
                        'sales_invoice_id' => $invoice->id,
                        'product_id' => $request->product_id[$i],
                        'quantity' => $request->quantity[$i],
                        'unit_price' => $request->unit_price[$i],
                    ]);

                    Product::where('id',$request->product_id[$i])->update([
                        'sell_price' => $request->unit_price[$i]
                    ]);

                }
            }

            if(!empty($products_data)){
                $invoice->salesInvoiceDetails()->createMany($products_data);
            }

            $taxes_totals_data = [];
            for ($i = 0; $i < count($request->total_tax_inv); $i++) {
                if($request->total_tax_inv_sum[$i] != '0.00' && $request->total_tax_inv[$i] != '') {
                    $taxes_totals_data[$i]['total_tax_inv'] = $request->total_tax_inv[$i];
                    $taxes_totals_data[$i]['total_tax_inv_sum'] = $request->total_tax_inv_sum[$i];

                }
            }
            if(!empty($taxes_totals_data)){
                $invoice->salesInvoiceTaxes()->createMany($taxes_totals_data);
            }

            if($request->hasFile('attachments')){
                $files_data = [];
                for ($i = 0; $i < count($request->attachments); $i++) {
                    $file[$i] = $request->attachments[$i];
                    $file_name[$i] = $file[$i]->getClientOriginalName();
                    $files_data[$i]['attachments'] = $file_name[$i];

                    $invoice_number = $request->inv_number;
                    $date_folder = date('m-Y');

                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('uploads/sales_invoices_attachments/'. $date_folder.'/'.$invoice_number);
                    $dateFolder = Storage::disk('public_uploads')->path('uploads/sales_invoices_attachments/'.$date_folder);

                    //Check if the invoiceNumberFolder and dateFolder exists.
                    if (!File::exists($invoiceNumberFolder)) {
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }elseif(!File::exists($dateFolder)) {
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }else{
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }
                }

                $invoice->salesInvoiceAttachments()->createMany($files_data);
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
            return redirect()->route('sales-invoices.index')->with('success', trans('applang.sales_invoice_created_success'));
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
    public function show(SalesInvoice $salesInvoice)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sales')],
            ["name" => trans('applang.sales_invoices'), "link" => route('sales-invoices.index') ],
            ["name" => trans('applang.show_sales_invoice').' # ('.$salesInvoice->inv_number.')'],
        ];

        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }

        $employees = User::all();

        return view('erp.sales.sales_invoices.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'salesInvoice' => $salesInvoice,
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
    public function edit(SalesInvoice $salesInvoice)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sales')],
            ["name" => trans('applang.sales_invoices'), "link" => route('sales-invoices.index') ],
            ["name" => trans('applang.edit_sales_invoice')],
        ];

        if($salesInvoice->receiving_status == '1'){
            return view('erp.sales.sales_invoices.edit')->with([
                'breadcrumbs' => $breadcrumbs,
                'salesInvoice' => $salesInvoice
            ]);
        }else{
            return redirect()->back()->with('MsgError', trans('applang.sales_invoice_received'));
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
        $salesInvoice = SalesInvoice::whereId($id)->first();

        $request->validate([
            "client_id" => ['required'],
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
            "client_id.required" => trans('applang.client_validation'),
            "warehouse_id.required" => trans('applang.warehouses_validation'),
            "discount_type.required_with" => trans('applang.discount_type_validation'),
            "down_payment_type.required_with" => trans('applang.down_payment_type_validation'),
            "deposit_payment_method.required_with" => trans('applang.deposit_payment_method_validation'),
            "deposit_transaction_id.required_with" => trans('applang.deposit_transaction_id_validation'),
            "payment_payment_method.required_with" => trans('applang.payment_payment_method_validation'),
            "payment_transaction_id.required_with" => trans('applang.payment_transaction_id_validation'),
        ]);

        $data["client_id"] = $request->client_id;
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
            $salesInvoice->update($data);
            $salesInvoice->salesInvoiceDetails()->delete();
            $salesInvoice->salesInvoiceTaxes()->delete();

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

                    WarehouseSalesDetail::where('warehouse_id', $request->warehouse_id)->firstOrCreate([
                        'warehouse_id' => $request->warehouse_id,
                        'sales_invoice_id' => $salesInvoice->id,
                        'product_id' => $request->product_id[$i],
                        'quantity' => $request->quantity[$i],
                        'unit_price' => $request->unit_price[$i],
                    ]);

                    Product::where('id',$request->product_id[$i])->update([
                        'sell_price' => $request->unit_price[$i]
                    ]);
                }
            }

            if(!empty($products_data)){
                $salesInvoice->salesInvoiceDetails()->createMany($products_data);
            }

            $taxes_totals_data = [];
            for ($i = 0; $i < count($request->total_tax_inv); $i++) {
                if($request->total_tax_inv_sum[$i] != '0.00' && $request->total_tax_inv[$i] != '') {
                    $taxes_totals_data[$i]['total_tax_inv'] = $request->total_tax_inv[$i];
                    $taxes_totals_data[$i]['total_tax_inv_sum'] = $request->total_tax_inv_sum[$i];

                }
            }
            if(!empty($taxes_totals_data)){
                $salesInvoice->salesInvoiceTaxes()->createMany($taxes_totals_data);
            }

            if($request->hasFile('attachments')){
                $invAttachments = $salesInvoice->salesInvoiceAttachments()->get()->pluck('attachments')->toArray();
                foreach($invAttachments as $invDoc){
                    foreach($request->attachments as $reqFile){
                        if($reqFile->getClientOriginalName() == $invDoc){
//                        SalesInvoiceAttachments::where('attachments' , $invDoc)->delete();
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

                    $invoiceNumberFolder = Storage::disk('public_uploads')->path('uploads/sales_invoices_attachments/'. $date_folder.'/'.$invoice_number);
                    $dateFolder = Storage::disk('public_uploads')->path('uploads/sales_invoices_attachments/'.$date_folder);

                    //Check if the invoiceNumberFolder and dateFolder exists.
                    if (!File::exists($invoiceNumberFolder)) {
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }elseif(!File::exists($dateFolder)) {
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }else{
                        $file[$i]->move(public_path('uploads/sales_invoices_attachments/' . $date_folder . '/' . $invoice_number), $file_name[$i]);
                    }
                }

                $salesInvoice->salesInvoiceAttachments()->createMany($files_data);
            }

            $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
            $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
            if($salesInvoice->paid_to_supplier_inv == null){
                $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
                $allPayments = $down_payment+(int)array_sum($completedPayments);
                $invoiceValue = (int)$salesInvoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
                $salesInvoice->update([
                    'payments_total' => (int)array_sum($completedPayments),
                    'due_amount_after_payments' => $due_after_payments
                ]);
            }else{
                $allPayments = $paid_to_supplier_inv;
                $invoiceValue = (int)$salesInvoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
            }

            if($salesInvoice->due_amount_after_payments == $salesInvoice->total_inv){
                $salesInvoice->update([
                    'payment_status' => 1,
                ]);
            }elseif($salesInvoice->due_amount_after_payments > 0.00 && $salesInvoice->due_amount_after_payments < $salesInvoice->total_inv){
                $salesInvoice->update([
                    'payment_status' => 2,
                ]);
            }elseif($salesInvoice->due_amount_after_payments == 0.00){
                $salesInvoice->update([
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
            return redirect()->back()->with('success', trans('applang.sales_invoice_updated_success'));
        }else{
            return redirect()->back()->with('MsgError', trans('applang.none_value_invoice'));
        }
    }

    public function filePreview($folderDate, $invoiceNumber, $fileName)
    {
//        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
//        return response()->file($file);
        $file = Storage::disk('public_uploads')->path('sales_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
        return response()->file($file);
    }

    public function fileDownload($folderDate, $invoiceNumber, $fileName)
    {
//        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('purchase_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
        return Storage::disk('public_uploads')->download('sales_invoices_attachments/'.$folderDate.'/'.$invoiceNumber.'/'.$fileName);
    }

    public function invoicePreview($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.sales.sales_invoices.sales_invoice_preview')->with([
            'salesInvoice' => $salesInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function invoicePrint($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.sales.sales_invoices.sales_invoice_print')->with([
            'salesInvoice' => $salesInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function invoicePDF($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $image = $companyData->logo;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $logo = file_get_contents(base_path('public/uploads/logo_image/'.$image));
        $logoPath = 'data:image/' . $type . ';base64,' . base64_encode($logo);
        $data['logoPath'] = $logoPath;

        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_pdf', $data);
        return $pdf->stream($salesInvoice->inv_number.'.pdf');
    }

    public function invoicePackageStickerPDF($salesInvoice_id)
    {
        $salesInvoice = SalesInvoice::whereId($salesInvoice_id)->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['invoice_items_quantities_total'] = array_sum($salesInvoice->salesInvoiceDetails->pluck('quantity')->toArray());

        $companyData = GeneralSetting::all()->first();
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $barcode_image = $salesInvoice->inv_number.'.jpg';
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('uploads/sales_vouchers/package_sticker/'.$barcode_image, $generator->getBarcode($salesInvoice->inv_number, $generator::TYPE_CODE_128, 3, 50));

        $type = pathinfo($barcode_image, PATHINFO_EXTENSION);
        $image = file_get_contents(base_path('public/uploads/sales_vouchers/package_sticker/'.$barcode_image));
        $barcodePath = 'data:image/' . $type . ';base64,' . base64_encode($image);
        $data['barcodePath'] = $barcodePath;

        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_package_sticker_pdf', $data);
        return $pdf->stream('package-sticker'.$salesInvoice->number.'.pdf');
    }

    public function invoiceReceiptListPDF($salesInvoice_id)
    {
        $salesInvoice = SalesInvoice::whereId($salesInvoice_id)->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['invoice_items_quantities_total'] = array_sum($salesInvoice->salesInvoiceDetails->pluck('quantity')->toArray());

        $companyData = GeneralSetting::all()->first();
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $barcode_image = $salesInvoice->inv_number.'.jpg';
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('uploads/sales_vouchers/receipt_list/'.$barcode_image, $generator->getBarcode($salesInvoice->inv_number, $generator::TYPE_CODE_128, 3, 50));

        $type = pathinfo($barcode_image, PATHINFO_EXTENSION);
        $image = file_get_contents(base_path('public/uploads/sales_vouchers/receipt_list/'.$barcode_image));
        $barcodePath = 'data:image/' . $type . ';base64,' . base64_encode($image);
        $data['barcodePath'] = $barcodePath;

        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_receipt_list_pdf', $data);
        return $pdf->stream('receipt-list'.$salesInvoice->number.'.pdf');
    }

    public function invoiceDeliveryStickerPDF($salesInvoice_id)
    {
        $salesInvoice = SalesInvoice::whereId($salesInvoice_id)->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['invoice_items_quantities_total'] = array_sum($salesInvoice->salesInvoiceDetails->pluck('quantity')->toArray());

        $companyData = GeneralSetting::all()->first();
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $barcode_image = $salesInvoice->inv_number.'.jpg';
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('uploads/sales_vouchers/delivery_stickers/'.$barcode_image, $generator->getBarcode($salesInvoice->inv_number, $generator::TYPE_CODE_128, 3, 50));

        $type = pathinfo($barcode_image, PATHINFO_EXTENSION);
        $image = file_get_contents(base_path('public/uploads/sales_vouchers/delivery_stickers/'.$barcode_image));
        $barcodePath = 'data:image/' . $type . ';base64,' . base64_encode($image);
        $data['barcodePath'] = $barcodePath;

        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_delivery_stickers_pdf', $data);
        return $pdf->stream('delivery-stickers'.$salesInvoice->number.'.pdf');
    }

    public function sentToEmail($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;

        $image = $companyData->logo;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $logo = file_get_contents(base_path('public/uploads/logo_image/'.$image));
        $logoPath = 'data:image/' . $type . ';base64,' . base64_encode($logo);
        $data['logoPath'] = $logoPath;

        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_pdf', $data);
        $pdf->save(public_path('uploads/sales-invoices-pdf/').$salesInvoice->inv_number.'.pdf');

        Mail::to($salesInvoice->client->email)->locale(config('app.locale'))->send(new SendSalesInvoice($salesInvoice));
        return redirect()->route('sales-invoices.index')->with('success', trans('applang.sales_invoice_send_success'));
    }

    public function addPaymentTransaction($id)
    {
        $salesInvoice = SalesInvoice::whereId($id)->with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes', 'payments')->first();

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        if($salesInvoice->paid_to_supplier_inv == null){
            $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        $employees = User::all();
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sales')],
            ["name" => trans('applang.sales') , 'link' => route('sales-invoices.index')],
            ["name" => trans('applang.show_sales_invoice'). '# (' . $salesInvoice->inv_number . ')', "link" => route('sales-invoices.show', $id) ],
            ["name" => trans('applang.add_payment_transaction').' '.trans('applang.purchase_invoice') . ' # (' . $salesInvoice->inv_number . ')'],
        ];

        return view('erp.sales.sales_invoices.sales_invoice_add_payment')->with([
            'breadcrumbs' => $breadcrumbs,
            'salesInvoice' => $salesInvoice,
            'employees' => $employees,
            'due_after_payments' => $due_after_payments
        ]);
    }

    public function storePaymentTransaction(Request $request)
    {
        $salesInvoice = SalesInvoice::whereId($request->salesInvoice_id)->first();
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
        $data['sales_invoice_id'] = $request->salesInvoice_id;
        $data['deposit_payment_method'] = $request->deposit_payment_method;
        $data['payment_amount'] = $request->payment_amount;
        $data['payment_date'] = $request->payment_date;
        $data['payment_status'] = $request->payment_status;
        $data['collected_by_id'] = $request->collected_by_id;
        $data['transaction_id'] = $request->transaction_id;
        $data['receipt_notes'] = $request->receipt_notes;

        $payment = SalesInvoicePayment::create($data);

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        if($salesInvoice->paid_to_supplier_inv == null){
            $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $salesInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($salesInvoice->due_amount_after_payments == $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($salesInvoice->due_amount_after_payments > 0.00 && $salesInvoice->due_amount_after_payments < $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($salesInvoice->due_amount_after_payments == 0.00){
            $salesInvoice->update([
                'payment_status' => 3,
            ]);
        }

        return redirect()->route('sales-invoices.show', $salesInvoice->id)->with('success', trans('applang.payment_added_success'));
    }

    public function showDownPaymentResponse($id)
    {
        $salesInvoice = SalesInvoice::find($id);
        return response()->json([
            'salesInvoice' => $salesInvoice,
            'down_payment_amount' => (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv),
            'user' => $salesInvoice->user->first_name .' '.$salesInvoice->user->last_name
        ]);
    }

    public function showPaymentTransactionResponse($id)
    {
        $payment = SalesInvoicePayment::find($id);
        return response()->json([
            'payment' => $payment,
            'user' => $payment->employee->first_name .' '.$payment->employee->last_name
        ]);
    }

    public function editPaymentTransactionResponse($id)
    {
        $payment = SalesInvoicePayment::find($id);
        return response()->json([
            'paymentEdit' => $payment,
            'userEdit' => $payment->employee->first_name .' '.$payment->employee->last_name
        ]);
    }

    public function updatePaymentTransaction(Request $request)
    {
        $salesInvoice = SalesInvoice::find($request->sales_invoice_id);
//        dd($purchaseInvoice);
        $payment = SalesInvoicePayment::find($request->id);
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

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        if($salesInvoice->paid_to_supplier_inv == null){
            $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $salesInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($salesInvoice->due_amount_after_payments == $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($salesInvoice->due_amount_after_payments > 0.00 && $salesInvoice->due_amount_after_payments < $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($salesInvoice->due_amount_after_payments == 0.00){
            $salesInvoice->update([
                'payment_status' => 3,
            ]);
        }
        return redirect()->back()->with('success', trans('applang.payment_updated_success'));
    }

    public function completePaymentTransaction($id)
    {
        $payment = SalesInvoicePayment::find($id);
        $salesInvoice = $payment->salesInvoice;
        $payment->update([
            'payment_status'  => 'completed'
        ]);

        $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $salesInvoice->paid_to_supplier_inv);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        if($salesInvoice->paid_to_supplier_inv == null){
            $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $salesInvoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
            $allPayments = $down_payment+(int)array_sum($completedPayments);
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
            $salesInvoice->update([
                'payments_total' => (int)array_sum($completedPayments),
                'due_amount_after_payments' => $due_after_payments
            ]);
        }else{
            $allPayments = $paid_to_supplier_inv;
            $invoiceValue = (int)$salesInvoice->total_inv;
            $due_after_payments = ($invoiceValue-$allPayments);
        }

        if($salesInvoice->due_amount_after_payments == $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 1,
            ]);
        }elseif($salesInvoice->due_amount_after_payments > 0.00 && $salesInvoice->due_amount_after_payments < $salesInvoice->total_inv){
            $salesInvoice->update([
                'payment_status' => 2,
            ]);
        }elseif($salesInvoice->due_amount_after_payments == 0.00){
            $salesInvoice->update([
                'payment_status' => 3,
            ]);
        }

        return response()->json([
            'paymentEdit' => $payment,
            'userEdit' => $payment->employee->first_name .' '.$payment->employee->last_name,
            'salesInvoice' => $salesInvoice
        ]);
    }

    public function paymentReceiptPrint($id)
    {
        $payment = SalesInvoicePayment::with('employee', 'salesInvoice')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.sales.sales_invoices.sales_invoice_payment_receipt_print')->with([
            'payment' => $payment,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function paymentReceiptPrintResponse($id)
    {
        $payment = SalesInvoicePayment::with('employee', 'salesInvoice')->find($id);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return response()->json([
            'status'=>true,
            "redirect_url"=>url('/'.app()->getLocale().'/erp/sales/sales-payment-receipt-print/'.$payment->id),
            'payment' => $payment,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol
        ]);
    }

    public function paymentReceiptPdf($id)
    {
        $payment = SalesInvoicePayment::with('employee', 'salesInvoice')->find($id);
        $companyData = GeneralSetting::all()->first();
        $data['payment'] = $payment;
        $data['companyData'] = $companyData;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;


        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_payment_receipt_pdf', $data);
        return $pdf->stream($payment->salesInvoice->inv_number.'_payment#'.$payment->id.'.pdf');
    }

    public function downPaymentReceiptPrint($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }
        return view('erp.sales.sales_invoices.sales_invoice_down_payment_receipt_print')->with([
            'salesInvoice' => $salesInvoice,
            'companyData' => $companyData,
            'currency_symbol' => $currency_symbol,
            'down_payment' => $down_payment
        ]);
    }

    public function downPaymentReceiptPdf($id)
    {
        $salesInvoice = SalesInvoice::with('client', 'salesInvoiceDetails', 'salesInvoiceTaxes')->find($id);
        $down_payment = (int)preg_replace("/[^0-9]/", "", $salesInvoice->down_payment_inv);
        $companyData = GeneralSetting::all()->first();
        $data['salesInvoice'] = $salesInvoice;
        $data['companyData'] = $companyData;
        $data['down_payment'] = $down_payment;
        $data['currency_symbol'] = app()->getLocale() == 'ar'? $companyData->basic_currency_symbol : $companyData->basic_currency;


        $pdf = PDF::loadView('erp.sales.sales_invoices.sales_invoice_down_payment_receipt_pdf', $data);
        return $pdf->stream($salesInvoice->inv_number.'_down-payment#'.$salesInvoice->number.'.pdf');
    }
}
