<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmPayment extends Model
{
    use SoftDeletes;

    protected $table = 'crm_payments';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'customer_id');
    }

    public function quotation()
    {
        return $this->belongsTo(CrmQuotation::class, 'quotation_id');
    }
}
