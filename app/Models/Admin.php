<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends Authenticatable implements HasMedia
{
    use InteractsWithMedia, HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = [
        'password',
    ];
    
    protected $casts = [
        'password' => 'hashed',
        'created_at' => 'date'
    ];

    public function role() : BelongsTo 
    {
        return $this->belongsTo(Role::class);
    }


    public function hasPermission($permissionName)
    {
        return $this->role->permissions->contains('name', $permissionName);
    }
}
