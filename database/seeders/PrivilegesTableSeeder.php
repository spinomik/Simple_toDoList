<?php

namespace Database\Seeders;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Privilege::insert([
            ['id' => '0b3e79a5-3d2b-49b3-b290-ded7da4cd7b0', 'name' => 'admin'],
            ['id' => '727cb786-e1da-401e-b6c7-1426273c749b', 'name' => 'task_read'],
            ['id' => '125a00c9-eed3-4727-9e68-c532f7c96b67', 'name' => 'task_create'],
            ['id' => 'e3be575f-b3b6-4568-be7d-f34684c3a48f', 'name' => 'task_edit'],
            ['id' => '98fc975d-93f0-4267-8389-62e40aabfa12', 'name' => 'task_delete'],

            ['id' => '028b43db-a06d-4c8c-aa6f-92df84a96cf2', 'name' => 'user_read'],
            ['id' => '7f39e2d0-52b3-4817-b470-09723de82d90', 'name' => 'user_edit'],
            ['id' => 'da35ceae-b5a4-4f7a-9485-6292a0d1140c', 'name' => 'user_delete'],
            ['id' => '35724f96-7a16-42cd-8103-46a04714789e', 'name' => 'privileges_change'],

            ['id' => '22f4c216-0a07-4312-9806-fec44fe6513a', 'name' => 'public_token_generate'],
            ['id' => '15e788dc-10fc-468c-8d70-212169920ba8', 'name' => 'public_token_delete']
        ]);
    }
}
