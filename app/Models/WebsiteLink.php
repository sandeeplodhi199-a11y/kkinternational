<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteLink extends Model
{
    use HasFactory;

    protected $table = 'tbl_website_links';

    protected $fillable = [
        'title',
        'url',
        'type',
        'description',
    ];
}
