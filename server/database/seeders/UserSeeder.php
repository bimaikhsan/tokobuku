<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => md5('admin'),
        ]);
    }
}
