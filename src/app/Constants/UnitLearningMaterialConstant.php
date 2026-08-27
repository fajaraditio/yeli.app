<?php

namespace App\Constants;

class UnitLearningMaterialConstant
{
    public const Type_Pdf   = 'PDF';
    public const Type_Video = 'Video';
    public const Type_Ppt   = 'PPT';

    public const Type_Enums = [
        self::Type_Pdf,
        self::Type_Video,
        self::Type_Ppt,
    ];

    public const Extension_Map = [
        'pdf'  => self::Type_Pdf,
        'mp4'  => self::Type_Video,
        'mov'  => self::Type_Video,
        'avi'  => self::Type_Video,
        'mkv'  => self::Type_Video,
        'ppt'  => self::Type_Ppt,
        'pptx' => self::Type_Ppt,
    ];

    public const Accepted_Mime_Types = [
        'application/pdf',
        'video/mp4',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-matroska',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];
}
