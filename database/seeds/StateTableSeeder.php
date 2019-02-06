<?php

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('states')->truncate();
        DB::table('states')->insert([
            'name' => 'Kerala',            
            'country_id' => 1
        ]);
        DB::table('states')->insert([
            'name' => 'Karnataka',            
            'country_id' => 1
        ]);
        DB::table('states')->insert([
            'name' => 'Victoria',            
            'country_id' => 2
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
