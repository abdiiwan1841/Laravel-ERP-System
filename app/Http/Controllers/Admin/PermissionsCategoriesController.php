<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PermissionsCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Contracts\Permission;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PermissionsCategoriesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['role:superadmin']);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.departments') ]
        ];
        // $permissions = Permission::all();
        $categories = PermissionsCategory::all();
        return view('admin.departments.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,
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
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.departments'), "link" => route('perm_categories.index') ],
            ["name" => trans('applang.create_permission_cat') ]
        ];
        return view('admin.departments.create')->with([
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
            'name_en' => 'required|unique:permissions_categories,name_en',
            'name_ar' => 'required|unique:permissions_categories,name_ar',
        ]);

        PermissionsCategory::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar
         ]);

        return redirect()->route('perm_categories.index')->with('success', trans('applang.perm_cat_created_successfully'));
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
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.departments'), "link" => route('perm_categories.index') ],
            ["name" => trans('applang.edit_perm_cat') ]
        ];
        $perm_cat = PermissionsCategory::find($id);
        return view('admin.departments.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'perm_cat' => $perm_cat,
        ]);
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
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required'
        ]);
        $perm_cat = PermissionsCategory::find($id);
        $perm_cat->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en
        ]);
        return redirect()->route('perm_categories.index')->with('success', trans('applang.perm_cat_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->category_id;
        $perm_cat = PermissionsCategory::where('id', $id)->first();
        $perm_cat->delete();
        return redirect()->route('perm_categories.index')->with('success', trans('applang.perm_cat_deleted_successfully'));
    }

    public function deleteSelectedPermissionsCategoies(Request $request)
    {
        $ids = $request->ids;
        PermissionsCategory::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ],200);
    }

    public function translatePermissionsCat($cat)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.departments'), "link" => route('perm_categories.index') ],
            ["name" => trans('applang.create_permission_cat') ]
        ];

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($cat);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($cat);

        return view('admin.departments.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en
        ]);
    }

    public function translateEditPermCategories($cat)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.departments'), "link" => route('perm_categories.index') ],
            ["name" => trans('applang.edit_perm_cat') ]
        ];

        $editedPermCatId = explode('/', url()->previous())[6];
        // $editedRole = Role::where('id', $editedroleId)->first();

        $perm_cat = PermissionsCategory::where('id', $editedPermCatId)->first();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($cat);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($cat);

        return view('admin.departments.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'editedPermCatId' => $editedPermCatId,
            'perm_cat'     => $perm_cat,
        ]);
    }

}
