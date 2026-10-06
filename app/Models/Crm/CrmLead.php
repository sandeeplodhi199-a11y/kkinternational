<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmLead extends Model
{
    use SoftDeletes;

    protected $table = 'crm_leads';
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(CrmBranch::class, 'branch_id');
    }

    public function source()
    {
        return $this->belongsTo(CrmLeadSource::class, 'source_id');
    }

    public function statusRel()
    {
        return $this->belongsTo(CrmLeadStatus::class, 'status_id');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(CrmEmployee::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(CrmLeadActivity::class, 'lead_id')->latest();
    }

    public function followups()
    {
        return $this->hasMany(CrmFollowup::class, 'lead_id')->latest();
    }

    public function tasks()
    {
        return $this->hasMany(CrmTask::class, 'related_lead_id')->latest();
    }
}
