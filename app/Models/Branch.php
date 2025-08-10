<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Branch extends Model
{
    use HasFactory;
     protected $fillable = [
        'brand_id',
        'name',
        'address',
        'contact'
    ];
      /**
     * Get the brand that owns this branch
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Scope for searching branches
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('address', 'like', "%{$term}%")
                    ->orWhere('contact', 'like', "%{$term}%");
    }
}
