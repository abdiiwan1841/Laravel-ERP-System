<?php

namespace App\Models\ERP\Sales;

use App\Models\ERP\Settings\SequentialCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "country",
        "phone_code",
        "phone",
        "mobile",
        "street_address",
        "postal_code",
        "state",
        "city",
        "email",
        "status",
        "currency" ,
        "currency_symbol",
        "opening_balance",
        "opening_balance_date",
        "notes",
        'created_by',
        'sequential_code_id',
        'number',
        'full_code',
    ];

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientContact::class);
    }

    public function sales_invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesInvoice::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = Client::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }

    public static function scopeSearch($query, $search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhere('full_name', 'like', '%'.$search.'%')
            ->orWhere('status', 'like', '%'.$search.'%');
    }
}
