<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_Media extends Model
{
    protected $table = "posts_media";
    protected $fillable = ['post_id', 'post_title', 'post_description', 'media_url', 'status', 'media_thumb_url'];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }



}
