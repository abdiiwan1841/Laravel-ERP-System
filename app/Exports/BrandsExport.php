<?php

namespace App\Exports;

use App\Models\ERP\Settings\Products\Brand;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($brand): array
    {
        return [
            $brand->id,
            $brand->name,
            $brand->status == 1 ? trans('applang.active') : trans('applang.suspended'),
            $brand->sections->map(function ($section){ return $section->name; }),
            $brand->categories->map(function ($category){ return $category->name; })
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            trans('applang.the_brand'),
            trans('applang.status'),
            trans('applang.sections'),
            trans('applang.categories'),
        ];
    }

    public function query()
    {
        return Brand::with(['sections','categories', 'products'])->whereIn('id', $this->checked);
    }
}
