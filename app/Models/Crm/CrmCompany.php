<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmCompany extends Model
{
    protected $table = 'crm_companies';
    protected $guarded = [];

    public function contacts()
    {
        return $this->hasMany(CrmContact::class, 'company_id');
    }
}
