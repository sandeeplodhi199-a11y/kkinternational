<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmTask extends Model
{
    use SoftDeletes;

    protected $table = 'crm_tasks';
    protected $guarded = [];

    public function assignedEmployee()
    {
        return $this->belongsTo(CrmEmployee::class, 'assigned_to');
    }

    public function lead()
    {
        return $this->belongsTo(CrmLead::class, 'related_lead_id');
    }

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'related_customer_id');
    }
}
