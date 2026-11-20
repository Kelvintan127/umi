<?php

/*
|--------------------------------------------------------------------------
| Kelengkapan situs, data bersama, dan konten terstruktur (Indonesia) —
| UNREVIEWED id draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| Draft terjemahan mesin-manusia tanpa tinjauan perusahaan. Setiap string
| berasal dari lang/en/site.php; tidak ada klaim, sertifikasi, pelanggan,
| atau angka yang ditambahkan. Token merek (UMI, PT. Uni-Metaltech Industry,
| ISO 9001:2015, ISO 14001:2015, SMETA, nama mesin, nama pelanggan) tidak
| diterjemahkan.
|
| Catatan: kutipan testimoni pelanggan diterjemahkan dari materi Inggris;
| bunyi asli kutipan tidak tersedia di sumber, jadi verifikasi diperlukan
| sebelum penayangan.
|
*/

return [

    'meta' => [
        'company' => 'PT. Uni-Metaltech Industry',
        'short' => 'UMI Stamping',
        'founded' => '2000',
        'tagline' => 'Stamping logam presisi dan manufaktur',
        'description' => 'Solusi stamping logam presisi dan manufaktur untuk aplikasi otomotif, elektronik, dan industri.',
    ],

    'nav' => [
        'home' => 'Beranda',
        'about' => 'Tentang',
        'capabilities' => 'Kapabilitas',
        'products' => 'Produk',
        'facilities' => 'Fasilitas',
        'policy' => 'Kebijakan Perusahaan',
        'quality' => 'Mutu',
        'contact' => 'Kontak',
    ],

    'cta' => [
        'contact' => 'Hubungi Kami',
        'quote' => 'Minta Penawaran',
        'capabilities' => 'Jelajahi Kapabilitas',
        'team' => 'Bicara dengan Tim Kami',
        'project' => 'Diskusikan Proyek Anda',
    ],

    /*
     * Ajakan penutup. Disimpan di satu tempat agar setiap halaman berakhir
     * dengan cara yang sama.
     */
    'cta_block' => [
        'title' => 'Punya komponen yang perlu diproduksi?',
        'lead' => 'Beri tahu kami apa yang sedang Anda kembangkan. Tim rekayasa dan manufaktur kami dapat membantu mengubah kebutuhan Anda menjadi solusi produksi yang andal.',
    ],

    'contact_page' => [
        'locations_eyebrow' => 'Lokasi',
        'locations_title' => 'Dua lokasi, satu standar.',
        'email' => 'Email',
        'phone' => 'Telepon',
        'location' => 'Lokasi',
        'view_map' => 'Lihat di peta',
    ],

    'nav_aria' => [
        'open' => 'Buka navigasi',
        'close' => 'Tutup navigasi',
        'primary' => 'Utama',
        'footer' => 'Kaki halaman',
        'breadcrumb' => 'Remah navigasi',
        'language' => 'Bahasa',
        'pause_video' => 'Jeda video latar',
        'play_video' => 'Putar video latar',
        'profile_play' => 'Putar video profil perusahaan',
        'profile_loading' => 'Memuat video...',
        'profile_error' => 'Video tidak dapat dimuat.',
        'skip' => 'Lewati ke konten',
    ],

    'footer' => [
        'blurb' => 'PT. Uni-Metaltech Industry — solusi stamping logam presisi dan manufaktur sejak 2000. Batam, Indonesia.',
        'company' => 'Perusahaan',
        'resources' => 'Sumber Daya',
        'rights' => 'Seluruh hak dilindungi.',
        'privacy' => 'Kebijakan Privasi',
        'terms' => 'Syarat Layanan',
        'links' => [
            'company_section' => [
                'about' => 'Tentang',
                'capabilities' => 'Kapabilitas',
                'products' => 'Produk',
            ],
            'resources_section' => [
                'quality' => 'Mutu',
                'certifications' => 'Sertifikasi',
                'facilities' => 'Fasilitas',
                'contact' => 'Kontak',
            ],
        ],
    ],

    'stats' => [
        ['value' => '25+', 'label' => 'Tahun pengalaman'],
        ['value' => '3,000', 'label' => 'm² luas pabrik'],
        ['value' => '0.10', 'label' => 'ketebalan material minimum dalam mm'],
        ['value' => '15–160', 'label' => 'rentang mesin pres (ton)'],
    ],

    'capabilities' => [
        [
            'title' => 'Stamping Logam',
            'category' => 'Manufaktur Inti',
            'description' => 'Solusi stamping logam presisi tinggi untuk komponen yang kompleks dan menuntut, mampu menstamp material setipis 0.10 mm.',
            'image' => '/images/facilities/sni-110-mechanical-stamping-press.png',
        ],
        [
            'title' => 'Perkakas dan Cetakan',
            'category' => 'Perkakas Presisi',
            'description' => 'Perancangan dan pembuatan perkakas di dalam perusahaan dengan kemampuan CNC WireCut, NC EDM, dan penggerindaan untuk waktu pengerjaan yang singkat.',
            'image' => '/images/facilities/donrun-four-column-hydraulic-press.png',
        ],
        [
            'title' => 'Pengelasan',
            'category' => 'Proses Sekunder',
            'description' => 'Las titik dan proses pengelasan lain dikerjakan di dalam perusahaan sebagai layanan bernilai tambah untuk manufaktur yang menyeluruh.',
            'image' => '/images/facilities/robotic-welding-arm.png',
        ],
        [
            'title' => 'Perakitan',
            'category' => 'Layanan Bernilai Tambah',
            'description' => 'Perakitan mekanis meliputi pengetapan, reverting, dan las titik untuk memberikan layanan yang menyeluruh kepada pelanggan.',
            'image' => '/images/facilities/eko-esii2508-sheet-metal-bending-machine.png',
        ],
    ],

    'industries' => [
        [
            'title' => 'Otomotif',
            'description' => 'Komponen dan rakitan presisi yang dirancang untuk aplikasi otomotif yang menuntut, tempat konsistensi, daya tahan, dan akurasi dimensi menjadi hal kritis.',
            'image' => '/images/industries/automotive.jpg',
        ],
        [
            'title' => 'Elektronik',
            'description' => 'Komponen presisi tinggi yang diproduksi untuk aplikasi elektronik yang memerlukan toleransi ketat, konsistensi, dan kinerja produksi yang andal.',
            'image' => '/images/industries/electronics.jpg',
        ],
        [
            'title' => 'Industri',
            'description' => 'Solusi manufaktur yang kokoh untuk aplikasi industri, memadukan keahlian rekayasa dengan produksi yang konsisten dan dapat diskalakan.',
            'image' => '/images/industries/industrial.jpg',
        ],
        [
            'title' => 'Konsumen',
            'description' => 'Komponen dan rakitan logam yang andal untuk produk konsumen, tempat desain, presisi, dan efisiensi manufaktur berpadu.',
            'image' => '/images/industries/consumer.jpg',
        ],
    ],

    'process' => [
        ['title' => 'Rekayasa', 'description' => 'Analisis produk, tinjauan desain, dan kelayakan manufaktur.'],
        ['title' => 'Perkakas', 'description' => 'Pengembangan cetakan dan perkakas presisi sesuai kebutuhan produksi.'],
        ['title' => 'Stamping', 'description' => 'Produksi terkendali menggunakan peralatan stamping presisi tinggi.'],
        ['title' => 'Inspeksi', 'description' => 'Inspeksi mutu dan verifikasi dimensi.'],
        ['title' => 'Perakitan', 'description' => 'Proses sekunder terpadu dan perakitan komponen.'],
        ['title' => 'Pengiriman', 'description' => 'Pengemasan yang aman dan pengiriman yang andal kepada pelanggan.'],
    ],

    'quality' => [
        'principles' => [
            ['title' => 'Presisi', 'description' => 'Setiap komponen diproduksi dengan perhatian penuh pada akurasi dimensi, spesifikasi, dan kebutuhan produksi.'],
            ['title' => 'Konsistensi', 'description' => 'Proses manufaktur yang terstruktur membantu menjaga hasil yang andal dan konsisten sepanjang produksi.'],
            ['title' => 'Ketertelusuran', 'description' => 'Proses produksi dan mutu didukung oleh dokumentasi dan pemantauan yang sistematis.'],
            ['title' => 'Keandalan', 'description' => 'Mutu terintegrasi di seluruh alur manufaktur untuk mendukung kinerja jangka panjang yang dapat diandalkan.'],
        ],
        'labelling' => 'Status sertifikasi yang ditampilkan di halaman ini dikutip dari materi terbitan perusahaan dan masih menunggu konfirmasi ulang dari pemilik mengenai nomor sertifikat, lembaga penerbit, dan tanggal berlaku.',
    ],

    'certifications' => [
        [
            'name' => 'ISO 9001:2015',
            'title' => 'Sistem Manajemen Mutu',
            'description' => 'Tersertifikasi sejak 2000 sesuai ISO 9001:2015. Audit internal dan eksternal memastikan sistem manajemen manufaktur kami ditinjau dan diperbarui secara berkala untuk menjaga kompetensi operasional dan peningkatan mutu produk secara berkelanjutan.',
            'document' => '/images/certifications/CPG 9001 QMS Recertification.pdf',
        ],
        [
            'name' => 'ISO 14000:2015',
            'title' => 'Sistem Manajemen Lingkungan',
            'description' => 'Tersertifikasi sesuai ISO 14000:2015. Kami berkomitmen untuk mencegah pencemaran, meminimalkan limbah, mematuhi peraturan, dan menurunkan konsumsi energi di seluruh proses produksi kami.',
            'document' => '/images/certifications/CPG 14001 EMS Recertification.pdf',
        ],
    ],

    'policy' => [
        'heading' => 'Kebijakan Mutu dan Lingkungan',
        'intro' => 'Kami berkomitmen untuk:',
        'items' => [
            'Menyediakan produk stamping logam bermutu tinggi yang memenuhi persyaratan pelanggan.',
            'Mencegah pencemaran lingkungan dan meminimalkan limbah dari proses produksi.',
            'Mematuhi semua persyaratan hukum, peraturan, dan persyaratan lingkungan lain yang berlaku.',
            'Menurunkan konsumsi energi dan meningkatkan efisiensi sumber daya.',
            'Mengidentifikasi dan menangani risiko serta peluang perubahan iklim yang dapat memengaruhi operasi kami.',
            'Meningkatkan kompetensi dan kesadaran karyawan mengenai mutu dan perlindungan lingkungan.',
            'Terus meningkatkan efektivitas sistem manajemen mutu dan lingkungan kami.',
        ],
    ],

    'products' => [
        [
            'key' => 'battery-contacts',
            'title' => 'Kontak Baterai',
            'description' => 'Kontak baterai untuk peralatan elektronik, paket baterai, dan perangkat elektronik portabel.',
            'image' => '/images/products/assorted-precision-metal-stamping-parts.png',
        ],
        [
            'key' => 'wire-harnessing',
            'title' => 'Terminal Kabel',
            'description' => 'Terminal kabel untuk aplikasi wire-harnessing di industri kelistrikan dan otomotif.',
            'image' => '/images/products/precision-metal-bar-assembly.png',
        ],
        [
            'key' => 'mechanical-assembly',
            'title' => 'Perakitan Mekanis',
            'description' => 'Layanan bernilai tambah meliputi pengetapan, riveting, dan las titik yang dikerjakan di dalam perusahaan.',
            'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
        ],
        [
            'key' => 'electrical-metal-parts',
            'title' => 'Komponen Logam Lainnya',
            'description' => 'Komponen logam untuk komputer, printer, telepon, MCB, catu daya, penerangan, dan UPS.',
            'image' => '/images/products/formed-steel-mounting-plate.png',
        ],
    ],

    'facilities' => [
        [
            'key' => 'production-machines',
            'title' => 'Mesin Produksi',
            'summary' => 'Mesin produksi mencakup pres 15 hingga 160 ton buatan Jepang dan Taiwan dengan feeder rol mekanis, udara, dan NC.',
            'specs' => [
                'Pres C-Frame, 15–160 ton: Seyi, Aida, Amada',
                'Pres Kecepatan Tinggi, 15–60 ton: Yamada Dobby, Amada, Seyi, ISIS',
                'Mesin pemotong, pengetap, dan reverting otomatis',
                'Mesin pres manual',
            ],
            'image' => '/images/facilities/snc-80-mechanical-stamping-press.png',
        ],
        [
            'key' => 'supporting-machines',
            'title' => 'Mesin Pendukung',
            'summary' => 'Departemen perkakas internal yang lengkap menjaga biaya perkakas tetap rendah dan waktu pengiriman singkat melalui investasi peralatan yang berkelanjutan.',
            'specs' => [
                'CNC WireCut: Sodick, Mitsubishi',
                'NC EDM: SEIKI',
                'NC Superdrill: SEIKI',
                'Mesin gerinda: Okamoto, Equiptop',
                'Frais CNC: Hurco',
                'Frais manual dan mesin bubut',
                'Pengukiran laser portabel LX-A1',
            ],
            'image' => '/images/facilities/sheet-metal-laser-cutting-machine.jpg',
        ],
        [
            'key' => 'tools-design-storage',
            'title' => 'Perancangan dan Penyimpanan Perkakas',
            'summary' => 'Tim rekayasa kami merancang dan membuat set cetakan secara lokal dengan waktu pengerjaan yang singkat; set cetakan kelas atas didukung dari Singapura dan Malaysia.',
            'specs' => [
                'Perancangan dan pembuatan cetakan di dalam perusahaan',
                'Produksi prototipe sebelum pembuatan perkakas produksi massal bila diperlukan',
                'Penyimpanan dan pemeliharaan perkakas yang tertata',
                'Pengadaan set cetakan dari Singapura dan Malaysia untuk perkakas kelas atas',
            ],
            'image' => '/images/facilities/donrun-four-column-hydraulic-press.png',
        ],
        [
            'key' => 'measurement-equipment',
            'title' => 'Peralatan Pengukuran',
            'summary' => 'Peralatan kendali mutu (QA) presisi tinggi menjaga komitmen bahwa hanya komponen bermutu tinggi yang dikirim; kalibrasi dilakukan secara internal dan eksternal.',
            'specs' => [
                'Pengukuran optik (VS)',
                'Proyektor profil: Mitutoyo',
                'High gauge: Mitutoyo',
                'Pin gauge',
                'Block gauge',
                'Jangka sorong',
                'Mikrometer',
                'Kalibrasi rutin dilakukan untuk semua peralatan QA guna memastikan ketepatan pengukuran, baik secara internal maupun eksternal.',
            ],
            'image' => '/images/facilities/eko-esii2508-sheet-metal-bending-machine.png',
        ],
    ],

    'metal_part_users' => [
        'intro' => 'UMI memasok komponen logam kepada produsen di industri kelistrikan, elektronik, dan otomotif.',
        'users' => [
            'Sanyo Energy Batam', 'Panasonic', 'Digi', 'Patlite', 'OrieX',
            'Foster Electric', 'Wellington', 'WIK', 'HW Genting', 'Valeo', 'SIIX',
            'Hitachi', 'Apple', 'BlackBerry', 'Kenwood', 'Dell', 'JVC', 'Nokia', 'Kyocera',
        ],
        'testimonials' => [
            ['name' => 'Foster Electric', 'period' => '2013–2015', 'quote' => '“Zero Reject” dan “Zero Claim” untuk tahun 2013–2015.'],
            ['name' => 'Sanyo Energy Batam', 'period' => 'Sejak 2000', 'quote' => 'Pengakuan atas keunggulan layanan berupa mutu yang baik dan dukungan yang sangat baik sejak tahun 2000.'],
        ],
        'customers_heading' => 'Pelanggan yang kami pasok langsung',
        'brands_heading' => 'Produk akhir yang menggunakan komponen kami',
        'brands_intro' => 'Komponen yang dipasok ke produsen kontrak juga digunakan pada produk akhir berikut. UMI tidak memasok merek-merek ini secara langsung.',
        'withheld_note' => 'Nama pelanggan dan kutipan penghargaan ditahan sampai ada izin tertulis dari masing-masing perusahaan. Daftar referensi tersedia atas permintaan di info@umistamping.com.',
        'note' => 'Nama pelanggan dan kutipan penghargaan ditahan sampai ada izin tertulis dari masing-masing perusahaan. Daftar referensi tersedia atas permintaan di info@umistamping.com.',
    ],

    'contact' => [
        'batam' => [
            'label' => 'Pabrik Manufaktur (Batam)',
            'lines' => [
                'Kara Industrial Park Block - C 05 No. 01',
                'Batam Center 29432 - Batam',
                'Kepri - Indonesia',
            ],
            'phone' => '+62 778 464141',
            'fax' => '+62 778 464143',
            'map' => 'https://maps.google.com/maps?q=1.109035+104.046600&hl=en&z=16',
        ],
        'email' => 'info@umistamping.com',
        'phone' => '+62 778 464141',
        'location' => 'Batam, Indonesia',
    ],

    'gallery' => [
        ['title' => 'Lantai produksi', 'label' => 'Lingkungan produksi', 'image' => '/images/gallery/factory-01.jpg'],
        ['title' => 'Mesin presisi', 'label' => 'Peralatan produksi', 'image' => '/images/gallery/machine-01.jpg'],
        ['title' => 'Proses produksi', 'label' => 'Kapabilitas manufaktur', 'image' => '/images/gallery/product-01.jpg'],
        ['title' => 'Detail rekayasa', 'label' => 'Manufaktur presisi', 'image' => '/images/gallery/team-01.jpg'],
    ],

    'news' => [
        ['date' => '2024', 'title' => 'Profil perusahaan UMI Stamping', 'excerpt' => 'Gambaran umum fasilitas manufaktur, kapabilitas, dan sistem mutu kami di Batam, Indonesia.'],
        ['date' => '2024', 'title' => 'Kapabilitas perkakas dan cetakan', 'excerpt' => 'Perancangan dan pembuatan cetakan di dalam perusahaan dengan CNC WireCut, NC EDM, dan penggerindaan untuk waktu pengerjaan yang singkat.'],
        ['date' => '2024', 'title' => 'Mutu dan sertifikasi', 'excerpt' => 'Sistem manajemen kami ditinjau melalui audit internal dan eksternal secara berkala.'],
    ],

    'language' => [
        'label' => 'Bahasa',
        'en' => 'English',
        'id' => 'Bahasa Indonesia',
        'zh' => '简体中文',
        'unavailable' => 'Terjemahan menunggu persetujuan perusahaan — halaman ini disajikan dalam bahasa Inggris.',
    ],

    /*
     * String yang harus berbeda dari bahasa Inggris pada locale terjemahan.
     * Tidak dipakai untuk rendering: hanya sampel yang diuji pemeriksaan
     * kelengkapan terjemahan.
     */
    'i18n_probe' => [
        'nav' => 'Tentang',
        'hero_title' => 'Tentang UMI',
        'cta' => 'Hubungi Kami',
        'policy' => 'Kami berkomitmen untuk:',
    ],

];
