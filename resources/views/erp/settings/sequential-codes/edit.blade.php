@extends('layouts.admin.admin_layout')
@section('title', trans('applang.seq_code_edit'))

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
                        <h4 class="modal-title white">{{trans('applang.seq_code_edit')}}</h4>
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">
                        <form action="{{route('sequential-codes.update', $code->id)}}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="model">{{ trans('applang.model') }}</label>
                                <fieldset class="form-group">
                                    <select id="model" class="custom-select @error('model') is-invalid @enderror" name='model'>
                                        <option value="" selected disabled>{{trans('applang.select_model')}}</option>
                                        @foreach($tables as $table)
                                            @if(!in_array($table->{$db}, $rejected))
                                                <option value="{{  $table->{$db} }}" {{$code->model == $table->{$db} ? 'selected' : 'disabled'}}>
                                                    {{  $table->{$db} }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('model'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('model') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="prefix">{{ trans('applang.prefix') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="prefix"
                                           type="text"
                                           class="form-control @error('prefix') is-invalid @enderror"
                                           name="prefix"
                                           placeholder="{{trans('applang.prefix')}}"
                                           autocomplete="prefix"
                                           value="{{$code->prefix}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bxs-lock"></i>
                                    </div>
                                    @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-50">
                                <label class="required" for="numbers_length">{{ trans('applang.numbers_length') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="numbers_length"
                                           type="text"
                                           class="form-control @error('numbers_length') is-invalid @enderror"
                                           name="numbers_length"
                                           placeholder="{{trans('applang.numbers_length')}}"
                                           autocomplete="numbers_length"
                                           value="{{$code->numbers_length}}"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bxs-lock"></i>
                                    </div>
                                    @error('numbers_length')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('sequential-codes.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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

