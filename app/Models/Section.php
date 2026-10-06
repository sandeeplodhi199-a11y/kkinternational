<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    protected $table = 'tbl_section';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name'
        ];
    }

   

    
}
