<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Test Account',
            'email' => 'test@test.com',
            'password' => '$2y$10$w/7zSu8/iNA2tHYJlMmHOee4iYDAvzGw3b4Tmnx0E1ChgeI0Tq8Ly',
        ]);

        DB::table('database_lists')->insert([
            'db_id' => 0,
            'db_name' => 'basics',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_id' => 1,
            'db_name' => 'statement',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_id' => 2,
            'db_name' => 'sources',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_id' => 3,
            'db_name' => 'activity',
            'tracking' => '127.0.0.1',
        ]);
    }
}
