<?php

namespace App\Models;

use App\Enums\StockType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the product that owns the ProductStock
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Get the warehouse that owns the ProductStock
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'stock_type' => StockType::class,
        ];
    }
}
