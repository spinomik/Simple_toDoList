<?php

namespace Database\Seeders;

use App\Enums\PrivilegeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //pass 'admin1234'
        User::factory()->create([
            'id' => '9dc3145a-520e-4c81-b7b5-655026f98bfe',
            'name' => env('APP_ADMIN_NAME', 'admin'),
            'email' => env('APP_ADMIN_EMAIL', 'example@domain.com'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('APP_ADMIN_PASSWORD', '123Frytki')),
            'remember_token' => NULL,
            'blocked' => false
        ]);
        $this->call([
            StatusesTableSeeder::class,
            PrioritiesTableSeeder::class,
            TasksTableSeeder::class,
            PrivilegesTableSeeder::class,
        ]);

        User::find('9dc3145a-520e-4c81-b7b5-655026f98bfe')->privileges()->attach([PrivilegeEnum::ADMIN->value]);
    }
}
