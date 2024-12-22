<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_statuses')->insert([
            ['id' => 'dc59e26e-fd5f-46fd-9449-0fffbcd68442', 'name' => 'to-do'],
            ['id' => '83257a53-fb85-4636-84c9-d495ed86cccb', 'name' => 'in progress'],
            ['id' => '44188117-c722-41de-a68d-7753cd3eb086', 'name' => 'done'],
        ]);
    }
};
