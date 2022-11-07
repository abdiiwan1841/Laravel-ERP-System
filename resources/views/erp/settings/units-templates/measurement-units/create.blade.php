@extends('layouts.admin.admin_layout')
@section('title', trans('applang.adjust_measurement_units'))

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
                        <h4 class="modal-title white">
                            {{trans('applang.adjust_measurement_units')}}
                            {{trans('applang.for_template')}}
                            {{app()->getLocale() == 'ar' ? $template->template_name_ar : $template->template_name_en}}
                            ( {{trans('applang.main_unit')}} : {{app()->getLocale() == 'ar' ? $template->main_unit_ar : $template->main_unit_en}} )
                        </h4>
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">
                        <form action="{{route('measurement-units.update', 'test')}}" method="POST">
                            @csrf

                            @method('PATCH')

                            <div class="row">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-small-font table-striped" id="tax_table" style="width: 100%">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="no-wrap">{{trans('applang.largest_unit_ar')}}</th>
                                            <th class="no-wrap">{{trans('applang.largest_unit_en')}}</th>
                                            <th></th>
                                            <th class="no-wrap">{{trans('applang.conversion_factor')}}</th>
                                            <th class="no-wrap">{{trans('applang.symbol_ar')}}</th>
                                            <th class="no-wrap">{{trans('applang.symbol_en')}}</th>
                                            <th class="no-wrap"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($template->measurement_units))
                                            @foreach ($template->measurement_units as $index => $unit )
                                                <tr>
                                                    <input type="hidden" value="{{$template->id}}" name="units_template_id">

                                                    <input type="hidden" value="{{$unit ? $unit->id : ''}}" name="unit_id[]">

                                                    <td width="20%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <div class="input-group">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text text-append" id="basic-addon2">{{trans('applang.one')}}</span>
                                                                </div>
                                                                <input id="largest_unit_ar"
                                                                       type="text"
                                                                       class="form-control @error('largest_unit_ar.'.$index) is-invalid @enderror"
                                                                       name="largest_unit_ar[]"
                                                                       placeholder="{{trans('applang.largest_unit_ar_ex')}}"
                                                                       autocomplete="largest_unit_ar"
                                                                       value="{{$unit ? $unit->largest_unit_ar : old('largest_unit_ar.'.$index)}}"
                                                                >
                                                                @error('largest_unit_ar.'.$index)
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td width="20%">
                                                        <div class="form-group col-md-12 mb-50">
                                                            <div class="input-group">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text text-append" id="basic-addon2">{{trans('applang.one')}}</span>
                                                                </div>
                                                                <input id="largest_unit_en"
                                                                       type="text"
                                                                       class="form-control @error('largest_unit_en.'.$index) is-invalid @enderror"
                                                                       name="largest_unit_en[]"
                                                                       placeholder="{{trans('applang.largest_unit_en_ex')}}"
                                                                       autocomplete="largest_unit_en"
                                                                       value="{{$unit ? $unit->largest_unit_en : old('largest_unit_en.'.$index)}}"
                                                                >
                                                                @error('largest_unit_en.'.$index)
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="text-center">{{trans('applang.equal')}}</td>

                                                    <td width="20%">
                                                        <div class="form-group col-md-12 mb-50">
                                                            <div class="input-group">
                                                                <input id="conversion_factor"
                                                                       type="text"
                                                                       class="form-control @error('conversion_factor.'.$index) is-invalid @enderror"
                                                                       name="conversion_factor[]"
                                                                       placeholder="{{trans('applang.conversion_factor')}}"
                                                                       autocomplete="conversion_factor"
                                                                       value="{{$unit ? $unit->conversion_factor : old('conversion_factor.'.$index)}}"
                                                                >
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">{{app()->getLocale() == 'ar' ? $template->main_unit_ar : $template->main_unit_en}}</span>
                                                                </div>
                                                                @error('conversion_factor.'.$index)
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td width="15%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <div class="position-relative has-icon-left">
                                                                <input id="largest_unit_symbol_ar"
                                                                       type="text"
                                                                       class="form-control @error('largest_unit_symbol_ar.'.$index) is-invalid @enderror"
                                                                       placeholder="{{trans('applang.largest_unit_symbol_ar_ex')}}"
                                                                       name="largest_unit_symbol_ar[]"
                                                                       autocomplete="largest_unit_symbol_ar"
                                                                       value="{{$unit ? $unit->largest_unit_symbol_ar : old('largest_unit_symbol_ar.'.$index)}}"
                                                                >
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pen"></i>
                                                                </div>
                                                                @error('largest_unit_symbol_ar.'.$index)
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td width="15%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <div class="position-relative has-icon-left">
                                                                <input id="largest_unit_symbol_en"
                                                                       type="text"
                                                                       class="form-control @error('largest_unit_symbol_en.'.$index) is-invalid @enderror"
                                                                       placeholder="{{trans('applang.largest_unit_symbol_en_ex')}}"
                                                                       name="largest_unit_symbol_en[]"
                                                                       autocomplete="largest_unit_symbol_en"
                                                                       value="{{$unit ? $unit->largest_unit_symbol_en : old('largest_unit_symbol_en.'.$index)}}"
                                                                >
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pen"></i>
                                                                </div>
                                                                @error('largest_unit_symbol_en.'.$index)
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td width="5%">
                                                        <div class="form-group col-md-12 mb-50">
                                                            <a href="#"
                                                               class="btn btn-light-danger btn-sm form-group delete d-block remove-tax"
                                                               title="{{trans('applang.delete')}}"
                                                               data-toggle="modal"
                                                               data-target="#formModalDeleteUnit"
                                                               data-unit_id="{{$unit->id}}"
                                                               data-largest_unit_ar="{{$unit->largest_unit_ar}}"
                                                               data-largest_unit_en="{{$unit->largest_unit_en}}">
                                                                <i class="bx bx-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-light-primary btn-sm addRow" type="button" >
                                        <i class="bx bx-plus"></i>
                                        <span class="invoice-repeat-btn">{{trans('applang.add_another_unit')}}</span>
                                    </button>
                                </div>

                            </div>

                            <hr class="hr modal-hr">

                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('units-templates.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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

    <!-- measurement units Modals -->
    @include('erp.settings.units-templates.measurement-units.modals')

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
            $('#formModalDeleteUnit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var unit_id = button.data('unit_id')
                var largest_unit_ar = button.data('largest_unit_ar')
                var largest_unit_en = button.data('largest_unit_en')
                var modal = $(this)
                modal.find('.modal-body #unit_id').val(unit_id)
                modal.find('.modal-body #largest_unit_ar').val(largest_unit_ar)
                modal.find('.modal-body #largest_unit_en').val(largest_unit_en)
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
    <script>
        $('.addRow').on('click',function(e){
            e.preventDefault();
            addRow();
        });
        function addRow()
        {
            var tr=
                '<tr>'+

                '<input type="hidden" value="{{$template->id}}" name="units_template_id">'+

                '<input type="hidden" value="" name="unit_id[]">'+

                '<td width="20%"> <div class="form-group col-md-12 mb-50" class="w-100"> <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-append" id="basic-addon2">{{trans('applang.one')}}</span> </div> <input id="largest_unit_ar" type="text" class="form-control @error('largest_unit_ar.*') is-invalid @enderror " name="largest_unit_ar[]" placeholder="{{trans('applang.largest_unit_ar_ex')}}" autocomplete="largest_unit_ar" value="{{old('largest_unit_ar.*')}}" > @error('largest_unit_ar.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

                '<td width="20%"> <div class="form-group col-md-12 mb-50" class="w-100"> <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-append" id="basic-addon2">{{trans('applang.one')}}</span> </div> <input id="largest_unit_en" type="text" class="form-control @error('largest_unit_en.*') is-invalid @enderror " name="largest_unit_en[]" placeholder="{{trans('applang.largest_unit_en_ex')}}" autocomplete="largest_unit_en" value="{{old('largest_unit_en.*')}}" > @error('largest_unit_en.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

                '<td class="text-center">{{trans('applang.equal')}}</td>'+

                '<td width="20%"> <div class="form-group col-md-12 mb-50"> <div class="input-group"> <input id="conversion_factor" type="text" class="form-control @error('conversion_factor.*') is-invalid @enderror" name="conversion_factor[]" placeholder="{{trans('applang.conversion_factor')}}" autocomplete="conversion_factor" value="{{old('conversion_factor.*')}}" > <div class="input-group-append"> <span class="input-group-text" id="basic-addon2">{{app()->getLocale() == 'ar' ? $template->main_unit_ar : $template->main_unit_en}}</span> </div> @error('conversion_factor.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

                '<td width="15%"> <div class="form-group col-md-12 mb-50" class="w-100"> <div class="position-relative has-icon-left"> <input id="largest_unit_symbol_ar" type="text" class="form-control @error('largest_unit_symbol_ar.*') is-invalid @enderror" placeholder="{{trans('applang.largest_unit_symbol_ar_ex')}}" name="largest_unit_symbol_ar[]" autocomplete="largest_unit_symbol_ar" value="{{old('largest_unit_symbol_ar.*')}}" > <div class="form-control-position"> <i class="bx bx-pen"></i> </div> @error('largest_unit_symbol_ar.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

                '<td width="15%"> <div class="form-group col-md-12 mb-50" class="w-100"> <div class="position-relative has-icon-left"> <input id="largest_unit_symbol_ar" type="text" class="form-control @error('largest_unit_symbol_en.*') is-invalid @enderror" placeholder="{{trans('applang.largest_unit_symbol_en_ex')}}" name="largest_unit_symbol_en[]" autocomplete="largest_unit_symbol_ar" value="{{old('largest_unit_symbol_en.*')}}" > <div class="form-control-position"> <i class="bx bx-pen"></i> </div> @error('largest_unit_symbol_ar.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

                '<td width="5%"> <div class="form-group col-md-12 mb-50"> <a href="#" class="btn btn-light-danger btn-sm form-group delete d-block remove"> <i class="bx bx-trash"></i> </a> </div> </td>'+

                '</tr>';
            $('tbody').append(tr);
        };

        $('body').on('click', '.remove', function (e){
            $(this).closest('tr').remove();
        });
    </script>
@endsection



