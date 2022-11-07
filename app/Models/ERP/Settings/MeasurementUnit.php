<?php

namespace App\Models\ERP\Settings;

use App\Models\ERP\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;
    protected $fillable = [
      'units_template_id',
      'largest_unit_ar',
      'largest_unit_en',
      'largest_unit_symbol_ar',
      'largest_unit_symbol_en',
      'conversion_factor',
    ];

    public function units_template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UnitsTemplate::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
