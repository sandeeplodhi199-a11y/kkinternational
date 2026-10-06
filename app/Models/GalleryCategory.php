<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_gallery_category';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'is_deleted',
    ];

    public function images()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
