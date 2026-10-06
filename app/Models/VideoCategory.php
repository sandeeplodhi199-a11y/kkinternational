<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_video_category';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'is_deleted',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id');
    }
}
