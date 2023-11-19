<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove foreign key constraint
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            ['id' => '1', 'name' => 'admin', 'guard_name' => 'api'],
            ['id' => '2', 'name' => 'user', 'guard_name' => 'api'],
            ['id' => '3', 'name' => 'driver', 'guard_name' => 'api'],
        ];

        foreach ($items as $item) {
            Role::updateOrCreate($item);
        }
    }
}
