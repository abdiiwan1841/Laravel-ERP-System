@if (\App\Models\ERP\Purchases\Supplier::count() > 0)
    <!--Start Delete Modal -->
    <div class="modal fade text-left" id="formModalDeleteSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.confirm_delete')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('suppliers.destroy', 'test')}}" method="POST">
                        @csrf
                        @method('Delete')
                        <input type="hidden" name="supplier_id" id="supplier_id">

                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.confirm_delete_msg')}}</p>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                            </button>
                            <button type="submit" class="btn btn-danger ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.delete')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->
@endif

@if (isset($supplier) && $supplier->contacts->count() > 0)
    <!--Start Delete Modal -->
    <div class="modal fade text-left" id="formModalDeleteSupplierContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.confirm_delete')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('deleteSupplierContact', 'test')}}" method="POST">
                        @csrf
                        @method('Delete')
                        <input type="hidden" name="supplier_id" id="supplier_id">

                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.confirm_delete_msg')}}</p>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                            </button>
                            <button type="submit" class="btn btn-danger ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.delete')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->
@endif

@if (isset($supplier))
    <!--Start Edit Supplier Opening Balance Modal -->
    <div class="modal fade text-left" id="formModalEditSupplierOpeningBalance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="myModalLabel17">{{trans('applang.edit_opening_balance')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('editSupplierOpeningBalance', 'test')}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="supplier_id" id="supplier_id">

                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.edit_opening_balance_msg')}}</p>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <div class="form-group">
                            <label class="required" for="opening_balance">{{ trans('applang.opening_balance') }}</label>
                            <div class="position-relative has-icon-left">
                                <input id="opening_balance"
                                       type="number"
                                       class="form-control"
                                       name="opening_balance"
                                       placeholder="{{trans('applang.opening_balance')}}"
                                       >
                                <div class="form-control-position">
                                    <i class="bx bx-pen"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="required" for="opening_balance_date">{{ trans('applang.opening_balance_date') }}</label>
                            <div class="position-relative has-icon-left">
                                <input type="text"
                                       id="opening_balance_date"
                                       class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}}"
                                       placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"
                                       name="opening_balance_date"
                                >
                                <div class="form-control-position">
                                    <i class="bx bx-calendar"></i>
                                </div>
                            </div>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                            </button>
                            <button type="submit" class="btn btn-warning ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Edit Supplier Opening Balance Modal -->

    <!--Start Suspend Supplier-->
    <div class="modal fade text-left" id="formModalSuspendSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.suspend_supplier')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('suspendSupplier', 'test')}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="supplier_id" id="supplier_id">

                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.suspend_supplier_msg')}}</p>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                            </button>
                            <button type="submit" class="btn btn-danger ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Edit Supplier Opening Balance Modal -->

    <!--Start Suspend Supplier-->
    <div class="modal fade text-left" id="formModalActivatingSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.activate_supplier')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('activateSupplier', 'test')}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="supplier_id" id="supplier_id">

                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.activate_supplier_msg')}}</p>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <hr class="hr modal-hr">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.close_btn')}}</span>
                            </button>
                            <button type="submit" class="btn btn-success ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Edit Supplier Opening Balance Modal -->
@endif
