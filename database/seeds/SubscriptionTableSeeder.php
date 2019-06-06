<?php

use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subscriptions')->truncate();
        DB::table('subscriptions')->insert([
            'name' => 'Bronze',            
            'no_of_months' => 3
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Silver',            
            'no_of_months' => 6
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Gold',            
            'no_of_months' => 9
        ]);
        DB::table('subscriptions')->insert([
            'name' => 'Platinum',            
            'no_of_months' => 12
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
