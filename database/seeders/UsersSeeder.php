<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Gestão - Prefeitura de Macapá',
            'email' => 'ti.prefeituramacapa@gmail.com',
            'password' => Hash::make('123456'),
            'is_admin' => 1,
            'is_manager' => 1,
            'activeted' => 1
        ]);
    }
}
