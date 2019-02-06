<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('religions')->truncate();
        DB::table('religions')->insert([
            'name' => 'Hindu',            
        ]);
        DB::table('religions')->insert([
            'name' => 'Muslim',            
        ]);
        DB::table('religions')->insert([
            'name' => 'Christian',            
        ]);
        DB::table('religions')->insert([
            'name' => 'Jain',            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
