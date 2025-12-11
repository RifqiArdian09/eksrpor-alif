<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HeroSection;
use App\Models\Highlight;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        AboutSection::truncate();
        HeroSection::truncate();
        Highlight::truncate();
        Service::truncate();
        Product::truncate();
        Partner::truncate();
        Faq::truncate();
        GalleryItem::truncate();
        Testimonial::truncate();
        Setting::whereIn('key', [
            'company.phone',
            'company.email',
            'company.address',
            'company.office_hours',
            'company.socials',
        ])->delete();

        AboutSection::create([
            'vision' => 'Menjadi mitra ekspor terkemuka yang membuka akses pasar global bagi UMKM Indonesia.',
            'mission' => 'Mendampingi pelaku usaha lokal menembus pasar internasional melalui solusi end-to-end ekspor.',
            'content' => <<<'MARKDOWN'
## Kenapa Kami Ada?

Kami berfokus membantu brand lokal memahami regulasi ekspor, mempersiapkan dokumen, hingga memastikan produk sampai ke tangan buyer tepat waktu.
MARKDOWN,
            'image_path' => 'images/about/warehouse-team.jpg',
        ]);

        HeroSection::create([
            'tagline' => 'One Stop Export Solution',
            'title' => 'Membuka Peluang Ekspor Tanpa Ribet',
            'description' => 'Kami bantu urus lisensi, dokumen, shipping, hingga pemasaran internasional sehingga Anda bisa fokus mengembangkan produk.',
            'media_path' => 'videos/hero/port-operations.mp4',
        ]);

        collect([
            [
                'title' => 'Tim Konsultan Ekspor Berpengalaman',
                'description' => 'Didukung praktisi ekspor dengan jaringan buyer di Asia, Timur Tengah, dan Eropa.',
            ],
            [
                'title' => 'Dokumen & Legalitas Terjamin',
                'description' => 'Pendampingan penyusunan HS Code, COO, dan compliance negara tujuan.',
            ],
            [
                'title' => 'Optimasi Strategi Go-To-Market',
                'description' => 'Riset pasar, pricing, dan campaign digital untuk meningkatkan peluang closing.',
            ],
        ])->each(fn (array $highlight) => Highlight::create($highlight));

        collect([
            [
                'title' => 'Konsultasi & Audit Export Readiness',
                'description' => 'Analisis kesiapan produk, penyesuaian regulasi, dan roadmap ekspor.',
            ],
            [
                'title' => 'Manajemen Dokumen & Legalitas',
                'description' => 'Pengurusan perizinan BPOM, Halal, COO, hingga sertifikasi negara tujuan.',
            ],
            [
                'title' => 'End-to-End Freight Forwarding',
                'description' => 'Pengiriman multimoda, asuransi kargo, dan tracking real-time.',
            ],
        ])->each(fn (array $service) => Service::create($service));

        collect([
            [
                'title' => 'Program Export Starter',
                'description' => 'Paket pendampingan 3 bulan untuk UMKM yang baru masuk pasar ekspor.',
                'thumbnail_path' => 'images/products/export-starter.jpg',
            ],
            [
                'title' => 'Export Acceleration Plan',
                'description' => 'Strategi pemasaran dan penjualan lintas negara untuk brand yang siap scale-up.',
                'thumbnail_path' => 'images/products/export-acceleration.jpg',
            ],
            [
                'title' => 'Global Distribution Network',
                'description' => 'Akses ke jaringan distributor dan buyer potensial di 12 negara.',
                'thumbnail_path' => 'images/products/global-distribution.jpg',
            ],
        ])->each(fn (array $product) => Product::create($product));

        collect([
            [
                'name' => 'Garuda Logistics',
                'logo_path' => 'images/partners/garuda-logistics.png',
            ],
            [
                'name' => 'Nusantara Bank',
                'logo_path' => 'images/partners/nusantara-bank.png',
            ],
            [
                'name' => 'Asia Trade Hub',
                'logo_path' => 'images/partners/asia-trade-hub.png',
            ],
            [
                'name' => 'Global Warehouse Alliance',
                'logo_path' => 'images/partners/global-warehouse.png',
            ],
        ])->each(fn (array $partner) => Partner::create($partner));

        collect([
            [
                'question' => 'Produk seperti apa yang bisa kami bantu ekspor?',
                'answer' => 'Kami fokus pada produk FMCG, agrikultur olahan, fesyen, dan kerajinan yang sudah memiliki standar kualitas ekspor.',
            ],
            [
                'question' => 'Berapa lama proses persiapan ekspor pertama?',
                'answer' => 'Rata-rata 6-12 minggu tergantung kelengkapan dokumen dan regulasi negara tujuan.',
            ],
            [
                'question' => 'Apakah tersedia layanan pendanaan PO?',
                'answer' => 'Kami bekerja sama dengan lembaga keuangan untuk skema pembiayaan PO ekspor hingga 70% dari invoice.',
            ],
        ])->each(fn (array $faq) => Faq::create($faq));

        collect([
            [
                'title' => 'Pengiriman Perdana ke Dubai',
                'description' => 'Ekspor batch pertama produk makanan olahan ke supermarket Timur Tengah.',
                'image_path' => 'images/gallery/dubai-export.jpg',
                'activity_date' => now()->subMonths(2),
                'slug' => 'pengiriman-perdana-ke-dubai',
                'images' => [
                    'images/gallery/dubai-export-1.jpg',
                    'images/gallery/dubai-export-2.jpg',
                ],
            ],
            [
                'title' => 'Business Matching Singapura',
                'description' => 'Mempertemukan 25 UMKM dengan buyer ritel premium di Singapura.',
                'image_path' => 'images/gallery/business-matching.jpg',
                'activity_date' => now()->subMonth(),
                'slug' => 'business-matching-singapura',
                'images' => [
                    'images/gallery/business-matching-1.jpg',
                    'images/gallery/business-matching-2.jpg',
                ],
            ],
        ])->each(fn (array $item) => GalleryItem::create($item));

        collect([
            [
                'name' => 'Rani Wijaya',
                'exported_item' => 'Produk perawatan tubuh organik',
                'body' => 'Tim sangat responsif, kami berhasil menembus pasar Jepang hanya dalam 4 bulan setelah program Export Starter.',
                'photo_path' => 'images/testimonials/rani-wijaya.jpg',
            ],
            [
                'name' => 'Abdul Rahman',
                'exported_item' => 'Kopi spesialti arabika',
                'body' => 'Dukungan dokumen dan jaringan buyer membuat order kontainer pertama kami ke Qatar berjalan mulus.',
                'photo_path' => 'images/testimonials/abdul-rahman.jpg',
            ],
        ])->each(fn (array $testimonial) => Testimonial::create($testimonial));

        collect([
            [
                'key' => 'company.phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
            ],
            [
                'key' => 'company.email',
                'value' => 'hello@eksporhub.id',
                'type' => 'text',
            ],
            [
                'key' => 'company.address',
                'value' => 'Jl. Pelabuhan No. 18, Penjaringan, Jakarta Utara 14440',
                'type' => 'text',
            ],
            [
                'key' => 'company.office_hours',
                'value' => 'Senin - Jumat, 09.00 - 18.00 WIB',
                'type' => 'text',
            ],
            [
                'key' => 'company.socials',
                'value' => [
                    'instagram' => 'https://instagram.com/eksporhub',
                    'linkedin' => 'https://linkedin.com/company/eksporhub',
                    'youtube' => 'https://youtube.com/@eksporhub',
                ],
                'type' => 'json',
            ],
        ])->each(fn (array $setting) => Setting::updateOrCreate(
            ['key' => $setting['key']],
            ['value' => $setting['value'], 'type' => $setting['type']]
        ));
    }
}
