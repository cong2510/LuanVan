<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    protected $table = 'image';

    protected $fillable = [
        'name',
        'image',
    ];

    /**
     * @return BelongsTo
     */
    public function sanpham(): BelongsTo
    {
        return $this->belongsTo(Sanpham::class);
    }
}
