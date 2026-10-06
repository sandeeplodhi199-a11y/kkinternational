<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    protected $table = 'tbl_slider';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name',
            'image',
            'is_deleted',
            'created_at',
            'update_at'
        ];
    }

   

    
}
