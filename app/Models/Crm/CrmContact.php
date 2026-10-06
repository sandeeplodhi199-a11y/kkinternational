<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmContact extends Model
{
    protected $table = 'crm_contacts';
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(CrmCompany::class, 'company_id');
    }
}
