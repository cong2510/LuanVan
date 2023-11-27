<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';

    /**
     * @return BelongsTo
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
