<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theloai extends Model
{
    use HasFactory;

    protected $table = 'theloai';
    protected $fillable = [
        'name',
    ];

     /**
     * @return BelongsToMany
     */
    public function sanpham(): BelongsToMany
    {
        return $this->belongsToMany(Sanpham::class);
    }

    const INTERMEDIATE_TABLE = [
        'sanpham_theloai'
    ];
}
