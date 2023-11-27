<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';


    protected $fillable = [
        'order_status',
    ];

    const ORDER_STATUS = [
        'Pending',
        'On the way',
        'Done',
        'Canceled'
    ];

    // const PAY_TYPE = [
    //     'VNPAY',
    //     'COD'
    // ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function orderdetail() : HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * @return BelongsToMany
     */
    public function sanpham(): BelongsToMany
    {
        return $this->belongsToMany(Sanpham::class);
    }

    public function paymentmethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class);
    }
}
