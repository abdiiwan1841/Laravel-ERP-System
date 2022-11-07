<?php

namespace App\Models;

use App\Models\ERP\Branch;
use App\Models\ERP\Purchases\PurchaseInvoice;
use App\Models\ERP\Purchases\PurchaseInvoicePayment;
use App\Models\ERP\Settings\SequentialCode;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $dates = ['last_active_at'];
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'email',
        'phone',
        'address_1',
        'address_2',
        'user_image',
        'password',
        'roles_name',
        'status',
        'branch_id',
        'department_id',
        'job_id',
        'system_user',
        'system_not_user',
        'last_active_at',
        'sequential_code_id',
        'number',
        'full_code',
    ];

    protected $appends = ['image_path'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name' => 'array',
    ];


    public function getImagePathAttribute(): string
    {
        return asset('uploads/users_images/'.$this->user_image);
    }

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PermissionsCategory::class);
    }

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public function purchase_invoice(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function purchase_invoice_payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PurchaseInvoicePayment::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = User::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
            $numbers_length =  SequentialCode::where('model', $model->getTable())->pluck('numbers_length')->first();
            $model->full_code = $model->sequential_code->prefix . '-' . str_pad($model->number, $numbers_length, '0', STR_PAD_LEFT);
        });
    }

}
