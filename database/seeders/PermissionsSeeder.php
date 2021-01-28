<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
    */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'admin',
            'guard_name' => 'backpack',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
