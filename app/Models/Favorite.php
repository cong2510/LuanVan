<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorite';

     /**
     * @return BelongsToMany
     */
    public function sanpham(): BelongsToMany
    {
        return $this->belongsToMany(Sanpham::class);
    }
}
