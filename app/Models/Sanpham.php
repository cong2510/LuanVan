<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sanpham extends Model
{
    use HasFactory;

    protected $table = 'sanpham';
    protected $fillable = [
        'name',
        'mota',
        'gia',
        'soluong',
        'brand_id',
    ];

    /**
     * @return BelongsToMany
     */
    public function theloai(): BelongsToMany
    {
        return $this->belongsToMany(Theloai::class);
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function image(): HasMany
    {
        return $this->hasMany(Image::class);
    }

     /**
     * @return BelongsToMany
     */
    public function favorite(): BelongsToMany
    {
        return $this->belongsToMany(Favorite::class);
    }

    /**
     * @return HasMany
     */
    public function rating() : HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
