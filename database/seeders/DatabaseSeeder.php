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

        DB::table('index_databases')->insert([
            'db_name' => 'basics',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_databases')->insert([
            'db_name' => 'statement',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_databases')->insert([
            'db_name' => 'source',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_databases')->insert([
            'db_name' => 'activity',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_databases')->insert([
            'db_name' => 'refs',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Sound',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Picture',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Video',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Letter',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Interactivity',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'System',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Location',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Self Awareness',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Self Reproduction',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'External Activation',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'External Motivation',
            'tracking' => '127.0.0.1',
        ]);
    }
}
