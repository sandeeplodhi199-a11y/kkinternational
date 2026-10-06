<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmPermission extends Model
{
    protected $table = 'crm_permissions';
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(CrmRole::class, 'crm_role_permissions', 'permission_id', 'role_id');
    }
}
