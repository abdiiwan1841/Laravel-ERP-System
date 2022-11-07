<?php

namespace App\Exports;

use App\Models\ERP\Inventory\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($prduct): array
    {
        return [
            $prduct->id,
            $prduct->name,
            $prduct->status == 1 ? trans('applang.active') : trans('applang.suspended'),
            $prduct->section->name,
            $prduct->brand->name,
            $prduct->category->name,
            $prduct->subcategory->name,
            $prduct->supplier->name,
            $prduct->supplier->full_code,
            $prduct->total_quantity,
            $prduct->purchase_price,
            $prduct->sell_price,
            $prduct->sku,
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            trans('applang.name'),
            trans('applang.status'),
            trans('applang.the_section'),
            trans('applang.the_brand'),
            trans('applang.category'),
            trans('applang.sub_cat'),
            trans('applang.supplier'),
            trans('applang.supplier_code'),
            trans('applang.inventory_quantity'),
            trans('applang.purchase_price'),
            trans('applang.sell_price'),
            trans('applang.sku'),
        ];
    }

    public function query()
    {
        return Product::with(['section', 'brand', 'category', 'subcategory', 'unitTemplate', 'measurementUnit', 'supplier', 'sequential_code'])->whereIn('id', $this->checked);
    }
}
