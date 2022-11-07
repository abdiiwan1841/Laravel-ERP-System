<div class="content-body">
    <div class="card">
        {{-- Buttons--}}
        <div class="card-header justify-content-between bg-secondary bg-lighten-4" style="border-bottom: 1px solid #DDD">
            <div class="btn-group justify-content-start align-items-center">
                <a href="#" data-toggle="modal" data-target="#formModalAddSection" class="btn btn-success mb-0">
                    <i class="bx bx-plus d-sm-inline-block"></i>
                    <span class="d-none d-sm-inline-block">{{trans('applang.add')}}</span>
                </a>
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

            <div class="btn-group align-items-center">
                <a href="{{route('brands.index')}}" class="btn btn-sm btn-secondary"><i class="bx bx-tv"></i> {{trans('applang.brands')}}</a>
                <a href="{{route('categories.index')}}" class="btn btn-sm btn-secondary"><i class="bx bx-sitemap"></i> {{trans('applang.categories')}}</a>
                <a href="{{route('subcategories.index')}}" class="btn btn-sm btn-secondary"><i class="bx bx-purchase-tag-alt"></i> {{trans('applang.sub_categories')}}</a>
            </div>
        </div>
        <div class="card-body pt-1">
            {{--Filters--}}
            <div class="form-row">
                <div class="col-md-6">
                    <input wire:model="search" type="text" class="form-control mb-50 custom-input-color" placeholder="{{trans('applang.search')}}">
                </div>
                <div class="col-md-3">
                    <select wire:model="filterByStatus" class="custom-select mb-50 custom-input-color">
                        <option selected value="">{{trans('applang.select_status')}}</option>
                        <option value="1">{{trans('applang.active')}}</option>
                        <option>{{trans('applang.suspended')}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model="perPage" class="custom-select mb-50 custom-input-color">
                        <option selected>{{trans('applang.per_page')}}</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

            </div>
            <div class="form-row mb-2">
                <div class="col-md-3">
                    <select wire:model="sortAsc" class="custom-select mb-50 custom-input-color">
                        <option selected >{{trans('applang.sort_by')}}</option>
                        <option value="1">{{trans('applang.ascending')}}</option>
                        <option value="0">{{trans('applang.descending')}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model="sortField" class="custom-select mb-50 custom-input-color">
                        <option selected >{{trans('applang.sort_column')}}</option>
                        <option value="name">{{trans('applang.name')}}</option>
                        <option value="status">{{trans('applang.status')}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button wire:click.prevent="resetSearch" class="btn btn-primary w-100">{{trans('applang.reset')}}</button>
                </div>
            </div>

            {{--Datatable--}}
            <div class="row">
                @if($selectPage)
                    <div class="col-md-12 mb-2">
                        <div class="d-flex justify-content-start align-items-center">
                            @if($selectAll)
                                <div class="d-flex justify-content-start align-items-center">
                                    <p class="mb-0">
                                        {{trans('applang.you_have_selected_all')}} ( <strong>{{$sections->total()}}</strong> {{trans('applang.items')}} ).
                                    </p>
                                </div>
                            @else
                                <div class="d-flex justify-content-start align-items-center">
                                    <p class="mb-0">
                                        {{trans('applang.you_have_selected')}} ( <strong>{{count($checked)}}</strong> {{trans('applang.items')}} ),
                                        {{trans('applang.do_you_want_to_select_all')}} ( <strong>{{$sections->total()}}</strong> {{trans('applang.items')}} ) ?
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
                @if($sections->isNotEmpty())
                <div class="col-12 col-md-12 table-responsive">
                     <table class="user-view hover" style="width: 100%; border: 1px solid #ddd">
                        <thead class="table-head">
                            <tr>
                                <th>
                                    <fieldset>
                                        <div class="checkbox checkbox-secondary">
                                            <input type="checkbox" id="selectAll" wire:model="selectPage">
                                            <label for="selectAll"></label>
                                        </div>
                                    </fieldset>
                                </th>
                                <th>#</th>
                                <th>{{trans('applang.name')}}</th>
                                <th>{{trans('applang.status')}}</th>
                                <th>{{trans('applang.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sections as $index => $section)
                            <tr class="{{in_array($section->id ,$checked)? 'table-secondary' : ''}}">
                                <td class="no-wrap" style="width: 5%">
                                    <fieldset>
                                        <div class="checkbox checkbox-secondary">
                                            <input type="checkbox" id="section-{{$section->id}}" value="{{$section->id}}" wire:model="checked" class="item_checkbox">
                                            <label for="section-{{$section->id}}"></label>
                                        </div>
                                    </fieldset>
                                </td>
                                <td class="no-wrap" style="width: 5%">{{$index + 1}}</td>
                                <td class="no-wrap">{{$section->name}}</td>
                                <td class="no-wrap"><span class="badge {{$section->status == 1 ? 'badge-light-success' : 'badge-light-danger'}}">{{$section->status == 1 ? trans('applang.active') : trans('applang.suspended')}}</span></td>
                                <td class="no-wrap">
                                    <a href="#" data-toggle="modal" data-target="#formModalEditSection" wire:click.prevent="editSection({{$section->id}})"><i class="bx bx-edit-alt"></i></a>
                                    @if(count($checked) < 2)
                                        <a href="#" class="text-danger mr-1 ml-1" wire:click.prevent="confirmDelete('{{$section->id}}','{{$section->name}}')"><i class="bx bx-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                        @endforelse
                        </tbody>

                    </table>
                </div>
                @else
                    <div class="col-12 col-md-12">
                        <p class="text-center">{{trans('applang.no_records_yet')}}</p>
                    </div>
                @endif
            </div>

            <div class="d-flex d-flex justify-content-between custom-pagination mt-1">
                {{$sections->links()}}
                <p>
                    {{trans('applang.showing')}}
                    {{count($sections)}}
                    {{trans('applang.from_original')}}
                    {{count(\App\Models\ERP\Settings\Products\Section::all())}}
                    {{trans('applang.entries')}}
                </p>
            </div>
        </div>


    </div>
    @include('erp.settings.products.sections.modals')
</div>


