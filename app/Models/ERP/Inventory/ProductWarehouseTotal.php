<?php

namespace App\Models\ERP\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarehouseTotal extends Model
{
    use HasFactory;
    protected $table = 'product_warehouse_total';

    protected $fillable = [
        'product_id',
        'warehouse_total_id',
    ];
}
