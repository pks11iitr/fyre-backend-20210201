<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();

    // For standard categories

    $TEXT['category-1'] = "Ponsel, tablet, dan aksesori";
    $TEXT['category-2'] = "Mobil, motor dan kendaraan lain";
    $TEXT['category-3'] = "Real estat";
    $TEXT['category-4'] = "Pakaian, Mode dan Gaya";
    $TEXT['category-5'] = "Hewan dan hewan peliharaan";
    $TEXT['category-6'] = "Komputer, konsol game, dan aksesori";
    $TEXT['category-7'] = "Kosmetik, parfum dan produk kesehatan dan kecantikan lainnya";
    $TEXT['category-8'] = "Mebel";
    $TEXT['category-9'] = "Sepatu";
    $TEXT['category-10'] = "Alat, dan barang-barang rumah tangga lainnya";
    $TEXT['category-11'] = "Jam tangan";
    $TEXT['category-12'] = "Bisnis dan layanan";

    $TEXT['category-13'] = "Ponsel dan tablet";
    $TEXT['category-14'] = "Aksesori untuk ponsel dan tablet";
    $TEXT['category-15'] = "Lainnya";

    $TEXT['category-16'] = "Mobil";
    $TEXT['category-17'] = "Truk";
    $TEXT['category-18'] = "Bus";
    $TEXT['category-19'] = "Motorcycles";
    $TEXT['category-20'] = "Mesin khusus";
    $TEXT['category-21'] = "Mesin pertanian";
    $TEXT['category-22'] = "Transportasi air";
    $TEXT['category-23'] = "Kendaraan penerbangan";
    $TEXT['category-24'] = "Ban dan roda";
    $TEXT['category-25'] = "Suku cadang mobil";
    $TEXT['category-26'] = "Asesoris untuk mobil";
    $TEXT['category-27'] = "Suku cadang sepeda motor";
    $TEXT['category-28'] = "Aksesori sepeda motor";
    $TEXT['category-29'] = "Bagian lain";
    $TEXT['category-30'] = "Lainnya";

    $TEXT['category-31'] = "Penjualan apartemen, kamar";
    $TEXT['category-32'] = "Apartemen sewa jangka panjang, kamar";
    $TEXT['category-33'] = "Penjualan rumah";
    $TEXT['category-34'] = "Rumah sewa jangka panjang";
    $TEXT['category-35'] = "Penjualan tanah";
    $TEXT['category-36'] = "Sewa tanah";
    $TEXT['category-37'] = "Penjualan real estat komersial";
    $TEXT['category-38'] = "Sewa real estat komersial";
    $TEXT['category-39'] = "Penjualan garasi, parkir";
    $TEXT['category-40'] = "Sewa garasi, parkir";
    $TEXT['category-41'] = "Sewa Harian";
    $TEXT['category-42'] = "Lainnya";

    $TEXT['category-43'] = "Pakaian Wanita";
    $TEXT['category-44'] = "Pakaian dalam, pakaian renang";
    $TEXT['category-45'] = "Pakaian Pria";
    $TEXT['category-46'] = "Pakaian dalam pria";
    $TEXT['category-47'] = "Topi";
    $TEXT['category-48'] = "Tas";
    $TEXT['category-49'] = "Perhiasan";
    $TEXT['category-50'] = "Bijouterie";
    $TEXT['category-51'] = "Hadiah";
    $TEXT['category-52'] = "Lainnya";

    $TEXT['category-53'] = "Anjing";
    $TEXT['category-54'] = "Kucing";
    $TEXT['category-55'] = "Burung-burung";
    $TEXT['category-56'] = "Reptil";
    $TEXT['category-57'] = "Hewan pengerat";
    $TEXT['category-58'] = "Akuarium";
    $TEXT['category-59'] = "Persediaan hewan peliharaan";
    $TEXT['category-60'] = "Lainnya";

    $TEXT['category-61'] = "Komputer desktop";
    $TEXT['category-62'] = "Laptop";
    $TEXT['category-63'] = "Server";
    $TEXT['category-64'] = "Konsol game";
    $TEXT['category-65'] = "Game untuk PC dan Konsol";
    $TEXT['category-66'] = "Peripherals";
    $TEXT['category-67'] = "Monitor";
    $TEXT['category-68'] = "Drive eksternal";
    $TEXT['category-69'] = "Komponen dan aksesori";
    $TEXT['category-70'] = "Expendables";
    $TEXT['category-71'] = "Perangkat lunak";
    $TEXT['category-72'] = "Lainnya";

    $TEXT['category-73'] = "Kosmetika";
    $TEXT['category-74'] = "Wewangian";
    $TEXT['category-75'] = "Produk perawatan";
    $TEXT['category-76'] = "Produk kesehatan dan kecantikan lainnya";

    $TEXT['category-77'] = "Perabot ruang tamu";
    $TEXT['category-78'] = "Perabot kamar tidur";
    $TEXT['category-79'] = "Mebel lorong";
    $TEXT['category-80'] = "Perabotan dapur";
    $TEXT['category-81'] = "Perabot kamar mandi";
    $TEXT['category-82'] = "Perabotan kantor";
    $TEXT['category-83'] = "Lainnya";

    $TEXT['category-84'] = "Sepatu Wanita";
    $TEXT['category-85'] = "Sepatu Pria";
    $TEXT['category-86'] = "Lainnya";

    $TEXT['category-87'] = "Alat kekuasaan";
    $TEXT['category-88'] = "Alat tangan";
    $TEXT['category-89'] = "Alat bertenaga gas";
    $TEXT['category-90'] = "Alat lainnya";
    $TEXT['category-91'] = "Alat berkebun";
    $TEXT['category-92'] = "Peralatan Rumah tangga";
    $TEXT['category-93'] = "Lainnya";

    $TEXT['category-94'] = "Jam tangan wanita";
    $TEXT['category-95'] = "Jam tangan pria";
    $TEXT['category-96'] = "Lainnya";

    $TEXT['category-97'] = "Jasa konstruksi";
    $TEXT['category-98'] = "Desain dan arsitektur";
    $TEXT['category-99'] = "Menjual bisnis";
    $TEXT['category-100'] = "Jasa keuangan";
    $TEXT['category-101'] = "Pengasuh anak";
    $TEXT['category-102'] = "Hiburan";
    $TEXT['category-103'] = "Layanan Otomatis dan Moto";
    $TEXT['category-104'] = "Layanan Hewan";
    $TEXT['category-105'] = "Pariwisata";
    $TEXT['category-106'] = "Pendidikan dan Olahraga";
    $TEXT['category-107'] = "Peralatan";
    $TEXT['category-108'] = "Periklanan / Percetakan / Pemasaran / Internet";
    $TEXT['category-109'] = "Lainnya";