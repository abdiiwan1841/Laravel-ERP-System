<?php

namespace App\Exports;

use App\Models\ERP\Settings\Products\SubCategory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubcategoriesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($subcategory): array
    {
        return [
            $subcategory->id,
            $subcategory->name,
            $subcategory->status == 1 ? trans('applang.active') : trans('applang.suspended'),
            $subcategory->category->name,
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            trans('applang.sub_cat'),
            trans('applang.status'),
            trans('applang.the_category')
        ];
    }

    public function query()
    {
        return SubCategory::with('category:id,name')->whereIn('id', $this->checked);
    }
}
