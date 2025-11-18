<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Contact Information
            ['key' => 'contact_phone', 'value' => '+94 81 222 3333', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_landline', 'value' => '081-222-3333', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_fax', 'value' => '081-222-3334', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'info@kandyscouts.lk', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Scout Association, Kandy District, Sri Lanka', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'contact_map_embed', 'value' => '', 'type' => 'textarea', 'group' => 'contact'],

            // Branding
            ['key' => 'logo_light', 'value' => '', 'type' => 'image', 'group' => 'branding'],
            ['key' => 'logo_dark', 'value' => '', 'type' => 'image', 'group' => 'branding'],
            ['key' => 'favicon', 'value' => '', 'type' => 'image', 'group' => 'branding'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/kandyscouts', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@kandyscouts', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => '', 'type' => 'text', 'group' => 'social'],

            // Directors/Commissioner
            ['key' => 'commissioner_image', 'value' => '', 'type' => 'image', 'group' => 'directors'],
            ['key' => 'commissioner_name', 'value' => 'District Commissioner Name', 'type' => 'text', 'group' => 'directors'],
            ['key' => 'commissioner_message', 'value' => 'Welcome to Kandy District Scout Branch...', 'type' => 'textarea', 'group' => 'directors'],

            // Home Banner
            ['key' => 'banner_title', 'value' => 'Welcome to Kandy District Scout Branch', 'type' => 'text', 'group' => 'home_banner'],
            ['key' => 'banner_subtitle', 'value' => 'Building Character, Leadership, and Community', 'type' => 'text', 'group' => 'home_banner'],
            ['key' => 'banner_cta_text', 'value' => 'Learn More', 'type' => 'text', 'group' => 'home_banner'],
            ['key' => 'banner_cta_link', 'value' => '/about', 'type' => 'text', 'group' => 'home_banner'],
            ['key' => 'banner_background_image', 'value' => '', 'type' => 'image', 'group' => 'home_banner'],

            // SEO
            ['key' => 'default_og_image', 'value' => '', 'type' => 'image', 'group' => 'seo'],
            ['key' => 'site_title_suffix', 'value' => ' | Kandy District Scout Branch', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'group' => $setting['group'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
