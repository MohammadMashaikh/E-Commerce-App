<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name'];
    

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id')
        ->withTimestamps();
    }


    
    public function syncPermissions(array $permissionIds)
    {
        $this->permissions()->sync($permissionIds);
    }


}
