@extends('layouts.admin.admin_layout')
@section('title', trans('applang.edit_role'))

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
@endsection

@section('content')

<!--Start Update -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header modal-header bg-primary">
                    <h4 class="modal-title white">{{trans('applang.edit_role')}}</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <form action="{{route('roles.update', $transRole->role_id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        @livewire('admin.role-edit-translation')

                        <div class="form-group col-md-12 mb-50">
                            <label class="required" for="name_ar">{{ trans('applang.name_ar') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="name_ar"
                                        type="text"
                                        class="form-control @error('name_ar') is-invalid @enderror"
                                        name="name_ar"
                                        placeholder="{{trans('applang.name')}}"
                                        autocomplete="name"
                                        value="{{isset($translated_ar) ? $translated_ar :$transRole->name_ar}}"
                                        autofocus>
                                <div class="form-control-position">
                                    <i class="bx bxs-lock"></i>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-50">
                            <label class="required" for="name_en">{{ trans('applang.name_en') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="name_en"
                                        type="text"
                                        class="form-control @error('name_en') is-invalid @enderror"
                                        name="name_en"
                                        placeholder="{{trans('applang.name')}}"
                                        autocomplete="name_en"
                                        value="{{isset($translated_en) ? $translated_en :$transRole->name_en}}"
                                        autofocus>
                                <div class="form-control-position">
                                    <i class="bx bxs-lock"></i>
                                </div>
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group col-md-12 mb-50 mt-2">
                            <div class="col-sm-12 pl-0 pr-0">
                                <label>{{trans('applang.permissions')}}</label>
                            </div>

                            <div class="row">
                                @foreach ($permissions as $perm_id => $permission)
                                    <div class="col-sm-3 mt-1">
                                        <div>
                                            <fieldset>
                                                <div class="checkbox checkbox-shadow checkbox-primary">
                                                    <input type="checkbox" value="{{$perm_id}}" id="perm_{{$perm_id}}" name="permissions[]"
                                                    {{in_array($perm_id, permissionsOfRole($transRole->role_id)) ||
                                                        in_array($perm_id, permissionsOfRole($editedroleId)) ? 'checked' : ''}}
                                                    >
                                                    <label for="perm_{{$perm_id}}">{{$permission}}</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div> --}}

                        @livewire('admin.edit-role-permissions', [
                            'categories' => $categories,
                            'transRole' => $transRole,
                            'editedroleId' => $editedroleId
                        ])

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="{{route('roles.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
                            </a>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Update Form -->

@endsection



@section('page-vendor-js')
<script src="{{asset('app-assets')}}/vendors/js/extensions/toastr.min.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
@endsection

@section('page-js')
<script src="{{asset('app-assets')}}/js/scripts/extensions/toastr.js"></script>
<script>
    $(document).ready(function () {
        if (window.location.href.indexOf("translated") > -1) {
            $("#transBtn").attr("style", "display: none");
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.select-all').click(function (e) {
            e.preventDefault();
            let $catPermissions = $(this).parents('.card-header').next('.card-body').find('.catPermission');
            $catPermissions.prop('checked', true);
        })
        $('.deselect-all').click(function (e) {
            e.preventDefault();
            let $catPermissions = $(this).parents('.card-header').next('.card-body').find('.catPermission');
            $catPermissions.prop('checked', false);
        })
    });
</script>
<script type="text/javascript">
    @if(Session::has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true,
            "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
        }
  		toastr.success("{{ session('success') }}");
    @endif

    @if ($errors->any())
        @foreach($errors->all() as $error)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "{{app()->getLocale() == 'ar' ? 'toast-top-left' : 'toast-top-right'}}",
            }
            toastr.error("{{$error}}");
        @endforeach
    @endif
</script>
@endsection
