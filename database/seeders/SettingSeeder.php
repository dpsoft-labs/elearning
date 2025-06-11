<?php

namespace Database\Seeders;

use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            'name' => 'dp soft',
            'domain' => 'https://example.com',
            'description' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters',
            'logo' => 'logo.png',
            'logo_black' => 'logo-black.png',
            'favicon' => 'favicon.png',
            'theme' => 'default',
            'primary_color' => '#FFAB1D',
            'timezone' => 'UTC',
            'default_language' => 'en',
            'default_currency' => 'eur',
            'maintenance' => 0,
            'multistep_register' => 0,
            'emailVerified' => 0,
            'recaptcha' => 0,
            'recaptcha_site_key' => '6LcdgoYqAAAAALmmMQxSyV4KzgGRFrTtf7esBU68',
            'recaptcha_secret' => '6LcdgoYqAAAAAErmuceR5ZG7XSGpWgnBDN_E2Oaq',
            'max_sessions' => 2,
            'session_timeout' => 2,
            'max_attempts' => 3,
            'email1' => 'info@example.com',
            'email2' => 'support@example.com',
            'phone1' => '+20123456789',
            'phone2' => '+20123456789',
            'whatsapp' => '+20123456789',
            'facebook' => 'https://facebook.com/example',
            'twitter' => 'https://x.com/example',
            'instagram' => 'https://instagram.com/example',
            'linkedin' => 'https://linkedin.com/example',
            'youtube' => 'https://youtube.com/example',
            'address' => '66 avenue des Champs, 75008, Paris, France',
            'author' => 'Adel Fawzy',
            'app_store_link' => 'https://apps.apple.com/app/id1234567890',
            'play_store_link' => 'https://play.google.com/store/apps/details?id=com.example.app',
            'email_enabled' => 0,
            'sms_enabled' => 0,
            'email' => 'support@example.com',
            'MAIL_PASSWORD' => '********',
            'MAIL_HOST' => 'mail.example.com',
            'MAIL_PORT' => '465',
            'MAIL_ENCRYPTION' => 'ssl',
            'can_any_register' => 1,
            'googleLogin' => 1,
            'facebookLogin' => 1,
            'twitterLogin' => 1,
            'GOOGLE_CLIENT_ID' => '326522251635-h38btkri1gg5kn7i40chv56s84riqi60.apps.googleusercontent.com',
            'GOOGLE_CLIENT_SECRET' => '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',
            'FACEBOOK_CLIENT_ID' => '508478304153531',
            'FACEBOOK_CLIENT_SECRET' => 'bdaefd7146784b2c272a39ff016a1d04',
            'TWITTER_CLIENT_API_KEY' => 'vPJAO8m4gYyycVvrOtSILFQrr',
            'TWITTER_CLIENT_API_SECRET_KEY' => 'n5RoZez3iX16XzVVcl6gmWxJqiP5RgfJMPeUeYcVcwpvnO75fr',
            'headerCode' => null,
            'footerCode' => null,
            'allow_cookies' => 0,
            'google_analytics' => null,
            'admission_status' => 1,
            'registration_status' => 1,
            'registration_start_date' => '2025-01-01',
            'registration_end_date' => '2025-12-31',
            'when_enable_content' => 'after_registration', // after_paid, after_registration
            'hour_price' => 250,
            'min_hours' => 9,
            'max_hours' => 18,
            'gpa_4' => 90,
            'gpa_3_6' => 85,
            'gpa_3_2' => 80,
            'gpa_3_0' => 75,
            'gpa_2_7' => 70,
            'gpa_2_5' => 65,
            'gpa_2_2' => 60,
            'gpa_2_0' => 50,
        ];

        foreach ($options as $option => $value) {
            Setting::firstOrCreate(['option' => $option], ['value' => $value]);
        }
    }
}
