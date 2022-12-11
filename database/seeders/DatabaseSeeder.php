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
            'email' => 'test.@test.com',
            'password' => '12345678',
        ]);

        DB::table('database_lists')->insert([
            'id' => 0,
            'name' => 'basics',
        ]);

        DB::table('database_lists')->insert([
            'id' => 1,
            'name' => 'statement',
        ]);

        DB::table('database_lists')->insert([
            'id' => 2,
            'name' => 'sources',
        ]);

        DB::table('database_lists')->insert([
            'id' => 3,
            'name' => 'activity',
        ]);
    }
}
