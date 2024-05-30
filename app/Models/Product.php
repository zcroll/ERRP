<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_discontinued' => 'boolean',
        'product_category_id' => 'integer',
    ];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productDimension(): HasOne
    {
        return $this->hasOne(ProductDimension::class);
    }

    public function productSupplier(): HasOne
    {
        return $this->hasOne(ProductDimension::class);
    }

}
