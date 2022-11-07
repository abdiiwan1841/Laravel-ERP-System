<?php

namespace App\Models\ERP\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_cont_first_name',
        'client_cont_last_name',
        'client_cont_email',
        'client_cont_phone',
        'client_cont_mobile',
        'client_id',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
