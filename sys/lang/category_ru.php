<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();

    // For standard categories

    $TEXT['category-1'] = "Телефоны, планшеты и аксессуары";
    $TEXT['category-2'] = "Автомобили, мотоциклы и другие транспортные средства";
    $TEXT['category-3'] = "Недвижимость";
    $TEXT['category-4'] = "Одежда, Мода и Стиль";
    $TEXT['category-5'] = "Животные";
    $TEXT['category-6'] = "Компьютеры, игровые приставки и аксессуары";
    $TEXT['category-7'] = "Косметика, парфюмерия и другие товары для красоты и здоровья";
    $TEXT['category-8'] = "Мебель";
    $TEXT['category-9'] = "Обувь";
    $TEXT['category-10'] = "Инструменты и другие товары для дома";
    $TEXT['category-11'] = "Наручные часы";
    $TEXT['category-12'] = "Бизнес и услуги";

    $TEXT['category-13'] = "Мобильные телефоны и планшеты";
    $TEXT['category-14'] = "Аксессуары для телефонов и планшетов";
    $TEXT['category-15'] = "Разное";

    $TEXT['category-16'] = "Легковые автомобили";
    $TEXT['category-17'] = "Грузовые автомобили";
    $TEXT['category-18'] = "Автобусы";
    $TEXT['category-19'] = "Мото";
    $TEXT['category-20'] = "Спецтехника";
    $TEXT['category-21'] = "Сельскохозяйственная техника";
    $TEXT['category-22'] = "Водный транспорт";
    $TEXT['category-23'] = "Воздушный транспорт";
    $TEXT['category-24'] = "Шины и диски";
    $TEXT['category-25'] = "Автомобильные запчасти";
    $TEXT['category-26'] = "Аксессуары для авто";
    $TEXT['category-27'] = "Мото запчасти";
    $TEXT['category-28'] = "Мото аксессуары";
    $TEXT['category-29'] = "Другие запчасти";
    $TEXT['category-30'] = "Разное";

    $TEXT['category-31'] = "Продажа квартир, комнат";
    $TEXT['category-32'] = "Долгосрочная аренда квартир, комнат";
    $TEXT['category-33'] = "Продажа домов";
    $TEXT['category-34'] = "Долгосрочная аренда домов";
    $TEXT['category-35'] = "Продажа земли";
    $TEXT['category-36'] = "Аренда земли";
    $TEXT['category-37'] = "Продажа коммерческой недвижимости";
    $TEXT['category-38'] = "Аренда коммерческой недвижимости";
    $TEXT['category-39'] = "Продажа гаражей, парковок";
    $TEXT['category-40'] = "Аренда гаражей, стоянок";
    $TEXT['category-41'] = "Посуточная аренда";
    $TEXT['category-42'] = "Разное";

    $TEXT['category-43'] = "Женская одежда";
    $TEXT['category-44'] = "Белье, купальники";
    $TEXT['category-45'] = "Мужская одежда";
    $TEXT['category-46'] = "Мужское нижнее белье";
    $TEXT['category-47'] = "Головные уборы";
    $TEXT['category-48'] = "Сумки";
    $TEXT['category-49'] = "Ювелирные изделия";
    $TEXT['category-50'] = "Бижутерия";
    $TEXT['category-51'] = "Подарки";
    $TEXT['category-52'] = "Разное";

    $TEXT['category-53'] = "Собаки";
    $TEXT['category-54'] = "Кошки";
    $TEXT['category-55'] = "Птицы";
    $TEXT['category-56'] = "Рептилии";
    $TEXT['category-57'] = "Грызуны";
    $TEXT['category-58'] = "Аквариум";
    $TEXT['category-59'] = "Зоотовары";
    $TEXT['category-60'] = "Разное";

    $TEXT['category-61'] = "Компьютеры";
    $TEXT['category-62'] = "Ноутбуки";
    $TEXT['category-63'] = "Серверы";
    $TEXT['category-64'] = "Игровые приставки";
    $TEXT['category-65'] = "Игры для ПК и приставок";
    $TEXT['category-66'] = "Периферийные устройства";
    $TEXT['category-67'] = "Мониторы";
    $TEXT['category-68'] = "Внешние накопители";
    $TEXT['category-69'] = "Компоненты и аксессуары";
    $TEXT['category-70'] = "Расходные материалы";
    $TEXT['category-71'] = "Программное обеспечение";
    $TEXT['category-72'] = "Разное";

    $TEXT['category-73'] = "Косметика";
    $TEXT['category-74'] = "Парфюмерия";
    $TEXT['category-75'] = "Средства по уходу";
    $TEXT['category-76'] = "Другие товары для здоровья и красоты";

    $TEXT['category-77'] = "Мебель для гостиной";
    $TEXT['category-78'] = "Мебель для спальни";
    $TEXT['category-79'] = "Мебель для прихожей";
    $TEXT['category-80'] = "Кухонная мебель";
    $TEXT['category-81'] = "Мебель для ванной";
    $TEXT['category-82'] = "Офисная мебель";
    $TEXT['category-83'] = "Разное";

    $TEXT['category-84'] = "Женская обувь";
    $TEXT['category-85'] = "Мужская обувь";
    $TEXT['category-86'] = "Разное";

    $TEXT['category-87'] = "Электроинструмент";
    $TEXT['category-88'] = "Ручной инструмент";
    $TEXT['category-89'] = "Бензоинструмент";
    $TEXT['category-90'] = "Другие инструменты";
    $TEXT['category-91'] = "Садовый инвентарь";
    $TEXT['category-92'] = "Бытовая техника";
    $TEXT['category-93'] = "Разное";

    $TEXT['category-94'] = "Женские часы";
    $TEXT['category-95'] = "Мужские наручные часы";
    $TEXT['category-96'] = "Разное";

    $TEXT['category-97'] = "Строительные услуги";
    $TEXT['category-98'] = "Дизайн и архитектура";
    $TEXT['category-99'] = "Продажа бизнеса";
    $TEXT['category-100'] = "Финансовые услуги";
    $TEXT['category-101'] = "Няни";
    $TEXT['category-102'] = "Развлечения";
    $TEXT['category-103'] = "Авто и Мото Услуги";
    $TEXT['category-104'] = "Услуги для животных";
    $TEXT['category-105'] = "Туризм";
    $TEXT['category-106'] = "Образование и Спорт";
    $TEXT['category-107'] = "Оборудование";
    $TEXT['category-108'] = "Реклама / Полиграфия / Маркетинг / Интернет";
    $TEXT['category-109'] = "Разное";