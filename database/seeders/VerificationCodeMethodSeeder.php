<?php

namespace Database\Seeders;

use App\Models\VerificationCodeMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerificationCodeMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerificationCodeMethod::truncate();
        $items = [
            ['id' => 1, 'name' => 'email'],
            ['id' => 2, 'name' => 'sms'],
            ['id' => 3, 'name' => 'whatsapp'],
        ];
        foreach ($items as $item) {
            VerificationCodeMethod::updateOrCreate($item);
        }
    }
}
