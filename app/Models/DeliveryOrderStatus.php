<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderStatus extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $fillable = [
        'approved',
        'processing',
        'shipped',
        'delivered',
        'rejected',
        'created_by'
    ];

}
