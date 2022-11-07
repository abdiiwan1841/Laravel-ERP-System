<div class="form-group col-sm-12 tile" style="padding:0">
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
                                <div>
                                    <fieldset>
                                        <div class="checkbox checkbox-shadow checkbox-primary">
                                            <input type="checkbox" value="{{$key}}" id="role_{{$key}}" name="roles_name[]"
                                                    wire:model='selectedRoles'>
                                            <label for="role_{{$key}}">{{transRoleName($key)}}</label>
                                        </div>
                                    </fieldset>
                                </div>
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
                <div class="card-header border-bottom" style="background-color: #f9f9f9">
                    <fieldset>
                        <div class="checkbox checkbox-shadow checkbox-primary">
                            <input type="checkbox" value="{{$cat_key}}" id="cat_{{$cat_key}}" name="category" wire:model='selectedCategory'>
                            <label for="cat_{{$cat_key}}" class="card-title">{{$category}}</label>
                        </div>
                    </fieldset>
                </div>

                <div class="card-body">
                    <div class="row">
                        @if (Spatie\Permission\Models\Role::count() > 0 && Spatie\Permission\Models\Permission::count() > 0)
                            @foreach (cat_Permissions($cat_key) as $key => $permission)
                                <div class="col-sm-3 mt-1">
                                    <div>
                                        <fieldset>
                                            <div class="checkbox checkbox-shadow checkbox-primary">
                                                <input type="checkbox" value="{{$key}}" id="perm_{{$key}}" name="permissions[]"
                                                {{in_array($key, permissionsOfCategory($selectedCategory)) ? 'checked' : ''}}
                                                {{in_array($key, permissionsOfRole($selectedRoles)) ? 'checked disabled' : ''}}
                                                >
                                                <label for="perm_{{$key}}">{{$permission}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div><!-- /.container -->
</div>
