<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->delete();
        $pages = array(
            array(
                'title'      => 'Contact us',
                'summary'      => 'Drop us your message here and we will knock your doors back soon',
                'slug'      => 'contact-us',
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'About us',
                'summary'      => 'What’s a world without creativity? At Innovay, we nurture the creativity of our team through active imagination and inspiration. Our solutions are achieved in that creative spirit.',
                'slug'      => 'about-us',
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Events',
                'summary'      => 'What’s a world without creativity? At Innovay, we nurture the creativity of our team through active imagination and inspiration. Our solutions are achieved in that creative spirit.',
                'slug'      => 'events',
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Photos',
                'summary'      => 'What’s a world without creativity? At Innovay, we nurture the creativity of our team through active imagination and inspiration. Our solutions are achieved in that creative spirit.',
                'slug'      => 'photos',
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Videos',
                'summary'      => 'What’s a world without creativity? At Innovay, we nurture the creativity of our team through active imagination and inspiration. Our solutions are achieved in that creative spirit.',
                'slug'      => 'videos',
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Help & FAQs',
                'summary'      => 'Content Goes Here',
                'slug'      => str_slug('Help & FAQs'),
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Terms Of Service',
                'summary'      => 'Terms Of Service Content Goes Here',
                'slug'      => str_slug('Terms Of Service'),
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Privacy Policy',
                'summary'      => 'Some websites also define their privacy policies using P3P or Internet Content Rating Association (ICRA)',
                'slug'      => str_slug('Privacy Policy'),
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Return Policy',
                'summary'      => 'Return Policy Content Goes Here',
                'slug'      => str_slug('Return Policy'),
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Customer Rebate Center',
                'summary'      => 'Customer Rebate Center Content Goes Here',
                'slug'      => str_slug('Customer Rebate Center'),
                'status'      => 1,
                'user_id'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
        );
        DB::table('pages')->insert( $pages );
    }
}