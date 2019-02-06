<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotherTongueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('mother_tongues')->truncate();
        DB::table('mother_tongues')->insert([
            'name' => 'Malayalam',            
        ]);
        DB::table('mother_tongues')->insert([
            'name' => 'English',            
        ]);
        DB::table('mother_tongues')->insert([
            'name' => 'Tamil',            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
