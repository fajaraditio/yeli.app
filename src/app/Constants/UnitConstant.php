<?php

namespace App\Constants;

use Filafly\Icons\Phosphor\Enums\Phosphor;

class UnitConstant
{
    public const Status_Draft     = 'Draft';
    public const Status_InReview  = 'In Review';
    public const Status_Published = 'Published';

    public const Status_Enums = [
        self::Status_Draft,
        self::Status_InReview,
        self::Status_Published,
    ];

    public const Status_Colors = [
        self::Status_Draft => 'gray',
        self::Status_InReview => 'info',
        self::Status_Published => 'success',
    ];

    public const Status_Icons = [
        self::Status_Draft => Phosphor::Pencil,
        self::Status_InReview => Phosphor::Clock,
        self::Status_Published => Phosphor::CheckCircle,
    ];
}
