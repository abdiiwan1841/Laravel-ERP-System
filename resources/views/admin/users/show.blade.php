@extends('layouts.admin.admin_layout')
@section('title', trans('applang.show_user'))

@section('vendor-css')
@endsection

@section('page-css')
@endsection

@section('content')
<!-- BEGIN: Content-->
<!-- users view start -->
<section class="users-view">
    <div class="container">
        <!-- users view media object start -->
        <div class="row">
            <div class="col-8 col-sm-7">
                <div class="media mb-2">
                        <span class="user_sub_name_img mr-1"
                              style="height: 64px; width: 64px; {{mb_detect_encoding($user->first_name) != 'UTF-8' ? 'line-height:64px; font-size: 25px' : 'line-height:54px; font-size: 25px'}}">
                            {{subUserName($user->first_name, $user->last_name)}}
                            {{-- <img src="{{$user->image_path}}" alt=""> --}}
                        </span>
                    <div class="media-body pt-25">
                        <h4 class="media-heading"><span class="users-view-name">{{$user->first_name}} {{$user->last_name}} </span></h4>
                        <span>{{trans('applang.code')}} :</span>
                        <span class="users-view-id">{{$user->full_code}}</span>
                    </div>
                </div>
            </div>

            <div class="col-4 col-sm-5">

            </div>
        </div>
        <!-- users view media object ends -->
        <!-- users view card data start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{$user->image_path}}" alt="{{$user->first_name}}" width="150" class="img-thumbnail rounded-circle">
                            <div class="mt-3">
                            <h4>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</h4>
                            <p class="text-secondary mb-1">{{app()->getLocale() == 'ar' ? $user->job->name_ar : $user->job->name_en}}</p>
                            <p class="text-muted font-size-sm">{{$user->address_1}}</p>
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-outline-primary">{{trans('applang.edit')}}</a>
                            <a href="{{route('users.index')}}" class="btn btn-outline-primary">{{trans('applang.back_btn')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <table class="user-view table-responsive" style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.created_at')}}:</th>
                                            <td class="w-100">{{dateHelper($user->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.birth_date')}}:</th>
                                            <td class="w-100">{{$user->birth_date}}</td>
                                        </tr>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.gender')}}:</th>
                                            <td class="w-100">
                                                @if(app()->getLocale() == 'ar' && $user->gender == 'male')
                                                    {{trans('applang.male')}}
                                                @elseif(app()->getLocale() == 'ar' && $user->gender == 'female')
                                                    {{trans('applang.female')}}
                                                @elseif(app()->getLocale() == 'en' && $user->gender == 'male')
                                                    {{trans('applang.male')}}
                                                @elseif(app()->getLocale() == 'en' && $user->gender == 'female')
                                                    {{trans('applang.female')}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.phone')}}:</td>
                                            <td>{{$user->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.address_1')}}:</td>
                                            <td>{{$user->address_1}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.address_2')}}:</td>
                                            <td>{{$user->address_2}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.email')}}:</td>
                                            <td>{{$user->email}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.branch')}}:</td>
                                            <td>{{app()->getLocale() == 'ar' ? $user->branch->name_ar : $user->branch->name_en}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.department')}}:</td>
                                            <td>{{app()->getLocale() == 'ar' ? $user->department->name_ar : $user->department->name_en}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.job')}}:</td>
                                            <td>{{app()->getLocale() == 'ar' ? $user->job->name_ar : $user->job->name_en}}</td>
                                        </tr>

                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.system_user_roles')}}:</td>
                                            <td class="normal-wrap">
                                                @if (Spatie\Permission\Models\Role::count() > 0 && userRolesIds($user->id)->count() > 0)
                                                    {!! "<span class='badge badge-light-primary mr-1 badge-lower'>"
                                                    .implode('</span><span class="badge badge-light-primary mr-1 badge-lower">', userRolesName($user->id))
                                                    ."</span>"!!}
                                                @else
                                                    <span>{{trans('applang.not_found')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="normal-wrap" scope="row">{{trans('applang.basic_permissions')}}:</th>
                                            <td class="normal-wrap">
                                                @if (Spatie\Permission\Models\Role::count() > 0 && userRolesIds($user->id)->count() > 0)
                                                    {!! "<span class='badge badge-light-primary mr-1 badge-lower'>"
                                                    .implode('</span><span class="badge badge-light-primary mr-1 badge-lower">',
                                                            array_unique(userPermissionsNamesViaRoles($user->id)))
                                                    ."</span>"!!}
                                                @else
                                                    <span>{{trans('applang.not_found')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.direct_permissions')}}:</th>
                                            <td class="normal-wrap">
                                                @if ($user->getDirectPermissions()->count() > 0)
                                                    {!! "<span class='badge badge-light-primary mr-1 badge-lower'>"
                                                    .implode('</span><span class="badge badge-light-primary mr-1 badge-lower">', userDirectPermissionsNames($user->id))
                                                    ."</span>"!!}
                                                @else
                                                    <span>{{trans('applang.not_found')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.status')}}:</th>
                                            <td>
                                                @if ($user->status == 1)
                                                    <span class="badge badge-light-success">{{trans('applang.active')}}</span>
                                                @elseif ($user->status == 2)
                                                    <span class="badge badge-light-warning">{{trans('applang.close')}}</span>
                                                @elseif ($user->status == 3)
                                                    <span class="badge badge-light-danger">{{trans('applang.banned')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="no-wrap" scope="row">{{trans('applang.last_activity')}}:</td>
                                            <td>
                                                @if (app()->getLocale() == 'ar')
                                                    {{$user->last_active_at ? date_format($user->last_active_at, ' Y-m-d \الساعة g:ia') : trans('applang.not_found')}}
                                                @else
                                                    {{$user->last_active_at ? date_format($user->last_active_at, 'Y-m-d \o\n g:ia') : trans('applang.not_found')}}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- users view card data ends -->
    </div>
</section>
<!-- users view ends -->
<!-- END: Content-->
@endsection

@section('page-vendor-js')
@endsection

@section('page-js')
@endsection
