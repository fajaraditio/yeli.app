<?php

namespace App\Constants;

use Filafly\Icons\Phosphor\Enums\Phosphor;

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

    public const Status_Colors = [
        self::Status_Pending => 'warning',
        self::Status_Approved => 'success',
        self::Status_Rejected => 'danger',
        self::Status_Suspended => 'danger',
    ];

    public const Status_Icons = [
        self::Status_Pending => Phosphor::Clock,
        self::Status_Approved => Phosphor::CheckCircle,
        self::Status_Rejected => Phosphor::XCircle,
        self::Status_Suspended => Phosphor::Stop,
    ];
}
