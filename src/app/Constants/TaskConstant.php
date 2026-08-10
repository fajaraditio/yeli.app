<?php

namespace App\Constants;

class TaskConstant
{
    public const Status_Draft     = 'Draft';
    public const Status_InReview  = 'In Review';
    public const Status_Published = 'Published';

    public const Status_Enums = [
        self::Status_Draft,
        self::Status_InReview,
        self::Status_Published,
    ];

    public const Indicator_Interpretation  = 'Interpretation';
    public const Indicator_Analysis        = 'Analysis';
    public const Indicator_Evaluation      = 'Evaluation';
    public const Indicator_Inference       = 'Inference';
    public const Indicator_Explanation     = 'Explanation';
    public const Indicator_SelfRegulation  = 'Self-Regulation';

    public const Indicator_Enums = [
        self::Indicator_Interpretation,
        self::Indicator_Analysis,
        self::Indicator_Evaluation,
        self::Indicator_Inference,
        self::Indicator_Explanation,
        self::Indicator_SelfRegulation,
    ];
}
