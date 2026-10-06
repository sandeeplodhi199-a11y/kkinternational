<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmBranch extends Model
{
    protected $table = 'crm_branches';
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(CrmEmployee::class, 'branch_id');
    }

    public function leads()
    {
        return $this->hasMany(CrmLead::class, 'branch_id');
    }
}
