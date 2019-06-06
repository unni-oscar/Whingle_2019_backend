<?php

use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('coupons')->truncate();
        DB::table('coupons')->insert([
            'name' => 'Launch Offer 2020',            
            'code' => 'LAUNCH',
            'desc' => 'Website launch offer to all customers',
            'start_date' => '2019-06-01',
            'end_date' => '2019-08-01',
            'discount' => 50
        ]);
       
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
