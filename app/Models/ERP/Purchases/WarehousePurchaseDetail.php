<?php

namespace App\Models\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehousePurchaseDetail extends Model
{
    use HasFactory;
    protected $fillable = [
      'warehouse_id',
      'purchase_invoice_id',
      'product_id',
      'quantity',
      'unit_price',
      'receiving_status',
    ];

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function purchaseInvoice(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
