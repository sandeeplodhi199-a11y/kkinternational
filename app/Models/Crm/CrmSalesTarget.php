<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmSalesTarget extends Model
{
    protected $table = 'crm_sales_targets';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(CrmEmployee::class, 'user_id');
    }
}
