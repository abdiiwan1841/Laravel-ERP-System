<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromQuery, WithMapping, WithHeadings
{
    protected $checked;

    public function __construct($checked)
    {
        $this->checked = $checked;
    }

    public function map($client): array
    {
        return [
            $client->number,
            $client->full_name,
            $client->status == 1 ? trans('applang.active') : trans('applang.suspended'),
            $client->email,
            $client->phone_code,
            $client->phone,
            $client->mobile,
            $client->street_address,
            $client->city,
            $client->state,
            $client->full_code,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            trans('applang.full_name'),
            trans('applang.status'),
            trans('applang.email'),
            trans('applang.phone_code'),
            trans('applang.phone_number'),
            trans('applang.mobile'),
            trans('applang.street_address'),
            trans('applang.city'),
            trans('applang.state'),
            trans('applang.full_code'),
        ];
    }

    public function query()
    {
        return \App\Models\ERP\Sales\Client::with(['sequential_code', 'contacts'])->whereIn('id', $this->checked);
    }
}
