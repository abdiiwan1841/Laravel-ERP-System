<?php

namespace App\Models\ERP;

use App\Models\ERP\Inventory\Warehouse;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'number',
        'name_ar',
        'name_en',
        'address_ar',
        'address_en',
        'sequential_code_id',
        'full_code',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public function warehouses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = Branch::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }
}
