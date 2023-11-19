<?php

namespace Database\Seeders;

use App\Models\VerificationCodePurpose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerificationCodePurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerificationCodePurpose::truncate();
        $items = [
            ['id' => 1, 'name' => 'Account Verification', 'queue' => '1'],
            ['id' => 2, 'name' => 'Account Recovery', 'queue' => '1']
        ];
        foreach ($items as $item) {
            VerificationCodePurpose::updateOrCreate($item);
        }
    }
}
