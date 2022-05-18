<?php

namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasApiTokens, Notifiable;
    protected $table = "users";

    protected $fillable = ['name', 'email', 'password'];

}
