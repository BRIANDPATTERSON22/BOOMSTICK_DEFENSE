<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->delete();
        $menus = array(
            array(
                'type'      => 'header',
                'title'      => 'About us',
                'url'      => 'about-us',
                'status'      => 1,
                'order'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'type'      => 'header',
                'title'      => 'Events',
                'url'      => 'events',
                'status'      => 1,
                'order'      => 3,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'type'      => 'header',
                'title'      => 'Contact us',
                'url'      => 'contact-us',
                'status'      => 1,
                'order'      => 4,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );
        DB::table('menus')->insert( $menus );
    }
}