<?php

namespace App\Constants;

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

    public const BloomLevel_Analyze       = 'Analyze';
    public const BloomLevel_Evaluate      = 'Evaluate';
    public const BloomLevel_EvaluateInfer = 'Evaluate / Infer';
    public const BloomLevel_Create        = 'Create';

    public const BloomLevel_Enums = [
        self::BloomLevel_Analyze,
        self::BloomLevel_Evaluate,
        self::BloomLevel_EvaluateInfer,
        self::BloomLevel_Create,
    ];
}
