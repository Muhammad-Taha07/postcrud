<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\AuthController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password','status','verification_code', 'verification_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_code','verification_expiry'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Needs to be Cleared
    public function updateUserStatus($userId, $input)
    {
    return $updateUser = User::where('id', $userId)->update($input);
    }

    public function updateUser($id, $data)
    {
        $saveUser =  User::find($id);
        $saveUser->update($data);
        $saveUser->save();
        return $saveUser ? $saveUser : array();
    }

    public function createUser($data)
    {
        $user = User::create($data);
        return $user ? $user : array();
    }
    /* has Many Relationship */
    public function postings() :HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getUserPosts($user)
    {
        return $result = User::join('posts','posts.user_id', '=', 'users.id')
        ->where('posts.user_id',$user->id)
        ->select('users.id as user_id','posts.id as post_id','users.name as user_name', 'users.email as user_email', 'posts.title as post_title', 'posts.description as post_description')
        ->get();
    }

}
