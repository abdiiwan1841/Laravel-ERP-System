<div class="card">
    <div class="card-header modal-header bg-primary">
        <h4 class="modal-title white">{{trans('applang.edit_sales_invoice')}} # ({{$salesInvoice->inv_number}})</h4>
    </div>

    <div class="card-body mt-1" style="padding-bottom: 13px">
        <div class="row">
            <!--Client Data-->
            <div class="col-md-6">
                <div class="input-group">
                    <div style="width: 85%">
                        <label class="required" for="client_id">{{ trans('applang.client') }}</label>
                        <fieldset class="form-group">
                            <select id="client_id" class="custom-select @error('client_id') is-invalid @enderror text-append-logo" name='client_id' wire:model="client_id">
                                <option value="" selected>{{trans('applang.select_client')}}</option>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{$client->full_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('client_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('client_id') }}</strong>
                                </span>
                            @endif
                        </fieldset>
                    </div>
                    <a href="#"
                       class="btn btn-primary btn-sm text-append-reset" title="{{trans('applang.add_new')}}"
                       style="width: 15%;height: fit-content;align-items: center;margin-top: 23px;line-height: 2;"
                       wire:click.prevent="showCreateClient">
                        <i class="bx bx-plus-circle"></i>
                    </a>
                </div>

                <!--create Client-->
                <div class="client-form" style="display: {{$showCreateClient == false ? 'none' : 'block'}}">
                    <form wire:submit.prevent="saveNewClient">
                        <!--Full Name-->
                        <label class="required" for="full_name">{{ trans('applang.full_name') }}</label>
                        <div class="position-relative has-icon-left mb-50">
                            <input id="full_name"
                                   type="text"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   name="full_name"
                                   placeholder="{{trans('applang.full_name')}}"
                                   autocomplete="full_name"
                                   autofocus
                                   wire:model="full_name">
                            <div class="form-control-position">
                                <i class="bx bx-pen"></i>
                            </div>
                            @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!--Country-->
                        <label class="" for="country">{{ trans('applang.country') }}</label>
                        <fieldset class="form-group">
                            <select id="country" class="custom-select @error('country') is-invalid @enderror" name='country' wire:model="country">
                                <option value="">{{trans('applang.select_country')}}</option>
                                @foreach($countries as $key => $value)
                                    <option value="{{$key}}">
                                        {{app()->getLocale() == 'ar' ? $value['name'] : $value['en_name']}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </fieldset>

                        <!--Phone & Mobile-->
                        <div class="form-row mb-50">
                            <div class="col-md-6">
                                <label class="" for="phone">{{ trans('applang.phone') }}</label>
                                <div class="input-group" dir="ltr">
                                    <div class="input-group-append" style="width: 25%">
                                        <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                               placeholder="&#9872; &#9743;" wire:model="phone_code">
                                    </div>
                                    <input id="phone"
                                           type="number"
                                           class="form-control @error('phone') is-invalid @enderror text-append-phone"
                                           name="phone"
                                           placeholder="{{trans('applang.phone')}}"
                                           autocomplete="phone"
                                           wire:model="phone"
                                    >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="mobile">{{ trans('applang.mobile') }}</label>
                                <div class="input-group" dir="ltr">
                                    <div class="input-group-append" style="width: 25%">
                                        <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                               placeholder="&#9872; &#9743;" value="{{old('phone_code')}}" wire:model="phone_code">
                                    </div>
                                    <input id="mobile"
                                           type="number"
                                           class="form-control @error('mobile') is-invalid @enderror text-append-phone"
                                           name="mobile"
                                           placeholder="{{trans('applang.mobile')}}"
                                           autocomplete="mobile"
                                           wire:model="mobile"
                                    >
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!--Street Adress & Postal Code-->
                        <div class="form-row mb-50">
                            <div class="col-md-9">
                                <label class="" for="street_address">{{ trans('applang.street_address') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="street_address"
                                           type="text"
                                           class="form-control @error('street_address') is-invalid @enderror"
                                           name="street_address"
                                           placeholder="{{trans('applang.street_address')}}"
                                           autocomplete="street_address"
                                           wire:model="street_address"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="postal_code">{{ trans('applang.postal_code') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="postal_code"
                                           type="number"
                                           class="form-control @error('postal_code') is-invalid @enderror"
                                           name="postal_code"
                                           placeholder="{{trans('applang.postal_code')}}"
                                           autocomplete="postal_code"
                                           wire:model="postal_code"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!--State & City-->
                        <div class="form-row mb-50">
                            <div class="col-md-6">
                                <label class="" for="state">{{ trans('applang.state') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="state"
                                           type="text"
                                           class="form-control @error('state') is-invalid @enderror"
                                           name="state"
                                           placeholder="{{trans('applang.state')}}"
                                           autocomplete="state"
                                           wire:model="state"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="" for="city">{{ trans('applang.city') }}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="city"
                                           type="text"
                                           class="form-control @error('city') is-invalid @enderror"
                                           name="city"
                                           placeholder="{{trans('applang.city')}}"
                                           autocomplete="city"
                                           wire:model="city"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2rem">
                            <a href="" class="btn btn-light-secondary" wire:click.prevent="cancelCreateClient">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.cancel')}}</span>
                            </a>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                            </button>
                        </div>

                    </form>
                </div>

            @if($client_id)
                <!--Edit Client-->
                    <div class="client-form" style="display: {{$showEditClient == false ? 'none' : 'block'}}">
                        <form wire:submit.prevent="saveEditClient">
                            <!--Full Name-->
                            <label class="required" for="full_name">{{ trans('applang.full_name') }}</label>
                            <div class="position-relative has-icon-left mb-50">
                                <input id="full_name"
                                       type="text"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       name="full_name"
                                       placeholder="{{trans('applang.full_name')}}"
                                       autocomplete="full_name"
                                       autofocus
                                       wire:model="full_name">
                                <div class="form-control-position">
                                    <i class="bx bx-pen"></i>
                                </div>
                                @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <!--Country-->
                            <label class="" for="country">{{ trans('applang.country') }}</label>
                            <fieldset class="form-group">
                                <select id="country" class="custom-select @error('country') is-invalid @enderror" name='country' wire:model="country">
                                    <option value="">{{trans('applang.select_country')}}</option>
                                    @foreach($countries as $key => $value)
                                        <option value="{{$key}}">
                                            {{app()->getLocale() == 'ar' ? $value['name'] : $value['en_name']}}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </fieldset>

                            <!--Phone & Mobile-->
                            <div class="form-row mb-50">
                                <div class="col-md-6">
                                    <label class="" for="phone">{{ trans('applang.phone') }}</label>
                                    <div class="input-group" dir="ltr">
                                        <div class="input-group-append" style="width: 25%">
                                            <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                   placeholder="&#9872; &#9743;" value="{{old('phone_code')}}" wire:model="phone_code">
                                        </div>
                                        <input id="phone"
                                               type="number"
                                               class="form-control @error('phone') is-invalid @enderror text-append-phone"
                                               name="phone"
                                               placeholder="{{trans('applang.phone')}}"
                                               autocomplete="phone"
                                               wire:model="phone"
                                        >
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile">{{ trans('applang.mobile') }}</label>
                                    <div class="input-group" dir="ltr">
                                        <div class="input-group-append" style="width: 25%">
                                            <input type="text" class="form-control text-append-phone-code phone_code text-center" readonly name="phone_code"
                                                   placeholder="&#9872; &#9743;" value="{{old('phone_code')}}" wire:model="phone_code">
                                        </div>
                                        <input id="mobile"
                                               type="number"
                                               class="form-control @error('mobile') is-invalid @enderror text-append-phone"
                                               name="mobile"
                                               placeholder="{{trans('applang.mobile')}}"
                                               autocomplete="mobile"
                                               wire:model="mobile"
                                        >
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!--Street Adress & Postal Code-->
                            <div class="form-row mb-50">
                                <div class="col-md-9">
                                    <label class="" for="street_address">{{ trans('applang.street_address') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="street_address"
                                               type="text"
                                               class="form-control @error('street_address') is-invalid @enderror"
                                               name="street_address"
                                               placeholder="{{trans('applang.street_address')}}"
                                               autocomplete="street_address"
                                               wire:model="street_address">
                                        <div class="form-control-position">
                                            <i class="bx bx-pen"></i>
                                        </div>
                                        @error('street_address')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="postal_code">{{ trans('applang.postal_code') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="postal_code"
                                               type="number"
                                               class="form-control @error('postal_code') is-invalid @enderror"
                                               name="postal_code"
                                               placeholder="{{trans('applang.postal_code')}}"
                                               autocomplete="postal_code"
                                               wire:model="postal_code">
                                        <div class="form-control-position">
                                            <i class="bx bx-pen"></i>
                                        </div>
                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!--State & City-->
                            <div class="form-row mb-50">
                                <div class="col-md-6">
                                    <label class="" for="state">{{ trans('applang.state') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="state"
                                               type="text"
                                               class="form-control @error('state') is-invalid @enderror"
                                               name="state"
                                               placeholder="{{trans('applang.state')}}"
                                               autocomplete="state"
                                               wire:model="state">
                                        <div class="form-control-position">
                                            <i class="bx bx-pen"></i>
                                        </div>
                                        @error('state')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="" for="city">{{ trans('applang.city') }}</label>
                                    <div class="position-relative has-icon-left">
                                        <input id="city"
                                               type="text"
                                               class="form-control @error('city') is-invalid @enderror"
                                               name="city"
                                               placeholder="{{trans('applang.city')}}"
                                               autocomplete="city"
                                               wire:model="city">
                                        <div class="form-control-position">
                                            <i class="bx bx-pen"></i>
                                        </div>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-2rem">
                                <a href="" class="btn btn-light-secondary" wire:click.prevent="cancelEditClient">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.cancel')}}</span>
                                </a>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!--Selected Client-->
                    <div class="supplier_invoice" style="border: 1px solid #00b0ef; background-color: #f6f9fc">
                        <div class="d-flex align-items-center">
                            <h4 class="font-weight-bold black">{{$clnt->full_name}}</h4>
                            <a href="" id="editClient" class="font-size-small black font-weight-bold ml-50 mr-50" style="text-decoration: underline" wire:click.prevent="showEditClient">
                                <i class="bx bx-pencil font-size-base font-weight-bold"></i> {{trans('applang.edit_details')}}
                            </a>
                        </div>
                        @if($clnt->street_address != null)
                            <div class="d-flex mt-50">
                                <span class="font-weight-bold text-dark">{{trans('applang.address')}}:</span>
                                <div class="ml-1 mr-1">
                                    <span style="display: block">{{$clnt->street_address}}</span>
                                    <span style="display: block">{{$clnt->city}}, {{$clnt->state}}, {{$clnt->country}}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!--Invoice number & Issue Date & Due Date-->
            <div class="col-md-6">
                <!--Invoice number-->
                <label class="required" for="inv_number">{{ trans('applang.purchase_invoice_number') }}</label>
                <div class="position-relative has-icon-left mb-50">
                    <input id="inv_number"
                           type="text"
                           class="form-control @error('inv_number') is-invalid @enderror"
                           name="inv_number"
                           placeholder="{{trans('applang.purchase_invoice_number')}}"
                           autocomplete="inv_number"
                           value="{{$salesInvoice->inv_number}}"
                           readonly>
                    <div class="form-control-position">
                        <i class="bx bx-pen"></i>
                    </div>
                </div>
                <!--Issue Date-->
                <label class="required" for="issue_date">{{ trans('applang.issue_date') }}</label>
                <div class="position-relative has-icon-left mb-50">
                    <input type="text"
                           class="form-control @error('issue_date') is-invalid @enderror"
                           placeholder="{{trans('applang.select_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"
                           name="issue_date"
                           value="{{$salesInvoice->issue_date}}"
                           readonly
                    >
                    <div class="form-control-position">
                        <i class="bx bx-calendar"></i>
                    </div>
                </div>
                <!--Due Date-->
                <label class="required" for="due_date">{{ trans('applang.due_date') }}</label>
                <div class="position-relative has-icon-left">
                    <input type="text"
                           class="form-control {{app()->getLocale() == 'ar' ? 'datepicker_ar' : 'datepicker_en'}} @error('due_date') is-invalid @enderror"
                           placeholder="{{trans('applang.due_date')}}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}"
                           name="due_date"
                           value="{{$salesInvoice->due_date ?? date('Y-m-d')}}"
                    >
                    <div class="form-control-position">
                        <i class="bx bx-calendar"></i>
                    </div>
                    @if ($errors->has('due_date'))
                        <span class="text-danger ">
                            <strong class="small font-weight-bolder">{{ $errors->first('due_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>


        <hr class="hr-dotted">

        <!--invoice table-->
        <div class="table-responsive">
            <table class="table table-small-font table-bordered inv-table" id="tax_table" style="width: 100%">
                <thead style="background-color: #f5f5f5;">
                <tr>
                    <td class="no-wrap inv-table-head">{{trans('applang.item')}}</td>
                    <td class="no-wrap inv-table-head">{{trans('applang.description')}}</td>
                    <td class="no-wrap inv-table-head">{{trans('applang.unit_price')}}</td>
                    <td class="no-wrap inv-table-head">{{trans('applang.quantity')}}</td>
                    <td class="no-wrap inv-table-head">{{trans('applang.tax')}} 1</td>
                    @if(count($taxes) > 1)
                        <td class="no-wrap inv-table-head">{{trans('applang.tax')}} 2</td>
                    @endif
                    <td class="no-wrap inv-table-head">{{trans('applang.total')}}</td>
                    <td class="no-wrap inv-table-head"></td>
                </tr>
                </thead>

                <tbody>
                <!--Invoice Items Details-->
                @foreach($addProduct as $index => $more)
                    <tr>
                        <!--Products-->
                        <td style="width: 18%" class="pt-0 pb-0">
                            <div class="form-group col-md-12 mb-0 w-100">
                                <select id="product_id.{{$index}}"
                                        class="border-0 pl-0 pr-0 @error('product_id') is-invalid @enderror"
                                        name='product_id[]' wire:model="addProduct.{{$index}}.product_id" style="outline: none; width: 100%">
                                    <option value="" selected></option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id.'.$index))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product_id[]') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </td>
                        <!--Description-->
                        <td class="pt-0 pb-0" style="width: 18%">
                            <div class="form-group col-md-12 mb-0 w-100">
                                <div class="d-flex align-items-center">
                                            <textarea name="description[]"
                                                      id="description.{{$index}}"
                                                      cols="{{count($taxes) > 1 ? '20' : '25'}}"
                                                      rows="3" style="height: 40px; border: none; outline: none; resize: none; width: 100%"
                                                      wire:model="descriptions.{{$index}}"
                                            ></textarea>
                                    @error('description.'.$index)
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>
                        </td>
                        <!--Unit Price-->
                        <td  class="pt-0 pb-0" style="width: {{count($taxes) > 1 ? '8%' : ''}}">
                            <div class="form-group col-md-12 mb-0 w-100">
                                <input id="unit_price.{{$index}}"
                                       type="number"
                                       class="@error('unit_price') is-invalid @enderror border-0 w-100 inv-unit_price"
                                       name="unit_price[]"
                                       style="outline: none"
                                       wire:model="unit_prices.{{$index}}"
                                       {{isset($quantities[$index]) ? '' : 'disabled'}}
                                       onkeypress="restrictMinus(event);"
                                >
                                @error('unit_price.'.$index)
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </td>
                        <!--Quantity-->
                        <td  class="pt-0 pb-0" style="background-color: {{isset($descriptions[$index]) ? '#FFFBE5' : ''}}">
                            <div class="form-group col-md-12 mb-0 w-100">
                                <input id="quantity.{{$index}}"
                                       type="number"
                                       class="@error('quantity') is-invalid @enderror border-0 w-100 inv-quantity"
                                       name="quantity[]"
                                       style="outline: none; background-color: {{isset($descriptions[$index]) ? '#FFFBE5' : ''}}"
                                       wire:model="quantities.{{$index}}"
                                       {{isset($descriptions[$index]) ? '' : 'disabled'}}
                                       {{isset($descriptions[$index]) ? 'autofocus' : ''}}
                                       onkeypress="restrictMinus(event);"
                                >
                                @error('quantity.'.$index)
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </td>
                        <!--First tax-->
                        <td class="pt-0 pb-0" style="width: 15%">
                            <div class="form-group col-md-12 mb-0 w-100">
                                <select id="first_tax_id.{{$index}}"
                                        class="@error('first_tax_id') is-invalid @enderror border-0"
                                        name='first_tax_id[]' style="outline: none; width: 100%" wire:model="first_tax_ids.{{$index}}">
                                    <option value="" selected></option>
                                    @if(isset($descriptions[$index]))
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}">
                                                {{app()->getLocale() == 'ar' ? $tax->tax_name_ar : $tax->tax_name_en}}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled style="color: #333333 !important;">{{trans('applang.first_tax')}}</option>
                                    @endif
                                </select>
                            </div>

                            <input type="text" wire:model="first_tax_items_val.{{$index}}" class="tax-input" disabled>
                        </td>
                        <!--Second tax-->
                        @if(count($taxes) > 1)
                            <td class="pt-0 pb-0" style="width: 15%">
                                <div class="form-group col-md-12 mb-0 w-100">
                                    <select id="second_tax_id.{{$index}}"
                                            class="@error('second_tax_id') is-invalid @enderror border-0"
                                            name='second_tax_id[]' style="outline: none; width: 100%" wire:model="second_tax_ids.{{$index}}">
                                        <option value="" selected></option>
                                        @if(isset($first_tax_ids[$index]))
                                            @foreach($taxes as $tax)
                                                <option value="{{$tax->id}}">
                                                    {{app()->getLocale() == 'ar' ? $tax->tax_name_ar : $tax->tax_name_en}}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled style="color: #333333 !important;">{{trans('applang.second_tax')}}</option>
                                        @endif
                                    </select>
                                </div>

                                <input type="text" wire:model="second_tax_items_val.{{$index}}" class="tax-input" disabled>
                            </td>
                        @endif
                    <!--row total-->
                        <td class="pt-0 pb-0" style="background-color: #EEEEEE; width: 15%">
                            <div class="form-group col-md-12 mb-0">
                                <input id="row_total.{{$index}}"
                                       type="text"
                                       class="@error('row_total') is-invalid @enderror border-0 w-100"
                                       name="row_total[]"
                                       value="{{$row_total && isset($row_total[$index]) ? $row_total[$index] : '0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE"
                                       readonly
                                >
                            </div>
                        </td>
                        <!--Delete row button-->
                        @if($loop->index > 0)
                            <td class="pt-0 pb-0" style="background-color: #f5f5f5; padding-left: 5px !important; padding-right: 5px !important; width: 3%">
                                <button class="btn btn-danger btn-xs" wire:ignore wire:click.prevent="removeProduct({{$index}})"><i class="bx bx-x-circle"></i></button>
                            </td>
                        @else
                            <td class="pt-0 pb-0" style="background-color: #f5f5f5; padding-left: 5px !important; padding-right: 5px !important; width: 3%"></td>
                        @endif
                    </tr>
                @endforeach


                <!--total before or subtotal-->
                <!--subtotal-->
                <tr style="background-color: #EEEEEE; font-weight: bolder">
                    <td class="table-invoice-totals" style="border-bottom: none;padding-top: 0 !important;" colspan="{{count($taxes) > 1 ? '5' : '4'}}">
                        <button class="btn btn-primary btn-sm" type="button" style="border-radius: 0" wire:click.prevent="addMoreProduct"
                            {{$showAddMoreBtn == false ? 'disabled' : ''}}
                        >
                            <i class="bx bx-plus"></i>
                            <span class="invoice-repeat-btn">{{trans('applang.add_line')}}</span>
                        </button>
                    </td>
                    <td class="text-center table-invoice-totals black">{{trans('applang.total_before')}}</td>
                    <td class="table-invoice-totals">
                        <div class="form-group col-md-12 mb-0">
                            <input id="subtotal"
                                   type="text"
                                   class="border-0 w-100"
                                   name="subtotal"
                                   value="{{$subtotal ?? '0.00'}} {{$currency_symbol}}"
                                   style="outline: none; background-color: #EEE; font-weight: bold"
                                   readonly
                            >
                        </div>
                    </td>
                    <td class="table-invoice-totals"></td>
                </tr>

                <!--discount-->
                @if($discount && $discount_inv && $discount_type != '' && $subtotal != '')
                    <tr style="background-color: #EEEEEE; font-weight: bolder">
                        <td class="table-invoice-totals" style="border-bottom: none" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                        <td class="text-center table-invoice-totals black">{{trans('applang.discount')}}</td>
                        <td class="table-invoice-totals">
                            <div class="form-group col-md-12 mb-0">
                                <input id="discount_inv"
                                       type="text"
                                       class="border-0 w-100"
                                       name="discount_inv"
                                       value="{{isset($discount_inv) ? '-'.' '.$discount_inv :'0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE; font-weight: bold"
                                       readonly
                                >
                            </div>
                        </td>
                        <td class="table-invoice-totals"></td>
                    </tr>
                @endif

                <!--taxes-->
                @if($total_taxes_ids)
                    @foreach($total_taxes_ids as $key => $total_tax)
                        @if($total_tax_inv[$key])
                            <tr style="background-color: #EEEEEE; font-weight: bolder">
                                <td class="table-invoice-totals" style="border-bottom: none" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                                <td class="text-center table-invoice-totals black">
                                    <div class="form-group col-md-12 mb-0">
                                        <input id="total_tax_inv.{{$key}}"
                                               type="text"
                                               class="border-0 w-100"
                                               name="total_tax_inv[]"
                                               value="{{app()->getLocale() == 'ar' ? $total_tax_inv[$key]['tax_name_ar'] : $total_tax_inv[$key]['tax_name_en']}} ({{number_format($total_tax_inv[$key]['tax_value'])}}%) "
                                               style="outline: none; background-color: #EEE; text-align: center; font-weight: bold"
                                               readonly
                                        >
                                    </div>
                                </td>
                                <td class="table-invoice-totals">
                                    <div class="form-group col-md-12 mb-0">
                                        <input id="total_tax_inv_sum.{{$key}}"
                                               type="text"
                                               class="border-0 w-100"
                                               name="total_tax_inv_sum[]"
                                               value="{{isset($total_tax_inv_sum)? array_sum(array_column($total_tax_inv_sum, $total_tax_inv[$key]['id'])) : '00.0' }} {{$currency_symbol}}"
                                               style="outline: none; background-color: #EEE; font-weight: bold"
                                               readonly
                                        >
                                    </div>
                                </td>
                                <td class="table-invoice-totals"></td>
                            </tr>
                        @endif
                    @endforeach
                @endif

                <!--shipping expenses-->
                @if($shipping_expense && $subtotal != '')
                    <tr style="background-color: #EEEEEE; font-weight: bolder">
                        <td class="table-invoice-totals" style="border-bottom: none" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                        <td class="text-center table-invoice-totals black">{{trans('applang.shipping_expense')}}</td>
                        <td class="table-invoice-totals">
                            <div class="form-group col-md-12 mb-0">
                                <input id="shipping_expense_inv"
                                       type="text"
                                       class="border-0 w-100"
                                       name="shipping_expense_inv"
                                       value="{{isset($shipping_expense_inv) ? $shipping_expense_inv :'0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE; font-weight: bold"
                                       readonly
                                >
                            </div>
                        </td>
                        <td class="table-invoice-totals"></td>
                    </tr>
                @endif

                <!--down payment-->
                @if($down_payment && $down_payment_inv && $down_payment_type != null && $subtotal != '' && $deposit_is_paid == true)
                    <tr style="background-color: #EEEEEE; font-weight: bolder">
                        <td class="table-invoice-totals" style="border-bottom: none" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                        <td class="text-center table-invoice-totals black">{{trans('applang.down_payment')}}</td>
                        <td class="table-invoice-totals">
                            <div class="form-group col-md-12 mb-0">
                                <input id="down_payment_inv"
                                       type="text"
                                       class="border-0 w-100"
                                       name="down_payment_inv"
                                       value="{{isset($down_payment_inv) ? '-'.' '.$down_payment_inv :'0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE; font-weight: bold"
                                       readonly
                                >
                            </div>
                        </td>
                        <td class="table-invoice-totals"></td>
                    </tr>
                @endif


                <!--due amount-->
                <tr style="background-color: #EEEEEE; font-weight: bolder">
                    <td class="table-invoice-totals" style="border-bottom: {{$paid_to_supplier_checkbox ? 'none' : ''}}" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                    <td class="text-center table-invoice-totals black">{{trans('applang.due_amount')}}</td>
                    <td class="table-invoice-totals">
                        <div class="form-group col-md-12 mb-0">
                            <input id="due_amount"
                                   type="text"
                                   class="border-0 w-100"
                                   name="due_amount"
                                   value="{{isset($due_amount) ? $due_amount :'0.00'}} {{$currency_symbol}}"
                                   style="outline: none; background-color: #EEE; font-weight: bold"
                                   readonly
                            >
                        </div>
                    </td>
                    <td class="table-invoice-totals"></td>
                </tr>
                <!--Paid To Supplier-->
                @if($paid_to_supplier_checkbox && $due_amount != '')
                    <tr style="background-color: #EEEEEE; font-weight: bolder">
                        <td class="table-invoice-totals" style="border-bottom: none" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                        <td class="text-center table-invoice-totals black">{{trans('applang.paid')}}</td>
                        <td class="table-invoice-totals">
                            <div class="form-group col-md-12 mb-0">
                                <input id="paid_to_supplier_inv$table->decimal('down_payment_inv', 8, 2)->default(0.00);"
                                       type="text"
                                       class="border-0 w-100"
                                       name="paid_to_supplier_inv"
                                       value="{{'-'.$paid_to_supplier_inv ?? '0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE; font-weight: bold"
                                       readonly
                                >
                            </div>
                        </td>
                        <td class="table-invoice-totals"></td>
                    </tr>
                    <!--Due After Paid-->
                    <tr style="background-color: #EEEEEE; font-weight: bolder">
                        <td class="table-invoice-totals" colspan="{{count($taxes) > 1 ? '5' : '4'}}"></td>
                        <td class="text-center table-invoice-totals black">{{trans('applang.due_amount_after_paid')}}</td>
                        <td class="table-invoice-totals">
                            <div class="form-group col-md-12 mb-0">
                                <input id="due_amount_after_paid"
                                       type="text"
                                       class="border-0 w-100"
                                       name="due_amount_after_paid"
                                       value="{{'0.00'}} {{$currency_symbol}}"
                                       style="outline: none; background-color: #EEE; font-weight: bold"
                                       readonly
                                >
                            </div>
                        </td>
                        <td class="table-invoice-totals"></td>
                    </tr>
                @endif

                </tbody>

            </table>
        </div>

        <!--Other Data-->
        <ul class="inv_other_data nav nav-tabs mb-0" id="myTab" role="tablist" wire:ignore>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#discountAndDownpayment" role="tab" aria-controls="home" aria-selected="true">{{trans('applang.discount')}} & {{trans('applang.down_payment')}}</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#shippingExpense" role="tab" aria-controls="shippingExpense" aria-selected="false">{{trans('applang.shipping')}}</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#attachDocuments" role="tab" aria-controls="attachDocuments" aria-selected="false">{{trans('applang.attach_documents')}}</a>
            </li>
        </ul>

        <div class="tab-content mb-1" style="padding: 10px; background-color: #edf1f2" id="myTabContent" wire:ignore>
            <div class="tab-pane fade show active" id="discountAndDownpayment" role="tabpanel" aria-labelledby="discountAndDownpayment-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row mb-50">
                            <!--Discount-->
                            <div class="col-md-6">
                                <label for="discount">{{trans('applang.discount')}}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="discount"
                                           type="number"
                                           class="form-control"
                                           name="discount"
                                           placeholder="{{trans('applang.discount')}}"
                                           wire:model="discount"
                                           onkeypress="restrictMinus(event);"
                                           value="{{$discount}}"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--Discount type-->
                            <div class="col-md-6">
                                <label for="discount_type">{{trans('applang.discount_type')}}</label>
                                <fieldset class="form-group">
                                    <select id="discount_type" class="custom-select " name="discount_type" wire:model="discount_type">
                                        <option value="" selected="" >{{trans('applang.select_discount_type')}}</option>
                                        <option value="1" {{$discount_type == 1 ? 'selected' :  ''}}>{{trans('applang.percentage')}}</option>
                                        <option value="0" {{$discount_type == 0 ? 'selected' :  ''}}>{{trans('applang.cash_amount')}}</option>
                                    </select>
                                    @if ($errors->has('discount_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount_type') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <!--Down payment-->
                        <div x-data="{ open: {{$down_payment ? 'true' : 'false'}} }" class="down-div">
                            <div class="form-row mb-50">
                                <div class="col-md-12">
                                    <label for="">{{trans('applang.down_payment')}}</label>
                                    <div class="down-payment-head">
                                        <fieldset>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" id="deposit_is_paid" @click="open = ! open" wire:model="deposit_is_paid">
                                                <label style="font-size: small" for="deposit_is_paid">{{trans('applang.already_paid')}}</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div x-show="open">
                                <div class="form-row">
                                    <!--Down payment-->
                                    <div class="col-md-6">
                                        <label class="required" for="down_payment">{{trans('applang.paid_amount')}}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="down_payment"
                                                   type="number"
                                                   class="form-control @error('down_payment') is-invalid @enderror"
                                                   name="down_payment"
                                                   placeholder="{{trans('applang.down_payment')}}"
                                                   autocomplete="down_payment"
                                                   wire:model="down_payment"
                                                   onkeypress="restrictMinus(event);"
                                                   value="{{$down_payment}}"
                                            >
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @if ($errors->has('down_payment'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('down_payment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!--Down payment type-->
                                    <div class="col-md-6">
                                        <label class="required" for="down_payment_type">{{trans('applang.down_payment_type')}}</label>
                                        <fieldset class="form-group">
                                            <select id="down_payment_type" class="custom-select @error('down_payment_type') is-invalid @enderror" name="down_payment_type" wire:model="down_payment_type">
                                                <option value="" selected="">{{trans('applang.select_down_payment_type')}}</option>
                                                <option value="1" {{$down_payment_type == 1 ? 'selected' : ''}}>{{trans('applang.percentage')}}</option>
                                                <option value="0" {{$down_payment_type == 0 ? 'selected' : ''}}>{{trans('applang.cash_amount')}}</option>
                                            </select>
                                            @if ($errors->has('down_payment_type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('down_payment_type') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <!--Deposit Method-->
                                    <div class="col-md-6">
                                        <label class="required" for="deposit_payment_method">{{trans('applang.deposit_payment_method')}}</label>
                                        <fieldset class="form-group">
                                            <select id="deposit_payment_method" class="custom-select @error('deposit_payment_method') is-invalid @enderror" name="deposit_payment_method" wire:model="deposit_payment_method">
                                                <option value="" selected="">{{trans('applang.select_deposit_payment_method')}}</option>
                                                <option value="cash" {{$deposit_payment_method == 'cash' ? 'selected' : ''}}>{{trans('applang.cash_amount')}}</option>
                                                <option value="cheque" {{$deposit_payment_method == 'cheque' ? 'selected' : ''}}>{{trans('applang.cheque')}}</option>
                                                <option value="bank_transfer" {{$deposit_payment_method == 'bank_transfer' ? 'selected' : ''}}>{{trans('applang.bank_transfer')}}</option>
                                            </select>
                                            @if ($errors->has('deposit_payment_method'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('deposit_payment_method') }}</strong>
                                                </span>
                                            @endif
                                        </fieldset>
                                    </div>
                                    <!--Reference Number-->
                                    <div class="col-md-6">
                                        <label class="required" for="deposit_transaction_id">{{trans('applang.reference_number')}}</label>
                                        <div class="position-relative has-icon-left">
                                            <input id="deposit_transaction_id"
                                                   type="number"
                                                   class="form-control @error('deposit_transaction_id') is-invalid @enderror"
                                                   name="deposit_transaction_id"
                                                   placeholder="{{trans('applang.reference_number')}}"
                                                   wire:model="deposit_transaction_id"
                                                   onkeypress="restrictMinus(event);"
                                                   value="{{$deposit_transaction_id}}"
                                            >
                                            <div class="form-control-position">
                                                <i class="bx bx-pen"></i>
                                            </div>
                                            @if ($errors->has('deposit_transaction_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('deposit_transaction_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="shippingExpense" role="tabpanel" aria-labelledby="shipping_expense-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row mb-50">
                            <!--Warehouse-->
                            <div class="col-md-6">
                                <label class="required" for="warehouse_id">{{trans('applang.warehouses')}}</label>
                                <fieldset class="form-group">
                                    <select id="warehouse_id" class="custom-select @error('warehouse_id') is-invalid @enderror" name="warehouse_id">
                                        <option value="" selected="" disabled="">{{trans('applang.select_warehouse')}}</option>
                                        @foreach($warehouses as $key => $warehouse)
                                            <option value="{{$warehouse->id}}" {{$salesInvoice->warehouse_id == $warehouse->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('warehouse_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('warehouse_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <!--Shipping Expenses-->
                            <div class="col-md-6">
                                <label for="shipping_expense">{{trans('applang.shipping_expense')}}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="shipping_expense"
                                           type="number"
                                           class="form-control"
                                           name="shipping_expense"
                                           placeholder="{{trans('applang.shipping_expense')}}"
                                           autocomplete="shipping_expense"
                                           wire:model="shipping_expense"
                                           onkeypress="restrictMinus(event);"
                                           value="{{$shipping_expense}}"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="attachDocuments" role="tabpanel" aria-labelledby="attachDocuments-tab">
                @if(count($salesInvoice->salesInvoiceAttachments) > 0)
                    <table class="table table-responsive-sm table-sm table-striped inv-files shadow" style="width: 100%; text-align: center">
                        <thead class="" >
                        <tr>
                            <th >#</th>
                            <th >{{trans('applang.file_name')}}</th>
                            <th >{{trans('applang.created_at')}}</th>
                            <th>{{trans('applang.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($salesInvoice->salesInvoiceAttachments as $index => $file)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$file->attachments}}</td>
                                <td>{{$file->created_at->format('d-m-Y')}}</td>
                                <td>
                                    <a href="{{route('SalesFilePreview', [$salesInvoice->created_at->format('m-Y'), $salesInvoice->inv_number, $file->attachments])}}" target="_blank">
                                        <i class="bx bx-show-alt"></i>
                                    </a>
                                    <a href="{{route('SalesFileDownload', [$salesInvoice->created_at->format('m-Y'), $salesInvoice->inv_number,$file->attachments])}}" class="mr-1 ml-1">
                                        <i class="bx bx-download"></i>
                                    </a>
                                    <a href="#" class="danger" wire:click.prevent="confirmDelete('{{$file->id}}','{{$file->attachments}}')">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="row justify-content-center">
                    <!--Attachments-->
                    <div class="col-md-12">
                        <input type="file" id="attachedDocuments" name="attachments[]"  class="file" multiple
                               data-preview-file-type="text"
                               data-browse-on-zone-click="true"
                               data-show-upload="false"
                               data-show-caption="true"
                               data-msg-placeholder=""
                        >
                    </div>
                </div>
            </div>
        </div>

        <!--Notes-->
        <div class="mt-1 mb-50" wire:ignore>
            <label for="editor">{{trans('applang.notes')}}</label>
            <textarea id="editor" name="notes">{{$salesInvoice->notes}}</textarea>
        </div>

        <hr class="hr-dotted">

        <!--Payment to supplier-->
        <div class="form-row" style=" background-color: #edf1f2; padding: 10px">
            <div class="col-md-6">
                <div x-data="{ open: {{$paid_to_supplier_inv != '' ? 'true' : 'false'}} }">
                    <div class="form-row mb-50">
                        <div class="col-md-12">
                            <label for="paid_to_supplier_checkbox">{{trans('applang.full_payment')}}</label>
                            <div class="down-payment-head" style="width: 98% !important;">
                                <fieldset>
                                    <div class="checkbox checkbox-primary">
                                        <input type="checkbox" id="paid_to_supplier_checkbox" @click="open = ! open" wire:model="paid_to_supplier_checkbox">
                                        <label style="font-size: small" for="paid_to_supplier_checkbox">{{trans('applang.already_paid_to_supplier')}}</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div x-show="open">
                        <div class="form-row col-md-12 pl-0 pr-0">
                            <!--Payment Method-->
                            <div class="col-md-6">
                                <label class="required" for="payment_payment_method">{{trans('applang.payment_payment_method')}}</label>
                                <fieldset class="form-group">
                                    <select id="payment_payment_method" class="custom-select @error('payment_payment_method') is-invalid @enderror" name="payment_payment_method" wire:model="payment_payment_method">
                                        <option value="" selected="">{{trans('applang.select_payment_payment_method')}}</option>
                                        <option value="cash">{{trans('applang.cash_amount')}}</option>
                                        <option value="cheque">{{trans('applang.cheque')}}</option>
                                        <option value="bank_transfer">{{trans('applang.bank_transfer')}}</option>
                                    </select>
                                    @if ($errors->has('payment_payment_method'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_payment_method') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <!--Reference Number-->
                            <div class="col-md-6">
                                <label class="required" for="payment_transaction_id">{{trans('applang.reference_number')}}</label>
                                <div class="position-relative has-icon-left">
                                    <input id="payment_transaction_id"
                                           type="number"
                                           class="form-control @error('payment_transaction_id') is-invalid @enderror"
                                           name="payment_transaction_id"
                                           placeholder="{{trans('applang.reference_number')}}"
                                           wire:model="payment_transaction_id"
                                           onkeypress="restrictMinus(event);"
                                    >
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @if ($errors->has('payment_transaction_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_transaction_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" value="{{$payment_status}}" name="payment_status">
        <input type="hidden" value="{{$receiving_status}}" name="receiving_status">
        <input type="hidden" value="{{$total_inv}}" name="total_inv">


        <hr class="hr modal-hr">
        <div class="d-flex justify-content-end mt-2rem">
            <a href="{{route('sales-invoices.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">{{trans('applang.back_btn')}}</span>
            </a>
            <button type="submit" class="btn btn-primary ml-1">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">{{trans('applang.save')}}</span>
            </button>
        </div>
    </div>
</div>
