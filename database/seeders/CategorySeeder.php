<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Konsultan Keuangan',
                'slug' => 'konsultan-keuangan',
                'description' => 'Layanan konsultasi keuangan personal dan bisnis oleh para ahli berpengalaman.',
                'icon' => '💼',
                'is_featured' => true,
            ],
            [
                'name' => 'Financial Planner',
                'slug' => 'financial-planner',
                'description' => 'Perencanaan keuangan komprehensif untuk mencapai tujuan finansial Anda.',
                'icon' => '📊',
                'is_featured' => true,
            ],
            [
                'name' => 'Investasi',
                'slug' => 'investasi',
                'description' => 'Panduan dan analisis investasi untuk mengembangkan aset Anda.',
                'icon' => '📈',
                'is_featured' => false,
            ],
            [
                'name' => 'Asuransi',
                'slug' => 'asuransi',
                'description' => 'Solusi perlindungan asuransi terbaik untuk diri dan keluarga Anda.',
                'icon' => '🛡️',
                'is_featured' => false,
            ],
            [
                'name' => 'Perpajakan',
                'slug' => 'perpajakan',
                'description' => 'Konsultasi dan optimasi pajak untuk individu dan perusahaan.',
                'icon' => '📋',
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
