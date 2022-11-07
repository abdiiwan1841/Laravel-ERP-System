<?php

namespace App\Models\ERP\Settings;

use App\Models\ERP\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_name_ar',
        'template_name_en',
        'main_unit_ar',
        'main_unit_en',
        'main_unit_symbol_ar',
        'main_unit_symbol_en',
    ];

    public function measurement_units(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MeasurementUnit::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
