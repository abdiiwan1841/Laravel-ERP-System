<?php

namespace App\Http\Controllers\ERP\Settings;

use App\Http\Controllers\Controller;
use App\Models\ERP\Settings\MeasurementUnit;
use App\Models\ERP\Settings\UnitsTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MeasurementUnitsController extends Controller
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
    public function create($template_id)
    {
        $template = UnitsTemplate::with('measurement_units')->find($template_id);
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.units_templates'), "link" => route('units-templates.index')],
            ["name" => trans('applang.adjust_measurement_units')],
        ];

        $units = MeasurementUnit::all();

        return view('erp.settings.units-templates.measurement-units.create', compact(['breadcrumbs', 'template', 'units']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        foreach($request->unit_id as $key=>$id){
            $request->validate([
                'largest_unit_ar.'.$key => ['required', Rule::unique('measurement_units','largest_unit_ar')->ignore($request->unit_id[$key])],
                'largest_unit_en.'.$key => ['required', Rule::unique('measurement_units','largest_unit_en')->ignore($request->unit_id[$key])],
                'conversion_factor.'.$key  => 'required|regex:/^\d{1,12}(\.\d{1,4})?$/|numeric|min:0',
                'largest_unit_symbol_ar.'.$key  => ['required', Rule::unique('measurement_units','largest_unit_symbol_ar')->ignore($request->unit_id[$key])],
                'largest_unit_symbol_en.'.$key  => ['required', Rule::unique('measurement_units','largest_unit_symbol_en')->ignore($request->unit_id[$key])],
            ],[
                'largest_unit_ar.'.$key.'.required'    => trans('applang.largest_unit_ar_required'),
                'largest_unit_en.'.$key.'.required'    => trans('applang.largest_unit_en_required'),
                'conversion_factor.'.$key.'.required'      => trans('applang.conversion_factor_required'),
                'largest_unit_symbol_ar.'.$key.'.required' => trans('applang.largest_unit_symbol_ar_required'),
                'largest_unit_symbol_en.'.$key.'.required' => trans('applang.largest_unit_symbol_en_required'),
            ]);

            $unit = MeasurementUnit::firstOrNew(['id'=> $request->unit_id[$key]]);
            $unit->units_template_id = $request->units_template_id;
            $unit->largest_unit_ar = $request->largest_unit_ar[$key];
            $unit->largest_unit_en = $request->largest_unit_en[$key];
            $unit->conversion_factor = $request->conversion_factor[$key];
            $unit->largest_unit_symbol_ar = $request->largest_unit_symbol_ar[$key];
            $unit->largest_unit_symbol_en = $request->largest_unit_symbol_en[$key];
            $unit->save();

        }

        return redirect()->back()->with('success', trans('applang.unit_added_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->unit_id;
        $unit = MeasurementUnit::where('id', $id)->first();
        $unit->delete();
        return redirect()->back()->with('success', trans('applang.unit_deleted_successfully'));
    }
}
