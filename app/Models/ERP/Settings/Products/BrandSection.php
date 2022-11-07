<?php

namespace App\Models\ERP\Settings\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSection extends Model
{
    use HasFactory;

    protected $table = 'brand_section';

    protected $fillable = [
        'section_id',
        'brand_id',
    ];

}
