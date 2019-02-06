<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
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
        DB::table('countries')->truncate();
        DB::table('countries')->insert([
            'name' => 'India',            
        ]);
        DB::table('countries')->insert([
            'name' => 'Australia',            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
