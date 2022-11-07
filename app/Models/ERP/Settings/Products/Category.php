<?php

namespace App\Models\ERP\Settings\Products;

use App\Models\ERP\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'section_id',
    ];

//    public static function search($search)
//    {
//        return empty($search) ? static::query()
//            : static::where('id', 'like', '%'.$search.'%')
//                ->orWhere('name', 'like', '%'.$search.'%')
//                ->orWhere('status', 'like', '%'.$search.'%')
//                ->orWhereHas('section', function ($query) use ($search){
//                    $query->where('name', 'like', '%'.$search.'%');
//                })
//                ->orWhereHas('brands', function ($query) use ($search){
//                    $query->where('name', 'like', '%'.$search.'%');
//                });
//    }

    public static function scopeSearch($query,$search)
    {
        $query->where('id', 'like', '%'.$search.'%') 
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhereHas('section', function ($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('brands', function ($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
    }

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function brands(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }

    public function subCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
