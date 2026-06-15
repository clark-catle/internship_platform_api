<?php

namespace App\Enum\File;

enum FileMimeTypeEnum: string
{
    case jpeg = 'image/jpeg';
    case png = 'image/png';
    case webpg = 'image/webp';
    case pdf = 'application/pdf';
    case docs = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
}
