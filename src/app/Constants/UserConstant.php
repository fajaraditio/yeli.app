<?php

namespace App\Constants;

class UserConstant
{
    public const Role_Admin     = 'Administrator';
    public const Role_Lecturer  = 'Lecturer';
    public const Role_Student   = 'Student';

    public const Status_Pending     = 'Pending';
    public const Status_Approved    = 'Approved';
    public const Status_Rejected    = 'Rejected';
    public const Status_Suspended   = 'Suspended';

    public const Status_Enums = [
        self::Status_Pending,
        self::Status_Approved,
        self::Status_Rejected,
        self::Status_Suspended,
    ];
}
