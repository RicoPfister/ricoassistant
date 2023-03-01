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
            'medium_name' => 'Idle',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Story',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Media',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Admin',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Fact',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Elaboration',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Education',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Exchange',
            'tracking' => '127.0.0.1',
        ]);

        DB::table('index_mediums')->insert([
            'medium_name' => 'Evaluation',
            'tracking' => '127.0.0.1',
        ]);

    }
}
