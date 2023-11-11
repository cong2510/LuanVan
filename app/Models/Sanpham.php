<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
