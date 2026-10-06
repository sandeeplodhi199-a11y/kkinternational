<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmProduct extends Model
{
    use SoftDeletes;

    protected $table = 'crm_products';
    protected $guarded = [];
}
