<?php

namespace App\Models\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Sales\SalesInvoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSalesDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'sales_invoice_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function salesInvoice(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoice::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
