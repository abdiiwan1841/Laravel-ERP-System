<?php

namespace Database\Seeders;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Sales\SalesInvoiceDetails;
use App\Models\ERP\Sales\SalesInvoicePayment;
use App\Models\ERP\Sales\SalesInvoiceTaxes;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesInvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales_invoice_payments')->delete();
        DB::table('sales_invoice_taxes')->delete();
        DB::table('sales_invoice_details')->delete();
        DB::table('sales_invoices')->delete();

        SalesInvoice::factory(100)->create()->each(function ($p){
            $p->salesInvoiceDetails()->saveMany(SalesInvoiceDetails::factory(rand(1,4))->make());
            $p->salesInvoiceTaxes()->saveMany(SalesInvoiceTaxes::factory(1)->make());
            $p->payments()->saveMany(SalesInvoicePayment::factory(1)->make());
        });

        $salesInvoicesDetails = SalesInvoiceDetails::all();
        $salesInvoices = SalesInvoice::all();
        $issue_date = [
            '2022-01-08',
            '2022-01-10',
            '2022-01-11',
            '2022-01-17',
            '2022-01-18',
            '2022-01-26',
            '2022-01-31',
            '2022-02-01',
            '2022-02-07',
            '2022-02-10',
            '2022-02-15',
            '2022-02-18',
            '2022-02-19',
            '2022-02-23',
            '2022-02-27',
            '2022-03-01',
            '2022-03-02',
            '2022-03-06',
            '2022-03-10',
            '2022-03-10',
            '2022-03-12',
            '2022-03-15',
            '2022-03-20',
            '2022-04-01',
            '2022-04-04',
            '2022-04-06',
            '2022-04-13',
            '2022-04-15',
            '2022-04-29',
            '2022-04-29',
            '2022-04-30',
            '2022-05-01',
            '2022-05-09',
            '2022-05-20',
            '2022-05-21',
            '2022-05-26',
            '2022-05-27',
            '2022-05-29',
            '2022-05-31',
            '2022-06-01',
            '2022-06-05',
            '2022-06-15',
            '2022-06-24',
            '2022-06-26',
            '2022-06-27',
            '2022-06-28',
            '2022-06-30',
            '2022-07-01',
            '2022-07-10',
            '2022-07-17',
            '2022-07-19',
            '2022-07-19',
            '2022-07-20',
            '2022-07-25',
            '2022-07-31',
            '2022-08-01',
            '2022-08-05',
            '2022-08-09',
            '2022-08-10',
            '2022-08-11',
            '2022-08-13',
            '2022-08-19',
            '2022-08-27',
            '2022-09-01',
            '2022-09-08',
            '2022-09-10',
            '2022-09-12',
            '2022-09-15',
            '2022-09-15',
            '2022-09-19',
            '2022-09-25',
            '2022-09-30',
            '2022-10-01',
            '2022-10-02',
            '2022-10-16',
            '2022-10-18',
            '2022-10-19',
            '2022-10-24',
            '2022-10-26',
            '2022-10-31',
            '2022-11-01',
            '2022-11-10',
            '2022-11-12',
            '2022-11-20',
            '2022-11-22',
            '2022-11-25',
            '2022-11-27',
            '2022-11-28',
            '2022-11-28',
            '2022-11-30',
            '2022-12-01',
            '2022-12-06',
            '2022-12-11',
            '2022-12-18',
            '2022-12-22',
            '2022-12-25',
            '2022-12-28',
            '2022-12-28',
            '2022-12-29',
            '2022-12-30',
            '2022-12-31',
        ];
        $due_date = [
            '2022-06-17',
            '2022-05-29',
            '2022-05-30',
            '2022-06-14',
            '2022-06-15',
            '2022-06-15',
            '2022-06-13',
            '2022-05-23',
            '2022-06-08',
            '2022-05-26',
            '2022-06-07',
            '2022-06-08',
            '2022-06-03',
            '2022-05-27',
            '2022-06-06',
            '2022-05-30',
            '2022-06-14',
            '2022-05-17',
            '2022-05-25',
            '2022-05-22',
            '2022-05-20',
            '2022-05-28',
            '2022-06-06',
            '2022-05-31',
            '2022-06-12',
            '2022-06-05',
            '2022-06-15',
            '2022-05-28',
            '2022-05-29',
            '2022-05-26',
            '2022-05-22',
            '2022-05-22',
            '2022-05-21',
            '2022-06-16',
            '2022-06-05',
            '2022-05-20',
            '2022-06-04',
            '2022-06-09',
            '2022-06-12',
            '2022-06-30',
            '2022-06-30',
            '2022-06-30',
            '2022-06-30',
            '2022-06-30',
            '2022-06-30',
            '2022-06-30',
            '2022-07-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-08-31',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-09-30',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-10-31',
            '2022-11-30',
            '2022-11-30',
            '2022-11-30',
            '2022-12-31',
            '2022-12-31',
            '2022-12-31',
            '2022-11-30',
            '2022-11-30',
            '2022-12-31',
            '2022-12-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
            '2023-01-31',
        ];

        foreach ($salesInvoicesDetails as $detail){
            $detail->update([
                'row_total' => ($detail->quantity * $detail->unit_price)
            ]);
        }

        foreach ($salesInvoices as $key => $invoice){
            $subtotal = array_sum(SalesInvoiceDetails::where('sales_invoice_id', $invoice->id)->pluck('row_total')->toArray());
            $valueAddTax = $subtotal * 0.14;
            $total_inv = $subtotal + $valueAddTax;
            $invoice->update([
                'issue_date' => $issue_date[$key],
                'due_date' => $due_date[$key],
                'subtotal' => $subtotal . ' ' . 'ج.م.',
                'total_inv' => $total_inv,
                'due_amount' => $total_inv . ' ' . 'ج.م.'
            ]);

            SalesInvoiceTaxes::where('sales_invoice_id', $invoice->id)->update([
                'sales_invoice_id' => $invoice->id,
                'total_tax_inv' => 'القيمة المضافة (14%)',
                'total_tax_inv_sum' => $valueAddTax . ' ' . 'ج.م.'
            ]);

            foreach ($invoice->salesInvoiceDetails as $key => $detail){
                WarehouseSalesDetail::create([
                    'warehouse_id' => $invoice->warehouse_id,
                    'sales_invoice_id' => $invoice->id,
                    'product_id' => $detail->product_id,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->unit_price,
                ]);

                Product::where('id',$detail->product_id)->update([
                    'sell_price' => $detail->unit_price
                ]);
            }

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
        }

        $partiallyPaidInvoices = SalesInvoice::inRandomOrder()->whereBetween('id', [1, 50])->limit(35)->get();
        $totallyPaidInvoices = SalesInvoice::inRandomOrder()->whereBetween('id', [51, 100])->limit(30)->get();

        foreach ($partiallyPaidInvoices as $invoice){
            foreach ($invoice->payments as $payment){
                $payment->update([
                    'sales_invoice_id' => $invoice->id,
                    'payment_amount' => $invoice->total_inv * 0.25,
                    'payment_date' => $invoice->issue_date,
                ]);
            }

            $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $invoice->paid_to_supplier_inv);
            $down_payment = (int)preg_replace("/[^0-9]/", "", $invoice->down_payment_inv);
            if($invoice->paid_to_supplier_inv == null){
                $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $invoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
                $allPayments = $down_payment+(int)array_sum($completedPayments);
                $invoiceValue = (int)$invoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
                $invoice->update([
                    'payments_total' => (int)array_sum($completedPayments),
                    'due_amount_after_payments' => $due_after_payments
                ]);
            }else{
                $allPayments = $paid_to_supplier_inv;
                $invoiceValue = (int)$invoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
            }

            if($invoice->due_amount_after_payments == $invoice->total_inv){
                $invoice->update([
                    'payment_status' => 1,
                ]);
            }elseif($invoice->due_amount_after_payments > 0.00 && $invoice->due_amount_after_payments < $invoice->total_inv){
                $invoice->update([
                    'payment_status' => 2,
                ]);
            }elseif($invoice->due_amount_after_payments == 0.00){
                $invoice->update([
                    'payment_status' => 3,
                ]);
            }
        }

        foreach ($totallyPaidInvoices as $invoice){
            foreach ($invoice->payments as $payment){
                $payment->update([
                    'sales_invoice_id' => $invoice->id,
                    'payment_amount' => $invoice->total_inv,
                    'payment_date' => $invoice->issue_date,
                ]);
            }

            $paid_to_supplier_inv = (int)preg_replace("/[^0-9]/", "", $invoice->paid_to_supplier_inv);
            $down_payment = (int)preg_replace("/[^0-9]/", "", $invoice->down_payment_inv);
            if($invoice->paid_to_supplier_inv == null){
                $completedPayments = SalesInvoicePayment::where(['sales_invoice_id'=> $invoice->id, 'payment_status' => 'completed'])->pluck('payment_amount')->toArray();
                $allPayments = $down_payment+(int)array_sum($completedPayments);
                $invoiceValue = (int)$invoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
                $invoice->update([
                    'payments_total' => (int)array_sum($completedPayments),
                    'due_amount_after_payments' => $due_after_payments
                ]);
            }else{
                $allPayments = $paid_to_supplier_inv;
                $invoiceValue = (int)$invoice->total_inv;
                $due_after_payments = ($invoiceValue-$allPayments);
            }

            if($invoice->due_amount_after_payments == $invoice->total_inv){
                $invoice->update([
                    'payment_status' => 1,
                ]);
            }elseif($invoice->due_amount_after_payments > 0.00 && $invoice->due_amount_after_payments < $invoice->total_inv){
                $invoice->update([
                    'payment_status' => 2,
                ]);
            }elseif($invoice->due_amount_after_payments == 0.00){
                $invoice->update([
                    'payment_status' => 3,
                ]);
            }
        }
    }
}
