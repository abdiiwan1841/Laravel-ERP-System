<?php

namespace App\Models\ERP\Settings;

use App\Models\ERP\Branch;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SequentialCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'prefix',
        'numbers_length',
        'model',
    ];

    public function branch(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function suppliers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseInvoice(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }
}
