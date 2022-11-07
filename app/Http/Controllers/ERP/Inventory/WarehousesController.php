<?php

namespace App\Http\Controllers\ERP\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ERP\Branch;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\WarehousePurchaseDetail;
use App\Models\ERP\Purchases\WarehouseSalesDetail;
use App\Models\ERP\Purchases\WarehouseTotal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WarehousesController extends Controller
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
            ["name" => trans('applang.inventory') ],
            ["name" => trans('applang.warehouses') ],
        ];

        $warehouses = Warehouse::with('branch')->paginate(10);
        return view('erp.inventory.warehouses.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'warehouses'  => $warehouses,
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
            ["name" => trans('applang.warehouses'), "link" => route('warehouses.index') ],
            ["name" => trans('applang.add_warehouse') ],
        ];
        $branches = Branch::all();
        return view('erp.inventory.warehouses.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'branches'  => $branches
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
            'branch_id' => ['required'],
            'name' => ['required', 'string', 'max:255', 'unique:warehouses,name'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'status'    => ['required'],
        ]);
        $data = $request->all();
        Warehouse::create($data);
        return redirect()->route('warehouses.index')->with('success', trans('applang.create_warehouse_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.warehouses'), "link" => route('warehouses.index') ],
            ["name" => trans('applang.show_warehouse_summary') ],
        ];

        $products = Product::all();
        $warehouseTotals = WarehouseTotal::where('warehouse_id', $warehouse->id)->get();

        return view('erp.inventory.warehouses.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'warehouse'  => $warehouse,
            'products' => $products,
            'warehouseTotals' => $warehouseTotals

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inventoryValue($id)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.warehouses'), "link" => route('warehouses.index') ],
            ["name" => trans('applang.inventory_value') ],
        ];
        $warehouse = Warehouse::whereId($id)->first();
        $warehouseTotals = WarehouseTotal::where('warehouse_id', $warehouse->id)->get();
        $warehouseTotalsSellPrice = array_sum(WarehouseTotal::where('warehouse_id', $warehouse->id)->pluck('total_sales_value_of_remain')->toArray());
        $warehouseTotalsPurchasePrice = array_sum(WarehouseTotal::where('warehouse_id', $warehouse->id)->pluck('total_remain_cost')->toArray());
        $warehouseTotalsExpectedProfit = array_sum(WarehouseTotal::where('warehouse_id', $warehouse->id)->pluck('expected_profit_of_remain')->toArray());

        return view('erp.inventory.warehouses.inventory_value')->with([
            'breadcrumbs' => $breadcrumbs,
            'warehouse'  => $warehouse,
            'warehouseTotals' => $warehouseTotals,
            'warehouseTotalsSellPrice' => $warehouseTotalsSellPrice,
            'warehouseTotalsPurchasePrice' => $warehouseTotalsPurchasePrice,
            'warehouseTotalsExpectedProfit' => $warehouseTotalsExpectedProfit,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.warehouses'), "link" => route('warehouses.index') ],
            ["name" => trans('applang.edit_warehouse') ],
        ];
        $branches = Branch::all();
        return view('erp.inventory.warehouses.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'branches'  => $branches,
            'warehouse' => $warehouse
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'branch_id' => ['required'],
            'name' => ['required', 'string', 'max:255', Rule::unique('warehouses','name')->ignore($warehouse->id)],
            'shipping_address' => ['required', 'string', 'max:255'],
            'status'    => ['required'],
        ]);
        $data = $request->all();
        $warehouse->update($data);
        return redirect()->route('warehouses.index')->with('success', trans('applang.edit_warehouse_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->warehouse_id;
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        return redirect()->back()->with('success', trans('applang.delete_warehouse_success'));
    }
}
