<?php

namespace App\Models\ERP\Purchases;

use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseInvoiceDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoiceDetails::class, 'purchase_invoice_id', 'id');
    }

    public function purchaseInvoiceTaxes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoiceTaxes::class, 'purchase_invoice_id', 'id');
    }

    public function purchaseInvoiceAttachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoiceAttachments::class, 'purchase_invoice_id', 'id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoicePayment::class, 'purchase_invoice_id', 'id');
    }


    public static function scopeSearch($query,$search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhereHas('supplier', function ($query) use ($search){
                $query->where('commercial_name', 'like', '%'.$search.'%')
                    ->orWhere('full_code', 'like', '%'.$search.'%');
            })
            ->orWhereHas('user', function ($query) use ($search){
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('middle_name', 'like', '%'.$search.'%')
                    ->orwhere('last_name', 'like', '%'.$search.'%');
            })
            ->orWhere('inv_number', 'like', '%'.$search.'%');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = PurchaseInvoice::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
//            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
//            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }
}
