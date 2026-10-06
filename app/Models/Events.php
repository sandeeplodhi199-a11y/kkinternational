<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    protected $table = 'tbl_events';

    public function __construct(){
        parent::__construct();
        $this->setFillable();
    }

    public function setFillable(){
        $this->fillable = [
            'id',
            'name',
            'slug',
            'id_hash',
            'event_date',
            'event_time',
            'conduct_by',
            'short_content',
            'content',
            'image',
            'is_deleted',
            'created_at',
            'updated_at'
        ];
    }

    // Helper method to get formatted date
    public function getFormattedDate()
    {
        if ($this->event_date) {
            return date('d F, Y', strtotime($this->event_date));
        }
        return 'Date to be announced';
    }

    // Helper method to get image URL
    public function getImageUrl()
    {
        if ($this->image) {
            return url('public/uploads/' . $this->image);
        }
        return url('assets/frontend/img/about/ev-d-1-1.jpg');
    }
}