<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmReservation extends Model
{
    protected $table = 'crm_reservations';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'customer_id');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(CrmEmployee::class, 'assigned_to');
    }
}
