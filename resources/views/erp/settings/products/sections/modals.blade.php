<!--Start ِAdd Section Modal -->
<div class="modal fade text-left closeModal" id="formModalAddSection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.add_section')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                        @forelse($addMore as $more)
                        <div class="form-row">
                            <div class="col-sm-9">
                                <div class="form-group mb-50">
                                    <label class="required" for="name">{{ trans('applang.name') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="{{trans('applang.name')}}"
                                               autocomplete="name"
                                               value="{{old('name')}}"
                                               autofocus
                                               wire:model="name.{{$more}}">
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
                            </div>

                            <div class="d-flex align-items-end custom-control custom-switch col-sm-1" data-toggle="tooltip" data-placement="top" title="status">
                                <div class="form-group mb-50">
                                    <label class="">{{trans('applang.status')}}</label>
                                    <input type="checkbox" class="custom-control-input" id="status.{{$more}}" wire:model="status.{{$more}}">
                                    <label class="custom-control-label" for="status.{{$more}}"></label>
                                </div>
                            </div>

                            <div class="col-sm-2 d-flex align-items-end mb-50">
                                <button class="btn btn-light-success btn-xs pl-1 pr-1" wire:ignore wire:click.prevent="AddMore">
                                    <i class="bx bx-plus"></i>
                                </button>
                                @if($loop->index > 0)
                                    <button class="btn btn-light-danger btn-xs mr-1 ml-1 pl-1 pr-1" wire:ignore wire:click.prevent="Remove({{$loop->index}})">
                                        <i class="bx bx-x"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        @endforelse


                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end mt-3">
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
<div class="modal fade text-left closeModal forceClose" id="formModalEditSection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.edit_section')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="col-sm-9">
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
                        </div>

                        <div class="d-flex align-items-end custom-control custom-switch col-sm-1" data-toggle="tooltip" data-placement="top" title="status">
                            <div class="form-group mb-50">
                                <label class="">{{trans('applang.status')}}</label>
                                <input type="checkbox" class="custom-control-input" id="status" wire:model="status">
                                <label class="custom-control-label" for="status"></label>
                            </div>
                        </div>

                    </div>

                    <hr class="hr modal-hr">
                    <div class="d-flex justify-content-end mt-3">
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

