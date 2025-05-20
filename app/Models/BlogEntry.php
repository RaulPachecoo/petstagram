<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogEntry extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}
