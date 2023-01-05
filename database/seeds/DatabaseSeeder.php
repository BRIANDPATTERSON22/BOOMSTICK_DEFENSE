<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('PageTableSeeder');
        $this->call('MenuTableSeeder');
        $this->call('CountryTableSeeder');
        $this->call('OptionsTableSeeder');
    }
}
