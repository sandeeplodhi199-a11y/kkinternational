<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    protected $table = 'tbl_faq';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name',
            'id_hash',
            'content',
            'type',
            'is_deleted',
            'created_at',
            'updated_at'
        ];
    }

   

    
}
