<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        $settings = [
            ['key' => 'version', 'value' => config('artisan.version', '1.0.0')],
            ['key' => 'app_name', 'value' => 'AIRobo: The Ultimate AI-Powered Marketing & SEO Tool'],
            ['key' => 'app_url', 'value' => 'https://localhost'],
            ['key' => 'website_email', 'value' => 'contact@example.com'],
            ['key' => 'website_contact_number', 'value' => '9876654321'],
            ['key' => 'admin_prefix', 'value' => 'admin'],
            ['key' => 'website_logo', 'value' => 'themes/neuralink/images/logo.svg'],
            ['key' => 'website_logo_dark', 'value' => 'themes/neuralink/images/logo-light.svg'],
            ['key' => 'website_login_logo', 'value' => 'themes/neuralink/images/logo.svg'],
            ['key' => 'favicon', 'value' => 'themes/neuralink/images/favicon.png'],
            ['key' => 'auth_pages_image', 'value' => 'themes/neuralink/images/auth-bg.jpg'],
            ['key' => 'FB_ID', 'value' => '3056246081082951'],
            ['key' => 'FB_SECRET', 'value' => ''],
            ['key' => 'FB_REDIRECT', 'value' => ''],
            ['key' => 'datetime_format', 'value' => 'F d, Y h:i a'],
            ['key' => 'date_format', 'value' => 'm-d-Y'],
            ['key' => 'joined_date_format', 'value' => 'm-d-Y'],
            ['key' => 'cooldown_expires_hours', 'value' => '10'],
            ['key' => 'public_user_role', 'value' => '2'],
            ['key' => 'default_user_image', 'value' => '/storage/defaults/avatar.jpg'],
            ['key' => 'user_restore_key', 'value' => Str::random(32)], //regenerate
            ['key' => 'restore_user_enc_type', 'value' => 'AES-256-ECB'],
            ['key' => 'activation_required', 'value' => '1'],
            ['key' => 'activation_time_period', 'value' => '24'],
            ['key' => 'activation_max_attempts', 'value' => '5'],
            ['key' => 'recaptcha_status', 'value' => '0'],
            ['key' => 'recaptcha_site', 'value' => ''],
            ['key' => 'recaptcha_secret', 'value' => ''],
            ['key' => 'terms_link', 'value' => 'privacy-policy'],
            ['key' => 'privacy_link', 'value' => 'privacy-policy'],
            ['key' => 'meta_title', 'value' => 'AIRobo: The Ultimate AI-Powered Marketing & SEO Tool'],
            ['key' => 'meta_description', 'value' => 'Transform your online presence with AIRobo - the AI-powered solution for SEO, content writing, branding & more. Boost your marketing efforts today!'],
            ['key' => 'default_locale', 'value' => 'en'],
            ['key' => 'debug', 'value' => '1'],
            ['key' => 'maintenance_mode', 'value' => '0'],
            ['key' => 'maintenance_note', 'value' => 'Briefly unavailable for scheduled maintenance. Check back in a minute.'],
            ['key' => 'maintenance_token', 'value' => (string) Str::uuid()],
            ['key' => 'recaptcha_login', 'value' => '1'],
            ['key' => 'recaptcha_signup', 'value' => '1'],
            ['key' => 'recaptcha_contact', 'value' => '0'],
            ['key' => 'mail_use_smtp', 'value' => 'mail'],
            ['key' => 'mail_from_name', 'value' => 'AIRobo'],
            ['key' => 'mail_from_address', 'value' => 'no-reply@AIRobo.com'],
            ['key' => 'mail_smtp_host', 'value' => 'smtp.mailtrap.io'],
            ['key' => 'mail_smtp_port', 'value' => '587'],
            ['key' => 'mail_smtp_encryption', 'value' => 'tls'],
            ['key' => 'mail_smtp_username', 'value' => ''],
            ['key' => 'mail_smtp_password', 'value' => ''],
            ['key' => 'header_code', 'value' => ''],
            ['key' => 'footer_code', 'value' => ''],
            ['key' => '_footer_copyright', 'value' => '© 2023 DotArtisan, LLC. All rights reserved. <span class="float-end">Powered By: <a href="https://dotartisan.com">DotArtisan, LLC</span></a>'],
            ['key' => 'enable_header_code', 'value' => '0'],
            ['key' => 'enable_footer_code', 'value' => '0'],
            ['key' => 'purchase_code', 'value' => ''],
            ['key' => 'recaptcha_on_admin_login', 'value' => '0'],
            ['key' => 'google_analytics_id', 'value' => ''],
            ['key' => 'google_webmaster', 'value' => ''],
            ['key' => 'yandex_webmaster', 'value' => ''],
            ['key' => 'bing_webmaster', 'value' => ''],
            ['key' => 'alexa_webmaster', 'value' => ''],
            ['key' => 'pinterest_webmaster', 'value' => ''],
            ['key' => 'footer_widgets', 'value' => '1'],
            ['key' => 'footer_widget_columns', 'value' => '4'],
            ['key' => 'footer_copyright_bar', 'value' => '1'],
            ['key' => 'footer_center_copyright', 'value' => '1'],
            ['key' => '_main_menu', 'value' => 'Main Menu'], //
            ['key' => '_document_menu', 'value' => ''],
            ['key' => 'admin_pagination', 'value' => '10'],
            ['key' => 'front_pagination', 'value' => '10'],
            ['key' => 'maintenance_allowed_ips', 'value' => '127.0.0.1'],
            ['key' => 'SYSTEM_TIMEZONE', 'value' => ''],
            ['key' => 'FILESYSTEM_DRIVER', 'value' => 'public'],
            ['key' => 'WAS_ACCESS_KEY_ID', 'value' => ''],
            ['key' => 'WAS_SECRET_ACCESS_KEY', 'value' => ''],
            ['key' => 'WAS_DEFAULT_REGION', 'value' => ''],
            ['key' => 'WAS_BUCKET', 'value' => ''],
            ['key' => 'AWS_ACCESS_KEY_ID', 'value' => ''],
            ['key' => 'AWS_SECRET_ACCESS_KEY', 'value' => ''],
            ['key' => 'AWS_DEFAULT_REGION', 'value' => ''],
            ['key' => 'AWS_BUCKET', 'value' => ''],
            ['key' => 'GOOGLE_ID', 'value' => ''],
            ['key' => 'GOOGLE_SECRET', 'value' => ''],
            ['key' => 'GOOGLE_REDIRECT', 'value' => 'http://localhost/social/google/callback'],
            ['key' => 'STRIPE_KEY', 'value' => ''],
            ['key' => 'STRIPE_SECRET', 'value' => ''],
            ['key' => 'PAYPAL_MODE', 'value' => 'sandbox'],
            ['key' => 'PAYPAL_SANDBOX_CLIENT_ID', 'value' => ''],
            ['key' => 'PAYPAL_SANDBOX_CLIENT_SECRET', 'value' => ''],
            ['key' => 'PAYPAL_LIVE_CLIENT_ID', 'value' => ''],
            ['key' => 'PAYPAL_LIVE_CLIENT_SECRET', 'value' => ''],
            ['key' => 'PAYPAL_LIVE_APP_ID', 'value' => ''],
            ['key' => 'PAYPAL_SANDBOX_CLIENT_SECRET', 'value' => ''],
            ['key' => 'PAYPAL_VALIDATE_SSL', 'value' => 'true'],
            ['key' => 'currency', 'value' => 'USD'],
            ['key' => 'google_webmaster', 'value' => ''],
            ['key' => 'yandex_webmaster', 'value' => ''],
            ['key' => 'bing_webmaster', 'value' => ''],
            ['key' => 'pinterest_webmaster', 'value' => ''],
            ['key' => 'alexa_webmaster', 'value' => ''],
            ['key' => 'google_analytics_id', 'value' => ''],
            ['key' => 'restore_user_cutoff', 'value' => '30'],
            ['key' => 'PAYPAL_ALLOW', 'value' => '0'],
            ['key' => 'STRIPE_ALLOW', 'value' => '0'],
            ['key' => 'page_views', 'value' => '0'],
            ['key' => 'tags_views', 'value' => '0'],
            ['key' => 'post_views', 'value' => '0'],
            ['key' => 'SUPER_ADMIN_ROLE', 'value' => '1'],
            ['key' => 'cookies_consent', 'value' => '1'],
            ['key' => 'append_sitename', 'value' => '1'],
            ['key' => 'social_links_facebook', 'value' => 'https://www.facebook.com/dotartisan'],
            ['key' => 'social_links_twitter', 'value' => 'https://twitter.com/dotartisan'],
            ['key' => 'social_links_linkedin', 'value' => 'https://www.linkedin.com/company/dotartisan/'],
            ['key' => 'social_links_youtube', 'value' => 'https://studio.youtube.com/channel/UCQC_AwtG_n9MW0-hRlzQZRQ/'],
            ['key' => 'footer_widgets', 'value' => '0'],
        ];

        foreach ($settings as $settingData) {
            DB::table('settings')->insertGetId($settingData);
        }
    }
}
