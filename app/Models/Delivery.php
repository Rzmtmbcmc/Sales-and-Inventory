<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id',
        'user_id',
        'delivery_date',
        'status',
    ];
}
