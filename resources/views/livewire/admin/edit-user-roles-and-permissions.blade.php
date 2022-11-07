<div class="form-group col-sm-12" style="padding:0">
    <label class="required text-bold-600">{{trans('applang.user_roles_permissions')}}</label>
    <div class="container">

        <div class="col-sm-12 pl-0 pr-0 mt-1">
            <label>{{trans('applang.roles')}}</label>
        </div>

        @if ($errors->has('roles_name'))
            <small><strong class="text-danger">{{ $errors->first('roles_name') }}</strong></small>
        @endif

        <div class="custom-card mt-1">
            <div class="card-header border-bottom" style="background-color: #f9f9f9">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="card-title">{{trans('applang.select_user_roles')}}</label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-1">
                    @if (Spatie\Permission\Models\Role::count() > 0)
                        @foreach ($roles as $key => $role)
                            <div class="col-sm-3 mt-1">
                                <fieldset>
                                    <div class="checkbox checkbox-shadow checkbox-primary">
                                        <input type="checkbox" value="{{$key}}" id="role_{{$key}}" name="roles_name[]"
                                            wire:model='selectedRoles'
                                            {{in_array($key, userRolesArray($user->id)) ? 'checked' : ''}}
                                        >
                                        <label for="role_{{$key}}">{{transRoleName($key)}}</label>
                                    </div>
                                </fieldset>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <label>{{trans('applang.permissions')}}</label>
            </div>
        </div>

        @foreach ($categories as $cat_key => $category)
            <div class="custom-card mt-1">
                <div class="card-header border-bottom justify-content-between" style="background-color: #f9f9f9">
                    {{-- <fieldset>
                        <div class="checkbox checkbox-shadow checkbox-primary">
                            <input type="checkbox" value="{{$cat_key}}" id="cat_{{$cat_key}}" name="category" wire:model='selectedCategory'>
                            <label for="cat_{{$cat_key}}" class="card-title">{{$category}}</label>
                        </div>
                    </fieldset> --}}
                    <label for="cat_{{$cat_key}}" class="card-title" >{{$category}}</label>
                    <div class="card-buttons">
                        <button class="btn btn-icon btn-light-primary select-all custom-icon-btn" title="{{trans('applang.select_all')}}">
                            <i class="bx bx-select-multiple"></i>
                        </button>
                        <button class="btn btn-icon btn-light-danger deselect-all custom-icon-btn" title="{{trans('applang.deselect')}}">
                            <i class="bx bx-reset"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        @if (Spatie\Permission\Models\Role::count() > 0 && Spatie\Permission\Models\Permission::count() > 0)
                            @if (userRolesIds($user->id)->count() > 0)
                                @foreach (cat_Permissions($cat_key) as $perm_id => $permission)
                                    <div class="col-sm-3 mt-1">
                                        <div>
                                            <fieldset>
                                                <div class="checkbox checkbox-shadow checkbox-primary">
                                                    <input type="checkbox" value="{{$perm_id}}" id="perm_{{$perm_id}}" name="permissions[]"
                                                        {{in_array($perm_id, permissionsOfCategory($selectedCategory)) ? 'checked' : ''}}
                                                        @if (in_array($perm_id, permissionsOfRole($selectedRoles)))
                                                            checked disabled
                                                        @elseif(in_array($perm_id, $directPermissions))
                                                            checked
                                                        @endif
                                                        class="catPermission"
                                                    >
                                                    <label for="perm_{{$perm_id}}">{{$permission}}</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($permissions as $perm_id => $permission)
                                    <div class="col-sm-3 mt-1">
                                        <div>
                                            <fieldset>
                                                <div class="checkbox checkbox-shadow checkbox-primary">
                                                    <input type="checkbox" value="{{$perm_id}}" id="perm_{{$perm_id}}" name="permissions[]">
                                                    <label for="perm_{{$perm_id}}">{{$permission}}</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div><!-- /.container -->
</div>
