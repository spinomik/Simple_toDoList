<?php

namespace App\Enums;

enum TaskPriorityEnum: string
{
    case LOW = '6e7200d7-c20f-46ca-b04d-4582c7808931';
    case MEDIUM = 'ee3979f5-c453-441d-b706-c73cd39c43d9';
    case HIGH = '7c9f9ae5-fba3-47e5-bd02-dbe05f9bb201';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'low',
            self::MEDIUM => 'medium',
            self::HIGH => 'high',
        };
    }
}
