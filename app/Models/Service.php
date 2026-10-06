<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'tbl_service';
    
    protected $fillable = [
        'name',
        'slug',
        'id_hash',
        'status',
        'is_deleted',
        'image',
        'content',
        'short_content',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'image_alt',
        'image_title',
        'image_description'
    ];
    
    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
    ];
}