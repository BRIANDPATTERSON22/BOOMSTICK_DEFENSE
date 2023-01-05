<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themeSettingsData = '
        {
            "section_one_title": "null",
            "section_six_title": null,
        }';
        
        DB::table('options')->delete();
        $options = array(
            array(
                'name'                  => 'Innovay laravel CMS',
                'title'                 => 'Innovay laravel CMS',
                'description'           => 'What’s a world without creativity? At Innovay, we nurture the creativity of our team through active imagination and inspiration. Our solutions are achieved in that creative spirit.',
                'keywords'              => 'Creativity, Development, Analysis',
                'phone_no'              => '+94 21 221 7095',
                'mobile_no'             => NULL,
                'email'                 => 'info@domain.com',
                'address'               => '#237, Vauxhall Street, Colombo 02, Sri Lanka.',
                'branch'                => '#55, College Road, Neeraviyadi, Jaffna.',
                'latitude'              => '6.923390',
                'longitude'             => '79.853677',
                'favicon'               =>  NULL,
                'logo'                  =>  NULL,
                'logo_white'            =>  NULL,
                'logo_black'            =>  NULL,
                'bg_breadcrumb'         =>  NULL,
                'facebook'              => 'https://www.facebook.com/innovay',
                'youtube'               => 'https://www.youtube.com/innovay',
                'twitter'               => 'https://twitter.com/innovay',
                'pinterest'             => NULL,
                'instagram'             => NULL,
                'company_name'          => 'innovay Pvt Ltd.',
                'company_website'       => 'http://www.innovay.com/',
                'currency_code'         => 'LKR',
                'currency_symbol'       => 'Rs.',
                'theme_settings'        => $themeSettingsData,
                'status'                => 1,
                'created_at'            => new DateTime,
                'updated_at'            => new DateTime,
            )
        );
        DB::table('options')->insert( $options );

        Cache::forever('optionsCache', \App\Option::first());
    }
}
