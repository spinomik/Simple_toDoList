<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case TODO = 'dc59e26e-fd5f-46fd-9449-0fffbcd68442';
    case IN_PROGRESS = '83257a53-fb85-4636-84c9-d495ed86cccb';
    case DONE = '44188117-c722-41de-a68d-7753cd3eb086';

    public function label(): string
    {
        return match ($this) {
            self::TODO => 'to-do',
            self::IN_PROGRESS => 'in progress',
            self::DONE => 'done',
        };
    }
}
