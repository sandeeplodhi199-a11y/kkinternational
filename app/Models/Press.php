<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Press extends Model
{
    protected $table = 'tbl_press';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'image',
            'name',
            'id_hash',
            'content',
            'is_deleted',
            'created_at',
            'updated_at'
        ];
    }

   

    
}
