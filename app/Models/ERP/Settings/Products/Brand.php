<?php

namespace App\Models\ERP\Settings\Products;

use App\Models\ERP\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

/*    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('status', 'like', '%'.$search.'%')
                ->orWhereHas('sections', function ($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
    }*/

    public static function scopeSearch($query, $search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhere('name', 'like', '%'.$search.'%')
            ->orWhere('status', 'like', '%'.$search.'%')
            ->orWhereHas('sections', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            });
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
