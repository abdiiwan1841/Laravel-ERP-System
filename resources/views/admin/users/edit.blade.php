@extends('layouts.admin.admin_layout')
@section('title', trans('applang.update_user'))

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/pickers/pickadate/pickadate.css">
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
                    <h4 class="modal-title white">{{trans('applang.update_user')}}</h4>
                </div>
                <div class="card-body mt-1" style="padding-bottom: 13px">
                    <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-row">

                            <div class="col-lg-8">

                                <!--User Names-->
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-50">
                                            <label class="required" for="first_name">{{ trans('applang.first_name') }}</label>
                                            <div class="position-relative has-icon-left">
                                                <input id="first_name"
                                                        type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        name="first_name"
                                                        placeholder="{{trans('applang.first_name')}}"
                                                        autocomplete="first_name"
                                                        value="{{$user->first_name}}"
                                                        autofocus>
                                                <div class="form-control-position">
                                                    <i class="bx bx-user"></i>
                                                </div>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-50">
                                            <label class="required" for="middle_name">{{ trans('applang.middle_name') }}</label>
                                            <div class="position-relative has-icon-left">
                                                <input id="middle_name"
                                                        type="text"
                                                        class="form-control @error('middle_name') is-invalid @enderror"
                                                        name="middle_name"
                                                        placeholder="{{trans('applang.middle_name')}}"
                                                        autocomplete="middle_name"
                                                        value="{{$user->middle_name}}">
                                                <div class="form-control-position">
                                                    <i class="bx bx-user"></i>
                                                </div>
                                                @error('middle_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-50">
                                            <label class="required" for="last_name">{{ trans('applang.last_name') }}</label>
                                            <div class="position-relative has-icon-left">
                                                <input id="last_name"
                                                        type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        name="last_name"
                                                        placeholder="{{trans('applang.last_name')}}"
                                                        autocomplete="last_name"
                                                        value="{{$user->last_name}}">
                                                <div class="form-control-position">
                                                    <i class="bx bx-user"></i>
                                                </div>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--User gender & birthdate-->
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-50">
                                            <label class="required" for="gender">{{trans('applang.gender')}}</label>
                                            <fieldset class="form-group">
                                                <select class="custom-select @error('gender') is-invalid @enderror" id="customSelect" name="gender">
                                                    <option selected disabled>{{trans('applang.select_gender')}}</option>
                                                    <option value="male" {{$user->gender == 'male' ? 'selected' : ''}}>{{trans('applang.male')}}</option>
                                                    <option value="female" {{$user->gender == 'female' ? 'selected' : ''}}>{{trans('applang.female')}}</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-50">
                                            <label class="required" for="birth_date">{{trans('applang.birth_date')}}</label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input id="birth_date"
                                                        type="text"
                                                        name="birth_date"
                                                        class="form-control {{app()->getLocale() == 'ar' ? 'pickadate_ar' : 'pickadate'}} @error('birth_date') is-invalid @enderror"
                                                        placeholder="{{trans('applang.birth_date')}}"
                                                        value="{{$user->birth_date}}">
                                                <div class="form-control-position">
                                                    <i class='bx bx-calendar'></i>
                                                </div>
                                                @if ($errors->has('birth_date'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                                    </span>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                                <!--User email-->
                                <div class="form-group mb-50">
                                    <label class="required" class="text-bold-600" for="email">{{ trans('applang.email_address') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="email"
                                                type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="{{ trans('applang.email_address') }}"
                                                name="email"
                                                autocomplete="email"
                                                value="{{$user->email}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-mail-send"></i>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!--User phone-->
                                <div class="form-group mb-50">
                                    <label class="required" class="text-bold-600" for="phone">{{ trans('applang.phone_number') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="phone"
                                                type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="{{ trans('applang.phone_placeholder') }}"
                                                name="phone"
                                                autocomplete="phone"
                                                value="{{$user->phone}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-mobile"></i>
                                        </div>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!--User address1-->
                                <div class="form-group mb-50">
                                    <label class="required" class="text-bold-600" for="address_1">{{ trans('applang.address_1') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="address_1"
                                               type="text"
                                               class="form-control @error('address_1') is-invalid @enderror"
                                               placeholder="{{ trans('applang.address_1_placeholder') }}"
                                               name="address_1"
                                               autocomplete="address_1"
                                               value="{{$user->address_1}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-map"></i>
                                        </div>
                                        @error('address_1')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <!--User address2-->
                                <div class="form-group mb-50">
                                    <label class="text-bold-600" for="address_2">{{ trans('applang.address_2') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="address_2"
                                               type="text"
                                               class="form-control @error('address_2') is-invalid @enderror"
                                               placeholder="{{ trans('applang.address_2_placeholder') }}"
                                               name="address_2"
                                               autocomplete="address_2"
                                               value="{{$user->address_2}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-map"></i>
                                        </div>
                                        @error('address_2')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <!--User Image-->
                            <div class="col-lg-4">
                                <div class="img-container">
                                    <label for="fileField" class="attachment mt-2">
                                        <div class="row btn-file">
                                            <div class="btn-file__preview"></div>
                                                <div class="btn-file__actions">
                                                    <div class="btn-file__actions__item col-xs-12 text-center">
                                                        <div class="btn-file__actions__item--shadow">
                                                            <i class="bx bxs-cloud-upload" style="font-size: 50px"></i>
                                                            <div class="visible-xs-block"></div>
                                                            {{trans('applang.select_user_img')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <input name="user_image" type="file" id="fileField" class="hidden">
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <!--User branch-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="branch_id">{{ trans('applang.branch') }}</label>
                                    <fieldset class="form-group">
                                        <select id="branch_id" class="custom-select @error('branch_id') is-invalid @enderror" name='branch_id'>
                                            <option value="" selected disabled>{{trans('applang.select_branch')}}</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" {{$user->branch_id == $branch->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ? $branch->name_ar: $branch->name_en}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('branch_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('branch_id') }}</strong>
                                            </span>
                                        @endif
                                    </fieldset>
                                </div>
                            </div>

                            <!--User status-->
                            <div class="col-md-6">
                                <div class="form-group mb-50">
                                    <label class="required" for="status">{{ trans('applang.status') }}</label>
                                    <select id="status" class="form-control @error('status') is-invalid @enderror" name='status'>
                                        <option value="0" selected disabled>{{trans('applang.select_status')}}</option>
                                        <option value="1" {{$user->status == 1 ? 'selected' : ''}}>{{trans('applang.active')}}</option>
                                        <option value="2" {{$user->status == 2 ? 'selected' : ''}}>{{trans('applang.close')}}</option>
                                        <option value="3" {{$user->status == 3 ? 'selected' : ''}}>{{trans('applang.banned')}}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <!--User department-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="department">{{ trans('applang.department') }}</label>
                                    <fieldset class="form-group">
                                        <select id="department_id" class="custom-select @error('department_id') is-invalid @enderror" name='department_id'>
                                            <option value="" selected disabled>{{trans('applang.select_department')}}</option>
                                            @foreach($categories as $key => $category)
                                                <option value="{{$key}}" {{$user->department->id == $key ? 'selected' : ''}}>{{$category}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('department_id') }}</strong>
                                            </span>
                                        @endif
                                    </fieldset>
                                </div>
                            </div>

                            <!--User job role-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="job">{{ trans('applang.job') }}</label>
                                    <fieldset class="form-group">
                                        <select id="job_id" class="custom-select @error('job_id') is-invalid @enderror" name='job_id'>
                                            <option value="" selected disabled>{{trans('applang.select_job')}}</option>
                                            @foreach ($jobs as $job)
                                                <option value="{{$job->id}}" {{$user->job->id == $job->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ? $job->name_ar : $job->name_en}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('job_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('job_id') }}</strong>
                                            </span>
                                        @endif
                                    </fieldset>
                                </div>
                            </div>
                        </div>


                        <!--User passwords-->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                            <label class="text-bold-600" for="password">{{ trans('applang.password') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="password"
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="{{ trans('applang.password') }}"
                                        name="password"
                                        autocomplete="new-password">
                                <div class="form-control-position">
                                    <i class="bx bx-lock"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                            <label class="text-bold-600" for="password-confirm">{{ trans('applang.confirm_password') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="password-confirm"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        placeholder="{{ trans('applang.confirm_password') }}"
                                        autocomplete="new-password">
                                <div class="form-control-position">
                                    <i class="bx bx-lock"></i>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>

                        <!--User system auth and roles & permissions-->
                        <div x-data="{ open: {{$user->system_user == 1 ? 'true' : 'false'}} }">
                            <label class="required text-bold-600">{{trans('applang.system_use_auth')}}</label>
                            <div class="form-row mb-2 mt-1">
                                <div class="col-md-3">
                                    <fieldset>
                                        <div class="checkbox checkbox-shadow checkbox-primary">
                                            <input type="checkbox" class="checkbox-input" id="system_not_user" name="system_not_user"
                                                   value="1" {{$user->system_not_user == '1' ? 'checked' : 'disabled'}} @click="open = false">
                                            <label for="system_not_user">{{trans('applang.system_not_user')}}</label>
                                        </div>
                                    </fieldset>
                                    @if ($errors->has('system_not_user'))
                                        <small><strong class="text-danger">{{ $errors->first('system_not_user') }}</strong></small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <fieldset>
                                        <div class="checkbox checkbox-shadow checkbox-primary">
                                            <input type="checkbox" class="checkbox-input" id="system_user" name="system_user" @click="open = ! open"
                                                   value="1" {{$user->system_user == '1' ? 'checked' : 'disabled'}}>
                                            <label for="system_user">{{trans('applang.system_user')}}</label>
                                        </div>
                                    </fieldset>
                                    @if ($errors->has('roles_name'))
                                        <small><strong class="text-danger">{{ $errors->first('roles_name') }}</strong></small>
                                    @endif
                                    @if ($errors->has('system_user'))
                                        <small><strong class="text-danger">{{ $errors->first('system_user') }}</strong></small>
                                    @endif
                                </div>
                            </div>

                            <div x-show="open">
                                @if($user->system_not_user == 1)
                                    @livewire('admin.create-user-roles-and-permissions', [
                                        'roles' => $roles,
                                        'permissions' => $permissions,
                                        'categories' => $categories,
                                    ])

                                @else
                                    @livewire('admin.edit-user-roles-and-permissions',[
                                        'user'=> $user,
                                        'userRoles' => $userRoles,
                                        'roles' => $roles,
                                        'permissions' => $permissions,
                                        'categories'  => $categories
                                    ])

                                @endif
                            </div>
                        </div>



                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="{{route('users.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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
        $('.select-all').click(function (e) {
            e.preventDefault();
            let $catPermissions = $(this).parents('.card-header').next('.card-body').find('.catPermission');
            // $catPermissions.prop('checked', true);
            $catPermissions.each(function(){
                if(! $(this).prop('disabled')) {
                    $(this).prop('checked', true);
                }
            })
        })
        $('.deselect-all').click(function (e) {
            e.preventDefault();
            let $catPermissions = $(this).parents('.card-header').next('.card-body').find('.catPermission');
            // $catPermissions.prop('checked', false);
            $catPermissions.each(function(){
                if(! $(this).prop('disabled')) {
                    $(this).prop('checked', false);
                }
            })
        })
    });
</script>

<script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.js"></script>
<script src="{{asset('app-assets')}}/vendors/js/pickers/pickadate/picker.date.js"></script>
<script>
    // Basic date
    $('.pickadate').pickadate({
        format: 'yyyy-mm-dd',
        labelMonthNext: 'next month',
        labelMonthPrev: 'previous month',
        labelMonthSelect: 'Pick a month from the dropdown',
        labelYearSelect: 'Pick a year from the dropdown',
        selectMonths: true,
        selectYears: 60
    });

    $( '.pickadate_ar' ).pickadate({
        format: 'yyyy-mm-dd',
        monthsFull: [ 'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر' ],
        weekdaysShort: [ 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت' ],
        today: 'اليوم',
        clear: 'مسح',
        close: 'إغلاق',
        labelMonthNext: 'الشهر التالى',
        labelMonthPrev: 'الشهر السابق',
        labelMonthSelect: 'إختر الشهر',
        labelYearSelect: 'إختر السنة',
        selectMonths: true,
        selectYears: 60
    })
</script>

<script>
    jQuery(($) => {
            $('.btn-file__preview')
            .css({
                'background-image': 'url({{$user->image_path}})'
            });
    });
    jQuery(($) => {
        $('.attachment input[type="file"]')
            .on('change', (event) => {
            let el = $(event.target).closest('.attachment').find('.btn-file');

            if (window.matchMedia('(min-width: 486px)').matches)
            {
                el
                .find('.btn-file__actions__item')
                .css({
                    'padding': '158px 105px'
                });
            }

            if (window.matchMedia('(max-width: 485px)').matches)
            {
                el
                .find('.btn-file__actions__item')
                .css({
                    'padding': '45px 30px'
                });
            }

            el
            .find('.btn-file__preview')
            .css({
                'background-image': 'url(' + window.URL.createObjectURL(event.target.files[0]) + ')'
            });
        });

    });
</script>
<script>
    jQuery(($) => {
        //system use authentication (prevent multiple checked)
        $('#system_not_user').on('click', function () {
            var n = $('#system_user');
            if ($(this).is(':checked')) {
                console.log('ok')
                n.attr('checked',false);
                n.attr('disabled', true);
            } else {
                n.attr('disabled',false);
            }
        });

        $('#system_user').on('click', function () {
            var n = $('#system_not_user');

            if ($(this).is(':checked')) {
                console.log('ok')
                n.attr('checked',false);
                n.attr('disabled', true);
            } else {
                n.attr('disabled',false);
            }
        });
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
