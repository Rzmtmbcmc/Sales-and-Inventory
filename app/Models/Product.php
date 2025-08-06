<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'perishable'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    // Scope for low stock products
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '>', 0)->where('quantity', '<=', 10);
    }

    // Scope for out of stock products
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    // Scope for perishable products
    public function scopePerishable($query, $perishable)
    {
        return $query->where('perishable', $perishable);
    }
}