<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'tbl_enquiry';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];
}