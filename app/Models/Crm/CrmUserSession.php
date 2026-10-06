<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmUserSession extends Model
{
    protected $table = 'crm_user_sessions';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
