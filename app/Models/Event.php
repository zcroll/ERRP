<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{


    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
    ];
}
