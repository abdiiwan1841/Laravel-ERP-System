<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermissionsCategory;
use App\Models\TranslatedPermission;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PermissionsController extends Controller
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
            ["name" => trans('applang.permissions') ]
        ];
        // $permissions = Permission::all();
        $permissions = TranslatedPermission::with('category')->orderBy('id', 'DESC')->get();
        return view('admin.permissions.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions,
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
            ["name" => trans('applang.permissions'), "link" => route('permissions.index') ],
            ["name" => trans('applang.create_permission') ]
        ];
        $categories = PermissionsCategory::all();
        return view('admin.permissions.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,
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
            'name_ar' => 'required|unique:translated_permissions,name_ar',
            'name_en' => 'required|unique:translated_permissions,name_en',
            'category'  => 'required',
        ]);

        Permission::create([
            'name' => $request->name_en
         ]);

        $data = $request->all();
        $category = PermissionsCategory::findOrFail($data['category']); //<<< NEW LINE

        $permission = new TranslatedPermission();
        $permission->name_ar = $data['name_ar'];
        $permission->name_en = $data['name_en'];
        $permission->permission_id = Permission::latest()->first()->id;
        $permission->category_id = $category->id;
        $permission->save();

        return redirect()->route('permissions.index')->with('success', trans('applang.permission_created_successfully'));
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
    public function edit(Permission $permission)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.permissions'), "link" => route('permissions.index') ],
            ["name" => trans('applang.edit_permission') ]
        ];
        $transPermission = TranslatedPermission::where('permission_id', $permission->id)->first();
        $categories = PermissionsCategory::all();
        return view('admin.permissions.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'transPermission' => $transPermission,
            'categories'    => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'category' => 'required'
        ]);
        $transPermission = TranslatedPermission::find($permission->id);
        $originalPermission = Permission::where('id', $transPermission->permission_id)->first();
        $originalPermission->update([
            'name' => $request->name_en
        ]);

        $data = $request->all();
        $category = PermissionsCategory::findOrFail($data['category']); //<<< NEW LINE
        $transPermission->name_ar = $data['name_ar'];
        $transPermission->name_en = $originalPermission->name;
        $transPermission->category_id = $category->id;
        $transPermission->save();

        return redirect()->route('permissions.index')->with('success', trans('applang.permission_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->permission_id;
        $transPermission = TranslatedPermission::where('id', $id)->first();
        $originalPermission_id = $transPermission->permission_id;
        $transPermission->delete();
        $originalPermission = Permission::where('id',$originalPermission_id)->first();
        $originalPermission->delete();
        return redirect()->route('permissions.index')->with('success', trans('applang.permission_deleted_successfully'));
    }

    public function deleteSelectedPermissions(Request $request)
    {
        $ids = $request->ids;
        Permission::whereIn('id', $ids)->delete();
        TranslatedPermission::whereIn('permission_id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Permissions deleted successfully'
        ],200);
    }

    public function translatePermission($perm)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.permissions'), "link" => route('permissions.index') ],
            ["name" => trans('applang.create_permission') ]
        ];

        $categories = PermissionsCategory::all();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($perm);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($perm);

        return view('admin.permissions.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'categories'   => $categories
        ]);
    }

    public function translateEditPermission($cat)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.permissions'), "link" => route('permissions.index') ],
            ["name" => trans('applang.edit_permission') ]
        ];

        $editedPermCatId = explode('/', url()->previous())[6];
        // $editedRole = Role::where('id', $editedroleId)->first();

        $transPermission = TranslatedPermission::where('permission_id', $editedPermCatId)->first();
        $categories = PermissionsCategory::all();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($cat);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($cat);

        return view('admin.permissions.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'editedPermCatId' => $editedPermCatId,
            'transPermission'  => $transPermission,
            'categories'       => $categories
        ]);
    }
}
