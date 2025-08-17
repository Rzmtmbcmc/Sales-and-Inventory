<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PastOrder extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'branch_id', 'total_amount'];

    public function items(): HasMany
    {
        return $this->hasMany(PastOrderItem::class, 'past_order_id');
    }
}