<?php

/*
|--------------------------------------------------------------------------
| Per-page copy — Indonesian draft locale (UNREVIEWED)
|--------------------------------------------------------------------------
|
| STATUS: DRAFT — BELUM DITINJAU. This is an unreviewed Indonesian draft of the
| English source copy in lang/en/pages.php. It is NOT approved by the company,
| and it is NOT served: /{locale}/{page} redirects to /en/ until the company
| signs the copy off and adds the 'id' locale code to the page's entry in
| config/locales.php (the 'translated' allow-list). No sign-off, no serving.
|
| The English source is authoritative. Where this draft and lang/en/pages.php
| disagree in meaning, fact or figure, the English file wins and this one is
| the defect.
|
| Structure is identical to the English source, key for key: the same page
| keys, the same 'seo' / 'hero' / 'sections' keys, and within 'sections' the
| same 'type' values in the same order with the same counts of paragraphs,
| items and clauses. The React side indexes into these arrays by key, so a
| shape difference is a bug, not a style choice. Only values are translated.
|
| Preserved verbatim (brand tokens, identifiers, paths, numbers): PT.
| Uni-Metaltech Industry, UMI, UMI Stamping, ISO 9001:2015, ISO 14001:2015,
| SMETA, Batam, Jababeka, Cikarang, Kara Industrial Park, ODS DVD, 'mm',
| machine makes, URLs, emails and phone numbers. A rename of any of these is a
| single-line diff in lang/en only.
|
| Nothing here is invented: no certification, customer, figure or claim appears
| in this file that is not in the English source.
|
*/

