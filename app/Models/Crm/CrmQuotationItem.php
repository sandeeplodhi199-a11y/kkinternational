<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmQuotationItem extends Model
{
    protected $table = 'crm_quotation_items';
    protected $guarded = [];

    public function quotation()
    {
        return $this->belongsTo(CrmQuotation::class, 'quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(CrmProduct::class, 'product_id');
    }
}
