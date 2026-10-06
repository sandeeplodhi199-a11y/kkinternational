<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $table = 'tbl_admission';

    protected $fillable = [
        'first_name','middle_name','last_name',
        'phone','email',

        'session_id','grade_id','section_id',

        'dob_bs','dob_ad',

        'state','city','address','pincode',

        'iemis_no','nickname','gender','blood_group',
        'nationality','photo','ethnicity','mother_tongue',
        'contact','religion',

        'roll_number','admission_no','school_admission_no',

        'status','is_deleted',

        'admission_date','add_id','updated_id'
    ];
}
