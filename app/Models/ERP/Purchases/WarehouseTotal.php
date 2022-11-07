<?php

namespace App\Models\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Sales\SalesInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTotal extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'total_quantity_purchased',
        'total_purchases_cost',
        'total_sales_value_of_purchases',
        'expected_profit',
        'total_quantity_sold',
        'total_sold_cost',
        'total_value_of_sales',
        'actual_profit',
        'total_quantity_remain',
        'total_remain_cost',
        'total_sales_value_of_remain',
        'expected_profit_of_remain',
        'weighted_average_cost',
    ];

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
