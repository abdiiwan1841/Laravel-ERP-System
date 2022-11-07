<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Models\ERP\Branch;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Stichoza\GoogleTranslate\GoogleTranslate;

class BranchesController extends Controller
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
            ["name" => trans('applang.branches')],
            ["name" => trans('applang.branches_admin') ]
        ];
        $branches = Branch::with('users')->get();
//        dd($branches);
        return view('erp.branches.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'branches' => $branches,
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
            ["name" => trans('applang.branches')],
            ["name" => trans('applang.branch_add') ]
        ];
        return view('erp.branches.create')->with([
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|unique:branches,name_ar',
            'name_en' => 'required|unique:branches,name_en',
            'address_ar'  => 'required',
            'address_en'  => 'required',
        ]);

        Branch::create([
            'name_ar'   => $request->name_ar,
            'name_en'   => $request->name_en,
            'address_ar'   => $request->address_ar,
            'address_en'   => $request->address_en,
        ]);

        return redirect()->route('branches.index')->with('success', trans('applang.branch_created_successfully'));
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
    public function edit(Branch $branch)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.branches')],
            ["name" => trans('applang.branch_edit') ]
        ];
        return view('erp.branches.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'branch'    => $branch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name_ar' => 'required|unique:branches,name_ar',
            'name_en' => 'required|unique:branches,name_en',
            'address_ar'  => 'required',
            'address_en'  => 'required',
        ]);

        $data = $request->all();
        $branch->update($data);

        return redirect()->route('branches.index')->with('success', trans('applang.branch_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->branch_id;
        $branch = Branch::where('id', $id);
        $branch->delete();
        return redirect()->route('branches.index')->with('success', trans('applang.branch_deleted_successfully'));
    }

    public function deleteSelectedBranches(Request $request)
    {
        $ids = $request->ids;
        Branch::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Branches deleted successfully'
        ],200);
    }

    public function translateBranch($name, $address)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.branches')],
            ["name" => trans('applang.branch_add') ]
        ];

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_name_ar = $tr->setSource('en')->setTarget('ar')->translate($name);
        $translated_name_en = $tr->setSource('ar')->setTarget('en')->translate($name);

        $translated_address_ar = $tr->setSource('en')->setTarget('ar')->translate($address);
        $translated_address_en = $tr->setSource('ar')->setTarget('en')->translate($address);

        return view('erp.branches.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_name_ar' => $translated_name_ar,
            'translated_name_en' => $translated_name_en,
            'translated_address_ar' => $translated_address_ar,
            'translated_address_en' => $translated_address_en,

        ]);
    }

    public function translateEditBranch($name, $address)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.branches')],
            ["name" => trans('applang.branch_edit') ]
        ];

        $editedBranchId = explode('/', url()->previous())[6];
        $branch = Branch::where('id', $editedBranchId)->first();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default

        $translated_name_ar = $tr->setSource('en')->setTarget('ar')->translate($name);
        $translated_name_en = $tr->setSource('ar')->setTarget('en')->translate($name);

        $translated_address_ar = $tr->setSource('en')->setTarget('ar')->translate($address);
        $translated_address_en = $tr->setSource('ar')->setTarget('en')->translate($address);

        return view('erp.branches.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_name_ar' => $translated_name_ar,
            'translated_name_en' => $translated_name_en,
            'translated_address_ar' => $translated_address_ar,
            'translated_address_en' => $translated_address_en,
            'branch'                => $branch

        ]);
    }
}
