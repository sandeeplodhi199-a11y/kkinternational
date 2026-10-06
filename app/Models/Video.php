<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    protected $table = 'tbl_video';

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
            'url',
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
        return $this->belongsTo(VideoCategory::class, 'category_id');
    }
}
