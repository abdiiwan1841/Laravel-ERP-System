<?php

namespace App\Models\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Settings\SequentialCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable =[
      'commercial_name',
      'first_name',
      'last_name',
      'email',
      'phone',
      'mobile',
      'fax',
      'phone_code',
      'street_address',
      'city',
      'state',
      'postal_code',
      'country',
      'commercial_record',
      'tax_registration',
      'currency',
      'currency_symbol',
      'opening_balance',
      'opening_balance_date',
      'notes',
      'status',
      'created_by',
      'sequential_code_id',
      'number',
      'full_code',
    ];

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public function purchase_invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = Supplier::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
