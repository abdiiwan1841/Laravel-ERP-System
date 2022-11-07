<?php

namespace App\Exports;

use App\Models\ERP\Settings\Products\Category;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->status == 1 ? trans('applang.active') : trans('applang.suspended'),
            $category->section->name,
            $category->brands->map(function ($brand){ return $brand->name; }),
            $category->subCategories->map(function ($subcategory){ return $subcategory->name; })
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            trans('applang.the_category'),
            trans('applang.status'),
            trans('applang.the_section'),
            trans('applang.the_brand'),
            trans('applang.sub_cat'),
        ];
    }

    public function query()
    {
        return Category::with(['section', 'brands', 'subCategories', 'products'])->whereIn('id', $this->checked);
    }
}
