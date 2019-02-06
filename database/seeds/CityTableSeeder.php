<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cities')->truncate();
        DB::table('cities')->insert([
            'name' => 'Cochin',            
            'state_id' => 1
        ]);
        DB::table('cities')->insert([
            'name' => 'Calicut',            
            'state_id' => 1
        ]);
        DB::table('cities')->insert([
            'name' => 'Melbourne',            
            'state_id' => 3
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
