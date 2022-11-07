<!--Start ِAdd Brand Modal -->
<div class="modal fade text-left closeModal" id="formModalAddBrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.add_brand')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group mb-1">
                        <label class="required" for="name">{{ trans('applang.name') }}</label>
                        <div class="position-relative has-icon-left is-invalid">
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{trans('applang.name')}}"
                                   autocomplete="name"
                                   value="{{old('name')}}"
                                   autofocus
                                   wire:model="name">
                            <div class="form-control-position">
                                <i class="bx bx-pen"></i>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 pl-0 pr-0">
                            <label class="required">{{trans('applang.sections')}}</label>
                        </div>
                        @if ($errors->has('section_id'))
                            <small><strong class="text-danger">{{ $errors->first('section_id') }}</strong></small>
                        @endif
                        <div class="row">
                            @foreach ($sections as $section)
                                <div class="col-sm-3 mt-1">
                                    <div>
                                        <fieldset>
                                            <div class="checkbox checkbox-shadow checkbox-primary">
                                                <input type="checkbox" value="{{$section->id}}" id="section_{{$section->id}}" wire:model="section_id">
                                                <label class="card-text" for="section_{{$section->id}}">{{$section->name}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex align-items-end custom-control custom-switch col-sm-1 mb-50" data-toggle="tooltip" data-placement="bottom" title="{{trans('applang.status')}}">
                        <div class="form-group">
                            <label class="">{{trans('applang.status')}}</label>
                            <input type="checkbox" class="custom-control-input" id="status" wire:model="status">
                            <label class="custom-control-label" for="status"></label>
                        </div>
                    </div>

                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                        </button>
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
<!--End Add Brand Modal -->

<!--Start Edit Brand Modal -->
<div class="modal fade text-left closeModal forceClose" id="formModalEditBrand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.edit_brand')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <div class="form-group mb-50">
                        <label class="required" for="name">{{ trans('applang.name') }}</label>
                        <div class="position-relative has-icon-left">
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{trans('applang.name')}}"
                                   autocomplete="name"
                                   value="{{old('name')}}"
                                   autofocus
                                   wire:model="name">
                            <div class="form-control-position">
                                <i class="bx bx-pen"></i>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 pl-0 pr-0">
                            <label class="required">{{trans('applang.sections')}}</label>
                        </div>
                        @if ($errors->has('section_id'))
                            <small><strong class="text-danger">{{ $errors->first('section_id') }}</strong></small>
                        @endif
                        <div class="row">
                            @foreach ($sections as $section)
                                <div class="col-sm-3 mt-1">
                                    <div>
                                        <fieldset>
                                            <div class="checkbox checkbox-shadow checkbox-primary">
                                                <input type="checkbox" value="{{$section->id}}" id="section_{{$section->id}}" wire:model="section_id">
                                                <label class="card-text" for="section_{{$section->id}}">{{$section->name}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex align-items-end custom-control custom-switch col-sm-1 mb-50" data-toggle="tooltip" data-placement="bottom" title="{{trans('applang.status')}}">
                        <div class="form-group">
                            <label class="">{{trans('applang.status')}}</label>
                            <input type="checkbox" class="custom-control-input" id="status" wire:model="status">
                            <label class="custom-control-label" for="status"></label>
                        </div>
                    </div>

                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                        </button>
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
<!--End Edit Brand Modal -->

{{--@push('scripts')
    <script>
        $(document).ready(function() {
            $('.section_id').select2({
                placeholder: "{{trans('applang.select_section')}}",
            }).on('change', function () {

                let placeholder = $('.select2-search__field');
                placeholder[0].style.setProperty("width", "0.75em", "important") //hide placeholder
                if($('.select2-selection__choice').length < 1){
                    placeholder[0].style.setProperty("width", "100%", "important") //show placeholder if no selections
                }

                @this.set('section_id', $(this).val());
            });
        });
    </script>
@endpush--}}

