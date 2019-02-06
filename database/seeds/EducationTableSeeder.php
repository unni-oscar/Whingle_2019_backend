<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('education')->truncate();
        DB::table('education')->insert([
            'name' => 'Bsc Computer Science',            
        ]);
        DB::table('education')->insert([
            'name' => 'BCom',            
        ]);
        DB::table('education')->insert([
            'name' => 'Msc',            
        ]);
        DB::table('education')->insert([
            'name' => 'Doctorate',            
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
