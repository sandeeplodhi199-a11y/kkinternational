<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    protected $table = 'tbl_blog';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name',
            'slug',
            'image',
            'add_date',
            'added_by',
            'content',
            'short_content',
            'tags'
        ];
    }

   

    
}
