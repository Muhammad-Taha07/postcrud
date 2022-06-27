<?php

namespace App\config;

class Constants
{
    /* Role IDs */
    public const ROLE_USER = 1;
    public const ROLE_ADMIN = 2;

    /* User Status */
    public const USER_STATUS_UNVERIFIED     = 0;
    public const USER_STATUS_ACTIVE         = 1;
    public const USER_STATUS_IN_ACTIVE      = 2;

    /* Post Status */
    public const POST_TYPE_UNVERIFIED       = 0;
    public const POST_TYPE_ACTIVE           = 1;
    public const POST_TYPE_INACTIVE         = 2;

    /* Post Media Type Status */
    public const POST_MEDIA_TYPE_UNVERIFIED       = 0;
    public const POST_MEDIA_TYPE_ACTIVE           = 1;
    public const POST_MEDIA_TYPE_INACTIVE         = 2;

}
