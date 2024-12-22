<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_priorities')->insert([
            ['id' => '6e7200d7-c20f-46ca-b04d-4582c7808931', 'name' => 'low'],
            ['id' => 'ee3979f5-c453-441d-b706-c73cd39c43d9', 'name' => 'medium'],
            ['id' => '7c9f9ae5-fba3-47e5-bd02-dbe05f9bb201', 'name' => 'high'],
        ]);
    }
}
