<?php

namespace App\Enums;

enum PrivilegeEnum: string
{
    case ADMIN = '0b3e79a5-3d2b-49b3-b290-ded7da4cd7b0';
    case TASK_READ = '727cb786-e1da-401e-b6c7-1426273c749b';
    case TASK_CREATE = '125a00c9-eed3-4727-9e68-c532f7c96b67';
    case TASK_EDIT = 'e3be575f-b3b6-4568-be7d-f34684c3a48f';
    case TASK_DELETE = '98fc975d-93f0-4267-8389-62e40aabfa12';
    case USER_READ = '028b43db-a06d-4c8c-aa6f-92df84a96cf2';
    case USER_EDIT = '7f39e2d0-52b3-4817-b470-09723de82d90';
    case USER_DELETE = 'da35ceae-b5a4-4f7a-9485-6292a0d1140c';
    case PRIVILEGE_CHANGE = '35724f96-7a16-42cd-8103-46a04714789e';
    case PUBLIC_TOKEN_GENERATE = '22f4c216-0a07-4312-9806-fec44fe6513a';
    case PUBLIC_TOKEN_DELETE = '15e788dc-10fc-468c-8d70-212169920ba8';

    // public function label(): string
    // {
    //     return match ($this) {
    //         self::ADMIN => 'Admin',
    //         self::TASK_READ => 'Read',
    //         self::TASK_CREATE => 'Create',
    //         self::TASK_EDIT => 'Edit',
    //         self::DELETE => 'Delete',
    //     };
    // }
}
