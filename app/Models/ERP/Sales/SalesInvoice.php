<?php

namespace App\Models\ERP\Sales;

use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoiceAttachments;
use App\Models\ERP\Purchases\PurchaseInvoiceDetails;
use App\Models\ERP\Purchases\PurchaseInvoicePayment;
use App\Models\ERP\Purchases\PurchaseInvoiceTaxes;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
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

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function salesInvoiceDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoiceDetails::class, 'sales_invoice_id', 'id');
    }

    public function salesInvoiceTaxes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoiceTaxes::class, 'sales_invoice_id', 'id');
    }

    public function salesInvoiceAttachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoiceAttachments::class, 'sales_invoice_id', 'id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoicePayment::class, 'sales_invoice_id', 'id');
    }


    public static function scopeSearch($query,$search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhereHas('client', function ($query) use ($search){
                $query->where('full_name', 'like', '%'.$search.'%')
                    ->orWhere('full_code', 'like', '%'.$search.'%')
                    ->orWhere('mobile', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
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
            $model->number = SalesInvoice::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
//            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
//            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }
}
