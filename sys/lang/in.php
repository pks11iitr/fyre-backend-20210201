<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();
	$SEX = array("Jantan" => 0, "Wanita" => 1);

    $LANG_CATEGORIES_ARRAY = array(
        "Phones, tablets and accessories", //Телефоны, планшеты и аксессуары
        "Cars, motorcycles and other vehicles", //Автомобили, мотоциклы и другой транспорт
        "Real estate", //Недвижимость
        "Clothing, Fashion and Style", //Одежда, мода и стиль
        "Pets", //Домашние животные
        "Computers, game consoles and accessories", //Компьютеры, игровые приставки и аксессуары
        "Cosmetics, perfumes and other health and beauty products", //Косметика, парфюмерия и прочии товары для красоты и здоровья
        "Furniture", //Мебель
        "Shoes", //Обувь
        "Tools and other household goods", //Инструменты и прочие товары для дома
        "Wristwatches", //Наручные часы
        "Business and services"); //Бизнес и услуги

    $TEXT['lang-code'] = "in";
    $TEXT['lang-name'] = "Indonesian";

    // For admin panel

    $TEXT['apanel-dashboard'] = "Dasbor";
    $TEXT['apanel-home'] = "Rumah";
    $TEXT['apanel-support'] = "Mendukung";
    $TEXT['apanel-settings'] = "Pengaturan";
    $TEXT['apanel-logout'] = "Logout";
    $TEXT['apanel-login'] = "Log In";
    $TEXT['apanel-market'] = "Pasar";
    $TEXT['apanel-reports'] = "Laporan";
    $TEXT['apanel-messages'] = "Pesan";
    $TEXT['apanel-chats'] = "Obrolan";
    $TEXT['apanel-chat'] = "Obrolan";
    $TEXT['apanel-items'] = "Item";
    $TEXT['apanel-users'] = "Pengguna";
    $TEXT['apanel-fcm'] = "Pemberitahuan Push";
    $TEXT['apanel-admob'] = "Admob";
    $TEXT['apanel-profile'] = "Profil";

    $TEXT['apanel-categories'] = "Kategori";
    $TEXT['apanel-subcategories'] = "Subkategori";
    $TEXT['apanel-category-new'] = "Buat Kategori";
    $TEXT['apanel-category-edit'] = "Edit Kategori";

    $TEXT['apanel-subcategory-new'] = "Buat Subkategori";
    $TEXT['apanel-subcategory-edit'] = "Edit Subkategori";

    $TEXT['apanel-label-category'] = "Kategori";
    $TEXT['apanel-label-subcategory'] = "Subkategori";
    $TEXT['apanel-label-categories'] = "Kategori";
    $TEXT['apanel-label-subcategories'] = "Subkategori";

    $TEXT['apanel-label-general'] = "Umum";
    $TEXT['apanel-label-stream'] = "Aliran";
    $TEXT['apanel-label-settings'] = "Pengaturan";

    $TEXT['apanel-placeholder-username'] = "Nama pengguna";
    $TEXT['apanel-placeholder-password'] = "Kata sandi";
    $TEXT['apanel-placeholder-search'] = "Masukkan teks";
    $TEXT['apanel-placeholder-category-title'] = "Masukkan nama kategori";

    $TEXT['apanel-action-login'] = "Log In";
    $TEXT['apanel-action-delete'] = "Menghapus";
    $TEXT['apanel-action-cancel'] = "Batalkan";
    $TEXT['apanel-action-approve'] = "Menyetujui";
    $TEXT['apanel-action-reject'] = "Tolak";
    $TEXT['apanel-action-view-more'] = "Lihat lebih";
    $TEXT['apanel-action-search'] = "Pencarian";
    $TEXT['apanel-action-view'] = "Lihat";
    $TEXT['apanel-action-send'] = "Mengirimkan";
    $TEXT['apanel-action-edit'] = "Edit";
    $TEXT['apanel-action-rename'] = "Ganti nama";
    $TEXT['apanel-action-save'] = "Simpan";
    $TEXT['apanel-action-add'] = "Menambahkan";
    $TEXT['apanel-action-create'] = "Menciptakan";
    $TEXT['apanel-action-close-all-auth'] = "Tutup semua otorisasi";
    $TEXT['apanel-action-verified-set'] = "Tetapkan akun sebagai terverifikasi";
    $TEXT['apanel-action-verified-unset'] = "unset diverifikasi";
    $TEXT['apanel-action-create-fcm'] = "Kirim Personal FCM Pesan";
    $TEXT['apanel-action-account-block'] = "Blokir akun";
    $TEXT['apanel-action-account-unblock'] = "Buka blokir akun";
    $TEXT['apanel-action-remove-connection'] = "Hapus koneksi";
    $TEXT['apanel-action-admob-on'] = "Nyalakan AdMob di akun ini";
    $TEXT['apanel-action-admob-off'] = "Matikan AdMob di akun ini";
    $TEXT['apanel-action-delete-photo'] = "Menghapus foto";
    $TEXT['apanel-action-delete-cover'] = "Hapus Sampul";

    $TEXT['apanel-auth-label-title'] = "Otorisasi";

    $TEXT['apanel-label-create-at'] = "Tanggal dibuat";
    $TEXT['apanel-label-close-at'] = "ditutup Tanggal";
    $TEXT['apanel-label-signup-at'] = "Tanggal Pendaftaran";
    $TEXT['apanel-label-app-type'] = "Jenis Aplikasi";

    $TEXT['apanel-label-account-edit'] = "Edit Profil";
    $TEXT['apanel-label-location'] = "Lokasi";
    $TEXT['apanel-label-balance'] = "Keseimbangan";
    $TEXT['apanel-label-fullname'] = "Nama lengkap";
    $TEXT['apanel-label-admob-state'] = "AdMob (on / off AdMob dalam akun)";
    $TEXT['apanel-label-admob-state-active'] = "Aktif (AdMob aktif di akun)";
    $TEXT['apanel-label-admob-state-inactive'] = "Off (AdMob tidak aktif di akun)";
    $TEXT['apanel-label-account-state'] = "Status akun";
    $TEXT['apanel-label-account-state-enabled'] = "Akun aktif";
    $TEXT['apanel-label-account-state-blocked'] = "Akun diblokir";
    $TEXT['apanel-label-account-state-disabled'] = "Akun dinonaktifkan oleh pengguna";
    $TEXT['apanel-label-account-state-verified'] = "Akun terverifikasi";
    $TEXT['apanel-label-account-verified'] = "Akun diverifikasi.";
    $TEXT['apanel-label-account-unverified'] = "Akun tidak diverifikasi.";
    $TEXT['apanel-label-account-facebook-connected'] = "Terhubung ke Facebook";
    $TEXT['apanel-label-connected'] = "Terhubung";
    $TEXT['apanel-label-not-connected'] = "Tidak terhubung";

    $TEXT['apanel-label-account-chats'] = "Obrolan aktif (tidak dihapus)";
    $TEXT['apanel-label-account-items'] = "Item (tidak dihapus)";
    $TEXT['apanel-label-account-reports'] = "Keluhan Profil";

    $TEXT['apanel-label-sort-type'] = "Menyortir";
    $TEXT['apanel-label-moderation-type'] = "Moderasi";
    $TEXT['apanel-label-active-type'] = "Aktif";
    $TEXT['apanel-label-category'] = "Kategori";
    $TEXT['apanel-label-search'] = "Pencarian";
    $TEXT['apanel-label-list-empty'] = "Daftar kosong.";
    $TEXT['apanel-label-list-empty-desc'] = "Ini berarti bahwa tidak ada data untuk ditampilkan :)";

    $TEXT['apanel-sort-type-new'] = "Dari yang baru ke yang lama";
    $TEXT['apanel-sort-type-old'] = "Dari yang lama ke yang baru";

    $TEXT['apanel-active-type-all'] = "Semua barang";
    $TEXT['apanel-active-type-active'] = "Hanya item yang aktif";

    $TEXT['apanel-moderation-type-all'] = "Semua barang";
    $TEXT['apanel-moderation-type-moderated'] = "Hanya item yang dimoderasi";
    $TEXT['apanel-moderation-type-unmoderated'] = "Hanya item yang tidak dimoderasi";

    $TEXT['apanel-report-type-item'] = "Keluhan terhadap unsur-unsur";
    $TEXT['apanel-report-type-profile'] = "Keluhan terhadap anggota";

    $TEXT['apanel-label-item-active'] = "Aktif";
    $TEXT['apanel-label-item-inactive'] = "Non-aktif";
    $TEXT['apanel-label-item-approved'] = "Disetujui";
    $TEXT['apanel-label-item-rejected'] = "Ditolak";

    $TEXT['apanel-label-name'] = "Nama";
    $TEXT['apanel-label-count'] = "Menghitung";
    $TEXT['apanel-label-value'] = "Nilai";

    $TEXT['apanel-label-error'] = "Error!";
    $TEXT['apanel-label-thanks'] = "Terima kasih!";

    $TEXT['apanel-settings-label-change-password'] = "Ganti kata sandi";
    $TEXT['apanel-settings-label-change-password-desc'] = "Masukkan kata sandi saat ini dan yang baru";
    $TEXT['apanel-settings-label-current-password'] = "kata sandi saat ini";
    $TEXT['apanel-settings-label-new-password'] = "kata sandi baru";

    $TEXT['apanel-settings-label-password-saved'] = "Kata sandi baru disimpan";
    $TEXT['apanel-settings-label-password-error'] = "sandi saat ini tidak valid atau salah memasukkan password baru";

    $TEXT['apanel-fcm-label-title'] = "Kirim Notifikasi Dorong";
    $TEXT['apanel-fcm-label-recently-title'] = "Baru-baru push-pesan";
    $TEXT['apanel-fcm-type-for-all'] = "Ini akan ditampilkan, bahkan jika pengguna tidak diotorisasi";
    $TEXT['apanel-fcm-type-for-authorized'] = "Hanya pengguna yang diotorisasi";
    $TEXT['apanel-fcm-type-for-all-users'] = "Untuk semua pengguna";
    $TEXT['apanel-fcm-type-for-authorized-users'] = "Hanya untuk pengguna yang diotorisasi";

    $TEXT['apanel-label-tickets'] = "Ticket";
    $TEXT['apanel-label-unknown'] = "Tidak dikenal";
    $TEXT['apanel-label-reports'] = "Keluhan";
    $TEXT['apanel-label-items'] = "Item";
    $TEXT['apanel-label-messages'] = "Pesan";
    $TEXT['apanel-label-chats'] = "Obrolan";

    $TEXT['apanel-label-img'] = "Gambar";
    $TEXT['apanel-label-abuse'] = "Penyalahgunaan";
    $TEXT['apanel-label-to-item'] = "Untuk Item";
    $TEXT['apanel-label-to'] = "Untuk";
    $TEXT['apanel-label-from'] = "Dari";
    $TEXT['apanel-label-subject'] = "Subyek";
    $TEXT['apanel-label-text'] = "Teks";
    $TEXT['apanel-label-date'] = "Tanggal";
    $TEXT['apanel-label-action'] = "Tindakan";
    $TEXT['apanel-label-warning'] = "Peringatan!";
    $TEXT['apanel-label-app-changes-effect-desc'] = "Dalam perubahan aplikasi akan berlaku selama otorisasi pengguna berikutnya.";
    $TEXT['apanel-label-demo-fcm-off-desc'] = "Mengirim pemberitahuan push (FCM) tidak tersedia dalam mode versi demo. Bahwa kami mematikan pengiriman pemberitahuan push (FCM) dalam mode versi demo untuk melindungi pengguna dari spam dan bahasa kotor.";
    $TEXT['apanel-label-type'] = "Mengetik";
    $TEXT['apanel-label-status'] = "Status";
    $TEXT['apanel-label-delivered'] = "Disampaikan";
    $TEXT['apanel-label-demo-mode'] = "Versi demo!";
    $TEXT['apanel-label-demo-mode-desc'] = "Peringatan! Diaktifkan mode versi demo! Perubahan yang Anda buat tidak akan disimpan.";

    $TEXT['apanel-label-total-accounts'] = "Total Akun";
    $TEXT['apanel-label-total-market-items'] = "Total Iklan Baris";
    $TEXT['apanel-label-total-chats'] = "Total Obrolan";
    $TEXT['apanel-label-total-messages'] = "Total Pesan";
    $TEXT['apanel-label-removed-chats'] = "Chatting dihapus";
    $TEXT['apanel-label-removed-messages'] = "Pesan yang Dihapus";
    $TEXT['apanel-label-active-chats'] = "Chatting aktif";
    $TEXT['apanel-label-active-messages'] = "Pesan Aktif";

    $TEXT['apanel-label-stats-total-items'] = "Total";
    $TEXT['apanel-label-stats-approved-items'] = "Disetujui";
    $TEXT['apanel-label-stats-rejected-items'] = "Ditolak";
    $TEXT['apanel-label-stats-active-items'] = "Aktif";
    $TEXT['apanel-label-stats-inactive-items'] = "Non-aktif";
    $TEXT['apanel-label-stats-removed-items'] = "Dihapus";
    $TEXT['apanel-label-stats-unmoderated-items'] = "Perlu moderasi";
    $TEXT['apanel-label-stats-blocked-items'] = "Dicekal";

    $TEXT['apanel-label-stats-active-items-reports'] = "Keluhan terhadap unsur-unsur";
    $TEXT['apanel-label-stats-active-profiles-reports'] = "Keluhan terhadap anggota";
    $TEXT['apanel-label-stats-active-support-items'] = "Tiket pendukung";
    $TEXT['apanel-label-stats-active-likes'] = "Item dalam favorit";

    $TEXT['apanel-label-stats-market'] = "Iklan baris";
    $TEXT['apanel-label-stats-messages'] = "Pesan dan Obrolan";
    $TEXT['apanel-label-stats-accounts'] = "Akun";
    $TEXT['apanel-label-stats-reports'] = "Keluhan";
    $TEXT['apanel-label-stats-support'] = "Mendukung";
    $TEXT['apanel-label-stats-other'] = "Lain";
    $TEXT['apanel-label-stats-recently-profiles-list'] = "Para pengguna baru terdaftar";
    $TEXT['apanel-label-stats-recently-profiles-list-desc'] = "Klik pada Profil untuk melihat detail";

    $TEXT['apanel-label-stats-profile-chats'] = "Obrolan Aktif Pengguna";
    $TEXT['apanel-label-stats-profile-chats-desc'] = "Klik pada Obrolan untuk melihat pesan";

    $TEXT['apanel-label-stats-profile-reports'] = "Keluhan aktif";
    $TEXT['apanel-label-stats-profile-items'] = "Semua item Profil";

    $TEXT['apanel-action-admob-action-off-for-new-users'] = "Matikan AdMob untuk pengguna baru";
    $TEXT['apanel-action-admob-action-on-for-new-users'] = "Nyalakan AdMob untuk pengguna baru";
    $TEXT['apanel-action-admob-action-off-for-all-users'] = "Matikan AdMob di semua akun";
    $TEXT['apanel-action-admob-action-on-for-all-users'] = "Nyalakan AdMob di semua akun";

    $TEXT['apanel-label-admob-active-accounts'] = "AdMob aktif di akun (Aktif)";
    $TEXT['apanel-label-admob-inactive-accounts'] = "Account menghitung dengan AdMob dinonaktifkan (Off)";
    $TEXT['apanel-label-admob-default-for-new-accounts'] = "Nilai AdMob default untuk pengguna baru";

    $TEXT['apanel-delete-dialog-title'] = "Menghapus";
    $TEXT['apanel-delete-dialog-header'] = "Apakah Anda benar-benar ingin menghapusnya?";
    $TEXT['apanel-delete-category-dialog-sub-header'] = "Jika Anda menghapus kategori, semua subkategori akan dihapus dan semua item yang termasuk dalam kategori ini dan subkategori akan memiliki nilai default 0 (bidang kategori dan subkategori dalam tabel db)";
    $TEXT['apanel-delete-subcategory-dialog-sub-header'] = "Jika Anda menghapus subkategori, semua item yang termasuk dalam subkategori ini akan memiliki nilai default 0 (bidang subkategori dalam tabel db)";

    $TEXT['apanel-label-moderation'] = "Moderasi";
    $TEXT['apanel-label-moderation-photos'] = "Foto profil";
    $TEXT['apanel-label-moderation-covers'] = "Profil penutup";

    // For Web site

    $TEXT['topbar-users'] = "Pengguna";

    $TEXT['topbar-stats'] = "Statistik";

    $TEXT['topbar-signin'] = "Masuk";

    $TEXT['topbar-logout'] = "Logout";

    $TEXT['topbar-signup'] = "Mendaftar";


    $TEXT['topbar-settings'] = "Pengaturan";

    $TEXT['topbar-messages'] = "Pesan";

    $TEXT['topbar-support'] = "Mendukung";

    $TEXT['topbar-profile'] = "Profil";

    $TEXT['topbar-likes'] = "Notifikasi";

    $TEXT['topbar-notifications'] = "Notifikasi";

    $TEXT['topbar-search'] = "Pencarian";

    $TEXT['topbar-main-page'] = "Halaman Utama";

    $TEXT['topbar-wall'] = "Utama";

    $TEXT['topbar-messages'] = "Pesan";


    $TEXT['footer-about'] = "tentang";

    $TEXT['footer-terms'] = "aturannya";

    $TEXT['footer-contact'] = "hubungi kami";

    $TEXT['footer-support'] = "mendukung";

    $TEXT['footer-android-application'] = "Android app";

    $TEXT['page-main'] = "Utama";

    $TEXT['page-ad'] = "Iklan";

    $TEXT['page-users'] = "Pengguna";

    $TEXT['page-terms'] = "Ketentuan dan Kebijakan";

    $TEXT['page-about'] = "Tentang";

    $TEXT['page-language'] = "Pilih bahasamu";

    $TEXT['page-support'] = "Mendukung";

    $TEXT['page-restore'] = "Pemulihan kata sandi";

    $TEXT['page-restore-sub-title'] = "Silakan masukkan email yang ditentukan saat pendaftaran";

    $TEXT['page-signup'] = "membuat akun";

    $TEXT['page-login'] = "Masuk";

    $TEXT['page-blacklist'] = "Daftar hitam";

    $TEXT['page-messages'] = "Pesan";



    $TEXT['page-search'] = "Pencarian";

    $TEXT['page-profile-report'] = "Keluhan";

    $TEXT['page-profile-block'] = "Blok";

    $TEXT['page-profile-upload-avatar'] = "Mengunggah foto";

    $TEXT['page-profile-upload-cover'] = "Unggah sampul";

    $TEXT['page-profile-report-sub-title'] = "Profil yang dilaporkan dikirim ke moderator kami untuk ditinjau. Mereka akan melarang profil yang dilaporkan jika mereka melanggar ketentuan penggunaan";

    $TEXT['page-profile-block-sub-title'] = "tidak akan dapat menulis komentar ke Item Anda dan mengirim pesan Anda, dan Anda tidak akan melihat pemberitahuan dari";



    $TEXT['page-likes'] = "Orang yang suka ini";

    $TEXT['page-services'] = "Jasa";

    $TEXT['page-services-sub-title'] = "Hubungkan Marketplace dengan akun jejaring sosial Anda";

    $TEXT['page-prompt'] = "buat akun atau login";

    $TEXT['page-settings'] = "Pengaturan";

    $TEXT['page-profile-settings'] = "Profil";

    $TEXT['page-profile-password'] = "Ganti kata sandi";

    $TEXT['page-notifications-likes'] = "Notifikasi";

    $TEXT['page-profile-deactivation'] = "Nonaktifkan akun";

    $TEXT['page-profile-deactivation-sub-title'] = "Leaving us?<br>All your Items will be deleted!<br>If you proceed with deactivating your account, you can always come back. Just enter your login and password on the log-in page. We hope to see you again!";

    $TEXT['page-error-404'] = "Halaman tidak ditemukan";

    $TEXT['label-location'] = "Lokasi";
    $TEXT['label-facebook-link'] = "Halaman Facebook";
    $TEXT['label-instagram-link'] = "Halaman Instagram";
    $TEXT['label-status'] = "Bio";

    $TEXT['label-error-404'] = "Halaman yang diminta tidak ditemukan.";

    $TEXT['label-account-disabled'] = "Pengguna ini telah menonaktifkan akunnya.";

    $TEXT['label-account-blocked'] = "Akun ini telah diblokir oleh administrator.";

    $TEXT['label-account-deactivated'] = "Akun ini tidak diaktifkan.";

    $TEXT['label-reposition-cover'] = "Seret ke Sampul Reposisi";

    $TEXT['label-or'] = "atau";

    $TEXT['label-and'] = "dan";

    $TEXT['label-signup-confirm'] = "Dengan mengklik Daftar, Anda setuju dengan";



    $TEXT['label-empty-page'] = "Di sini kosong.";

    $TEXT['label-empty-friends-header'] = "Anda tidak punya teman.";

    $TEXT['label-empty-likes-header'] = "Anda tidak memiliki notifikasi.";

    $TEXT['label-empty-list'] = "Daftar kosong.";

    $TEXT['label-empty-feeds'] = "Di sini Anda akan melihat pembaruan teman-teman Anda.";

    $TEXT['label-search-result'] = "Hasil Pencarian";

    $TEXT['label-search-empty'] = "Tidak ada yang ditemukan.";

    $TEXT['label-search-prompt'] = "Temukan item berdasarkan judul, teks, atau lokasi.";

    $TEXT['label-who-us'] = "Lihat siapa yang bersama kami";

    $TEXT['label-thanks'] = "Hore!";





    $TEXT['label-messages-privacy'] = "Pengaturan privasi untuk pesan";

    $TEXT['label-messages-allow'] = "Terima pesan dari siapa pun.";

    $TEXT['label-messages-allow-desc'] = "Anda akan dapat menerima pesan dari pengguna mana pun";

    $TEXT['label-settings-saved'] = "Pengaturan disimpan.";

    $TEXT['label-password-saved'] = "Kata sandi berhasil diubah.";

    $TEXT['label-profile-settings-links'] = "Dan juga Anda bisa";

    $TEXT['label-photo'] = "Foto";

    $TEXT['label-background'] = "Latar Belakang";

    $TEXT['label-username'] = "Nama pengguna";

    $TEXT['label-fullname'] = "Nama lengkap";

    $TEXT['label-services'] = "Jasa";

    $TEXT['label-blacklist'] = "Daftar hitam";

    $TEXT['label-blacklist-desc'] = "Lihat daftar hitam";

    $TEXT['label-profile'] = "Profil";

    $TEXT['label-email'] = "Email";

    $TEXT['label-password'] = "Kata sandi";

    $TEXT['label-old-password'] = "Kata sandi saat ini";

    $TEXT['label-new-password'] = "Kata sandi baru";

    $TEXT['label-change-password'] = "Ganti kata sandi";

    $TEXT['label-facebook'] = "Facebook";

    $TEXT['label-placeholder-message'] = "Menulis pesan...";

    $TEXT['label-img-format'] = "Ukuran maksimum 3 Mb. JPG, PNG";

    $TEXT['label-message'] = "Pesan";

    $TEXT['label-subject'] = "Subyek";

    $TEXT['label-support-message'] = "Tentang apa Anda menghubungi kami?";

    $TEXT['label-support-sub-title'] = "Kami senang mendengar dari Anda!";

    $TEXT['label-profile-reported'] = "Profil dilaporkan!";

    $TEXT['label-profile-report-reason-1'] = "Ini adalah spam";

    $TEXT['label-profile-report-reason-2'] = "Benci Ucapan atau kekerasan";

    $TEXT['label-profile-report-reason-3'] = "Ketelanjangan atau Pornografi";

    $TEXT['label-profile-report-reason-4'] = "Profil palsu";

    $TEXT['label-profile-report-reason-5'] = "Pembajakan";

    $TEXT['label-success'] = "Keberhasilan";

    $TEXT['label-password-reset-success'] = "Kata sandi baru telah berhasil dipasang!";

    $TEXT['label-verify'] = "memverifikasi";

    $TEXT['label-account-verified'] = "Akun terverifikasi";

    $TEXT['label-true'] = "sejati";

    $TEXT['label-false'] = "palsu";

    $TEXT['label-state'] = "status akun";

    $TEXT['label-stats'] = "Statistik";

    $TEXT['label-id'] = "Id";

    $TEXT['label-count'] = "Hitungan";

    $TEXT['label-repeat-password'] = "ulangi kata sandi";

    $TEXT['label-category'] = "Kategori";

    $TEXT['label-from-user'] = "dari";

    $TEXT['label-to-user'] = "ke";

    $TEXT['label-reason'] = "Alasan";

    $TEXT['label-action'] = "Tindakan";

    $TEXT['label-warning'] = "Peringatan!";

    $TEXT['label-connected-with-facebook'] = "Terhubung dengan Facebook";

    $TEXT['label-authorization-with-facebook'] = "Otorisasi melalui Facebook.";

    $TEXT['label-services-facebook-connected'] = "Anda telah berhasil ditautkan dengan akun Anda di Facebook!";

    $TEXT['label-services-facebook-disconnected'] = "Koneksi dengan akun Facebook Anda dihapus.";

    $TEXT['label-services-facebook-error'] = "Akun Anda di Facebook sudah dikaitkan dengan akun lain.";

    $TEXT['action-login-with'] = "Login dengan";

    $TEXT['action-signup-with'] = "Mendaftar dengan";
    $TEXT['action-delete-profile-photo'] = "Hapus foto";
    $TEXT['action-delete-profile-cover'] = "Hapus gambar sampul";
    $TEXT['action-change-photo'] = "Ubah foto";
    $TEXT['action-change-password'] = "Ganti kata sandi";

    $TEXT['action-more'] = "Lihat lebih";

    $TEXT['action-next'] = "Berikutnya";

    $TEXT['action-add-img'] = "Tambahkan gambar";

    $TEXT['action-remove-img'] = "Hapus gambar";

    $TEXT['action-close'] = "Dekat";

    $TEXT['action-go-to-conversation'] = "Pergi ke percakapan";

    $TEXT['action-post'] = "Pos";

    $TEXT['action-remove'] = "Menghapus";

    $TEXT['action-report'] = "Melaporkan";

    $TEXT['action-block'] = "Blokir";

    $TEXT['action-unblock'] = "Buka kunci";

    $TEXT['action-send-message'] = "Pesan";

    $TEXT['action-change-cover'] = "Perubahan tutupan";

    $TEXT['action-change'] = "Perubahan";

    $TEXT['action-change-image'] = "Ganti gambar";

    $TEXT['action-edit-profile'] = "Edit profil";

    $TEXT['action-edit'] = "Edit";

    $TEXT['action-restore'] = "Kembalikan";

    $TEXT['action-accept'] = "Terima";

    $TEXT['action-reject'] = "Tolak";

    $TEXT['label-question-removed'] = "Pertanyaan telah dihapus.";

    $TEXT['action-deactivation-profile'] = "Nonaktifkan akun";

    $TEXT['action-connect-profile'] = "Terhubung dengan akun jejaring sosial";

    $TEXT['action-connect-facebook'] = "Terhubung dengan Facebook";

    $TEXT['action-disconnect'] = "Hapus koneksi";

    $TEXT['action-back-to-default-signup'] = "Kembali ke formulir pendaftaran reguler";

    $TEXT['action-back-to-main-page'] = "Kembali ke halaman utama";

    $TEXT['action-back-to-previous-page'] = "Kembali ke halaman sebelumnya";

    $TEXT['action-forgot-password'] = "Lupa kata sandi atau nama pengguna Anda?";

    $TEXT['action-full-profile'] = "Lihat profil lengkap..";

    $TEXT['action-delete-image'] = "Hapus gambar tulisan";

    $TEXT['action-send'] = "Mengirim";

    $TEXT['action-cancel'] = "Membatalkan";

    $TEXT['action-upload'] = "Upload";

    $TEXT['action-search'] = "Pencarian";

    $TEXT['action-change'] = "Perubahan";

    $TEXT['action-save'] = "Menyimpan";

    $TEXT['action-login'] = "Masuk";

    $TEXT['action-signup'] = "Mendaftar";

    $TEXT['action-join'] = "BERGABUNG SEKARANG!";
