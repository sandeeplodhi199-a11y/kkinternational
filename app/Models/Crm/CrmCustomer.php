<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'crm_customers';
    protected $guarded = [];

    public function assignedEmployee()
    {
        return $this->belongsTo(CrmEmployee::class, 'assigned_to');
    }

    public function deals()
    {
        return $this->hasMany(CrmDeal::class, 'customer_id');
    }

    public function quotations()
    {
        return $this->hasMany(CrmQuotation::class, 'customer_id');
    }

    public function payments()
    {
        return $this->hasMany(CrmPayment::class, 'customer_id');
    }

    public function followups()
    {
        return $this->hasMany(CrmFollowup::class, 'customer_id');
    }

    public function tasks()
    {
        return $this->hasMany(CrmTask::class, 'related_customer_id');
    }
}
