<div>
    <!-- Filters start-->
    <section class="users-list-wrapper">
        <div class="default-app-list-table">
            <div class="card">
                {{--Filters--}}
                <div class="card-header justify-content-start">
                    <span class="text-bold-700 font-medium-1 text-black-50">{{trans('applang.filters')}}</span>
                </div>
                <div class="card-body pt-2 pb-0">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input wire:model="search" type="text" class="form-control mb-50" placeholder="{{trans('applang.search')}}">
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterBySection" class="custom-select mb-50">
                                <option selected>{{trans('applang.select_section')}}</option>
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterByBrand" class="custom-select mb-50">
                                <option selected>{{trans('applang.select_brand')}}</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <select wire:model="filterByCategory" class="custom-select mb-50">
                                <option selected>{{trans('applang.select_the_category')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterBySubCategory" class="custom-select mb-50">
                                <option selected>{{trans('applang.select_subcategory')}}</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input wire:model="filterBySKU" type="text" class="form-control mb-50" placeholder="{{trans('applang.sku_barcode')}}">
                        </div>
                        <div class="col-md-3">
                            <select wire:model="filterByStatus" class="custom-select mb-50">
                                <option selected value="">{{trans('applang.select_status')}}</option>
                                <option value="1">{{trans('applang.active')}}</option>
                                <option>{{trans('applang.suspended')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-3">
                            <select wire:model="sortAsc" class="custom-select mb-50">
                                <option selected>{{trans('applang.sort_by')}}</option>
                                <option value="1">{{trans('applang.ascending')}}</option>
                                <option value="0">{{trans('applang.descending')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="sortField" class="custom-select mb-50">
                                <option selected>{{trans('applang.sort_column')}}</option>
                                <option value="name">{{trans('applang.name')}}</option>
                                <option value="status">{{trans('applang.status')}}</option>
                                <option value="section_id">{{trans('applang.the_section')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model="perPage" class="custom-select mb-50">
                                <option selected>{{trans('applang.per_page')}}</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button wire:click.prevent="resetSearch" class="btn btn-primary w-100">{{trans('applang.reset')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- filters ends -->

    <!-- products list start -->
    <section class="users-list-wrapper">
        <div class="default-app-list-table">
            <div class="card">
                {{-- Buttons--}}
                <div class="card-header justify-content-start">
                    <a href="{{route('products.create')}}" class="btn btn-success mb-0 mr-1">
                        <i class="bx bx-plus"></i> {{trans('applang.add')}}
                    </a>

                    <div class="btn-group">
                        <fieldset class="btn btn-bitbucket" style="padding: 4px 15px">
                            <label class="container-custom-checkbox">
                                <div class="d-flex justify-content-between align-content-center">
                                    <input type="checkbox" id="selectAll" wire:model="selectPage">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">{{trans('applang.select_all')}}</span>
                                </div>
                            </label>
                        </fieldset>
                        @if(count($checked) > 0)
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-danger dropdown-toggle rounded-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        (<span class="d-none d-sm-inline-block">{{trans('applang.selected_rows_is')}}</span> {{count($checked)}})
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4" style="width: 100%">
                                        <a href="#" class="dropdown-item" wire:click.prevent="confirmBulkDelete()">
                                            <i class="bx bx-trash"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.delete')}}</span>
                                        </a>
                                        <a href="#" class="dropdown-item" wire:click.prevent="exportSelected()"
                                           onclick="confirm('{{trans('applang.export_confirm_message')}}') || event.stopImmediatePropagation()">
                                            <i class="bx bxs-file-export"></i>
                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.export')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-info" wire:click.prevent="deselectSelected()">
                                <i class="bx bx-reset d-sm-inline-block"></i>
                                <span class="d-none d-sm-inline-block">{{trans('applang.deselect')}}</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-1 pb-1">
                    @if($selectPage)
                        <div class="col-md-12 mb-2 pl-0 pr-0">
                            <div class="d-flex justify-content-start align-items-center">
                                @if($selectAll)
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="mb-0">
                                            {{trans('applang.you_have_selected_all')}} ( <strong>{{$products->total()}}</strong> {{trans('applang.items')}} ).
                                        </p>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start align-items-center">
                                        <p class="mb-0">
                                            {{trans('applang.you_have_selected')}} ( <strong>{{count($checked)}}</strong> {{trans('applang.items')}} ),
                                            {{trans('applang.do_you_want_to_select_all')}} ( <strong>{{$products->total()}}</strong> {{trans('applang.items')}} ) ?
                                        </p>
                                        <a href="#" class="btn btn-sm btn-primary ml-1" wire:click="selectAll" title="{{trans('applang.select_all')}}">
                                            <i class="bx bx-select-multiple d-sm-inline-block"></i>
                                            <span class="d-none d-sm-inline-block">{{trans('applang.select_all')}}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <ul class="day-view-entry-list">
                        @foreach($products as $index => $product)
                            <li class="day-view-entry product-index {{in_array($product->id ,$checked)? 'lightyellow' : ''}}">

                                <label class="checkbox-container" style="display: {{in_array($product->id ,$checked)? 'block' : ''}}">
                                    <input type="checkbox" class="product-input" value="{{$product->id}}" wire:model="checked">
                                    <span class="checkmark"></span>
                                </label>

                                <div class="row align-items-center pr-2 pl-2">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div style="width: 50px; height: 50px" class="img-thumbnail">
                                                <img style="width:100%; height: 100%; object-fit: cover" src="{{asset('uploads/products/images/'.$product->product_image)}}" alt="">
                                            </div>
                                            <a href="{{route('products.show', $product->id)}}" class="ml-1">
                                                <div class="project-client">
                                                    <span class="text-black-50">#{{$product->number}}</span>
                                                    <span class="font-weight-bolder font-size-base black">{{$product->name}} </span>
                                                </div>
                                                <div class="text-black-50 d-flex align-items-center">
                                                    <i class="fas fa-barcode font-medium-1"></i>
                                                    <span style="margin-right: 5px; margin-left: 5px">{{$product->sku}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center" >
                                                <div class="text-center">
                                                    @if($product->total_quantity > $product->lowest_stock_alert)
                                                        <span class="badge badge-success-custom">{{trans('applang.available_stock')}}</span>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <i class="bx bxs-component font-medium-3"></i>
                                                            <span>{{$product->total_quantity}} {{trans('applang.available')}}</span>
                                                        </span>
                                                    @elseif($product->total_quantity <= $product->lowest_stock_alert  && $product->total_quantity > 0.00)
                                                        <span class="badge badge-warning">{{trans('applang.low_stock')}}</span>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <i class="bx bxs-component font-medium-3"></i>
                                                            <span>{{$product->total_quantity}} {{trans('applang.available')}}</span>
                                                        </span>
                                                    @elseif($product->total_quantity == 0.00)
                                                        <span class="badge badge-danger">{{trans('applang.out_of_stock')}}</span>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <i class="bx bxs-component font-medium-3"></i>
                                                            <span>{{$product->total_quantity}}
                                                                {{trans('applang.available')}}
                                                            </span>
                                                        </span>
                                                    @elseif($product->total_quantity < 0.00)
                                                        <span class="badge badge-danger">{{trans('applang.out_of_stock')}}</span>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <i class="bx bxs-component font-medium-3"></i>
                                                            <span>{{$product->total_quantity}}
                                                                {{trans('applang.inability')}}
                                                            </span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div >
                                                    <div class="d-flex justify-content-between" style="margin-bottom: 3px">
                                                        <i class="bx bxs-cart-alt font-medium-1"></i>
                                                        <span style="margin-right: 3px; margin-left: 3px">{{$product->sell_price}} {{$currency_symbol}}</span>
                                                    </div>

                                                    <div class="d-flex justify-content-between">
                                                        <i class="bx bxs-truck font-medium-1"></i>
                                                        <span style="margin-right: 3px; margin-left: 3px">{{$product->purchase_price}} {{$currency_symbol}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="dropdown" style="margin-right: 5px; margin-left: 5px">
                                                    <button class="btn btn-sm btn-light-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu {{app()->getLocale() == 'ar' ? 'dropdown-menu-right': ''}}">
                                                        <a class="dropdown-item" href="{{route('products.show', $product->id)}}" title="{{trans('applang.show')}}" >
                                                            <i class="bx bx-search"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.show')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{route('products.edit', $product->id)}}" title="{{trans('applang.edit')}}" >
                                                            <i class="bx bx-edit-alt"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.edit')}}</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#" title="{{trans('applang.delete')}}"
                                                           wire:click.prevent="confirmDelete('{{$product->id}}','{{$product->name}}')">
                                                            <i class="bx bx-trash"></i>
                                                            <span class="font-weight-bold ml-1 mr-1">{{trans('applang.delete')}}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex d-flex justify-content-between custom-pagination mt-1">
                        {!! $products->links() !!}
                        <p>
                            {{trans('applang.showing')}}
                            {{count($products)}}
                            {{trans('applang.from_original')}}
                            {{count(\App\Models\ERP\Inventory\Product::all())}}
                            {{trans('applang.entries')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- products list ends -->
</div>
