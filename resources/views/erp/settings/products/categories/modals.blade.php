<!--Start ِAdd Section Modal -->
<div class="modal fade text-left closeModal" id="formModalAddCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.add_category')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" autocomplete="off">
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

                    <div class="form-group mb-50">
                        <label for="section_id" class="required">{{trans('applang.the_section')}}</label>
                        <select id="section_id" class="custome-select form-control @error('section_id') is-invalid @enderror" wire:model="section_id">
                            <option value="#" selected>{{trans('applang.select_section')}}</option>
                            @foreach($sections as $section)
                                <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('section_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('section_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <div class="col-sm-12 pl-0 pr-0 mb-0">
                            <label class="required">{{trans('applang.brands')}}</label>
                        </div>
                        @if ($errors->has('brand_id'))
                            <small><strong class="text-danger">{{ $errors->first('brand_id') }}</strong></small>
                        @endif
                        <div class="row">
                            @foreach ($brands as $brand)
                                <div class="col-sm-3 mb-1">
                                    <div>
                                        <fieldset>
                                            <div class="checkbox checkbox-shadow checkbox-primary">
                                                <input type="checkbox" value="{{$brand->id}}" id="brand_{{$brand->id}}" wire:model="brand_id">
                                                <label class="card-text" for="brand_{{$brand->id}}">{{$brand->name}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex align-items-end custom-control custom-switch col-sm-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="{{trans('applang.status')}}">
                        <div class="form-group">
                            <label class="">{{trans('applang.status')}}</label>
                            <input type="checkbox" class="custom-control-input" id="status" wire:model="status">
                            <label class="custom-control-label" for="status"></label>
                        </div>
                    </div>

                    <hr class="hr modal-hr mb-2">
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
<!--End Add Section Modal -->

<!--Start Edit Section Modal -->
<div class="modal fade text-left closeModal forceClose" id="formModalEditCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.edit_category')}}</h4>
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

                    <div class="form-group mb-50">
                        <label for="section_id" class="required">{{trans('applang.the_section')}}</label>
                        <select id="section_id" class="custome-select form-control @error('section_id') is-invalid @enderror" wire:model="section_id">
                            <option value="#" selected>{{trans('applang.select_section')}}</option>
                            @foreach($sections as $section)
                                <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('section_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('section_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <div class="col-sm-12 pl-0 pr-0 mb-0">
                            <label class="required">{{trans('applang.brands')}}</label>
                        </div>
                        @if ($errors->has('brand_id'))
                            <small><strong class="text-danger">{{ $errors->first('brand_id') }}</strong></small>
                        @endif
                        <div class="row">
                            @foreach ($brands as $brand)
                                <div class="col-sm-3 mb-1">
                                    <div>
                                        <fieldset>
                                            <div class="checkbox checkbox-shadow checkbox-primary">
                                                <input type="checkbox" value="{{$brand->id}}" id="brand_{{$brand->id}}" wire:model="brand_id">
                                                <label class="card-text" for="brand_{{$brand->id}}">{{$brand->name}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex align-items-end custom-control custom-switch col-sm-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="{{trans('applang.status')}}">
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
<!--End Edit Section Modal -->

