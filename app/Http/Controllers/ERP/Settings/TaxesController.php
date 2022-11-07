<?php

namespace App\Http\Controllers\ERP\Settings;

use Illuminate\Http\Request;

use App\Models\ERP\Settings\Tax;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Nullable;
use function PHPUnit\Framework\isNull;


class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.taxes')],
            ["name" => trans('applang.tax_add') ]
        ];
        $taxes = Tax::all();
        // dd($taxes);
        return view('erp.settings.taxes.create',compact(['breadcrumbs', 'taxes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'tax_name_ar.*' => 'required|unique:taxes,tax_name_ar',
//            'tax_name_en.*' => 'required|unique:taxes,tax_name_ar',
//            'tax_value.*'  => 'required|numeric|digits_between:1,2',
//            'unit_price_inc.*'  => 'required',
//        ]);
//
//        $data = $request->all();
//        Tax::create($data);
//
//        return redirect()->route('taxes.create')->with('success', trans('applang.tax_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ids)
    {
        foreach($request->tax_id as $key=>$id){
            $request->validate([
                'tax_name_ar.'.$key => ['required', Rule::unique('taxes','tax_name_ar')->ignore($request->tax_id[$key])],
                'tax_name_en.'.$key => ['required', Rule::unique('taxes','tax_name_en')->ignore($request->tax_id[$key])],
                'tax_value.'.$key  => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/|numeric|max:24.999',
                'unit_price_inc.'.$key  => 'required',
            ],[
                'tax_name_ar.'.$key.'.required'    => trans('applang.tax_name_ar_required'),
                'tax_name_en.'.$key.'.required'    => trans('applang.tax_name_en_required'),
                'tax_value.'.$key.'.required'      => trans('applang.tax_value_required'),
                'unit_price_inc.'.$key.'.required' => trans('applang.unit_price_inc_required'),
            ]);

            $tax = Tax::firstOrNew(['id'=> $request->tax_id[$key]]);
            $tax->tax_name_ar = $request->tax_name_ar[$key];
            $tax->tax_name_en = $request->tax_name_en[$key];
            $tax->tax_value = $request->tax_value[$key];
            $tax->unit_price_inc = $request->unit_price_inc[$key];
            $tax->save();
        }

        return redirect()->route('taxes.create')->with('success', trans('applang.tax_added_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->tax_id;
        $tax = Tax::where('id', $id)->first();
        $tax->delete();
        return redirect()->route('taxes.create')->with('success', trans('applang.tax_deleted_successfully'));
    }
}