return [

    'home' => [
        'seo' => [
            'title' => 'UMI Stamping — Produsen Stamping Logam Presisi di Batam, Indonesia',
            'description' => 'PT. Uni-Metaltech Industry adalah produsen stamping logam presisi di Batam, Indonesia. Stamping, perkakas dan cetakan, pengelasan, serta perakitan untuk aplikasi otomotif, elektronik, dan industri.',
        ],
        'hero' => [
            'eyebrow' => 'Manufaktur presisi',
            'title' => 'Presisi. Keunggulan manufaktur.',
            'lead' => 'Stamping logam presisi, perkakas, pengelasan, perakitan, dan solusi manufaktur yang dirancang untuk industri dengan tuntutan tinggi.',
            'video' => '/videos/hero-factory.mp4',
            'video_mobile' => '/videos/hero-factory-mobile.mp4',
            'poster' => '/images/hero/factory.jpg',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Stamping logam presisi, dirancang di Batam',
                'video' => '/videos/company-profile.mp4',
                'paragraphs' => [
                    'PT. Uni-Metaltech Industry (UMI) adalah perusahaan stamping logam presisi yang didirikan pada tahun 2000 di Batam, Indonesia. Pabrik kami berada di Kara Industrial Park, Batam Center, dengan Kantor Penjualan Jakarta di Jababeka Industrial Park yang didirikan pada tahun 2014.',
                    'Kami memproduksi kontak baterai, perakitan kabel dan terminal kabel, komponen ODS DVD drive, perakitan mekanis, serta komponen logam listrik dan komponen logam lainnya untuk produsen listrik, elektronik, dan otomotif.',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'process', 'heading' => 'Dari desain hingga pengiriman'],
            ['type' => 'cards', 'heading' => 'Produk dan layanan kami', 'source' => 'products', 'link_base' => 'products'],
            ['type' => 'specs', 'heading' => 'Di dalam pabrik', 'source' => 'facilities'],
            ['type' => 'certifications', 'heading' => 'Mutu dan sertifikasi'],
            ['type' => 'policy', 'heading' => 'Kebijakan perusahaan'],
            ['type' => 'cta'],
        ],
    ],

    'about' => [
        'seo' => [
            'title' => 'Tentang UMI Stamping — PT. Uni-Metaltech Industry',
            'description' => 'PT. Uni-Metaltech Industry adalah perusahaan stamping logam presisi yang didirikan pada tahun 2000 di Batam, Indonesia, dengan kantor penjualan Jakarta di Jababeka sejak tahun 2014.',
        ],
        'hero' => [
            'eyebrow' => 'Tentang UMI',
            'title' => 'Stamping presisi sejak tahun 2000.',
            'lead' => 'PT. Uni-Metaltech Industry (UMI) adalah perusahaan stamping logam presisi yang didirikan pada tahun 2000 di Batam, Indonesia.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Lokasi manufaktur yang strategis',
                'video' => '/videos/company-profile.mp4',
                'paragraphs' => [
                    'Pabrik kami berlokasi di Kara Industrial Park, Batam Center — berjarak dekat dari Singapore Batamindo Industrial Park dan International Ferry Terminal.',
                    'Pulau Batam merupakan Kawasan Perdagangan Bebas (Free Trade Zone) dan dianggap sebagai salah satu lokasi manufaktur terbaik di Indonesia untuk produksi berorientasi ekspor. Kami memperoleh manfaat dari keunggulan biaya yang kompetitif di Indonesia sekaligus dukungan tenaga kerja terampil dan respons cepat dari Singapura.',
                    'Luas pabrik kami sekitar 3.000 m², terdiri atas area produksi, gudang, dan kantor. Kantor Penjualan Jakarta didirikan pada tahun 2014 di Jababeka Industrial Park.',
                    'Kami memproduksi berbagai komponen logam khusus untuk pelanggan di industri kelistrikan, elektronik, dan otomotif.',
                    'Dengan pengalaman produksi dan engineer yang terampil, kami mampu melakukan stamping material hingga setipis 0,10 mm dengan tooling presisi tinggi.',
                ],
            ],
            ['type' => 'stats'],
            ['type' => 'cards', 'heading' => 'Kapabilitas', 'source' => 'capabilities'],
            ['type' => 'cta'],
        ],
    ],

    'company-profile' => [
        'seo' => [
            'title' => 'Profil Perusahaan — UMI Stamping',
            'description' => 'Profil perusahaan PT. Uni-Metaltech Industry: didirikan pada tahun 2000 di Batam, Indonesia, luas area pabrik sekitar 3.000 m², melayani produsen listrik, elektronik, dan otomotif.',
        ],
        'hero' => [
            'eyebrow' => 'Profil perusahaan',
            'title' => 'Mitra stamping logam presisi.',
            'lead' => 'UMI memproduksi komponen logam sesuai pesanan dan mendukung produsen terkemuka di industri listrik, elektronik, dan otomotif.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Siapa kami',
                'image' => '/images/hero/factory.jpg',
                'paragraphs' => [
                    'PT. UNI METALTECH INDUSTRY (UMI) adalah perusahaan stamping logam presisi yang didirikan pada tahun 2000 di Batam, Indonesia, berlokasi di Kara Industrial Park, Batam Center.',
                    'Perusahaan kami memproduksi berbagai jenis komponen logam sesuai pesanan dan mendukung produsen terkemuka di industri listrik, elektronik, dan otomotif. Komponen logam tersebut digunakan pada produk seperti battery pack dan aplikasinya, terminal kabel, sistem audio, sistem penimbangan, serta perangkat peringatan bersuara.',
                    'Pengalaman kami telah berkembang seiring waktu, dan kami mampu melakukan stamping material setipis 0,10 mm, yang menuntut perkakas presisi tinggi dan engineer yang terampil.',
                ],
            ],
            [
                'type' => 'specs',
                'heading' => 'Fakta perusahaan',
                'items' => [
                    ['title' => 'Berdiri', 'summary' => 'Didirikan pada tahun 2000 di Batam, Indonesia.', 'specs' => []],
                    ['title' => 'Pabrik', 'summary' => 'Area produksi, gudang, dan kantor seluas sekitar 3.000 m² di Kara Industrial Park, Batam Center.', 'specs' => []],
                    ['title' => 'Kantor penjualan', 'summary' => 'Kantor perwakilan penjualan Jakarta di Jababeka Industrial Park, didirikan pada tahun 2014.', 'specs' => []],
                    ['title' => 'Kapabilitas', 'summary' => 'Stamping material setipis 0,10 mm, dengan kapasitas pres dari 15 sampai 160 ton.', 'specs' => []],
                ],
            ],
            ['type' => 'process'],
            ['type' => 'cta'],
        ],
    ],

    'certifications' => [
        'seo' => [
            'title' => 'Sertifikasi — UMI Stamping',
            'description' => 'Sertifikasi sistem manajemen UMI Stamping: manajemen mutu ISO 9001:2015 dan manajemen lingkungan ISO 14001:2015, dengan audit perdagangan etis SMETA.',
        ],
        'hero' => [
            'eyebrow' => 'Sertifikasi',
            'title' => 'Tersertifikasi untuk keyakinan.',
            'lead' => 'Sertifikasi kami mencerminkan komitmen terhadap sistem manufaktur yang terstruktur, jaminan mutu, dan perbaikan berkelanjutan.',
            'note' => 'site.quality.labelling',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Sistem manajemen',
                'paragraphs' => [
                    'Untuk memenuhi persyaratan pelanggan dan sebagai komitmen terhadap sistem manajemen yang baik, PT. UMI telah tersertifikasi sejak tahun 2000 sesuai standar internasional ISO 9001:2015 dan ISO 14001:2015.',
                    'Audit internal serta audit yang dilakukan oleh lembaga penilaian dan sertifikasi eksternal yang independen dan terakreditasi memastikan bahwa sistem manajemen manufaktur kami ditinjau, diaudit, dan diperbarui secara berkala untuk menjaga kompetensi operasional, kesesuaian terhadap spesifikasi, serta peningkatan mutu dan kinerja produk secara berkelanjutan.',
                    'Seluruh bahan baku diuji agar sesuai dengan peraturan pemerintah dan berbagai persyaratan pelanggan seperti RoHS dan REACH.',
                ],
            ],
            ['type' => 'certifications'],
            ['type' => 'cta'],
        ],
    ],

    'policy' => [
        'seo' => [
            'title' => 'Kebijakan Mutu dan Lingkungan — UMI Stamping',
            'description' => 'Kebijakan mutu dan lingkungan PT. Uni-Metaltech Industry yang dipublikasikan.',
        ],
        'hero' => [
            'eyebrow' => 'Kebijakan perusahaan',
            'title' => 'Berkomitmen pada mutu dan keberlanjutan.',
            'lead' => 'Kebijakan mutu dan lingkungan yang dipublikasikan oleh PT. Uni-Metaltech Industry.',
        ],
        'sections' => [
            ['type' => 'policy'],
            ['type' => 'cta'],
        ],
    ],

    'capabilities' => [
        'seo' => [
            'title' => 'Kapabilitas — UMI Stamping',
            'description' => 'Kapabilitas stamping logam terpadu: stamping presisi hingga 0,10 mm, perkakas dan cetakan internal, pengelasan, dan perakitan mekanis.',
        ],
        'hero' => [
            'eyebrow' => 'Kapabilitas',
            'title' => 'Manufaktur terpadu.',
            'lead' => 'Dari rekayasa dan pembuatan perkakas hingga stamping, perakitan, dan inspeksi mutu — kapabilitas kami dirancang untuk menghasilkan mutu dan keandalan yang konsisten.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'Apa yang kami kerjakan', 'source' => 'capabilities'],
            ['type' => 'process'],
            ['type' => 'stats'],
            ['type' => 'cta'],
        ],
    ],

    'products' => [
        'seo' => [
            'title' => 'Produk dan Layanan — UMI Stamping',
            'description' => 'Rangkaian produk UMI: kontak baterai, perakitan kabel dan terminal kabel, komponen ODS DVD drive, perakitan mekanis, serta komponen logam listrik dan komponen logam lainnya.',
        ],
        'hero' => [
            'eyebrow' => 'Produk dan layanan',
            'title' => 'Komponen logam sesuai pesanan.',
            'lead' => 'UMI memproduksi berbagai jenis komponen logam, sebagian besar disesuaikan dengan kebutuhan proyek tertentu. Kami mampu melakukan stamping material setipis 0,10 mm, yang menuntut perkakas presisi tinggi dan engineer yang terampil.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Rangkaian Produk',
                'paragraphs' => [
                    'UMI memproduksi berbagai jenis komponen logam yang sebagian besar disesuaikan dengan kebutuhan proyek pelanggan. Kapabilitas kami mencakup kontak baterai, terminal kabel, perakitan mekanis, dan berbagai komponen logam lain.',
                    'Dengan pengalaman produksi dan tooling presisi tinggi, kami mampu melakukan stamping material hingga setipis 0,10 mm.',
                ],
            ],
            ['type' => 'cards', 'heading' => 'Rangkaian produk', 'source' => 'products', 'link_base' => '/products/'],
            ['type' => 'cta'],
        ],
    ],

    'products.battery-contacts' => [
        'seo' => [
            'title' => 'Kontak Baterai — UMI Stamping',
            'description' => 'Kontak baterai hasil stamping presisi untuk peralatan elektronik, battery pack, dan perangkat elektronik portabel.',
        ],
        'hero' => [
            'eyebrow' => 'Produk',
            'title' => 'Kontak baterai.',
            'lead' => 'Kontak baterai yang banyak digunakan pada peralatan elektronik, battery pack, dan perangkat elektronik portabel.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Aplikasi',
                'image' => '/images/products/assorted-precision-metal-stamping-parts.png',
                'paragraphs' => [
                    'Kontak baterai distamping dari material strip sesuai persyaratan dimensi dan ketahanan kontak dari battery pack atau perangkat yang dilayaninya.',
                    'Aplikasi umumnya mencakup battery pack dan perangkat elektronik portabel, di mana geometri kontak dan pemilihan material menentukan kinerja kelistrikan sekaligus umur siklus.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.wire-harnessing' => [
        'seo' => [
            'title' => 'Perakitan Kabel dan Terminal Kabel — UMI Stamping',
            'description' => 'Terminal kabel yang digunakan pada aplikasi perakitan kabel yang mendukung industri listrik dan otomotif.',
        ],
        'hero' => [
            'eyebrow' => 'Produk',
            'title' => 'Perakitan kabel dan terminal kabel.',
            'lead' => 'Terminal kabel yang digunakan pada aplikasi perakitan kabel yang mendukung industri listrik dan otomotif.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Aplikasi',
                'image' => '/images/products/precision-metal-bar-assembly.png',
                'paragraphs' => [
                    'UMI melakukan stamping terminal kabel untuk aplikasi perakitan kabel di industri listrik dan otomotif.',
                    'Komponen terminal diproduksi secara internal dan dapat dikombinasikan dengan proses sekunder seperti pengetapan, reverting, dan las titik apabila suatu proyek membutuhkan komponen yang telah dirakit.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.ods-dvd-drive' => [
        'seo' => [
            'title' => 'Komponen ODS DVD Drive — UMI Stamping',
            'description' => 'Komponen logam hasil stamping presisi untuk perakitan optical disc drive.',
        ],
        'hero' => [
            'eyebrow' => 'Produk',
            'title' => 'Komponen ODS DVD drive.',
            'lead' => 'Komponen hasil stamping presisi untuk perakitan optical disc drive, diproduksi sesuai persyaratan dimensi yang ketat.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Aplikasi',
                'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
                'paragraphs' => [
                    'Perakitan optical disc drive menggunakan komponen logam hasil stamping di mana kerataan, ketelitian dimensi, dan kondisi permukaan memengaruhi pergerakan mekanisme drive.',
                    'Komponen ini diproduksi dengan perkakas progresif dan diverifikasi menggunakan peralatan pengukuran yang diuraikan pada bagian fasilitas kami.',
                ],
                'note' => 'Spesifikasi komponen yang terperinci tersedia atas permintaan; spesifikasi tersebut tidak dipublikasikan pada halaman ini.',
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.mechanical-assembly' => [
        'seo' => [
            'title' => 'Perakitan Mekanis — UMI Stamping',
            'description' => 'Perakitan mekanis internal dengan nilai tambah, meliputi pengetapan, reverting, dan las titik.',
        ],
        'hero' => [
            'eyebrow' => 'Produk',
            'title' => 'Perakitan mekanis.',
            'lead' => 'Layanan bernilai tambah seperti pengetapan, reverting, dan las titik disediakan secara internal untuk memberikan layanan yang lebih menyeluruh kepada pelanggan kami.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Proses sekunder, dikerjakan internal',
                'image' => '/images/products/black-coated-sheet-metal-panel-assembly.png',
                'paragraphs' => [
                    'Layanan bernilai tambah seperti pengetapan, reverting, dan las titik disediakan secara internal untuk memberikan layanan yang lebih menyeluruh kepada pelanggan kami.',
                ],
            ],
            [
                'type' => 'specs',
                'heading' => 'Proses sekunder internal',
                'items' => [
                    ['title' => 'Pengetapan', 'summary' => 'Proses pembuatan ulir yang dikerjakan secara internal setelah stamping.', 'specs' => []],
                    ['title' => 'Reverting', 'summary' => 'Proses reverting yang dikerjakan secara internal setelah stamping.', 'specs' => []],
                    ['title' => 'Las titik', 'summary' => 'Las titik yang dikerjakan secara internal sebagai proses sekunder.', 'specs' => []],
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'products.electrical-metal-parts' => [
        'seo' => [
            'title' => 'Komponen Logam Listrik dan Lainnya — UMI Stamping',
            'description' => 'Komponen logam hasil stamping untuk aplikasi komputer, printer, telepon, MCB, power supply, perangkat pencahayaan, dan UPS.',
        ],
        'hero' => [
            'eyebrow' => 'Produk',
            'title' => 'Komponen logam listrik dan lainnya.',
            'lead' => 'Komponen logam untuk aplikasi komputer, printer, telepon, MCB, power supply, perangkat pencahayaan, dan UPS.',
        ],
        'sections' => [
            [
                'type' => 'prose',
                'heading' => 'Aplikasi',
                'image' => '/images/products/formed-steel-mounting-plate.png',
                'paragraphs' => [
                    'UMI memproduksi berbagai macam komponen logam sesuai pesanan untuk aplikasi kelistrikan dan elektronik, sebagian besar disesuaikan dengan kebutuhan proyek tertentu.',
                    'Aplikasinya mencakup produk komputer, printer, telepon, miniature circuit breaker (MCB), power supply, perangkat pencahayaan, dan UPS.',
                ],
            ],
            ['type' => 'cta'],
        ],
    ],

    'facilities' => [
        'seo' => [
            'title' => 'Fasilitas — UMI Stamping',
            'description' => 'Fasilitas manufaktur UMI: pres produksi dari 15 sampai 160 ton, mesin pendukung pembuatan perkakas, desain dan penyimpanan perkakas, serta peralatan pengukuran.',
        ],
        'hero' => [
            'eyebrow' => 'Fasilitas',
            'title' => 'Peralatan di balik presisi.',
            'lead' => 'Pres produksi, mesin pembuatan perkakas internal, penyimpanan perkakas yang tertata, dan peralatan pengukuran presisi tinggi.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Kelompok fasilitas', 'source' => 'facilities'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.production-machines' => [
        'seo' => [
            'title' => 'Mesin Produksi — UMI Stamping',
            'description' => 'Pres mekanis C-frame dari 15 sampai 160 ton buatan Seyi, Aida, dan Amada; pres kecepatan tinggi buatan Yamada Dobby, Amada, Seyi, dan ISIS.',
        ],
        'hero' => [
            'eyebrow' => 'Fasilitas',
            'title' => 'Mesin produksi.',
            'lead' => 'Mesin produksi berupa pres berkapasitas 15 sampai 160 ton buatan Jepang dan Taiwan, dengan feeder mekanis roller, udara, dan NC.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Peralatan pres', 'only' => 'production-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.supporting-machines' => [
        'seo' => [
            'title' => 'Mesin Pendukung — UMI Stamping',
            'description' => 'Peralatan pembuatan perkakas internal: CNC WireCut, NC EDM, NC Superdrill, gerinda, CNC milling, dan laser engraving.',
        ],
        'hero' => [
            'eyebrow' => 'Fasilitas',
            'title' => 'Mesin pendukung.',
            'lead' => 'Departemen pembuatan perkakas internal yang lengkap menjaga biaya perkakas tetap rendah dan waktu pengiriman tetap singkat melalui investasi peralatan yang berkelanjutan.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Peralatan perkakas dan rekayasa', 'only' => 'supporting-machines'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.tools-design-storage' => [
        'seo' => [
            'title' => 'Desain dan Penyimpanan Perkakas — UMI Stamping',
            'description' => 'Desain dan pembuatan cetakan internal dengan waktu pengerjaan singkat, produksi prototipe, serta penyimpanan perkakas yang tertata.',
        ],
        'hero' => [
            'eyebrow' => 'Fasilitas',
            'title' => 'Desain dan penyimpanan perkakas.',
            'lead' => 'Tim rekayasa kami merancang dan membuat die set secara lokal dengan waktu pengerjaan singkat; die set kelas atas didukung dari Singapura dan Malaysia.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Kapabilitas pembuatan perkakas', 'only' => 'tools-design-storage'],
            ['type' => 'cta'],
        ],
    ],

    'facilities.measurement-equipment' => [
        'seo' => [
            'title' => 'Peralatan Pengukuran — UMI Stamping',
            'description' => 'Pengukuran optik, profile projector dan high gauge Mitutoyo, pin dan block gauge, vernier caliper dan micrometer, dengan kalibrasi internal dan eksternal secara berkala.',
        ],
        'hero' => [
            'eyebrow' => 'Fasilitas',
            'title' => 'Peralatan pengukuran.',
            'lead' => 'Peralatan QA presisi tinggi menjaga komitmen bahwa hanya komponen bermutu tinggi yang dikirim; kalibrasi dilakukan secara internal dan eksternal.',
        ],
        'sections' => [
            ['type' => 'specs', 'heading' => 'Peralatan jaminan mutu', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'metal-part-users' => [
        'seo' => [
            'title' => 'Pengguna Komponen Logam Kami — UMI Stamping',
            'description' => 'Produsen di industri listrik, elektronik, dan otomotif yang dilayani dengan komponen logam UMI.',
        ],
        'hero' => [
            'eyebrow' => 'Pengguna komponen logam kami',
            'title' => 'Dipercaya oleh produsen terkemuka.',
            'lead' => 'UMI memasok komponen logam kepada produsen di industri listrik, elektronik, dan otomotif.',
        ],
        'sections' => [
            ['type' => 'users'],
            ['type' => 'testimonials'],
            ['type' => 'cta'],
        ],
    ],

    'industries' => [
        'seo' => [
            'title' => 'Industri — UMI Stamping',
            'description' => 'Solusi manufaktur untuk industri otomotif, elektronik, industri, dan konsumen.',
        ],
        'hero' => [
            'eyebrow' => 'Industri',
            'title' => 'Dirancang untuk industri dengan tuntutan tinggi.',
            'lead' => 'Solusi manufaktur yang dirancang sesuai persyaratan berbagai industri — dari otomotif hingga elektronik konsumen.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'Industri yang dilayani', 'source' => 'industries'],
            ['type' => 'users'],
            ['type' => 'cta'],
        ],
    ],

    'quality' => [
        'seo' => [
            'title' => 'Mutu — UMI Stamping',
            'description' => 'Mutu dibangun ke dalam proses, bukan sekadar diperiksa: prinsip, sertifikasi, dan peralatan pengukuran di UMI Stamping.',
        ],
        'hero' => [
            'eyebrow' => 'Jaminan mutu',
            'title' => 'Mutu dibangun ke dalam proses, bukan sekadar diperiksa.',
            'lead' => 'Kami meyakini konsep "mutu dibangun ke dalam proses, bukan melalui inspeksi" — namun peralatan QA presisi tinggi memastikan hanya komponen bermutu tinggi yang dikirim.',
        ],
        'sections' => [
            ['type' => 'cards', 'heading' => 'Prinsip mutu', 'source' => 'quality.principles'],
            ['type' => 'certifications'],
            ['type' => 'specs', 'heading' => 'Peralatan pengukuran', 'only' => 'measurement-equipment'],
            ['type' => 'cta'],
        ],
    ],

    'gallery' => [
        'seo' => [
            'title' => 'Galeri — UMI Stamping',
            'description' => 'Lingkungan manufaktur UMI, kapabilitas produksi, dan orang-orang di balik pekerjaan kami.',
        ],
        'hero' => [
            'eyebrow' => 'Galeri',
            'title' => 'Dibangun oleh manusia. Didukung oleh teknologi.',
            'lead' => 'Telusuri lingkungan manufaktur kami, kapabilitas produksi, dan orang-orang di balik pekerjaan kami.',
        ],
        'sections' => [
            ['type' => 'gallery'],
            ['type' => 'cta'],
        ],
    ],

    'news' => [
        'seo' => [
            'title' => 'Berita dan Informasi — UMI Stamping',
            'description' => 'Berita dan informasi dari PT. Uni-Metaltech Industry.',
        ],
        'hero' => [
            'eyebrow' => 'Berita dan informasi',
            'title' => 'Informasi terbaru dari UMI Stamping.',
            'lead' => 'Informasi perusahaan dari PT. Uni-Metaltech Industry.',
        ],
        'sections' => [
            ['type' => 'news'],
            ['type' => 'cta'],
        ],
    ],

    'contact' => [
        'seo' => [
            'title' => 'Kontak — UMI Stamping',
            'description' => 'Hubungi PT. Uni-Metaltech Industry: pabrik manufaktur Batam dan kantor perwakilan penjualan Jakarta, dengan telepon, faks, dan email.',
        ],
        'hero' => [
            'eyebrow' => 'Kontak',
            'title' => 'Ada komponen yang perlu diproduksi?',
            'lead' => 'Ceritakan kepada kami apa yang sedang Anda bangun. Tim rekayasa dan manufaktur kami dapat membantu mengubah persyaratan Anda menjadi solusi produksi yang andal.',
        ],
        'sections' => [],
    ],

    'privacy' => [
        'seo' => [
            'title' => 'Kebijakan Privasi — UMI Stamping',
            'description' => 'Bagaimana PT. Uni-Metaltech Industry mengumpulkan, menggunakan, dan melindungi informasi Anda.',
        ],
        'hero' => [
            'eyebrow' => 'Legal',
            'title' => 'Kebijakan privasi.',
            'lead' => 'Bagaimana PT. Uni-Metaltech Industry mengumpulkan, menggunakan, dan melindungi informasi Anda.',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => 'Informasi yang kami kumpulkan', 'body' => ['Ketika Anda menghubungi kami melalui situs web atau formulir permintaan kami, kami dapat mengumpulkan nama, nama perusahaan, alamat email, nomor telepon, dan rincian proyek yang Anda berikan secara sukarela. Informasi ini digunakan semata-mata untuk menjawab permintaan Anda dan menyediakan layanan manufaktur.']],
                    ['heading' => 'Penggunaan informasi', 'body' => ['Informasi Anda digunakan untuk memproses permintaan, menyiapkan penawaran harga, berkomunikasi mengenai proyek, dan menyediakan layanan manufaktur. Kami tidak menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak ketiga untuk tujuan pemasaran.']],
                    ['heading' => 'Keamanan data', 'body' => ['Kami menerapkan langkah teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda terhadap akses, perubahan, pengungkapan, atau pemusnahan yang tidak sah. Akses terhadap data pribadi dibatasi hanya pada personel yang berwenang.']],
                    ['heading' => 'Cookie', 'body' => ['Situs web kami dapat menggunakan cookie untuk meningkatkan pengalaman pengguna dan menganalisis lalu lintas situs web. Anda dapat mengendalikan cookie melalui pengaturan peramban Anda. Menonaktifkan cookie dapat memengaruhi sebagian fungsi situs web.']],
                    ['heading' => 'Tautan pihak ketiga', 'body' => ['Situs web kami dapat memuat tautan ke situs web pihak ketiga. Kami tidak bertanggung jawab atas praktik privasi atau konten situs eksternal tersebut. Kami menyarankan Anda meninjau kebijakan privasi setiap situs pihak ketiga yang Anda kunjungi.']],
                    ['heading' => 'Hubungi kami', 'body' => ['Apabila Anda memiliki pertanyaan mengenai Kebijakan Privasi ini, silakan menghubungi PT. Uni-Metaltech Industry (UMI Stamping), Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia. Telepon +62 778 464141. Email info@umistamping.com.']],
                ],
            ],
        ],
    ],

    'terms' => [
        'seo' => [
            'title' => 'Syarat Layanan — UMI Stamping',
            'description' => 'Syarat dan ketentuan yang mengatur penggunaan situs web UMI Stamping dan layanan manufaktur.',
        ],
        'hero' => [
            'eyebrow' => 'Legal',
            'title' => 'Syarat layanan.',
            'lead' => 'Syarat dan ketentuan yang mengatur penggunaan situs web dan layanan manufaktur kami.',
        ],
        'sections' => [
            [
                'type' => 'legal',
                'clauses' => [
                    ['heading' => 'Penerimaan syarat', 'body' => ['Dengan mengakses dan menggunakan situs web UMI Stamping, Anda menerima dan menyetujui untuk terikat pada Syarat Layanan ini. Apabila Anda tidak menyetujui syarat-syarat ini, mohon jangan menggunakan situs web kami.']],
                    ['heading' => 'Layanan', 'body' => ['PT. Uni-Metaltech Industry (UMI Stamping) menyediakan layanan stamping logam presisi, pembuatan perkakas, pengelasan, dan perakitan. Informasi pada situs web ini disediakan untuk tujuan informasi umum dan bukan merupakan penawaran atau kontrak untuk layanan.']],
                    ['heading' => 'Kekayaan intelektual', 'body' => ['Seluruh konten pada situs web ini, termasuk teks, grafik, logo, gambar, dan perangkat lunak, merupakan milik PT. Uni-Metaltech Industry dan dilindungi oleh hukum kekayaan intelektual. Anda tidak boleh menggandakan, mendistribusikan, atau menggunakan konten apa pun tanpa izin tertulis sebelumnya.']],
                    ['heading' => 'Penawaran harga dan pesanan', 'body' => ['Seluruh penawaran harga yang diberikan oleh UMI Stamping dapat berubah berdasarkan biaya material, revisi desain, dan jumlah pesanan. Pesanan diterima dengan tunduk pada syarat dan ketentuan penjualan standar kami, yang akan diberikan bersama penawaran harga resmi.']],
                    ['heading' => 'Pembatasan tanggung jawab', 'body' => ['UMI Stamping tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan situs web atau layanan kami. Total tanggung jawab kami dibatasi pada nilai layanan yang diberikan.']],
                    ['heading' => 'Hukum yang berlaku', 'body' => ['Syarat Layanan ini diatur oleh hukum Republik Indonesia. Setiap sengketa akan diselesaikan di pengadilan yang berwenang atas wilayah Batam, Indonesia.']],
                    ['heading' => 'Kontak', 'body' => ['Untuk pertanyaan mengenai Syarat Layanan ini, silakan menghubungi PT. Uni-Metaltech Industry (UMI Stamping), Kara Industrial Park Block - C 05 No. 01, Batam Center 29432, Indonesia. Telepon +62 778 464141. Email info@umistamping.com.']],
                ],
            ],
        ],
    ],

];
