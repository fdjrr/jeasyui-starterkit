<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function scopeFilter(Builder $query, array $filters = [])
    {
        $search = $filters['search'] ?? false;
        $product_category_id = $filters['product_category_id'] ?? false;

        $query->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->whereLike('code', "%$search%")
                    ->orWhereLike('name', "%$search%")
                    ->orWhereLike('sku', "%$search%");
            });
        });

        $query->when($product_category_id, function ($query, $product_category_id) {
            $query->where('product_category_id', $product_category_id);
        });
    }

    /**
     * Get the product_category that owns the Product
     */
    public function product_category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /**
     * Get the product_unit that owns the Product
     */
    public function product_unit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'id');
    }
}
