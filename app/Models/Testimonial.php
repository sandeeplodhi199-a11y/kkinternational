<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    protected $table = 'tbl_testimonial';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'heading',
            'sub_heading',
            'image',
            'name',
            'id_hash',
            'slug',
            'rating',
            'content',
            'is_deleted',
            'created_at',
            'updated_at'
        ];
    }

   

    
}
