<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    protected $table = 'tbl_gallery';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name',
            'parent',
            'category_id',
            'slug',
            'image',
            'add_date',
            'added_by',
            'content',
            'short_content',
            'tags'
        ];
    }

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
