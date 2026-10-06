<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmQuotation extends Model
{
    use SoftDeletes;

    protected $table = 'crm_quotations';
    protected $guarded = [];

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(CrmQuotationItem::class, 'quotation_id');
    }

    public function payments()
    {
        return $this->hasMany(CrmPayment::class, 'quotation_id');
    }
}
