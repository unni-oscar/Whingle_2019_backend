<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(MotherTongueTableSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(ReligionTableSeeder::class);
        $this->call(CasteTableSeeder::class);
        $this->call(WorksTableSeeder::class);
    }
}
