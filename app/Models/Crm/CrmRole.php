<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmRole extends Model
{
    protected $table = 'crm_roles';
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(CrmPermission::class, 'crm_role_permissions', 'role_id', 'permission_id');
    }

    public function hasPermission($permissionSlug): bool
    {
        if ($this->slug === 'super_admin') {
            return true;
        }
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }
}
