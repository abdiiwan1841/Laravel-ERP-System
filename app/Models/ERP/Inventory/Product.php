<?php

namespace App\Models\ERP\Inventory;

use App\Models\ERP\Purchases\PurchaseInvoiceDetails;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\WarehouseTotal;
use App\Models\ERP\Settings\MeasurementUnit;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use App\Models\ERP\Settings\SequentialCode;
use App\Models\ERP\Settings\Tax;
use App\Models\ERP\Settings\UnitsTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'section_id',
        'brand_id',
        'category_id',
        'subcategory_id',
        'unit_template_id',
        'measurement_unit_id',
        'supplier_id',
        'barcode',
        'purchase_price',
        'sell_price',
        'first_tax_id',
        'second_tax_id',
        'lowest_sell_price',
        'discount',
        'discount_type',
        'profit_margin',
        'lowest_stock_alert',
        'notes',
        'status',
        'number',
        'sequential_code_id',
        'sku',
        'total_quantity',
        'product_image'
    ];

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function unitTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UnitsTemplate::class);
    }

    public function measurementUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tax(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function warehouseTotal(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(WarehouseTotal::class);
    }

    public function sequential_code(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SequentialCode::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sequential_code_id = SequentialCode::where('model', $model->getTable())->pluck('id')->first();
            $model->number = Product::where('sequential_code_id', $model->sequential_code_id)->max('number') + 1 ;
        });
    }

    public static function scopeSearch($query, $search)
    {
        $query->where('id', 'like', '%'.$search.'%')
            ->orWhere('name', 'like', '%'.$search.'%')
            ->orWhere('status', 'like', '%'.$search.'%')
            ->orWhere('sku', 'like', '%'.$search.'%')
            ->orWhereHas('section', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('brand', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('category', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('subcategory', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhereHas('supplier', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
