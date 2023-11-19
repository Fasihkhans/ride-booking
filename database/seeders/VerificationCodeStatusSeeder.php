<?php

namespace Database\Seeders;

use App\Models\VerificationCodeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerificationCodeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerificationCodeStatus::truncate();
        $items = [
            ['id' => 1, 'name' => 'Created'],
            ['id' => 2, 'name' => 'Validated'],
            ['id' => 3, 'name' => 'Used'],
        ];
        foreach ($items as $item) {
            VerificationCodeStatus  ::updateOrCreate($item);
        }
    }
}
