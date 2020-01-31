<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['id', 'user_id', 'tmdb_id', 'title', 'content', 'begin_at', 'end_at'];
}
