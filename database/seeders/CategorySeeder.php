<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::firstOrCreate(
            ['slug' => 'teknologi'],
            ['name' => 'Teknologi', 'color' => '#3B82F6']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'gaming'],
            ['name' => 'Gaming', 'color' => '#8B5CF6']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'tips-belajar'],
            ['name' => 'Tips Belajar', 'color' => '#10B981']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'opini'],
            ['name' => 'Opini', 'color' => '#F59E0B']
        );

        \App\Models\Category::firstOrCreate(
            ['slug' => 'kehidupan'],
            ['name' => 'Kehidupan', 'color' => '#EF4444']
        );
    }
}
