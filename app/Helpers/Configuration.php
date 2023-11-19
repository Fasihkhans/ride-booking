<?php

namespace App\Helpers;

use App\Models\AdministrativeConfiguration;
use App\Models\OAuthServiceProvider;
use App\Models\Role;
use App\Models\VerificationCodePurpose;

class Configuration
{
    public static function Get(string $key)
    {
        return AdministrativeConfiguration::where('config_key', $key)->first()->config_value;
    }

    public static function UserRole(string $name)
    {
        return Role::where('name', $name)->first()->id;
    }

    public static function VerificationPurpose(string $name)
    {
        return VerificationCodePurpose::where('name', $name)->first()->id;
    }


    public static function OAuthServiceProvider(string $name)
    {
        return OAuthServiceProvider::where('name', $name)->first()->id;
    }


    public static function VerificationPurposes(bool $csvString)
    {
        $names = VerificationCodePurpose::pluck('name')->all();
        if (!$csvString)
            return $names;
        return Helper::formatArrayToString($names);
    }
    public static function MediaCategory(string $name)
    {
        $name = str_replace('-', ' ', $name);

        if($name == 'DivineMusic')
            $name = 'Divine Music';
        if($name == 'Break & Groove')
            $name  = 'Break and Groove';
        $cat = MediaCategory::where('name', $name)->first();
        if ($cat)
            return $cat->id;
        return null;
    }
    
    public static function OAuthServiceProviders(bool $csvString)
    {
        $names = OAuthServiceProvider::pluck('name')->all();
        if (!$csvString)
            return $names;
        return Helper::formatArrayToString($names);
    }
}
