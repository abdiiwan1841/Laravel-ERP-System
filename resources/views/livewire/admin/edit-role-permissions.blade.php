<div class="form-group col-md-12 mb-50 mt-2">
    <div class="col-sm-12 pl-0 pr-0 mb-1">
        <label class="required">{{trans('applang.permissions')}}</label>
    </div>

    @if ($errors->has('permissions'))
        <small><strong class="text-danger">{{ $errors->first('permissions') }}</strong></small>
    @endif

    @foreach ($categories as $cat_key => $category)
        <div class="custom-card">
            <div class="card-header border-bottom justify-content-between" style="background-color: #f9f9f9">
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
                    @foreach (cat_Permissions($cat_key) as $perm_key => $permission)
                        <div class="col-sm-3 mt-1">
                            <div>
                                <fieldset>
                                    <div class="checkbox checkbox-shadow checkbox-primary">
                                        <input type="checkbox" value="{{$perm_key}}" id="perm_{{$perm_key}}" name="permissions[]"
                                            {{ in_array($perm_key, $selectedPermissions)? 'checked' : ''}}
                                            class="catPermission"
                                        >
                                        <label class="card-text" for="perm_{{$perm_key}}">{{$permission}}</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endforeach
</div>
