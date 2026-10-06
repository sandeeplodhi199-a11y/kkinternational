<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CrmEmployee extends Model
{
    use SoftDeletes;

    protected $table = 'crm_employees';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(CrmDepartment::class, 'department_id');
    }

    public function leads()
    {
        return $this->hasMany(CrmLead::class, 'assigned_to');
    }

    public function deals()
    {
        return $this->hasMany(CrmDeal::class, 'assigned_to');
    }

    public function tasks()
    {
        return $this->hasMany(CrmTask::class, 'assigned_to');
    }

    public function followups()
    {
        return $this->hasMany(CrmFollowup::class, 'assigned_to');
    }
}
