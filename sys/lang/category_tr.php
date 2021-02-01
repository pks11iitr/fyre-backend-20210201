<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();

    // For standard categories

    $TEXT['category-1'] = "Telefonlar, tabletler ve aksesuarlar";
    $TEXT['category-2'] = "Arabalar, motosikletler ve diğer araçlar";
    $TEXT['category-3'] = "Emlak";
    $TEXT['category-4'] = "Giyim, Moda ve Stil";
    $TEXT['category-5'] = "Evcil";
    $TEXT['category-6'] = "Bilgisayarlar, oyun konsolları ve aksesuarlar";
    $TEXT['category-7'] = "Kozmetikler, parfümler ve diğer sağlık ve güzellik ürünleri";
    $TEXT['category-8'] = "Mobilya";
    $TEXT['category-9'] = "Ayakkabıları";
    $TEXT['category-10'] = "Araçlar ve diğer ev eşyaları";
    $TEXT['category-11'] = "Kol saatleri";
    $TEXT['category-12'] = "İşletme ve hizmetler";

    $TEXT['category-13'] = "Cep telefonları ve tabletler";
    $TEXT['category-14'] = "Telefonlar ve tabletler için aksesuarlar";
    $TEXT['category-15'] = "Diğer";

    $TEXT['category-16'] = "Arabalar";
    $TEXT['category-17'] = "Kamyonlar";
    $TEXT['category-18'] = "Otobüsler";
    $TEXT['category-19'] = "Motosiklet";
    $TEXT['category-20'] = "Özel makine";
    $TEXT['category-21'] = "Tarım makineleri";
    $TEXT['category-22'] = "Su ulaştırma";
    $TEXT['category-23'] = "Hava Taşımacılığı";
    $TEXT['category-24'] = "Lastikler ve jantlar";
    $TEXT['category-25'] = "Oto parçaları";
    $TEXT['category-26'] = "Araba aksesuarları";
    $TEXT['category-27'] = "Motosiklet parçaları";
    $TEXT['category-28'] = "Motosiklet aksesuarları";
    $TEXT['category-29'] = "Diğer parçalar";
    $TEXT['category-30'] = "Diğer";

    $TEXT['category-31'] = "Dairelerin ve odaların satışı";
    $TEXT['category-32'] = "Uzun süreli kiralık daireler, odalar";
    $TEXT['category-33'] = "Evlerin satışı";
    $TEXT['category-34'] = "Uzun süreli kiralama evleri";
    $TEXT['category-35'] = "Arazi satışı";
    $TEXT['category-36'] = "Arazi kirası";
    $TEXT['category-37'] = "Ticari emlak satışı";
    $TEXT['category-38'] = "Ticari emlak kiralama";
    $TEXT['category-39'] = "Garajların satışı";
    $TEXT['category-40'] = "Kiralık garajlar";
    $TEXT['category-41'] = "Günlük Kiralama";
    $TEXT['category-42'] = "Diğer";

    $TEXT['category-43'] = "Bayan giyimi";
    $TEXT['category-44'] = "İç çamaşırı, mayo";
    $TEXT['category-45'] = "Erkek giyim";
    $TEXT['category-46'] = "Erkek iç çamaşırı";
    $TEXT['category-47'] = "Şapkalar";
    $TEXT['category-48'] = "Çanta";
    $TEXT['category-49'] = "Takı";
    $TEXT['category-50'] = "Bijouterie";
    $TEXT['category-51'] = "Hediyeler";
    $TEXT['category-52'] = "Diğer";

    $TEXT['category-53'] = "Köpekler";
    $TEXT['category-54'] = "Kediler";
    $TEXT['category-55'] = "Kuşlar";
    $TEXT['category-56'] = "Sürüngenler";
    $TEXT['category-57'] = "Kemirgenler";
    $TEXT['category-58'] = "Akvaryum";
    $TEXT['category-59'] = "Evcil Hayvan gereçleri";
    $TEXT['category-60'] = "Diğer";

    $TEXT['category-61'] = "Masaüstü bilgisayarlar";
    $TEXT['category-62'] = "Dizüstü";
    $TEXT['category-63'] = "Sunucular";
    $TEXT['category-64'] = "Oyun konsolu";
    $TEXT['category-65'] = "PC ve Konsol Oyunları";
    $TEXT['category-66'] = "Çevre Birimleri";
    $TEXT['category-67'] = "Monitörler";
    $TEXT['category-68'] = "Harici sürücüler";
    $TEXT['category-69'] = "Bileşenler ve aksesuarlar";
    $TEXT['category-70'] = "Gider malzemeler";
    $TEXT['category-71'] = "Yazılım";
    $TEXT['category-72'] = "Diğer";

    $TEXT['category-73'] = "Makyaj malzemeleri";
    $TEXT['category-74'] = "Parfümeri";
    $TEXT['category-75'] = "Bakım ürünleri";
    $TEXT['category-76'] = "Diğer sağlık ve güzellik ürünleri";

    $TEXT['category-77'] = "Oturma odası eşyası";
    $TEXT['category-78'] = "Yatak odası mobilyası";
    $TEXT['category-79'] = "Koridor mobilya";
    $TEXT['category-80'] = "Mutfak mobilyası";
    $TEXT['category-81'] = "Banyo mobilyası";
    $TEXT['category-82'] = "Ofis mobilyaları";
    $TEXT['category-83'] = "Diğer";

    $TEXT['category-84'] = "Kadın ayakkabısı";
    $TEXT['category-85'] = "Erkek ayakkabıları";
    $TEXT['category-86'] = "Diğer";

    $TEXT['category-87'] = "Güç aracı";
    $TEXT['category-88'] = "El aleti";
    $TEXT['category-89'] = "Benzin aletleri";
    $TEXT['category-90'] = "Diğer Aletler";
    $TEXT['category-91'] = "Bahçe aletleri";
    $TEXT['category-92'] = "Ev Aletleri";
    $TEXT['category-93'] = "Diğer";

    $TEXT['category-94'] = "Kadın saatler";
    $TEXT['category-95'] = "Erkek kol saati";
    $TEXT['category-96'] = "Diğer";

    $TEXT['category-97'] = "Inşaat hizmetleri";
    $TEXT['category-98'] = "Tasarım ve mimarlık";
    $TEXT['category-99'] = "Bir işletme Satış";
    $TEXT['category-100'] = "Finansal hizmetler";
    $TEXT['category-101'] = "Babysitters";
    $TEXT['category-102'] = "Eğlence";
    $TEXT['category-103'] = "Oto ve Moto Servisleri";
    $TEXT['category-104'] = "Hayvan Hizmetleri";
    $TEXT['category-105'] = "Turizm";
    $TEXT['category-106'] = "Eğitim ve Spor";
    $TEXT['category-107'] = "Ekipmanlar";
    $TEXT['category-108'] = "Reklamcılık / Baskı / Pazarlama / İnternet";
    $TEXT['category-109'] = "Diğer";