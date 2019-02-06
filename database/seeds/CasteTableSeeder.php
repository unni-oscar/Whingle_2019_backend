<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CasteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('castes')->truncate();
        DB::table('castes')->insert([
            'name' => 'Nair',     
            'religion_id' => 1 
        ]);
        DB::table('castes')->insert([
            'name' => 'Ezhava',  
            'religion_id' => 1           
        ]);
        DB::table('castes')->insert([
            'name' => 'Romann', 
            'religion_id' => 2               
        ]);
        DB::table('castes')->insert([
            'name' => 'Catholic', 
            'religion_id' => 2            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
