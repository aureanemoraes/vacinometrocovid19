<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'cpf' => '31228823022',
            'email' => 'ti.prefeituramacapa@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
