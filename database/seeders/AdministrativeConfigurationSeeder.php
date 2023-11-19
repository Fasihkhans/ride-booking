<?php

namespace Database\Seeders;

use App\Models\AdministrativeConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministrativeConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdministrativeConfiguration::truncate();
        $items = [
            ['id' => 1, 'config_key' => 'require_email_verification', 'config_value' => '1', 'description' => 'Require Email verification'],
            ['id' => 2, 'config_key' => 'send_verification_code_on_signup', 'config_value' => '1', 'description' => 'Automatically send verification code on email on user signup'],
            ['id' => 3, 'config_key' => 'allow_multi_device_login', 'config_value' => '0', 'description' => 'Allow user to sign into multiple devices at the same time'],
            ['id' => 4, 'config_key' => 'allow_multi_device_login_admin', 'config_value' => '1', 'description' => 'Allow admin to sign into multiple devices at the same time'],
            ['id' => 5, 'config_key' => 'use_presigned_urls', 'config_value' => '1', 'description' => 'Use temporary urls to access media in s3 bucket instead of permanent links'],
            ['id' => 6, 'config_key' => 'presigned_expiry', 'config_value' => '86400', 'description' => 'Default time (24 hours) before presigned URLs expiration'],
            ['id' => 7, 'config_key' => 'resource_collection_default_limit', 'config_value' => '10', 'description' => 'Default limit (10) for paginating resource collections'],
        ];
        foreach ($items as $item) {
            AdministrativeConfiguration::updateOrCreate($item);
        }
    }
}
