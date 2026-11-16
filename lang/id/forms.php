<?php

/*
|--------------------------------------------------------------------------
| Formulir kontak (Indonesia) —
| UNREVIEWED id draft; NOT company-approved; not served until the company
| adds the locale code in config/locales.php; English source is
| authoritative.
|--------------------------------------------------------------------------
|
| Draft terjemahan tanpa tinjauan perusahaan. Struktur kunci identik dengan
| lang/en/forms.php; hanya nilai yang diterjemahkan. Alamat email, nomor
| telepon, dan 'PT. Uni-Metaltech Industry' dibiarkan apa adanya.
|
*/

return [

    'title' => 'Kirimkan detail proyek Anda kepada kami',
    'intro' => 'Bidang bertanda * wajib diisi.',

    'fields' => [
        'name' => 'Nama lengkap',
        'company' => 'Perusahaan',
        'email' => 'Email',
        'phone' => 'Telepon',
        'inquiry_type' => 'Jenis pertanyaan',
        'message' => 'Detail proyek',
    ],

    'placeholders' => [
        'name' => 'Budi Santoso',
        'company' => 'Nama perusahaan',
        'email' => 'john@company.com',
        'phone' => '+62 ...',
        'message' => 'Ceritakan tentang proyek Anda — material, jumlah, toleransi, tenggat waktu...',
    ],

    'inquiry_types' => [
        'new-project' => 'Proyek baru',
        'engineering' => 'Rekayasa',
        'partnership' => 'Kemitraan',
        'other' => 'Lainnya',
    ],

    'submit' => 'Kirim pertanyaan',
    'submitting' => 'Mengirim...',
    'success_title' => 'Terima kasih atas pertanyaan Anda',
    'success_body' => 'Pesan Anda telah tercatat dan tim kami akan menghubungi Anda segera.',
    'success_again' => 'Kirim pesan lain',

    'ack_subject' => 'Kami telah menerima pertanyaan Anda — PT. Uni-Metaltech Industry',
    'ack_body' => 'Terima kasih telah menghubungi PT. Uni-Metaltech Industry. Tim kami telah menerima pertanyaan Anda dan akan membalas secepatnya.',
    'internal_body' => 'Sebuah pertanyaan baru dikirim melalui situs web.',

    'errors' => [
        'title' => 'Mohon periksa formulir',
        'generic' => 'Pertanyaan tidak dapat dikirim. Silakan coba lagi.',
        'throttled' => 'Terlalu banyak pertanyaan dikirim dari koneksi ini. Silakan coba lagi dalam satu menit.',
    ],

    'consent' => 'Dengan mengirim pertanyaan ini, Anda menyetujui bahwa kami dapat menggunakan informasi yang diberikan untuk menanggapi permintaan Anda.',

];
