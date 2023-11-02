<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    const PERMISSIONS = [
        'addProduct',
        'editProduct',
        'deleteProduct',

        'addGenre',
        'editGenre',
        'deleteGenre',

        'addBrand',
        'editBrand',
        'deleteBrand',

        'addRole',
        'editRole',
        'deleteRole',

        'addPermission',
        'editPermission',
        'deletePermission',

        'assignRole',
        'assignPermission',

        'addUser',
        'editUser',
        'deleteUser',

        'cancelOrder',
        'acceptOrder',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
