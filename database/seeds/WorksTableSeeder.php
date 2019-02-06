<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('works')->truncate();
        DB::table('works')->insert([
            'name' => 'Manager',            
        ]);
        DB::table('works')->insert([
            'name' => 'CEO',            
        ]);
        DB::table('works')->insert([
            'name' => 'Cutomer Care',            
        ]);
        DB::table('works')->insert([
            'name' => 'Doctor',            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
