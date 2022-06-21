<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_Media extends Model
{
    protected $table = "posts_media";


    public function posts()
    {
        return $this->belongsTo(Post::class);
    }



}
