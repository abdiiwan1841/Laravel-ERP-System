<?php

namespace App\Models\ERP\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable =[
        'business_name',
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
        'time_zone',
        'basic_currency',
        'basic_currency_symbol',
        'extra_currencies',
        'extra_currencies_symbols',
        'language',
        'logo'
    ];

    protected $casts = [
        'extra_currencies' => 'array',
        'extra_currencies_symbols' => 'array',
    ];

    public function getLogoPathAttribute(): string
    {
        return asset('uploads/logo_image/'.$this->logo);
    }
}
