<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


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
        'name', 'email', 'password','status','verification_code', 'verifciation_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Needs to be Cleared
    // public function updateUserStatus($userId, $input)
    // {
    // return $updateUser = User::where('id', $userId)->update($input);
    // }

    public function updateUser($id, $data)
    {
        $user =  User::find($id);
        $user->update($data);
        $user->save();
        return $user ? $user : array();
    }

    public function createUser($data)
    {
        $user = User::create($data);
        return $user ? $user : array();
    }
}
