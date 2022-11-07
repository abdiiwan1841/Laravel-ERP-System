<?php

namespace App\Http\Controllers\ERP\Settings;

use App\Http\Controllers\Controller;
use App\Models\ERP\Settings\UnitsTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitsTemplatesController extends Controller
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
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.units_templates')],
        ];

        $units_templates = UnitsTemplate::with('measurement_units')->get();

        return view('erp.settings.units-templates.index', compact(['breadcrumbs', 'units_templates']));
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
            ["name" => trans('applang.units_templates'), "link" => route('units-templates.index')],
            ["name" => trans('applang.add_new_template')],
        ];

        return view('erp.settings.units-templates.create', compact(['breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'template_name_ar' => 'required|unique:units_templates,template_name_ar',
            'template_name_en' => 'required|unique:units_templates,template_name_en',
            'main_unit_ar'     => 'required|unique:units_templates,main_unit_ar',
            'main_unit_symbol_ar'  => 'required|unique:units_templates,main_unit_symbol_ar',
            'main_unit_en'     => 'required|unique:units_templates,main_unit_en',
            'main_unit_symbol_en'  => 'required|unique:units_templates,main_unit_symbol_en',
        ]);

        $data = $request->all();

        UnitsTemplate::create($data);

        return redirect()->route('units-templates.index')->with('success', trans('applang.units_template_added_successfully'));
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
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.units_templates'), "link" => route('units-templates.index')],
            ["name" => trans('applang.edit_template')],
        ];
        $template = UnitsTemplate::find($id);

        return view('erp.settings.units-templates.edit', compact(['breadcrumbs', 'template']));
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
        $template = UnitsTemplate::find($id);

        $request->validate([
            'template_name_ar' => ['required', Rule::unique('units_templates','template_name_ar')->ignore($id)],
            'template_name_en' => ['required', Rule::unique('units_templates','template_name_en')->ignore($id)],
            'main_unit_ar'     => ['required', Rule::unique('units_templates','main_unit_ar')->ignore($id)],
            'main_unit_symbol_ar'  => ['required', Rule::unique('units_templates','main_unit_symbol_ar')->ignore($id)],
            'main_unit_en'     => ['required', Rule::unique('units_templates','main_unit_en')->ignore($id)],
            'main_unit_symbol_en'  => ['required', Rule::unique('units_templates','main_unit_symbol_en')->ignore($id)],
        ]);

        $data = $request->all();

       $template->update($data);

        return redirect()->route('units-templates.index')->with('success', trans('applang.units_template_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->template_id;
        $template = UnitsTemplate::where('id', $id)->first();
        $template->delete();
        return redirect()->back()->with('success', trans('applang.template_deleted_successfully'));
    }
}
