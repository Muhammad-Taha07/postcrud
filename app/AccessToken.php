<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class AccessToken extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'oauth_access_tokens';
    protected $fillable =['user_id', 'client_id', 'name', 'scopes', 'revoked', 'created_at', 'updated_at', 'expires_at'];

/**
 * Destroying Login Session
 */
    public function sessionDestroyed($userId)
    {
        return $destroy = AccessToken::where('user_id', $userId)->delete();
    }


}
