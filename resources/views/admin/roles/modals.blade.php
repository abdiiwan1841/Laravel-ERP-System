@if (Spatie\Permission\Models\Role::count() > 0)
<!--Start Delete Modal -->
<div class="modal fade text-left" id="formModalDeleteRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title white" id="myModalLabel17">{{trans('applang.confirm_delete')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('roles.destroy', $role)}}" method="POST">
                    @csrf
                    @method('Delete')
                    <input type="hidden" name="role_id" id="role_id">

                    @if (app()->getLocale() == 'ar')
                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.confirm_delete_msg')}}</p>
                            <input type="text" class="form-control" name="name_ar" id="name_ar" readonly>
                        </div>
                    @else
                        <div class="form-group">
                            <p class="text-danger font-weight-bold">{{trans('applang.confirm_delete_msg')}}</p>
                            <input type="text" class="form-control" name="name_en" id="name_en" readonly>
                        </div>
                    @endif

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
