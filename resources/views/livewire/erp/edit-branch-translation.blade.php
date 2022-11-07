<div>
    <div class="form-group col-md-12 mb-50">
        <label class="required" for="name">{{ trans('applang.name') }}</label>
        <div class="position-relative has-icon-left">
            <input id="name"
                   type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   name="name"
                   placeholder="{{trans('applang.name')}}"
                   autocomplete="name"
                   value="{{old('name')}}"
                   autofocus
                   wire:model='name'>
            <div class="form-control-position">
                <i class="bx bxs-lock"></i>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group col-md-12 mb-50">
        <label class="required" for="address">{{ trans('applang.address') }}</label>
        <div class="position-relative has-icon-left">
            <input id="address"
                   type="text"
                   class="form-control @error('address') is-invalid @enderror"
                   name="address"
                   placeholder="{{trans('applang.address')}}"
                   autocomplete="address"
                   value="{{old('address')}}"
                   autofocus
                   wire:model='address'>
            <div class="form-control-position">
                <i class="bx bxs-lock"></i>
            </div>
            @error('address')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <a class="btn btn-warning m-1" href="{{ route('translateEditBranch', $name && $address ? ['name'=>$name, 'address'=>$address] : ['name' => 'test', 'address' => 'test']) }}" id="transBtn">
        <i class="fas fa-language"></i>
        {{trans('applang.translate')}}
    </a>

</div>
