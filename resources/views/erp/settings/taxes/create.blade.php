@extends('layouts.admin.admin_layout')
@section('title', trans('applang.tax_add'))

@section('vendor-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/vendors/css/extensions/sweetalert2.min.css">
@endsection
@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets')}}/css/plugins/extensions/toastr.css">
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header modal-header bg-primary">
                        <h4 class="modal-title white">{{trans('applang.tax_add')}}</h4>
                    </div>
                    <div class="card-body mt-1" style="padding-bottom: 13px">
                        <form action="{{route('taxes.update', 'test')}}" method="POST" style="width: 100%">
                            @csrf

                            @method('PATCH')

                            <div class="row">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-small-font table-striped" id="tax_table" style="width: 100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="no-wrap">{{trans('applang.tax_name_ar')}}</th>
                                                <th class="no-wrap">{{trans('applang.tax_name_en')}}</th>
                                                <th class="no-wrap">{{trans('applang.tax_value')}}</th>
                                                <th class="no-wrap">{{trans('applang.unit_price')}}</th>
                                                <th class="no-wrap"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($taxes))
                                                @foreach ($taxes as $index => $tax )
                                                <tr>
                                                    <input type="hidden" value="{{$tax ? $tax->id : ''}}" name="tax_id[]">
                                                    <td width="25%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <div class="position-relative has-icon-left">
                                                                <input id="tax_name_ar"
                                                                        type="text"
                                                                        class="form-control @error('tax_name_ar.'.$index) is-invalid @enderror"
                                                                        name="tax_name_ar[]"
                                                                        placeholder="{{trans('applang.tax_name_ar')}}"
                                                                        autocomplete="tax_name_ar"
                                                                        value="{{$tax ? $tax->tax_name_ar : old('tax_name_ar.'.$index)}}"
                                                                >
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pen"></i>
                                                                </div>
                                                                @error('tax_name_ar.'.$index)
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="25%">
                                                        <div class="form-group col-md-12 mb-50">
                                                            <div class="position-relative has-icon-left" class="w-100">
                                                                <input id="tax_name_en"
                                                                        type="text"
                                                                        class="form-control @error('tax_name_en.'.$index) is-invalid @enderror"
                                                                        name="tax_name_en[]"
                                                                        placeholder="{{trans('applang.tax_name_en')}}"
                                                                        autocomplete="tax_name_en"
                                                                        value="{{$tax ? $tax->tax_name_en : old('tax_name_en.'.$index)}}"
                                                                >
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-pen"></i>
                                                                </div>
                                                                @error('tax_name_en.'.$index)
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="25%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                        class="form-control @error('tax_value.'.$index) is-invalid @enderror"
                                                                        placeholder="{{trans('applang.tax_value')}}"
                                                                        name="tax_value[]"
                                                                        autocomplete="tax_value"
                                                                        value="{{$tax ? floor($tax->tax_value *100)/100 : old('tax_value.'.$index)}}"
                                                                        >
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                                </div>
                                                                @error('tax_value.'.$index)
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="25%">
                                                        <div class="form-group col-md-12 mb-50" class="w-100">
                                                            <select id="model" class="custom-select @error('unit_price_inc.'.$index) is-invalid @enderror" name='unit_price_inc[]'>
                                                                <option value="" selected disabled>{{ trans('applang.choose_include') }}</option>
                                                                <option value="0" {{$tax && $tax->unit_price_inc == 0 ? 'selected' : ''}}>{{ trans('applang.not_included') }}</option>
                                                                <option value="1" {{$tax && $tax->unit_price_inc == 1 ? 'selected' : ''}}>{{trans('applang.included')}}</option>
                                                            </select>
                                                            @if ($errors->has('unit_price_inc.'.$index))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('unit_price_inc.'.$index) }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group col-md-12 mb-50">
                                                            <a href="#"
                                                                 class="btn btn-light-danger btn-sm form-group delete d-block remove-tax"
                                                                 title="{{trans('applang.delete')}}"
                                                                 data-toggle="modal"
                                                                 data-target="#formModalDeleteTax"
                                                                 data-tax_id="{{$tax->id}}"
                                                                 data-tax_name_ar="{{$tax->tax_name_ar}}"
                                                                 data-tax_name_en="{{$tax->tax_name_en}}">
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
                                        <span class="invoice-repeat-btn">{{trans('applang.add_another_tax')}}</span>
                                    </button>
                                </div>
                            </div>

                            <hr class="hr modal-hr">
                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="{{route('dashboard')}}" class="btn btn-light-secondary" data-dismiss="modal">
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

    <!-- taxes Modals -->
    @include('erp.settings.taxes.modals')

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
            $('#formModalDeleteTax').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var tax_id = button.data('tax_id')
                var tax_name_ar = button.data('tax_name_ar')
                var tax_name_en = button.data('tax_name_en')
                var modal = $(this)
                modal.find('.modal-body #tax_id').val(tax_id)
                modal.find('.modal-body #tax_name_ar').val(tax_name_ar)
                modal.find('.modal-body #tax_name_en').val(tax_name_en)
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
            '<input type="hidden" value="" name="tax_id[]">'+

            '<td width="25%"><div class="form-group col-md-12 mb-50" class="w-100"><div class="position-relative has-icon-left"><input id="tax_name_ar" type="text" class="form-control @error('tax_name_ar.*') is-invalid @enderror" name="tax_name_ar[]" placeholder="{{trans('applang.tax_name_ar')}}" autocomplete="tax_name_ar" value="{{old('tax_name_ar.*')}}"> <div class="form-control-position"> <i class="bx bx-pen"></i> </div> @error('tax_name_ar.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span> @enderror </div> </div> </td>'+

            '<td width="25%"> <div class="form-group col-md-12 mb-50"> <div class="position-relative has-icon-left" class="w-100"> <input id="tax_name_en" type="text" class="form-control @error('tax_name_en.*') is-invalid @enderror" name="tax_name_en[]" placeholder="{{trans('applang.tax_name_en')}}" autocomplete="tax_name_en" value="{{old('tax_name_en.*')}}" > <div class="form-control-position"> <i class="bx bx-pen"></i> </div> @error('tax_name_en.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

            '<td width="25%"> <div class="form-group col-md-12 mb-50" class="w-100"> <div class="input-group"> <input type="text" class="form-control @error('tax_value.*') is-invalid @enderror" placeholder="{{trans('applang.tax_value')}}" name="tax_value[]" autocomplete="tax_value" value="{{old('tax_value.*')}}" > <div class="input-group-append"> <span class="input-group-text" id="basic-addon2">%</span> </div> @error('tax_value.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> </td>'+

            '<td width="25%"> <div class="form-group col-md-12 mb-50" class="w-100"> <select id="model" class="custom-select @error('unit_price_inc.*') is-invalid @enderror" name="unit_price_inc[]"> <option value="" selected disabled>{{ trans('applang.choose_include') }}</option> <option value="0">{{ trans('applang.not_included') }}</option> <option value="1">{{trans('applang.included')}}</option> </select> @if ($errors->has('unit_price_inc.*')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('unit_price_inc.*') }}</strong> </span> @endif </div> </td>'+

            '<td> <div class="form-group col-md-12 mb-50"> <a href="#" class="btn btn-light-danger btn-sm form-group delete d-block remove"> <i class="bx bx-trash"></i> </a> </div> </td>'+
            '</tr>';
            $('tbody').append(tr);
        };

        $('body').on('click', '.remove', function (e){
            $(this).closest('tr').remove();
        });
    </script>

    <script>
        $(document).ready(function() {
            var last=$('tbody tr').length;

            var first = $('tbody tr:first .remove-tax')
            first.addClass('hidden');

            // if(last==1){
            //     $('.remove-tax').addClass('hidden');
            // }

            // $('body').on('click', '.remove', function (e){
            //     var last2=$('tbody tr').length;
            //     if(last2==1){
            //         $('.remove-tax').addClass('hidden');
            //     }
            // });
        });

        // $('body').on('click', '.addRow',function() {
        //     $('.remove-tax').removeClass('hidden');
        // });
    </script>

@endsection

