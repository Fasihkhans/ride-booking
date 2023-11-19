<?php

namespace Database\Seeders;

use App\Models\OAuthServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OAuthServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OAuthServiceProvider::truncate();
        $items = [
            ['id' => 1, 'name' => 'google'],
            ['id' => 2, 'name' => 'apple'],
            ['id' => 3, 'name' => 'facebook']
        ];
        foreach ($items as $item) {
            OAuthServiceProvider::updateOrCreate($item);
        }
    }
}
