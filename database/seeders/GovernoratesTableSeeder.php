<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernoratesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            ['name' => 'Governorate 1'],
            ['name' => 'Governorate 2'],
            ['name' => 'Governorate 3'],
        ]);
    }
}
