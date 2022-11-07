<div class="card">
    <div class="card-header modal-header bg-primary">
        <h4 class="modal-title white">{{trans('applang.create_product')}}</h4>
    </div>
    <div class="card-body mt-1" style="padding-bottom: 13px">
        <div class="row">
            <div class="col-md-6">
                <!--Product Details-->
                <div class="custom-card mt-1">
                    <div class="card-header border-bottom" style="background-color: #247dbd">
                        <span class="text-bold-700 text-white">{{trans('applang.product_details')}}</span>
                    </div>

                    <div class="card-body mt-1">
                        <!--Product Name-->
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="required" for="name">{{ trans('applang.name') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           placeholder="{{trans('applang.name')}}"
                                           autocomplete="name"
                                           value="{{old('name')}}"
                                           autofocus
                                            wire:model="product_name">
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

                        <!--Product Description-->
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="required" for="description">{{ trans('applang.description') }}</label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror mb-1"
                                    name="description"
                                    id="description"
                                    rows="5"
                                    placeholder="{{trans('applang.description')}}">
                                    {{old('description')}}
                                </textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--Section & Brand-->
                        <div class="form-row mb-50">
                            <div class="col-md-6">
                                <label class="required" for="section_id">{{ trans('applang.section') }}</label>
                                <fieldset class="form-group">
                                    <select id="section_id" class="custom-select @error('section_id') is-invalid @enderror" name='section_id' wire:model="section_id">
                                        <option value="" selected>{{trans('applang.select_section')}}</option>
                                        @foreach($sections as $section)
                                            <option value="{{$section->id}}">{{$section->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('section_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('section_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <label class="required" for="brand_id">{{ trans('applang.brand') }}</label>
                                <fieldset class="form-group">
                                    <select id="brand_id" class="custom-select @error('brand_id') is-invalid @enderror" name='brand_id' wire:model="brand_id">
                                        <option value="" selected>{{trans('applang.select_brand')}}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('brand_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('brand_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <!--Category & Subcategory-->
                        <div class="form-row mb-50">
                            <div class="col-md-6">
                                <label class="required" for="category_id">{{ trans('applang.category') }}</label>
                                <fieldset class="form-group">
                                    <select id="category_id" class="custom-select @error('category_id') is-invalid @enderror" name='category_id' wire:model="category_id">
                                        <option value="" selected>{{trans('applang.select_the_category')}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <label class="required" for="subcategory_id">{{ trans('applang.sub_cat') }}</label>
                                <fieldset class="form-group">
                                    <select id="brand_id" class="custom-select @error('subcategory_id') is-invalid @enderror" name='subcategory_id' wire:model="subcategory_id">
                                        <option value="" selected>{{trans('applang.select_subcategory')}}</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('subcategory_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('subcategory_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <!--Unit Template & Supplier-->
                        <div class="form-row mb-50">
                            <div class="col-md-6">
                                <label class="required" for="unit_template_id">{{ trans('applang.unit_template') }}</label>
                                <fieldset class="form-group">
                                    <select id="unit_template_id" class="custom-select @error('unit_template_id') is-invalid @enderror" name='unit_template_id' wire:model="unit_template_id">
                                        <option value="" selected>{{trans('applang.select_unit_template')}}</option>
                                        @foreach($units_templates as $unit_template)
                                            <option value="{{$unit_template->id}}">{{app()->getLocale() == 'ar' ? $unit_template->template_name_ar : $unit_template->template_name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('unit_template_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unit_template_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <label class="required" for="supplier_id">{{ trans('applang.supplier') }}</label>
                                <fieldset class="form-group">
                                    <select id="supplier_id" class="custom-select @error('supplier_id') is-invalid @enderror" name='supplier_id'>
                                        <option value="" selected disabled>{{trans('applang.select_supplier')}}</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->commercial_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('supplier_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('supplier_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <!--Lowest Stock Alert & Status-->
                        <div class="form-row mb-50">
                            <!--Lowest Stock Alert-->
                            <div class="col-md-6">
                                <label class="required" for="lowest_stock_alert">{{ trans('applang.lowest_stock_alert') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="lowest_stock_alert"
                                           type="number"
                                           class="form-control @error('lowest_stock_alert') is-invalid @enderror"
                                           name="lowest_stock_alert"
                                           placeholder="{{trans('applang.lowest_stock_alert_placeholder')}}"
                                           autocomplete="lowest_stock_alert"
                                           value="{{old('lowest_stock_alert')}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('lowest_stock_alert')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Status-->
                            <div class="col-md-6">
                                <label class="required" for="status">{{ trans('applang.status') }}</label>
                                <fieldset class="form-group mb-50">
                                    <select id="status" class="custom-select @error('status') is-invalid @enderror" name='status'>
                                        <option value="" selected disabled>{{trans('applang.status')}}</option>
                                        <option value="0" >{{trans('applang.suspended')}}</option>
                                        <option value="1" >{{trans('applang.active')}}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!--Pricing details-->
                <div class="custom-card mt-1">
                    <div class="card-header border-bottom" style="background-color: #247dbd">
                        <span class="text-bold-700 text-white">{{trans('applang.pricing_details')}}</span>
                    </div>

                    <div class="card-body mt-1">
                        <div class="form-row mb-50">
                            <!--Purchase Price-->
                            <div class="col-md-8">
                                <label class="required" for="purchase_price">{{ trans('applang.purchase_price') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="purchase_price"
                                           type="number"
                                           class="form-control @error('purchase_price') is-invalid @enderror"
                                           name="purchase_price"
                                           placeholder="{{trans('applang.purchase_price')}}"
                                           autocomplete="purchase_price"
                                           value="{{old('purchase_price')}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('purchase_price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Measurement Unit-->
                            <div class="col-md-4">
                                <label class="required" for="measurement_unit_id">{{ trans('applang.measurement_unit') }}</label>
                                <fieldset class="form-group">
                                    <select id="measurement_unit_id" class="custom-select @error('measurement_unit_id') is-invalid @enderror" name='measurement_unit_id' wire:model="measurement_unit_id">
                                        <option value="" selected>{{trans('applang.select_measurement_unit')}}</option>
                                        @foreach($measurement_units as $measurement_unit)
                                            <option value="{{$measurement_unit->id}}">{{app()->getLocale() == 'ar' ? $measurement_unit->largest_unit_ar : $measurement_unit->largest_unit_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('measurement_unit_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('measurement_unit_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-row mb-50">
                            <!--Sell Price-->
                            <div class="col-md-8">
                                <label class="required" for="sell_price">{{ trans('applang.sell_price') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="sell_price"
                                           type="number"
                                           class="form-control @error('sell_price') is-invalid @enderror"
                                           name="sell_price"
                                           placeholder="{{trans('applang.sell_price')}}"
                                           autocomplete="sell_price"
                                           value="{{old('sell_price')}}"
                                           autofocus
                                           wire:model="product_sell_price">
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('sell_price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Measurement Unit-->
                            <div class="col-md-4">
                                <label class="required" for="measurement_unit_id">{{ trans('applang.measurement_unit') }}</label>
                                <fieldset class="form-group">
                                    <select id="measurement_unit_id" class="custom-select @error('measurement_unit_id') is-invalid @enderror" name='measurement_unit_id' wire:model="measurement_unit_id">
                                        <option value="" selected>{{trans('applang.select_measurement_unit')}}</option>
                                        @foreach($measurement_units as $measurement_unit)
                                            <option value="{{$measurement_unit->id}}">{{app()->getLocale() == 'ar' ? $measurement_unit->largest_unit_ar : $measurement_unit->largest_unit_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('measurement_unit_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('measurement_unit_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-row mb-50">
                            <!--First Tax-->
                            <div class="col-md-6">
                                <label class="required" for="first_tax_id">{{ trans('applang.first_tax') }}</label>
                                <fieldset class="form-group">
                                    <select id="first_tax_id" class="custom-select @error('first_tax_id') is-invalid @enderror" name='first_tax_id'>
                                        <option value="" selected>{{trans('applang.select_first_tax')}}</option>
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}">{{app()->getLocale() == 'ar' ? $tax->tax_name_ar: $tax->tax_name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('first_tax_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_tax_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                            <!--Second Tax-->
                            <div class="col-md-6">
                                <label class="" for="second_tax_id">{{ trans('applang.second_tax') }}</label>
                                <fieldset class="form-group">
                                    <select id="second_tax_id" class="custom-select @error('second_tax_id') is-invalid @enderror" name='second_tax_id'>
                                        <option value="" selected>{{trans('applang.select_second_tax')}}</option>
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}">{{app()->getLocale() == 'ar' ? $tax->tax_name_ar: $tax->tax_name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('second_tax_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('second_tax_id') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-row mb-50">
                            <!--Lowest Sell Price-->
                            <div class="col-md-6">
                                <label class="required" for="lowest_sell_price">{{ trans('applang.lowest_sell_price') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="lowest_sell_price"
                                           type="number"
                                           class="form-control @error('lowest_sell_price') is-invalid @enderror"
                                           name="lowest_sell_price"
                                           placeholder="{{trans('applang.lowest_sell_price')}}"
                                           autocomplete="lowest_sell_price"
                                           value="{{old('lowest_sell_price')}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('lowest_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Profit Margin-->
                            <div class="col-md-6">
                                <label class="" for="profit_margin">{{ trans('applang.profit_margin_Percentage') }}</label>
                                <div class="position-relative has-icon-left mb-1 input-group">
                                    <input id="profit_margin"
                                           type="number"
                                           class="form-control @error('profit_margin') is-invalid @enderror"
                                           name="profit_margin"
                                           placeholder="{{trans('applang.profit_margin_Percentage')}}"
                                           autocomplete="profit_margin"
                                           value="{{old('profit_margin')}}"
                                           autofocus>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-append-reset">%</span>
                                    </div>
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('profit_margin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-50">
                            <!--Discount-->
                            <div class="col-md-6">
                                <label class="" for="sell_price">{{ trans('applang.discount') }}</label>
                                <div class="position-relative has-icon-left mb-1">
                                    <input id="discount"
                                           type="number"
                                           class="form-control @error('discount') is-invalid @enderror"
                                           name="discount"
                                           placeholder="{{trans('applang.discount')}}"
                                           autocomplete="discount"
                                           value="{{old('discount')}}"
                                           autofocus>
                                    <div class="form-control-position">
                                        <i class="bx bx-pen"></i>
                                    </div>
                                    @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--Discount Type-->
                            <div class="col-md-6">
                                <label class="" for="discount_type">{{ trans('applang.discount_type') }}</label>
                                <fieldset class="form-group">
                                    <select id="discount_type" class="custom-select @error('discount_type') is-invalid @enderror" name='discount_type'>
                                        <option value="" selected disabled>{{trans('applang.select_discount_type')}}</option>
                                        <option value="1">{{trans('applang.percentage')}}</option>
                                        <option value="0">{{trans('applang.cash_amount')}}</option>
                                    </select>
                                    @if ($errors->has('discount_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount_type') }}</strong>
                                        </span>
                                    @endif
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-row mb-1">
                            <!--Notes-->
                            <label class="" for="notes">{{ trans('applang.notes') }}</label>
                            <textarea
                                class="form-control @error('notes') is-invalid @enderror"
                                name="notes"
                                id="notes"
                                rows="5"
                                placeholder="{{trans('applang.notes')}}">
                                    {{old('notes')}}
                            </textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <!--Inventory-->
            <div class="col-md-6">
                <div class="custom-card mt-1">
                    <div class="card-header border-bottom" style="background-color: #247dbd">
                        <span class="text-bold-700 text-white">{{trans('applang.sku_barcode')}}</span>
                    </div>
                    <div class="card-body mt-1">
                        <!--SKU-->
                        <div class="form-row" style="margin-bottom: 21px">
                            <div class="col-md-12">
                                <label class="required" for="sku">{{ trans('applang.sku') }}</label>
                                <div class="d-flex justify-content-start">
                                    <div class="position-relative has-icon-left w-100">
                                        <input type="text" class="form-control button-input @error('sku') is-invalid @enderror" name="sku" placeholder="{{trans('applang.generate_sku')}}" wire:model="product_sku" readonly>
                                        <div class="form-control-position">
                                            <i class="bx bx-barcode"></i>
                                        </div>
                                        @if ($errors->has('sku'))
                                            <span class="invalid-feedback position-absolute" role="alert">
                                                <strong>{{ $errors->first('sku') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group-prepend generateSKU">
                                        <button class="btn btn-light-danger text-append-reset" wire:click.prevent="generateSKU">
                                            <i class="bx bx-analyse"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="required" for="barcode">{{ trans('applang.barcode') }}</label>
                                <div class="d-flex justify-content-center align-items-center product_barcode" wire:model="product_barcode">
                                    @if($product_barcode)
                                        <div class="mt-2 custom-card p-1 bg-white">
                                            <div class="d-flex justify-content-between mb-0">
                                                <h6 class="d-flex justify-content-center mb-0" style="font-size: 14px">
                                                    {{$product_barcode ? $product_name : ''}}
                                                </h6>
                                                <h6 class="d-flex justify-content-center mb-0" style="font-size: 14px">
                                                    {{$product_barcode ? $product_sell_price : ''}} {{$currency_symbol}}
                                                </h6>
                                            </div>
                                            <div class="d-flex justify-content-center">{!! $product_barcode !!}</div>
                                            <h6 class="d-flex justify-content-center mb-0">{{$product_sku}}</h6>
                                        </div>
                                    @else
                                        <h2 class="text-bold-600" style="color: #c5c5c5">{{trans('applang.barcode_preview')}}</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Product Image-->
            <div class="col-md-6">
                <div class="custom-card mt-1">
                    <div class="card-header border-bottom" style="background-color: #247dbd">
                        <span class="text-bold-700 text-white">{{trans('applang.product_image')}}</span>
                    </div>
                    <div class="card-body mt-1">
                        <div class="form-row mb-50">
                            <div class="col-md-12 mb-50">
                                <div id='img_contain'>
                                    <img id="blah"
                                         align='middle'
                                         src="{{$product_image ? $product_image->temporaryUrl() : asset('/uploads/products/images/defaultProduct.png')}}"
                                         alt="Product Image"
                                         title='Product Image'/>
                                </div>
                                <div class="input-group is-invalid">
                                    <div class="custom-file">
                                        <input type="file" id="inputGroupFile01" name="product_image" class="imgInp custom-file-input" wire:model="product_image">
                                        <label class="custom-file-label text-append-logo" for="inputGroupFile01">
                                            {{ $product_image? $product_image->getClientOriginalName() :trans('applang.choose_product_image')}}
                                        </label>
                                    </div>
                                    <a href="#" class="btn btn-light-info btn-sm remove-logo text-append-reset" title="{{trans('applang.reset')}}">
                                        <i class="bx bx-reset"></i>
                                    </a>
                                </div>
                                @if ($errors->has('product_image'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('product_image') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr modal-hr">
        <div class="d-flex justify-content-end mt-2rem">
            <a href="{{route('products.index')}}" class="btn btn-light-secondary" data-dismiss="modal">
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
