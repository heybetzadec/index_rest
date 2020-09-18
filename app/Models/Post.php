<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'foreign_key');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'foreign_key');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
