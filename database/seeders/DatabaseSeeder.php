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
            'db_name' => 'basics',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_name' => 'statement',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_name' => 'sources',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_name' => 'activity',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('database_lists')->insert([
            'db_name' => 'refs',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'sound',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'picture',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'video',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'letter',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'interactivity',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'system',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'location',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'self_awareness',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'self_reproduction',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'external_activation',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('medium_lists')->insert([
            'medium_name' => 'external_motivation',
            'tracking' => '127.0.0.1',
        ]);
    }
}
