<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    const GENDERS = [
        'Male',
        'Female',
        'Other'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
        return $permission_groups;
    }

    public static function getpermissionByGroupName($group_name)
    {
        $permissions = DB::table('permissions')->select('name', 'id')->where('group_name', $group_name)->get();
        return $permissions;
    }

    public static function roleHasPermissions($role,$permissions)
    {
        $hasPermission = true;
        foreach($permissions as $permission)
        {
            if(!$role->hasPermissionTo($permission->name))
            {
                $hasPermission = false;
            }
            return $hasPermission;
        }
    }
}
