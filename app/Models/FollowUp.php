<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowUp extends Model
{
    protected $table = 'tbl_follow_up';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'lead_id',
            'status',
            'follow_by',
            'comment',
            'follow_date'
            
        ];
    }

   

    
}
