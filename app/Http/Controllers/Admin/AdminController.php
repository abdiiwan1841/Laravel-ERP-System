<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Sales\SalesInvoice;
use App\Models\ERP\Settings\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard')]
        ];

        //get general settings currency
        $companyData = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $currency_symbol = $companyData->basic_currency_symbol;
        }else{
            $currency_symbol = $companyData->basic_currency;
        }

        //Total Sales
        $totalSales = SalesInvoice::select([
            DB::raw('YEAR(issue_date) as year'),
            DB::raw('SUM(total_inv) as total'),
            DB::raw('COUNT(*) as count'),
        ])->whereYear('issue_date',  Carbon::now()->year)->groupBy('year')->first();

        //Total Purchases
        $totalPurchases = PurchaseInvoice::select([
            DB::raw('YEAR(issue_date) as year'),
            DB::raw('SUM(total_inv) as total'),
            DB::raw('COUNT(*) as count'),
        ])->whereYear('issue_date',  Carbon::now()->year)->groupBy('year')->first();

        //Best Seller Product
        $salesDetails = WarehouseSalesDetail::join('products', 'products.id', '=', 'warehouse_sales_details.product_id')->select('warehouse_sales_details.*', 'products.name')
            ->join('sales_invoices', 'sales_invoices.id', '=', 'warehouse_sales_details.sales_invoice_id')->select('warehouse_sales_details.*', 'sales_invoices.issue_date')
            ->select([
                DB::raw('YEAR(issue_date) as year'),
                DB::raw('product_id as product_id'),
                DB::raw('name as product_name'),
                DB::raw('SUM(quantity) as total_q_sold'),
            ])
            ->whereYear('issue_date',  Carbon::now()->year)
            ->groupBy('product_id', 'product_name', 'year')->get();
        $bestSellerProduct = $salesDetails->where('total_q_sold', $salesDetails->max('total_q_sold'))->first();

        //Best Seller Employee
        $salesInvoicesDetails = SalesInvoice::join('users', 'users.id', '=', 'sales_invoices.user_id')->select('sales_invoices.*', 'users.first_name', 'users.last_name')
            ->select([
                DB::raw('YEAR(issue_date) as year'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_inv) as total'),
                DB::raw(' user_id as user_id'),
                DB::raw('first_name as user_first_name'),
                DB::raw('last_name as user_last_name'),
            ])
            ->whereYear('issue_date',  Carbon::now()->year)
            ->groupBy('user_first_name', 'user_last_name', 'user_id', 'year')->get();

        $bestSellerEmployee = $salesInvoicesDetails->where('total', $salesInvoicesDetails->max('total'))->first();

        //Current User
        $current_user = auth()->user()->first_name . auth()->user()->last_name;

        //Comparison Years
        $years = SalesInvoice::select(DB::raw('YEAR(issue_date) as year'))
            ->whereYear('issue_date', '>=', Carbon::now()->subYears(5))
            ->whereYear('issue_date', '<=', Carbon::now()->addYears(4)->year)
            ->groupBy(['year'])->orderBy('year')->pluck('year');
        $thisYear = Carbon::now()->year;


        return view('admin.dashboard')->with([
            'breadcrumbs' => $breadcrumbs,
            'totalSales' => $totalSales,
            'currency_symbol' => $currency_symbol,
            'years' => $years,
            'thisYear' => $thisYear,
            'current_user' => $current_user,
            'totalPurchases' => $totalPurchases,
            'bestSellerProduct' => $bestSellerProduct,
            'bestSellerEmployee' => $bestSellerEmployee,

        ]);
    }

    public function salesCharts(Request $request)
    {
        $group = $request->query('group', 'monthly');

        $query = SalesInvoice::select([
            DB::raw('SUM(total_inv) as total'),
            DB::raw('COUNT(*) as count'),
        ])->groupBy(['label'])->orderBy('label');

        switch ($group){
            case 'daily':
                $query->addSelect(DB::raw('DATE(issue_date) as label'));
                $query->whereDate('issue_date', '>=', Carbon::now()->startOfMonth());
                $query->whereDate('issue_date', '<=', Carbon::now()->endOfMonth());
                break;
            case 'weekly':
                $query->addSelect(DB::raw('WEEK(issue_date) as label'));
                $query->whereDate('issue_date', '>=', Carbon::now()->startOfweek());
                $query->whereDate('issue_date', '<=', Carbon::now()->endOfWeek());
                break;
            case 'yearly':
                $query->addSelect(DB::raw('YEAR(issue_date) as label'));
                $query->whereYear('issue_date', '>=', Carbon::now()->subYears(5)->year);
                $query->whereYear('issue_date', '<=', Carbon::now()->addYears(4)->year);
                break;
            case 'monthly':
                $query->addSelect(DB::raw('MONTH(issue_date) as label'));
                $query->whereDate('issue_date', '>=', Carbon::now()->startOfYear());
                $query->whereDate('issue_date', '<=', Carbon::now()->endOfYear());
//                $labels = [1 =>'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',];
            default:
        }

        $entries = $query->get();
        $total = [];
        $count = [];
        $labels = [];
        foreach ($entries as $entry){
            if($group === 'monthly'){
                $labels[] = date("F", mktime(0, 0, 0, $entry->label, 1));
            }else{
                $labels[] = $entry->label;
            }
            $total[$entry->label] =$entry->total;
            $count[$entry->label] =$entry->count;
        }

//        foreach ($labels as $month => $name){
//            if(!array_key_exists($month, $total)){
//                $total[$month] = 0;
//            }
//            if(!array_key_exists($month, $count)){
//                $count[$month] = 0;
//            }
//        }
//        ksort($total);
//        ksort($count);

        return [
            'group' => $group,
            'labels' => array_values($labels),
            'datasets' => [
                [
                    'label' => trans('applang.total_sales'),
                    'data' => array_values($total),
                    'backgroundColor' => ['rgba(255, 99, 132, 0.2)'],
                    'borderColor' => ['rgba(255, 99, 132, 1)'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'yAxisID' => 'y'
                ],
                [
                    'label' => trans('applang.invoices_count'),
                    'data' => array_values($count),
                    'backgroundColor' => ['rgba(54, 162, 235, 0.2)'],
                    'borderColor' => ['rgba(54, 162, 235, 1)'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'yAxisID' => 'invoices_count'
                ],
            ]
        ];
    }

    public function salesPaymentStatusCharts(Request $request)
    {
        $year = $request->query('year', Carbon::now()->year);
        $entries = SalesInvoice::select([
            DB::raw('YEAR(issue_date) as year'),
            DB::raw('payment_status as status'),
            DB::raw('SUM(total_inv) as total'),
            DB::raw('COUNT(*) as count'),
        ])
            ->whereYear('issue_date', $year)
            ->groupBy(['status', 'year'])
            ->orderBy('year')
            ->get();

        $labels = [
            1 => trans('applang.unpaid'),
            2 => trans('applang.partially_paid'),
            3 => trans('applang.paid')
        ];

        $total = [];
        $count = [];

        foreach ($entries as $entry){
            $total[$entry->status] = $entry->total;
            $count[$entry->status] = $entry->count;
        }

        foreach ($labels as $status => $name)
        {
            if(!array_key_exists($status, $total)){
                $total[$status] = 0;
            }
            if(!array_key_exists($status, $count)){
                $count[$status] = 0;
            }
        }
        ksort($total);
        ksort($count);

        return [
            'labels' => array_values($labels),
            'datasets' =>[
                [
                    'label' => trans('applang.payment_status_total'),
                    'data' => array_values($total),
                    'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                    'borderColor'=> [
                                        'rgb(255, 99, 132)',
                                        'rgb(255, 159, 64)',
                                        'rgb(75, 192, 192)',
                                    ],
                    'borderWidth'=> 2,
                    'yAxisID' => 'y'
                ],
                [
                    'label' => trans('applang.payment_status_count'),
                    'data' => array_values($count),
                    'backgroundColor' => [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 159, 64, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',

                                        ],
                    'borderColor'=> [
                                        'rgb(255, 99, 132)',
                                        'rgb(255, 159, 64)',
                                        'rgb(75, 192, 192)',

                                    ],
                    'borderWidth'=> 2,
                    'yAxisID' => 'payment_status_count'
                ],
            ]


        ];

    }

}
