<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TranslatedPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'permission_id',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function category()
    {
        return $this->belongsTo(PermissionsCategory::class);
    }
}
