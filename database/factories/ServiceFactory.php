<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->randomElement([
            'Konsultasi Rencana Keuangan Pribadi',
            'Perencanaan Dana Pensiun',
            'Analisis Portofolio Investasi',
            'Konsultasi Pajak Tahunan',
            'Manajemen Aset Komprehensif',
            'Perencanaan Warisan & Estate',
            'Konsultasi Asuransi Jiwa',
            'Perencanaan Dana Pendidikan Anak',
            'Analisis Risiko Investasi',
            'Konsultasi Bisnis & UMKM',
            'Perencanaan Keuangan Keluarga',
            'Optimasi Pajak Perusahaan',
            'Konsultasi Reksa Dana',
            'Perencanaan Dana Darurat',
            'Review Portofolio Bulanan',
        ]);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'short_description' => $this->faker->sentence(15),
            'price' => $this->faker->randomElement([500000, 750000, 1000000, 1500000, 2000000, 2500000, 3000000, 5000000]),
            'image' => null,
            'is_featured' => false,
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
