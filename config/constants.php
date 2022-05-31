<?php

namespace App\config;

class Constants
{
    //role ids
    public const ROLE_USER = 1;
    public const ROLE_ADMIN = 2;

    //user status
    public const USER_STATUS_UNVERIFIED     = 0;
    public const USER_STATUS_ACTIVE         = 1;
    public const USER_STATUS_IN_ACTIVE      = 2;

    //Posts Status
    public const POST_TYPE_INACTIVE       = 0;
    public const POST_TYPE_ACTIVE         = 1;
    public const POST_TYPE_REMOVED        = 2;

}
