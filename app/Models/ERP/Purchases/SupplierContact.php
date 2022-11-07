<?php

namespace App\Models\ERP\Purchases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'supp_cont_first_name',
        'supp_cont_last_name',
        'supp_cont_email',
        'supp_cont_phone',
        'supp_cont_mobile',
        'supplier_id',
    ];

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
