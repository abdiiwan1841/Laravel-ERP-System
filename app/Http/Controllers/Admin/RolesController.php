<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\PermissionsCategory;
use App\Models\TranslatedPermission;
use App\Models\TranslatedRole;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Stichoza\GoogleTranslate\GoogleTranslate;

class RolesController extends Controller
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
            ["name" => trans('applang.roles') ]
        ];
        $permissions = Permission::all();
        $roles = TranslatedRole::all();
        return view('admin.roles.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'roles'       => $roles,
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
            ["name" => trans('applang.roles'), "link" => route('roles.index') ],
            ["name" => trans('applang.create_role') ]
        ];
        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();
        // dd($categories);
        return view('admin.roles.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions,
            'categories' => $categories
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->name_en,
        ]);
        TranslatedRole::create([
            'name_ar' => $request->name_ar,
            'name_en' => Role::latest()->first()->name,
            'role_id' => Role::latest()->first()->id,
        ]);

        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', trans('applang.role_created_successfully'));
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
    public function edit(Role $role)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.roles'), "link" => route('roles.index') ],
            ["name" => trans('applang.edit_role') ]
        ];

        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();
        $transRole = TranslatedRole::where('role_id', $role->id)->first();
        $editedrole = TranslatedRole::where('role_id', $role->id)->pluck('role_id');
        $editedroleId = implode('',json_decode($editedrole));

        return view('admin.roles.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'permissions' => $permissions,
            'categories' => $categories,
            'transRole' => $transRole,
            'editedroleId' => $editedroleId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'permissions' => 'required'
        ]);
        $transRole = TranslatedRole::find($role->id);
        $originalRole = Role::where('id', $transRole->role_id)->first();
        $originalRole->update([
            'name' => $request->name_en
        ]);
        $transRole->update([
            'name_ar' => $request->name_ar,
            'name_en' => $originalRole->name,
        ]);
        $originalRole->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', trans('applang.role_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->role_id;
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', trans('applang.role_deleted_successfully'));
    }

    public function deleteSelectedRoles(Request $request)
    {
        $ids = $request->ids;
        Role::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Roles deleted successfully'
        ],200);
    }

    public function translateRole($role)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.roles'), "link" => route('roles.index') ],
            ["name" => trans('applang.create_role') ]
        ];

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($role);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($role);

        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();

        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        return view('admin.roles.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'permissions' => $permissions,
            'categories'   => $categories
        ]);
    }

    public function translateEditRole($role)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.roles'), "link" => route('roles.index') ],
            ["name" => trans('applang.create_role') ]
        ];

        $editedroleId = explode('/', url()->previous())[6];
        // $editedRole = Role::where('id', $editedroleId)->first();

        $transRole = TranslatedRole::where('role_id', $editedroleId)->first();
        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($role);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($role);

        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        return view('admin.roles.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'permissions' => $permissions,
            'categories' => $categories,
            'editedroleId' => $editedroleId,
            'transRole'     => $transRole
        ]);
    }
}
