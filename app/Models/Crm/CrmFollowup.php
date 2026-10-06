<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmFollowup extends Model
{
    use SoftDeletes;

    protected $table = 'crm_followups';
    protected $guarded = [];

    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'lead_id');
    }

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'customer_id');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(CrmEmployee::class, 'assigned_to');
    }
}
