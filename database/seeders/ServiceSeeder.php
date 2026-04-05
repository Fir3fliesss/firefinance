<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $konsultan = Category::where('slug', 'konsultan-keuangan')->first();
        $planner = Category::where('slug', 'financial-planner')->first();
        $investasi = Category::where('slug', 'investasi')->first();
        $asuransi = Category::where('slug', 'asuransi')->first();
        $pajak = Category::where('slug', 'perpajakan')->first();

        $services = [
            // Konsultan Keuangan (Featured)
            [
                'category_id' => $konsultan?->id,
                'title' => 'Konsultasi Keuangan Pribadi Premium',
                'slug' => 'konsultasi-keuangan-pribadi-premium',
                'short_description' => 'Sesi konsultasi 1-on-1 selama 2 jam bersama konsultan keuangan senior kami.',
                'description' => "Dapatkan analisis mendalam tentang kondisi keuangan Anda saat ini dan rekomendasi strategis dari konsultan berpengalaman kami.\n\nLayanan ini mencakup:\n- Analisis cash flow bulanan\n- Evaluasi utang dan aset\n- Rekomendasi alokasi anggaran\n- Rencana tindakan 90 hari\n- Laporan tertulis komprehensif",
                'price' => 1500000,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $konsultan?->id,
                'title' => 'Konsultasi Bisnis & UMKM',
                'slug' => 'konsultasi-bisnis-umkm',
                'short_description' => 'Solusi keuangan komprehensif untuk pelaku usaha kecil dan menengah.',
                'description' => "Layanan konsultasi khusus untuk pemilik bisnis UMKM yang ingin mengoptimalkan keuangan usahanya.\n\nMencakup:\n- Analisis laporan keuangan bisnis\n- Strategi pengelolaan modal kerja\n- Perencanaan ekspansi bisnis\n- Konsultasi pembiayaan usaha",
                'price' => 2000000,
                'is_featured' => true,
                'is_active' => true,
            ],
            // Financial Planner (Featured)
            [
                'category_id' => $planner?->id,
                'title' => 'Perencanaan Keuangan Komprehensif',
                'slug' => 'perencanaan-keuangan-komprehensif',
                'short_description' => 'Rencana keuangan holistik untuk mewujudkan seluruh tujuan finansial Anda.',
                'description' => "Program perencanaan keuangan menyeluruh yang dirancang untuk membantu Anda mencapai kebebasan finansial.\n\nMeliputi:\n- Goal setting & prioritas finansial\n- Perencanaan investasi jangka pendek & panjang\n- Strategi pensiun\n- Perencanaan dana darurat\n- Review berkala setiap 3 bulan",
                'price' => 3000000,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $planner?->id,
                'title' => 'Perencanaan Dana Pendidikan Anak',
                'slug' => 'perencanaan-dana-pendidikan-anak',
                'short_description' => 'Siapkan masa depan cerah buah hati Anda dengan perencanaan dana pendidikan yang tepat.',
                'description' => "Investasikan sejak dini untuk pendidikan anak Anda. Kami membantu merencanakan strategi tabungan dan investasi terbaik.\n\nIncluding:\n- Proyeksi biaya pendidikan\n- Rekomendasi instrumen investasi\n- Simulasi pertumbuhan dana\n- Milestone review tahunan",
                'price' => 1000000,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'category_id' => $planner?->id,
                'title' => 'Perencanaan Dana Pensiun',
                'slug' => 'perencanaan-dana-pensiun',
                'short_description' => 'Rencanakan pensiun nyaman Anda mulai hari ini.',
                'description' => "Wujudkan masa pensiun yang tenang dan sejahtera dengan strategi perencanaan yang matang.\n\nMeliputi:\n- Kalkulasi kebutuhan dana pensiun\n- Strategi akumulasi aset\n- Diversifikasi portofolio pensiun\n- Rencana penarikan dana yang optimal",
                'price' => 1500000,
                'is_featured' => false,
                'is_active' => true,
            ],
            // Investasi
            [
                'category_id' => $investasi?->id,
                'title' => 'Analisis Portofolio Investasi',
                'slug' => 'analisis-portofolio-investasi',
                'short_description' => 'Evaluasi menyeluruh portofolio investasi Anda untuk hasil yang optimal.',
                'description' => "Dapatkan analisis profesional tentang portofolio investasi Anda saat ini dan rekomendasi optimasi.\n\nMeliputi:\n- Review semua instrumen investasi\n- Analisis risk & return\n- Rekomendasi rebalancing\n- Strategi diversifikasi",
                'price' => 750000,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $investasi?->id,
                'title' => 'Konsultasi Reksa Dana',
                'slug' => 'konsultasi-reksa-dana',
                'short_description' => 'Panduan lengkap memilih reksa dana yang sesuai profil risiko Anda.',
                'description' => "Mulai investasi reksa dana dengan tepat bersama panduan dari ahli kami.\n\nMencakup:\n- Asesmen profil risiko\n- Rekomendasi reksa dana terpilih\n- Strategi Dollar Cost Averaging\n- Pemantauan berkala",
                'price' => 500000,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $investasi?->id,
                'title' => 'Review Portofolio Bulanan',
                'slug' => 'review-portofolio-bulanan',
                'short_description' => 'Pemantauan dan penyesuaian portofolio investasi setiap bulan.',
                'description' => "Layanan monitoring investasi bulanan untuk memastikan portofolio Anda tetap on-track.\n\nIncluding:\n- Laporan kinerja bulanan\n- Analisis pasar terkini\n- Rekomendasi penyesuaian\n- Konsultasi via WA",
                'price' => 500000,
                'is_featured' => false,
                'is_active' => true,
            ],
            // Asuransi
            [
                'category_id' => $asuransi?->id,
                'title' => 'Konsultasi Asuransi Jiwa & Kesehatan',
                'slug' => 'konsultasi-asuransi-jiwa-kesehatan',
                'short_description' => 'Temukan proteksi asuransi yang tepat untuk diri dan keluarga Anda.',
                'description' => "Melindungi yang Anda cintai dimulai dari perencanaan asuransi yang tepat.\n\nMeliputi:\n- Asesmen kebutuhan proteksi\n- Perbandingan produk asuransi\n- Rekomendasi manfaat optimal\n- Konsultasi klaim",
                'price' => 500000,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $asuransi?->id,
                'title' => 'Perencanaan Warisan & Estate Planning',
                'slug' => 'perencanaan-warisan-estate-planning',
                'short_description' => 'Pastikan warisan Anda terkelola dengan bijak dan sesuai keinginan.',
                'description' => "Rencanakan pewarisan aset dengan benar untuk melindungi keluarga Anda di masa depan.\n\nMencakup:\n- Inventarisasi aset & liabilitas\n- Perencanaan distribusi warisan\n- Konsultasi aspek hukum\n- Rekomendasi instrumen trust",
                'price' => 2500000,
                'is_featured' => false,
                'is_active' => true,
            ],
            // Perpajakan
            [
                'category_id' => $pajak?->id,
                'title' => 'Konsultasi Pajak Tahunan Pribadi',
                'slug' => 'konsultasi-pajak-tahunan-pribadi',
                'short_description' => 'Optimasi laporan pajak tahunan Anda secara legal dan efisien.',
                'description' => "Pastikan kewajiban pajak Anda terpenuhi dengan optimal dan efisien bersama ahli pajak kami.\n\nMeliputi:\n- Review SPT Tahunan\n- Optimasi pengurangan pajak\n- Pelaporan LKPM\n- Konsultasi perencanaan pajak",
                'price' => 750000,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'category_id' => $pajak?->id,
                'title' => 'Optimasi Pajak Perusahaan',
                'slug' => 'optimasi-pajak-perusahaan',
                'short_description' => 'Strategi perpajakan yang legal dan efektif untuk bisnis Anda.',
                'description' => "Minimalkan beban pajak perusahaan secara legal dengan strategi perpajakan yang cerdas.\n\nMeliputi:\n- Audit pajak internal\n- Perencanaan perpajakan proaktif\n- Kepatuhan pajak bulanan\n- Konsultasi transfer pricing",
                'price' => 5000000,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
