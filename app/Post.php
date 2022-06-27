<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Post_Media;

class Post extends Model
{
    use HasApiTokens;
    protected $table = "posts";
    protected $fillable = ['user_id', 'title', 'description', 'status'];

       public function author() :BelongsTo
       {

        return $this->belongsTo(User::class, 'user_id');

       }

       // Posts_Media Creating post details
       public function postsMedia()
       {
        return $this->hasMany(Post_Media::class, 'post_id');
       }
}
