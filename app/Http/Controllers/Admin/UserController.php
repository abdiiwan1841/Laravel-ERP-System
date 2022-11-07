<?php

namespace App\Http\Controllers\Admin;

use App\Models\ERP\Branch;
use App\Models\Job;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TranslatedRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\PermissionsCategory;
use App\Http\Controllers\Controller;
use App\Models\TranslatedPermission;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
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
            ["name" => trans('applang.users') ]
        ];
        $users = User::with('branch', 'department', 'job')->get();
        $roles = Role::all();
        $departments = PermissionsCategory::all();
        return view('admin.users.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'users' => $users,
            'roles' => $roles,
            'departments' => $departments
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
            ["name" => trans('applang.users'), "link" => route('users.index') ],
            ["name" => trans('applang.create_new_user') ]
        ];
        $roles = Role::pluck('name','id')->all();
        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();
        $branches = Branch::all();
        $jobs = Job::all();
        return view('admin.users.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles,
            'permissions' => $permissions,
            'categories' => $categories,
            'branches' => $branches,
            'jobs'  => $jobs
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
        $dt = new Carbon();
        $before = $dt->subYears(18)->format('d-m-Y');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender'    => ['required'],
            'birth_date' => ['required','date','before:'.$before],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:11', 'regex:/^\d{11}$/', 'unique:users', 'starts_with:010,011,012,015'],
            'status' => ['required'],
            'address_1' => ['required'],
            'address_2' => '',
            'user_image' => ['image'],
            'branch_id' => ['required'],
            'department_id' => ['required'],
            'job_id' => ['required'],
            'permissions' => '',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'system_not_user'=> ['required_without_all:system_user'],
            'system_user'=> ['required_without_all:system_not_user'],
        ]);

        $not_auth_system_user = [];
        if($request->system_not_user){
            $request->validate([
                'system_not_user'=> ['required_without_all:system_user'],
                'system_user'=> ['required_without_all:system_not_user'],
            ]);
            $request->merge([
                'system_user' => 0,
                'password' => Hash::make($request->password)
            ]);
            $not_auth_system_user= $request->except('roles_name');
        }

        $auth_system_user = [];
        if($request->system_user){
            $request->validate([
                'system_not_user'=> ['required_without_all:system_user'],
                'system_user'=> ['required_without_all:system_not_user'],
                'roles_name'   => ['required']
            ]);
            $roles = Role::find($request->roles_name)->pluck('name');
            $request->merge([
                'system_not_user' => 0,
                'password' => Hash::make($request->password),
                'roles_name' => $roles
            ]);
            $auth_system_user = $request->all();
//            dd($data);
        }

        if($request->user_image){
            Image::make($request->user_image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->user_image->hashName()));

            if($request->system_not_user){
                $not_auth_system_user['user_image'] = $request->user_image->hashName();
            }else{
                $auth_system_user['user_image'] = $request->user_image->hashName();
            }
        }

        if($request->system_not_user){
            User::create($not_auth_system_user);
        }else{
            $user = User::create($auth_system_user);
            $user->assignRole($request->roles_name);
            if($request->permissions){
                $user->givePermissionTo($request->permissions);
            }
        }

        return redirect()->route('users.index')->with('success', trans('applang.creat_user_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.users'), "link" => route('users.index') ],
            ["name" => trans('applang.show_user') ]
        ];
        $roles = Role::pluck('name','id')->all();
        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();

        return view('admin.users.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles,
            'permissions' => $permissions,
            'user' => $user
        ]);

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
            ["name" => trans('applang.users'), "link" => route('users.index') ],
            ["name" => trans('applang.update_user') ]
        ];
        $user = User::find($id);
        $userRoles = $user->roles;
        $roles = Role::pluck('name','id')->all();
        $permissions = TranslatedPermission::pluck('name_'.app()->getLocale(),'permission_id')->all();
        $categories = PermissionsCategory::pluck('name_'.app()->getLocale(),'id')->all();
        $branches = Branch::all();
        $jobs = Job::all();
        return view('admin.users.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'user' => $user,
            'permissions' => $permissions,
            'categories' => $categories,
            'branches'  => $branches,
            'jobs'  => $jobs
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
        $dt = new Carbon();
        $before = $dt->subYears(18)->format('d-m-Y');

        $user = User::find($id);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender'    => ['required'],
            'birth_date' => ['required','date','before:'.$before],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'phone' => ['required', 'numeric', 'digits:11', 'regex:/^\d{11}$/', 'unique:users,phone,'.$id, 'starts_with:010,011,012,015'],
            'status' => ['required'],
            'branch_id' => ['required'],
            'address_1' => ['required'],
            'address_2' => '',
            'user_image' => ['image'],
//            'roles_name' => ['required'],
            'permissions' => '',
            'password' => '',
            'system_not_user'=> ['required_without_all:system_user'],
            'system_user'=> ['required_without_all:system_not_user'],
        ]);

        $not_auth_system_user = [];
        if($request->system_not_user){
            $request->validate([
                'system_not_user'=> ['required_without_all:system_user'],
                'system_user'=> ['required_without_all:system_not_user'],
            ]);
            $request->merge(['system_user' => 0]);
            $not_auth_system_user= $request->except(['roles_name', 'password']);
        }

        $auth_system_user = [];
        if($request->system_user){
            $request->validate([
                'system_not_user' => ['required_without_all:system_user'],
                'system_user' => ['required_without_all:system_not_user'],
                'roles_name'   => ['required']
            ]);
            $roles = Role::find($request->roles_name)->pluck('name');
            $request->merge([
                'system_not_user' => 0,
                'roles_name' => $roles
            ]);
            $auth_system_user = $request->except( 'password');
        }

        if(!empty($request->password)){
            $request->validate(['password' => ['string', 'min:8', 'confirmed'],]);
            if($request->system_not_user){
                $not_auth_system_user['password'] = Hash::make($request->password);
            }else{
                $auth_system_user['password'] = Hash::make($request->password);
            }
        }

        if($request->user_image){
            //delete old user image
            if($user->user_image != 'default.png'){
                Storage::disk('public_uploads')->delete('/users_images//'.$user->user_image);
            }
            //create new user image
            Image::make($request->user_image)->resize(300, null, function ($constraint) { 
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->user_image->hashName()));

            if($request->system_not_user){
                $not_auth_system_user['user_image'] = $request->user_image->hashName();
            }else{
                $auth_system_user['user_image'] = $request->user_image->hashName();
            }
        }

        if($request->system_not_user){
            $user->update($not_auth_system_user);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            DB::table('model_has_permissions')->where('model_id', $id)->delete();
        }else {
            $user->update($auth_system_user);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            DB::table('model_has_permissions')->where('model_id', $id)->delete();
            $user->assignRole($request->roles_name);
            if ($request->permissions) {
                $user->givePermissionTo($request->permissions);
            }
        }

        return redirect()->route('users.index')->with('success', trans('applang.update_user_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->userid;
        $user = User::find($id);
        if($user->user_image != 'default.png') {
            Storage::disk('public_uploads')->delete('/users_images//'.$user->user_image);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', trans('applang.delete_user_success'));
    }

    public function deleteSelectedUsers(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $id){
            $user = User::find($id);
            if($user->user_image != 'default.png') {
                Storage::disk('public_uploads')->delete('/users_images//'.$user->user_image);
            }
        }
        User::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'users deleted successfully'
        ],200);
    }

    public function usersOfRoleQuery($id)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.roles'), "link" => route('roles.index')],
            ["name" => trans('applang.users') ]
        ];
        $roleQuery = TranslatedRole::where('role_id', $id)->pluck('name_'.app()->getLocale())->first();
        $users = User::with('branch', 'department', 'job')->get();
        $roles = Role::all();
        $departments = PermissionsCategory::all();
        return view('admin.users.index', [
            'breadcrumbs' => $breadcrumbs,
            'roleQuery' => $roleQuery,
            'users' => $users,
            'roles' => $roles,
            'departments' => $departments
        ]);
    }
}
