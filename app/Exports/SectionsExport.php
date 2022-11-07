<?php

namespace App\Exports;

use App\Models\ERP\Settings\Products\Section;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SectionsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($section): array
    {
        return [
            $section->id,
            $section->name,
            $section->status == 1 ? trans('applang.active') : trans('applang.suspended'),
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            trans('applang.the_section'),
            trans('applang.status'),
        ];
    }

    public function query()
    {
        return Section::whereIn('id', $this->checked);
    }
}