//    $TEXT['action-join'] = "Регистрация";

    $TEXT['action-forgot-password'] = "Lupa kata sandi?";

    $TEXT['msg-loading'] = "Pemuatan...";



    $TEXT['msg-login-taken'] = "Pengguna dengan nama pengguna itu sudah ada.";

    $TEXT['msg-login-incorrect'] = "Format nama pengguna salah.";

    $TEXT['msg-fullname-incorrect'] = "Format nama lengkap salah.";

    $TEXT['msg-password-incorrect'] = "Format kata sandi salah.";

    $TEXT['msg-password-save-error'] = "Kata sandi tidak diubah, salah kata sandi saat ini.";

    $TEXT['msg-email-incorrect'] = "Format email salah.";

    $TEXT['msg-email-taken'] = "Pengguna dengan alamat email ini sudah terdaftar.";

    $TEXT['msg-email-not-found'] = "Pengguna dengan email ini tidak ditemukan dalam database.";

    $TEXT['msg-reset-password-sent'] = "Pesan dengan tautan untuk mengatur ulang kata sandi Anda telah dikirim ke email Anda.";

    $TEXT['msg-error-unknown'] = "Kesalahan. Coba lagi nanti.";

    $TEXT['msg-error-authorize'] = "Username atau kata sandi salah.";

    $TEXT['msg-error-deactivation'] = "Kata sandi salah.";

    $TEXT['placeholder-users-search'] = "Temukan pengguna. Minimal 5 karakter.";

	$TEXT['ticket-send-success'] = 'Dalam waktu singkat kami akan meninjau permintaan Anda dan mengirim respons ke email Anda.';

	$TEXT['ticket-send-error'] = 'Silakan isi semua kolom.';



    $TEXT['action-show-all'] = "Tunjukkan semua";


    $TEXT['label-image-upload-description'] = "Kami mendukung file JPG, PNG, atau GIF.";

    $TEXT['action-select-file-and-upload'] = "Pilih file dan upload";

    $TEXT['fb-linking'] = "Terhubung dengan Facebook";


    $TEXT['label-gender'] = "Jenis kelamin";
    $TEXT['label-birth-date'] = "Tanggal lahir";
    $TEXT['label-join-date'] = "Tanggal Bergabung";

    $TEXT['gender-unknown'] = "Jenis Kelamin Tidak Diketahui";
    $TEXT['gender-male'] = "Jenis Kelamin Pria";
    $TEXT['gender-female'] = "Jenis kelamin perempuan";

    $TEXT['month-jan'] = "Januari";
    $TEXT['month-feb'] = "Februari";
    $TEXT['month-mar'] = "Maret";
    $TEXT['month-apr'] = "April";
    $TEXT['month-may'] = "Mei";
    $TEXT['month-june'] = "Juni";
    $TEXT['month-july'] = "Juli";
    $TEXT['month-aug'] = "Agustus";
    $TEXT['month-sept'] = "September";
    $TEXT['month-oct'] = "Oktober";
    $TEXT['month-nov'] = "November";
    $TEXT['month-dec'] = "Desember";

    $TEXT['topbar-stream'] = "Barang Terbaru";
    $TEXT['page-categories'] = "Kategori";
    $TEXT['topbar-categories'] = "Kategori";
    $TEXT['page-favorites'] = "Favorit";
    $TEXT['topbar-favorites'] = "Favorit";

    $TEXT['msg-added-to-favorites'] = "Ditambahkan ke Favorit.";
    $TEXT['msg-removed-from-favorites'] = "Dihapus dari favorit Anda.";

    $TEXT['page-create-item'] = "Buat Item Baru";
    $TEXT['page-edit-item'] = "Edit Item";
    $TEXT['page-view-item'] = "View item";

    $TEXT['action-create'] = "Menciptakan";

    $TEXT['label-title'] = "Judul";
    $TEXT['label-category'] = "Kategori";
    $TEXT['label-category-choose'] = "Pilih Kategori";
    $TEXT['label-subcategory-choose'] = "Pilih subkategori";
    $TEXT['label-price'] = "Harga";
    $TEXT['label-description'] = "Deskripsi";
    $TEXT['label-description-placeholder'] = "Deskripsi untuk Item";
    $TEXT['label-image'] = "Gambar";
    $TEXT['label-image-placeholder'] = "Gambar untuk Item";
    $TEXT['label-allow-comments'] = "Mengizinkan komentar untuk Item ini";

    $TEXT['label-items'] = "Item";
    $TEXT['label-phone'] = "Nomor Ponsel, contoh: +15417543010";
    $TEXT['msg-phone-incorrect'] = "Format telepon salah.";
    $TEXT['msg-phone-taken'] = "Seorang pengguna dengan nomor ponsel ini sudah terdaftar.";

    $TEXT['msg-item-removed'] = "Barang dihapus.";
    $TEXT['msg-item-reported'] = "Item dilaporkan.";

    $TEXT['notify-comment'] = "menambahkan komentar baru ke item Anda.";
    $TEXT['notify-comment-reply'] = "membalas komentar Anda.";

    $TEXT['label-placeholder-comment'] = "Tulis komen...";
    $TEXT['label-placeholder-comments'] = "Komentar";

    $TEXT['label-currency'] = "$";


    // new engine

    $TEXT['main-page-browser-title'] = "Situs web iklan baris untuk membeli dan menjual barang/barang bekas";

    $TEXT['action-continue'] = "Terus";

    $TEXT['label-ad-title'] = "Judul Iklan";
    $TEXT['label-ad-category'] = "Kategori";
    $TEXT['label-ad-subcategory'] = "Subkategori";
    $TEXT['label-ad-currency'] = "Mata uang";
    $TEXT['label-ad-price'] = "Harga";
    $TEXT['label-ad-description'] = "Deskripsi";
    $TEXT['label-ad-photos'] = "Foto";
    $TEXT['label-ad-phone'] = "Nomor telepon";
    $TEXT['label-ad-location'] = "Lokasi";

    $TEXT['label-ad-sub-title'] = "dari 5 hingga 70 karakter";
    $TEXT['label-ad-sub-price'] = "seharusnya tidak 0";
    $TEXT['label-ad-sub-description'] = "dari 10 hingga 500 karakter";
    $TEXT['label-ad-sub-photos'] = "setidaknya satu foto. hingga 5 foto. format: jpg, jpeg";
    $TEXT['label-ad-sub-phone'] = "contoh: +14567189456";
    $TEXT['label-ad-sub-location'] = "Seret penanda atau klik dua kali pada lokasi yang diinginkan.";

    $TEXT['placeholder-ad-title'] = "Masukkan judul untuk produk, objek, atau layanan Anda";
    $TEXT['placeholder-ad-description'] = "Tambahkan deskripsi untuk produk / layanan Anda, tentukan manfaat dan detail penting";
    $TEXT['placeholder-ad-phone'] = "Masukkan nomor telepon Anda";

    $TEXT['page-edit-ad-title'] = "Edit diklasifikasikan";
    $TEXT['page-new-ad-title'] = "Buat diklasifikasikan";
    $TEXT['action-new-ad'] = "Menciptakan";

    $TEXT['msg-error-ad-title'] = "Masukkan judul iklan";
    $TEXT['msg-error-ad-category'] = "Pilih kategori untuk produk Anda.";
    $TEXT['msg-error-ad-subcategory'] = "Pilih subkategori untuk produk Anda.";
    $TEXT['msg-error-ad-currency'] = "Pilih mata uang";
    $TEXT['msg-error-ad-price'] = "Masukkan harga";
    $TEXT['msg-error-ad-description'] = "Buat deskripsi untuk produk Anda.";
    $TEXT['msg-error-ad-photos'] = "Anda perlu menambahkan foto / gambar";
    $TEXT['msg-error-ad-phone'] = "Masukkan nomor telepon Anda";
    $TEXT['msg-error-ad-phone-incorrect'] = "Format nomor telepon tidak valid";
    $TEXT['msg-error-ad-length-title'] = "setidaknya 5 karakter";
    $TEXT['msg-error-ad-length-description'] = "setidaknya 10 karakter";

    // Restore send

    $TEXT['label-restore-sent-title'] = "Email pengaturan ulang kata sandi telah dikirim";
    $TEXT['label-restore-sent-msg'] = "Email telah dikirimkan kepada Anda dengan instruksi untuk mengubah kata sandi Anda.";

    // Restore success

    $TEXT['label-restore-success-title'] = "Pemulihan kata sandi";
    $TEXT['label-restore-success-msg'] = "Selamat! Anda telah berhasil menetapkan kata sandi baru!";

    // Restore new

    $TEXT['label-restore-new-title'] = "Buat kata sandi baru";
    $TEXT['label-restore-new-invalid-password-error-msg'] = "Format kata sandi tidak valid";
    $TEXT['label-restore-new-match-passwords-error-msg'] = "Sandi tidak cocok";

    // Login page

    $TEXT['label-signup-promo'] = "Tidak terdaftar? Bergabung sekarang!";
    $TEXT['label-remember'] = "Ingat saya";

    $TEXT['label-login-empty-field'] = "Bidang ini tidak boleh kosong";

    // Signup page

    $TEXT['label-login-promo'] = "Apakah kamu punya akun? Masuk";
    $TEXT['label-terms-start'] = "Dengan mengklik tombol Daftar, Anda mengonfirmasi bahwa Anda telah membaca";
    $TEXT['label-terms-link'] = "Syarat Penggunaan";
    $TEXT['label-terms-and'] = "dan";
    $TEXT['label-terms-privacy-link'] = "Kebijakan privasi";
    $TEXT['label-terms-cookies-link'] = "Penggunaan cookie";

    $TEXT['label-signup-sex'] = "Seks";

    $TEXT['label-signup-tooltip-username'] = "Ini adalah info masuk Anda. Digunakan untuk otorisasi dan sebagai nama untuk halaman profil Anda. Hanya huruf dan angka dalam bahasa Inggris. Setidaknya 5 karakter";
    $TEXT['label-signup-tooltip-fullname'] = "nama asli Anda dan nama keluarga. Misalnya: ditampilkan di halaman profil Anda dan di pesan. Setidaknya 2 karakter";
    $TEXT['label-signup-tooltip-password'] = "Kata sandi untuk akun Anda. Setidaknya 6 karakter";
    $TEXT['label-signup-tooltip-email'] = "Email yang valid Anda. Digunakan untuk memulihkan kata sandi Anda dan menghubungi Anda (jika perlu). Kami tidak mengirim email promosi dan spam!";
    $TEXT['label-signup-tooltip-sex'] = "Tentukan jenis kelamin Anda. Ini akan membuat profil Anda lebih lengkap dan informatif.";

    $TEXT['label-signup-placeholder-username'] = "Login Anda";
    $TEXT['label-signup-placeholder-fullname'] = "Siapa namamu?";
    $TEXT['label-signup-placeholder-password'] = "Masukkan kata sandi Anda";
    $TEXT['label-signup-placeholder-email'] = "Alamat email";

    $TEXT['label-signup-error-username'] = "Format yang tidak valid. Hanya karakter dan angka bahasa Inggris. Setidaknya 5 karakter";
    $TEXT['label-signup-error-fullname'] = "Format yang tidak valid. Setidaknya 2 karakter";
    $TEXT['label-signup-error-password'] = "Format yang tidak valid. Huruf dan angka bahasa Inggris. Setidaknya 6 karakter";
    $TEXT['label-signup-error-email'] = "Format yang tidak valid";

    // Footer

    $TEXT['label-footer-about'] = "Tentang";
    $TEXT['label-footer-terms'] = "Syarat Penggunaan";
    $TEXT['label-footer-privacy'] = "Kebijakan privasi";
    $TEXT['label-footer-cookies'] = "Penggunaan cookie";
    $TEXT['label-footer-help'] = "Membantu";
    $TEXT['label-footer-support'] = "Mendukung";

    // Topbar

    $TEXT['label-topbar-home'] = "Rumah";
    $TEXT['label-topbar-main'] = "Utama";
    $TEXT['label-topbar-messages'] = "Pesan";
    $TEXT['label-topbar-notifications'] = "Notifikasi";
    $TEXT['label-topbar-help'] = "Mendukung";
    $TEXT['label-topbar-search'] = "Pencarian";
    $TEXT['label-topbar-favorites'] = "Favorit";

    // Actions

    $TEXT['action-favorites-promo-button'] = "Cari sekarang!";
    $TEXT['action-new-classified'] = "Tambahkan yang diklasifikasikan";
    $TEXT['action-see-classified'] = "Lihat diklasifikasikan";
    $TEXT['action-find'] = "Pencarian";
    $TEXT['action-see-all'] = "Lihat semua";
    $TEXT['action-show'] = "Menunjukkan";
    $TEXT['action-yes'] = "Ya";
    $TEXT['action-no'] = "Tak";
    $TEXT['action-sold'] = "Terjual";
    $TEXT['action-remove-forever'] = "Hapus selamanya";
    $TEXT['action-item-inactivate'] = "Jadikan tidak aktif";
    $TEXT['action-item-activate'] = "Membuat aktif";
    $TEXT['action-show-map'] = "Tampilkan di peta";

    // Error messages

    $TEXT['msg-photo-file-size-exceeded'] = "Ukuran file terlampaui";
    $TEXT['msg-photo-file-size-error'] = "Ukuran file terlalu besar";
    $TEXT['msg-photo-format-error'] = "Format file gambar tidak valid";
    $TEXT['msg-photo-width-height-error'] = "Tinggi dan lebar harus lebih dari 300 piksel";
    $TEXT['msg-photo-file-upload-limit'] = "batas file melebihi untuk upload";
    $TEXT['msg-empty-fields'] = "Semua bidang yang diperlukan";
    $TEXT['msg-ad-published'] = "Iklan baris berhasil diterbitkan.";
    $TEXT['msg-ad-saved'] = "Perubahan berhasil disimpan";
    $TEXT['msg-selected-location-error'] = "Lokasi tidak ditentukan atau pemilihan lokasi salah";
    $TEXT['msg-contact-promo'] = "Ingin menghubungi %s? Bergabung sekarang!";
    $TEXT['msg-publish-ad-promo'] = "Posting iklan baris pertama Anda!";
    $TEXT['msg-empty-profile-items'] = "Tidak ada iklan baris.";
    $TEXT['msg-search-empty'] = "Tidak ditemukan hasil untuk permintaan Anda :(";
    $TEXT['msg-search-success'] = "Ditemukan %d iklan baris";
    $TEXT['msg-search-all'] = "Ditemukan %d iklan baris";
    $TEXT['msg-confirm-delete'] = "Anda yakin ingin menghapusnya?";
    $TEXT['msg-feature-disabled'] = "Fitur ini saat ini dinonaktifkan oleh administrator. Maaf atas ketidaknyamanan sementara. Silakan coba lagi nanti.";
    $TEXT['msg-block-user-text'] = "Pengguna %s akan ditambahkan ke daftar hitam Anda. Anda tidak akan menerima pesan pribadi dan pemberitahuan lainnya dari %s. Apakah Anda mengonfirmasi tindakan Anda?";
    $TEXT['msg-unblock-user-text'] = "Pengguna %s akan dihapus dari daftar hitam Anda. Apakah Anda mengonfirmasi tindakan Anda?";
    $TEXT['msg-unblock-user-text-2'] = "Pengguna akan dihapus dari daftar hitam Anda. Apakah Anda mengonfirmasi tindakan Anda?";
    $TEXT['msg-item-success-removed'] = "Iklan Anda telah berhasil dihapus";
    $TEXT['msg-item-success-inactivated'] = "Iklan baris Anda telah berhasil dinonaktifkan";
    $TEXT['msg-favorites-added'] = "Ditambahkan ke favorit";
    $TEXT['msg-favorites-removed'] = "Dihapus dari favorit Anda";

    $TEXT['msg-item-not-active'] = "Iklan Baris tidak aktif.";
    $TEXT['msg-item-make-active-promo'] = "Untuk mengaktifkan iklan ini - Anda harus mengeditnya.";
    $TEXT['msg-item-make-active-description'] = "Silakan membuat iklan yang benar. Masukkan judul, kategori, deskripsi, dan gambar yang benar.";

    $TEXT['msg-confirm-inactive-title'] = "Iklan baris akan ditandai sebagai \"Tidak Aktif\". Iklan baris tidak akan muncul dalam pencarian dan di profil Anda. Nomor telepon Anda akan disembunyikan dalam iklan baris.";
    $TEXT['msg-confirm-inactive-hint'] = "Anda akan dapat menghapus, mengedit dan membuat aktif diklasifikasikan ini lagi setiap saat.";
    $TEXT['msg-confirm-inactive-subtitle'] = "Anda yakin ingin melakukannya?";

    // Info messages

    $TEXT['page-notifications-empty-list'] = "Anda tidak memiliki notifikasi baru";
    $TEXT['page-messages-empty-list'] = "Anda belum memiliki percakapan";
    $TEXT['page-classifieds-items-empty-list'] = "Anda tidak memiliki iklan baris aktif";
    $TEXT['page-empty-list'] = "Daftar kosong";
    $TEXT['page-blacklist-empty-list'] = "Anda tidak memiliki pengguna di daftar hitam Anda";
    $TEXT['page-favorites-empty-list'] = "Anda belum menambahkan apa pun ke favorit Anda";

    // Item View

    $TEXT['page-item-view-title'] = "Iklan Baris";
    $TEXT['msg-item-not-found'] = "Iklan baris ini tidak ada atau sudah dihapus.";

    // Pages

    $TEXT['page-about'] = "Tentang";
    $TEXT['page-terms'] = "Syarat Penggunaan";
    $TEXT['page-privacy'] = "Kebijakan privasi";
    $TEXT['page-cookies'] = "Penggunaan cookie";
    $TEXT['page-gdpr'] = "GDPR (General Data Protection Regulation) Privacy Rights";
    $TEXT['page-support'] = "Mendukung";
    $TEXT['page-profile'] = "Profil";
    $TEXT['page-favorites'] = "Favorit";
    $TEXT['page-notifications'] = "Notifikasi";
    $TEXT['page-messages'] = "Pesan";
    $TEXT['page-chat'] = "Obrolan";
    $TEXT['page-items'] = "Iklan baris";

    $TEXT['page-404'] = "Halaman tidak ditemukan";
    $TEXT['page-404-description'] = "Halaman yang diminta tidak ditemukan";

    $TEXT['page-under-construction'] = "Segera akan datang";
    $TEXT['page-under-construction-description'] = "Situs web kami saat ini sedang menjalani pemeliharaan terjadwal. Kami harus segera kembali. Terima kasih atas kesabaran Anda.";

    // Support

    $TEXT['label-support-subject'] = "Subyek";
    $TEXT['label-support-details'] = "Detail";
    $TEXT['label-support-email-placeholder'] = "Email mu";
    $TEXT['label-support-subject-placeholder'] = "Apa yang ingin Anda laporkan? Judul Pesan.";
    $TEXT['label-support-details-placeholder'] = "Jelaskan masalah secara rinci";
    $TEXT['label-support-sent-title'] = "permintaan Anda telah diterima";
    $TEXT['label-support-sent-msg'] = "Dalam waktu dekat, kami akan memproses permintaan Anda dan menghubungi Anda jika perlu.";

    // Labels

    $TEXT['placeholder-login-username'] = "Masukkan login atau email Anda";
    $TEXT['placeholder-login-password'] = "Masukkan kata sandi Anda";

    $TEXT['label-username-or-email'] = "Username atau email";

    $TEXT['label-search-query'] = "Teks untuk pencarian";
    $TEXT['placeholder-search-query'] = "Apa yang sedang Anda cari?";
    $TEXT['label-all-categories'] = "Semua Kategori";
    $TEXT['label-all-profile-items'] = "%d iklan baris";
    $TEXT['label-cookie-message'] = "Kami menggunakan alat, seperti \"cookie\", untuk mengaktifkan layanan dan fungsi penting di situs kami dan untuk mengumpulkan data tentang bagaimana pengunjung berinteraksi dengan situs, produk, dan layanan kami. Dengan menggunakan situs web, Anda setuju dengan kami ";

    $TEXT['label-filters'] = "Filter"; //
    $TEXT['label-filters-all'] = "Semua"; //
    $TEXT['label-filters-comments'] = "Komentar"; //
    $TEXT['label-filters-likes'] = "Suka"; //
    $TEXT['label-filters-replies'] = "Balasan"; //
    $TEXT['label-filters-approved'] = "Disetujui"; //
    $TEXT['label-filters-rejected'] = "Ditolak"; //

    $TEXT['label-search-filters-moderation-type'] = "Moderasi";
    $TEXT['label-search-filters-moderation-only'] = "Hanya diverifikasi oleh moderator";
    $TEXT['label-search-filters-sort-type'] = "Menyortir";
    $TEXT['label-search-filters-sort-by-new'] = "Dari yang baru ke yang lama";
    $TEXT['label-search-filters-sort-by-old'] = "Dari yang lama ke yang baru";

    $TEXT['label-search-filters-location-type'] = "Di mana mencari?";
    $TEXT['label-search-filters-location-type-all'] = "Di mana-mana";
    $TEXT['label-search-filters-location-type-selected'] = "Lokasi yang dipilih";
    $TEXT['label-search-filters-distance-type'] = "Jarak";
    $TEXT['label-search-filters-distance-type-all'] = "Di mana-mana";
    $TEXT['label-search-filters-distance-type-5'] = "5km";
    $TEXT['label-search-filters-distance-type-15'] = "15km";
    $TEXT['label-search-filters-distance-type-30'] = "30km";
    $TEXT['label-search-filters-distance-type-50'] = "50km";
    $TEXT['label-search-filters-distance-type-100'] = "100km";
    $TEXT['label-search-filters-distance-type-300'] = "300km";
    $TEXT['label-search-filters-distance-type-500'] = "500km";
    $TEXT['label-search-filters-distance-type-700'] = "700km";

    $TEXT['label-optional'] = "opsional";
    $TEXT['label-detail'] = "detail";

    $TEXT['label-just-now'] = "baru saja";

    $TEXT['label-item-approved'] = "Diverifikasi";
    $TEXT['label-item-approved-title'] = "Diverifikasi oleh moderator";
    $TEXT['label-item-rejected'] = "Ditolak";
    $TEXT['label-item-rejected-title'] = "Ditolak oleh moderator";

    $TEXT['label-item-active'] = "Aktif";
    $TEXT['label-item-inactive'] = "Non-aktif";
    $TEXT['label-item-hot'] = "Panas";
    $TEXT['label-item-popular'] = "Populer";
    $TEXT['label-item-new'] = "Baru";

    $TEXT['label-favorites-add'] = "Tambahkan ke Favorit";
    $TEXT['label-favorites-remove'] = "Hapus dari favorit";

    $TEXT['label-notify-item'] = "Iklan Baris";
    $TEXT['label-notify-item-approved'] = "%s Anda disetujui oleh moderator.";
    $TEXT['label-notify-item-rejected'] = "%s Anda telah ditolak oleh moderator.";

    $TEXT['label-safety-tips-title'] = "Tips Keamanan untuk Pembeli";
    $TEXT['label-safety-tips-1'] = "Jangan mengirim uang sebelum menerima barang";
    $TEXT['label-safety-tips-2'] = "Periksa item sebelum Anda membeli";
    $TEXT['label-safety-tips-3'] = "Pembayaran setelah menerima dan memeriksa barang";
    $TEXT['label-safety-tips-4'] = "Temui penjual di lokasi yang aman";

    $TEXT['label-created-by-web-app'] = "Diposting dari versi web";
    $TEXT['label-created-by-android-app'] = "Diposting dari aplikasi Android";
    $TEXT['label-created-by-ios-app'] = "Diposting dari aplikasi iOS";

    $TEXT['label-item-stats'] = "Statistik";
    $TEXT['label-item-stats-views'] = "Tampilan";
    $TEXT['label-item-stats-likes'] = "Suka";
    $TEXT['label-item-stats-favorites'] = "Ditambahkan ke favorit";
    $TEXT['label-item-stats-phone-views'] = "Tampilan nomor telepon";

    $TEXT['label-item-disclaimer-title'] = "Penolakan";
    $TEXT['label-item-disclaimer-desc'] = "Kami tidak mengontrol konten yang diposting oleh anggota dan karenanya tidak bertanggung jawab atas segala akibat yang berkaitan langsung atau tidak langsung dengan tindakan atau tidak adanya tindakan.";

    $TEXT['label-items-related'] = "Iklan baris terkait";
    $TEXT['label-items-more-from-author'] = "Lebih dari %s";
    $TEXT['label-items-latest'] = "Iklan baris terbaru";
    $TEXT['label-items-featured'] = "Iklan baris fitur";
    $TEXT['label-items-popular'] = "Iklan baris populer";

    // Settings

    $TEXT['page-settings'] = "Settings";
    $TEXT['page-settings-account'] = "Settings";
    $TEXT['page-settings-profile'] = "Profil";
    $TEXT['page-settings-privacy'] = "Pribadi";
    $TEXT['page-settings-password'] = "Ganti kata sandi";
    $TEXT['page-settings-blacklist'] = "Daftar hitam";
    $TEXT['page-settings-connections'] = "Jaringan sosial";
    $TEXT['page-settings-deactivation'] = "Nonaktifkan akun";

    $TEXT['label-privacy-messages'] = "Pesan";
    $TEXT['label-privacy-allow-messages'] = "Terima pesan";

    $TEXT['label-sex'] = "Seks";
    $TEXT['label-sex-unknown'] = "Tidak ditentukan";
    $TEXT['label-sex-male'] = "Jantan";
    $TEXT['label-sex-female'] = "Wanita";

    $TEXT['label-bio'] = "Bio";
    $TEXT['label-phone-number'] = "Nomor telepon";
    $TEXT['placeholder-phone-number'] = "Nomor telepon, contoh: +15417543010";


    $TEXT['placeholder-bio'] = "Ceritakan sedikit tentang diri Anda";
    $TEXT['placeholder-facebook-page'] = "Tautan ke halaman Facebook";
    $TEXT['placeholder-instagram-page'] = "Tautan ke halaman Instagram";

    $TEXT['action-deactivate'] = "Menonaktifkan";
    $TEXT['label-password'] = "Kata sandi";
    $TEXT['placeholder-password-current'] = "Kata sandi saat ini";
    $TEXT['label-password-current'] = "Kata sandi saat ini";
    $TEXT['label-password-new'] = "Kata sandi baru";
    $TEXT['placeholder-password-new'] = "Kata sandi baru";

    $TEXT['msg-deactivation-promo'] = "<strong>Peringatan!</strong><br>Semua data, foto, pesan, dan profil Anda akan dihapus! Anda tidak dapat memulihkan data ini!";
    $TEXT['msg-deactivation-error'] = "Kata sandi salah.";

    $TEXT['msg-settings-saved'] = "Pengaturan disimpan.";
    $TEXT['msg-password-saved'] = "Kata sandi berhasil diubah.";

    $TEXT['msg-password-new-format-error'] = "Sandi tidak berubah, format yang salah untuk password baru.";
    $TEXT['msg-password-current-format-error'] = "Kata sandi tidak diubah, format yang salah untuk kata sandi saat ini.";
    $TEXT['msg-password-current-error'] = "Kata sandi tidak diubah, salah kata sandi saat ini.";

    // Dialogs

    $TEXT['dlg-confirm-block-title'] = "Blokir pengguna";
    $TEXT['dlg-confirm-unblock-title'] = "Buka blokir pengguna";
    $TEXT['dlg-confirm-action-title'] = "Konfirmasikan tindakan";
    $TEXT['dlg-item-title'] = "Item";
    $TEXT['dlg-message-title'] = "Pesan";
    $TEXT['dlg-message-placeholder'] = "Masukkan pesan Anda...";
    $TEXT['dlg-report-profile-title'] = "Keluhan";
    $TEXT['dlg-report-item-title'] = "Keluhan";
    $TEXT['dlg-report-sub-title'] = "Alasan untuk keluhan Anda";
    $TEXT['dlg-report-description-label'] = "Deskripsi";
    $TEXT['dlg-report-description-placeholder'] = "Anda dapat menjelaskan secara rinci alasan keluhan...";

    // Social connections

    $TEXT['page-settings-connections-sub-title'] = "Hubungkan %s dengan akun jejaring sosial Anda";

    $TEXT['label-notify-profile-photo-rejected'] = "Foto profil Anda telah ditolak oleh moderator. Unggah foto/gambar lain.";
    $TEXT['label-notify-profile-cover-rejected'] = "Sampul profil Anda telah ditolak oleh moderator. Unggah foto/gambar lain.";

    //

    $TEXT['label-currency-choose'] = "Pilih mata uang";
    $TEXT['label-currency-free'] = "Gratis";
    $TEXT['label-currency-negotiable'] = "Harga nego";