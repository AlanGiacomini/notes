<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create multiple users
        DB::table('users')->insert([
            [
                'username' => 'user1@provedor.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user2@provedor.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user3@provedor.com',
                'password' => bcrypt('asd123456'),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
