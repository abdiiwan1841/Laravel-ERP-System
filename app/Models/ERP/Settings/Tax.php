<?php

namespace App\Models\ERP\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'tax_name_ar',
        'tax_name_en',
        'tax_value',
        'unit_price_inc',
    ];
}
