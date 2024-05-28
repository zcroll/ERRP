<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_code',
        'name',
        'image',
        'description',
        'unit_price',
        'is_discontinued',
        'product_category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var arrayCall to undefined method App\Models\Product::productSupplier()
     */
    protected $casts = [
        'id' => 'integer',
        'unit_price' => 'decimal:2',
        'is_discontinued' => 'boolean',
        'product_category_id' => 'integer',
    ];

    public function productSupplier()
    {
        return $this->hasMany(\App\Models\ProductSupplier::class);
    }
    public function productDimension()
    {
        return $this->hasOne(ProductDimension::class);
    }
    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
