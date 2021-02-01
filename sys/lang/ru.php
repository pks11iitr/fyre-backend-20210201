<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();
	$SEX = array("Male" => 0, "Female" => 1);

    $LANG_CATEGORIES_ARRAY = array(
        "Телефоны, планшеты и аксессуары", //Phones, tablets and accessories
        "Автомобили, мотоциклы и другой транспорт", //Cars, motorcycles and other vehicles
        "Недвижимость", //Real estate
        "Одежда, мода и стиль", //Clothing, Fashion and Style
        "Домашние животные", //Pets
        "Компьютеры, игровые приставки и аксессуары", //Computers, game consoles and accessories
        "Косметика, парфюмерия и прочии товары для красоты и здоровья", //Cosmetics, perfumes and other health and beauty products
        "Мебель", //Furniture
        "Обувь", //Shoes
        "Инструменты и прочие товары для дома", //Tools and other household goods
        "Наручные часы", //Wristwatches
        "Бизнес и услуги"); //Business and services

    $TEXT['lang-code'] = "ru";
    $TEXT['lang-name'] = "Русский";

    // For admin panel

    $TEXT['apanel-dashboard'] = "Главная";
    $TEXT['apanel-home'] = "Панель управления";
    $TEXT['apanel-support'] = "Поддержка";
    $TEXT['apanel-settings'] = "Настройки";
    $TEXT['apanel-logout'] = "Выход";
    $TEXT['apanel-login'] = "Войти";
    $TEXT['apanel-market'] = "Маркет";
    $TEXT['apanel-reports'] = "Жалобы";
    $TEXT['apanel-messages'] = "Сообщения";
    $TEXT['apanel-chats'] = "Беседы";
    $TEXT['apanel-chat'] = "Беседа";
    $TEXT['apanel-items'] = "Публикации";
    $TEXT['apanel-users'] = "Пользователи";
    $TEXT['apanel-fcm'] = "Push Notifications";
    $TEXT['apanel-admob'] = "Admob";
    $TEXT['apanel-profile'] = "Профиль";

    $TEXT['apanel-categories'] = "Категории";
    $TEXT['apanel-subcategories'] = "Подкатегории";
    $TEXT['apanel-category-new'] = "Создать категорию";
    $TEXT['apanel-category-edit'] = "Редактировать категорию";

    $TEXT['apanel-subcategory-new'] = "Создать Подкатегорию";
    $TEXT['apanel-subcategory-edit'] = "Редактировать Подкатегорию";

    $TEXT['apanel-label-category'] = "Категория";
    $TEXT['apanel-label-subcategory'] = "Подкатегория";
    $TEXT['apanel-label-categories'] = "Категории";
    $TEXT['apanel-label-subcategories'] = "Подкатегории";

    $TEXT['apanel-label-general'] = "Главное";
    $TEXT['apanel-label-stream'] = "Потоки";
    $TEXT['apanel-label-settings'] = "Настройки";

    $TEXT['apanel-placeholder-username'] = "Имя пользователя";
    $TEXT['apanel-placeholder-password'] = "Пароль";
    $TEXT['apanel-placeholder-search'] = "Введите текст";
    $TEXT['apanel-placeholder-category-title'] = "Введите название категории";

    $TEXT['apanel-action-login'] = "Войти";
    $TEXT['apanel-action-delete'] = "Удалить";
    $TEXT['apanel-action-cancel'] = "Отмена";
    $TEXT['apanel-action-approve'] = "Одобрить";
    $TEXT['apanel-action-reject'] = "Отклонить";
    $TEXT['apanel-action-view-more'] = "Загрузить еще";
    $TEXT['apanel-action-search'] = "Поиск";
    $TEXT['apanel-action-view'] = "Смотреть";
    $TEXT['apanel-action-send'] = "Отправить";
    $TEXT['apanel-action-edit'] = "Редактировать";
    $TEXT['apanel-action-rename'] = "Переименовать";
    $TEXT['apanel-action-save'] = "Сохранить";
    $TEXT['apanel-action-add'] = "Добавить";
    $TEXT['apanel-action-create'] = "Создать";
    $TEXT['apanel-action-close-all-auth'] = "Закрыть все сессии";
    $TEXT['apanel-action-verified-set'] = "Отметить как проверенный";
    $TEXT['apanel-action-verified-unset'] = "Снять отметку \"Проверенный\"";
    $TEXT['apanel-action-create-fcm'] = "Отправить персональное Push сообщение";
    $TEXT['apanel-action-account-block'] = "Блокировать";
    $TEXT['apanel-action-account-unblock'] = "Разблокировать";
    $TEXT['apanel-action-remove-connection'] = "Удалить связь";
    $TEXT['apanel-action-admob-on'] = "Включить AdMob для этого аккаунта";
    $TEXT['apanel-action-admob-off'] = "Выключить AdMob для этого аккаунта";
    $TEXT['apanel-action-delete-photo'] = "Удалить фотографию";
    $TEXT['apanel-action-delete-cover'] = "Удалить обложку";

    $TEXT['apanel-auth-label-title'] = "Сессии/Авторизации";

    $TEXT['apanel-label-create-at'] = "Дата создания";
    $TEXT['apanel-label-close-at'] = "Дата закрытия";
    $TEXT['apanel-label-signup-at'] = "Дата регистрации";
    $TEXT['apanel-label-app-type'] = "Тип приложения";

    $TEXT['apanel-label-account-edit'] = "Редактировать";
    $TEXT['apanel-label-location'] = "Местоположение";
    $TEXT['apanel-label-balance'] = "Баланс";
    $TEXT['apanel-label-fullname'] = "Полное имя";
    $TEXT['apanel-label-admob-state'] = "AdMob (on/off AdMob для этого аккаунта)";
    $TEXT['apanel-label-admob-state-active'] = "On (AdMob активен в этом аккаунте)";
    $TEXT['apanel-label-admob-state-inactive'] = "Off (AdMob не активен в этом аккаунте)";
    $TEXT['apanel-label-account-state'] = "Состояние аккаунта";
    $TEXT['apanel-label-account-state-enabled'] = "Аккаунт активен";
    $TEXT['apanel-label-account-state-blocked'] = "Аккаунт заблокирован";
    $TEXT['apanel-label-account-state-disabled'] = "Аккаунт отключен пользователем";
    $TEXT['apanel-label-account-state-verified'] = "Верификация аккаунта";
    $TEXT['apanel-label-account-verified'] = "Аккаунт верифицирован|проверен";
    $TEXT['apanel-label-account-unverified'] = "Аккаунт не проверен, не имеет отметки \"проверен\"";
    $TEXT['apanel-label-account-facebook-connected'] = "Подключен к Facebook";
    $TEXT['apanel-label-connected'] = "Подключен";
    $TEXT['apanel-label-not-connected'] = "Не подключен";

    $TEXT['apanel-label-account-chats'] = "Беседы";
    $TEXT['apanel-label-account-items'] = "Объявления";
    $TEXT['apanel-label-account-reports'] = "Жалобы на профиль";

    $TEXT['apanel-label-sort-type'] = "Сортировать";
    $TEXT['apanel-label-moderation-type'] = "Модерация";
    $TEXT['apanel-label-active-type'] = "Активность";
    $TEXT['apanel-label-category'] = "Категория";
    $TEXT['apanel-label-search'] = "Искать";
    $TEXT['apanel-label-list-empty'] = "Список пуст.";
    $TEXT['apanel-label-list-empty-desc'] = "Это значит, что нечего отобразить :)";

    $TEXT['apanel-sort-type-new'] = "От новых к старым";
    $TEXT['apanel-sort-type-old'] = "От старых к новым";

    $TEXT['apanel-active-type-all'] = "Все";
    $TEXT['apanel-active-type-active'] = "Только активные";

    $TEXT['apanel-moderation-type-all'] = "Все";
    $TEXT['apanel-moderation-type-moderated'] = "Только модерированные";
    $TEXT['apanel-moderation-type-unmoderated'] = "Не модерированные";

    $TEXT['apanel-report-type-item'] = "Жалобы на объявления";
    $TEXT['apanel-report-type-profile'] = "Жалобы на пользователей";

    $TEXT['apanel-label-item-active'] = "Активно";
    $TEXT['apanel-label-item-inactive'] = "Неактивно";
    $TEXT['apanel-label-item-approved'] = "Одобрено";
    $TEXT['apanel-label-item-rejected'] = "Отклонено";

    $TEXT['apanel-label-name'] = "Название";
    $TEXT['apanel-label-count'] = "Количество";
    $TEXT['apanel-label-value'] = "Значение";

    $TEXT['apanel-label-error'] = "Ошибка!";
    $TEXT['apanel-label-thanks'] = "Спасибо!";

    $TEXT['apanel-settings-label-change-password'] = "Изменить пароль";
    $TEXT['apanel-settings-label-change-password-desc'] = "Введите текущий и новый пароль";
    $TEXT['apanel-settings-label-current-password'] = "Текущий пароль";
    $TEXT['apanel-settings-label-new-password'] = "Новый пароль";

    $TEXT['apanel-settings-label-password-saved'] = "Новый пароль сохранен";
    $TEXT['apanel-settings-label-password-error'] = "Некорректный текущий или неверный формат для нового пароля";

    $TEXT['apanel-fcm-label-title'] = "Создать Push Notification";
    $TEXT['apanel-fcm-label-recently-title'] = "Последнии push-messages";
    $TEXT['apanel-fcm-type-for-all'] = "Будет показано, даже если пользователь не авторизирован";
    $TEXT['apanel-fcm-type-for-authorized'] = "Будет показано, только если пользователь авторизирован";
    $TEXT['apanel-fcm-type-for-all-users'] = "Для всех пользователей";
    $TEXT['apanel-fcm-type-for-authorized-users'] = "Только для авторизированных пользователей";

    $TEXT['apanel-label-tickets'] = "Сообщения";
    $TEXT['apanel-label-unknown'] = "Неизвестный";
    $TEXT['apanel-label-reports'] = "Жалобы";
    $TEXT['apanel-label-items'] = "Объекты";
    $TEXT['apanel-label-messages'] = "Сообщения";
    $TEXT['apanel-label-chats'] = "Беседы";

    $TEXT['apanel-label-img'] = "Картинка";
    $TEXT['apanel-label-abuse'] = "Нарушение";
    $TEXT['apanel-label-to-item'] = "На элемент";
    $TEXT['apanel-label-to'] = "На";
    $TEXT['apanel-label-from'] = "От";
    $TEXT['apanel-label-subject'] = "Тема";
    $TEXT['apanel-label-text'] = "Текст";
    $TEXT['apanel-label-date'] = "Дата";
    $TEXT['apanel-label-action'] = "Действие";
    $TEXT['apanel-label-warning'] = "Внимание!";
    $TEXT['apanel-label-app-changes-effect-desc'] = "Изменения отбразятся в приложении только при следующей авторизации пользователя или перапуске приложения.";
    $TEXT['apanel-label-demo-fcm-off-desc'] = "Отправка (FCM) невозможна в демо версии. Это сделано, чтобы предовратить рассылку спама и оскорбительных выражений.";
    $TEXT['apanel-label-type'] = "Тип";
    $TEXT['apanel-label-status'] = "Статус";
    $TEXT['apanel-label-delivered'] = "Доставлено";
    $TEXT['apanel-label-demo-mode'] = "Демо версия!";
    $TEXT['apanel-label-demo-mode-desc'] = "Внимание! Активен режим демо версии! Сделанные Вами изменения не будут сохранены.";

    $TEXT['apanel-label-total-accounts'] = "Всего аккаунтов";
    $TEXT['apanel-label-total-market-items'] = "Всего объявлений";
    $TEXT['apanel-label-total-chats'] = "Всего бесед";
    $TEXT['apanel-label-total-messages'] = "Всего сообщений";
    $TEXT['apanel-label-removed-chats'] = "Удалено бесед";
    $TEXT['apanel-label-removed-messages'] = "Удалено сообщений";
    $TEXT['apanel-label-active-chats'] = "Активных бесед";
    $TEXT['apanel-label-active-messages'] = "Активных сообщений";

    $TEXT['apanel-label-stats-total-items'] = "Всего";
    $TEXT['apanel-label-stats-approved-items'] = "Одобрено";
    $TEXT['apanel-label-stats-rejected-items'] = "Отклонено";
    $TEXT['apanel-label-stats-active-items'] = "Активно";
    $TEXT['apanel-label-stats-inactive-items'] = "Неактивно";
    $TEXT['apanel-label-stats-removed-items'] = "Удалено";
    $TEXT['apanel-label-stats-unmoderated-items'] = "Нужна модерация";
    $TEXT['apanel-label-stats-blocked-items'] = "Заблокировано";

    $TEXT['apanel-label-stats-active-items-reports'] = "Жалобы на объявления";
    $TEXT['apanel-label-stats-active-profiles-reports'] = "Жалобы на пользователей";
    $TEXT['apanel-label-stats-active-support-items'] = "Обращения в поддержку";
    $TEXT['apanel-label-stats-active-likes'] = "Всего объявлений в избранном";
    $TEXT['apanel-label-stats-recently-profiles-list'] = "Недавно зарегистрированные пользователи";
    $TEXT['apanel-label-stats-recently-profiles-list-desc'] = "Нажмите на профиль для просмотра деталей";

    $TEXT['apanel-label-stats-market'] = "Объявления";
    $TEXT['apanel-label-stats-messages'] = "Сообщения и беседы";
    $TEXT['apanel-label-stats-accounts'] = "Аккаунты";
    $TEXT['apanel-label-stats-reports'] = "Жалобы";
    $TEXT['apanel-label-stats-support'] = "Поддержка";
    $TEXT['apanel-label-stats-other'] = "Разное";

    $TEXT['apanel-label-stats-profile-chats'] = "Бесебы пользователя";
    $TEXT['apanel-label-stats-profile-chats-desc'] = "Нажмите на беседу, чтобы увидеть сообщения";

    $TEXT['apanel-label-stats-profile-reports'] = "Жалобы на пользователя";
    $TEXT['apanel-label-stats-profile-items'] = "Объявления пользователя";

    $TEXT['apanel-action-admob-action-off-for-new-users'] = "Выключить Admob для новых пользователей";
    $TEXT['apanel-action-admob-action-on-for-new-users'] = "Включить Admob для новых пользователей";
    $TEXT['apanel-action-admob-action-off-for-all-users'] = "Выключить Admob во всех аккаунтах";
    $TEXT['apanel-action-admob-action-on-for-all-users'] = "Включить Admob во всех аккаунтах";

    $TEXT['apanel-label-admob-active-accounts'] = "Аккаунты с активным AdMob (On)";
    $TEXT['apanel-label-admob-inactive-accounts'] = "Аккаунты с неактивным AdMob (Off)";
    $TEXT['apanel-label-admob-default-for-new-accounts'] = "Статус AdMob для новых пользователей";

    $TEXT['apanel-delete-dialog-title'] = "Удалить";
    $TEXT['apanel-delete-dialog-header'] = "Вы действительно хотите удалить это?";
    $TEXT['apanel-delete-category-dialog-sub-header'] = "Если вы удалите категорию, все подкатегории будут удалены и все элементы которые относятся к этой категории и подкатегориям получат значение по умолчанию равное 0 (category and subcategory fields in db table)";
    $TEXT['apanel-delete-subcategory-dialog-sub-header'] = "Если вы удалите подкатегорию все элементы которые относятся к этой подкатегории получат значение по умолчанию равное 0 (subcategory field in db table)";

    $TEXT['apanel-label-moderation'] = "Модерация";
    $TEXT['apanel-label-moderation-photos'] = "Фото профиля";
    $TEXT['apanel-label-moderation-covers'] = "Обложка профиля";

    // For Web site

    $TEXT['topbar-users'] = "Пользователи";

    $TEXT['topbar-stats'] = "Статистика";

    $TEXT['topbar-signin'] = "Вход";

    $TEXT['topbar-logout'] = "Выйти";

    $TEXT['topbar-signup'] = "Регистрация";

    $TEXT['topbar-settings'] = "Настройки";

    $TEXT['topbar-support'] = "Поддержка";

    $TEXT['topbar-profile'] = "Профиль";

    $TEXT['topbar-likes'] = "Уведомления";

    $TEXT['topbar-notifications'] = "Уведомления";

    $TEXT['topbar-search'] = "Поиск";

    $TEXT['topbar-main-page'] = "Главная";

    $TEXT['topbar-wall'] = "Главная";

    $TEXT['topbar-messages'] = "Сообщения";

    $TEXT['footer-about'] = "о сайте";

    $TEXT['footer-terms'] = "правила";

    $TEXT['footer-contact'] = "контакты";

    $TEXT['footer-support'] = "поддержка";

    $TEXT['page-main'] = "Главная";

    $TEXT['page-users'] = "Пользователи";

    $TEXT['page-terms'] = "Правила";

    $TEXT['page-about'] = "О сайте";

    $TEXT['page-language'] = "Выбирете язык";

    $TEXT['page-support'] = "Поддержка";

    $TEXT['page-restore'] = "Восстановление пароля";

    $TEXT['page-restore-sub-title'] = "Пожалуйста введите email, который был указан при регистрации";

    $TEXT['page-signup'] = "регистрация";

    $TEXT['page-login'] = "Войти";

    $TEXT['page-blacklist'] = "Черный список";

    $TEXT['page-messages'] = "Сообщения";




    $TEXT['page-search'] = "Поиск";

    $TEXT['page-profile-report'] = "Жалоба";

    $TEXT['page-profile-block'] = "Блокировать";

    $TEXT['page-profile-upload-avatar'] = "Сменить фото";

    $TEXT['page-profile-upload-cover'] = "Сменить обложку";

    $TEXT['page-profile-report-sub-title'] = "Профили, на которые есть жалобы, проверяются модератором и могут быть блокированы, если они нарушают наши правила";

    $TEXT['page-profile-block-sub-title'] = "не сможет писать комментарии к вашим постам и отправлять Вам личные сообщения, и вы не будите получать уведомлений от";



    $TEXT['page-likes'] = "Люди, которым это нравиться";

    $TEXT['page-services'] = "Сервисы";

    $TEXT['page-services-sub-title'] = "Соедините Marketplace с аккаунтом в социальной сети";

    $TEXT['page-prompt'] = "регистрация или вход";

    $TEXT['page-settings'] = "Настройки";

    $TEXT['page-profile-settings'] = "Профиль";

    $TEXT['page-profile-password'] = "Сменить пароль";

    $TEXT['page-notifications-likes'] = "Уведомления";

    $TEXT['page-profile-deactivation'] = "Деактивировать профиль";

    $TEXT['page-profile-deactivation-sub-title'] = "Покидаете нас?<br>Все ваши объявления будут удалены!<br>Помните, что Вы всегда можете вернуться назад, введя свой логин и пароль на странице входа. Мы будем скучать без Вас!";

    $TEXT['page-error-404'] = "Страница не найдена";

    $TEXT['label-location'] = "Местоположение";
    $TEXT['label-facebook-link'] = "Страница Facebook";
    $TEXT['label-instagram-link'] = "Страница Instagram";
    $TEXT['label-status'] = "О себе";

    $TEXT['label-error-404'] = "Запрашиваемая страница не найдена.";

    $TEXT['label-account-disabled'] = "Пользователь отключил свой аккаунт.";

    $TEXT['label-account-blocked'] = "Аккаунт заблокирован администратором.";

    $TEXT['label-account-deactivated'] = "Аккаунт не активирован.";

    $TEXT['label-reposition-cover'] = "Обложку можно двигать";

    $TEXT['label-or'] = "или";

    $TEXT['label-and'] = "и";

    $TEXT['label-signup-confirm'] = "При нажатии Регистрация, Вы соглашаетесь с нашими";



    $TEXT['label-empty-page'] = "Здесь пусто.";


    $TEXT['label-empty-list'] = "Список пуст.";

    $TEXT['label-empty-feeds'] = "Здесь Вы будите видеть записи Ваших друзей.";

    $TEXT['label-search-result'] = "Результаты поиска";

    $TEXT['label-search-empty'] = "Ничего не найдено.";

    $TEXT['label-search-prompt'] = "Искать пользователей по логину.";

    $TEXT['label-who-us'] = "Смотрите кто с нами";

    $TEXT['label-thanks'] = "Ура!";





    $TEXT['label-messages-privacy'] = "Настройки сообщений";

    $TEXT['label-messages-allow'] = "Принимать сообщения от всех пользователей.";

    $TEXT['label-messages-allow-desc'] = "Вы будете иметь возможность получать сообщения от любого пользователя";

    $TEXT['label-settings-saved'] = "Настройки сохранены.";

    $TEXT['label-password-saved'] = "Пароль изменен.";

    $TEXT['label-profile-settings-links'] = "А также";

    $TEXT['label-photo'] = "Фото";

    $TEXT['label-username'] = "Логин";

    $TEXT['label-fullname'] = "Полное имя";

    $TEXT['label-services'] = "Сервисы";

    $TEXT['label-blacklist'] = "Черный список";

    $TEXT['label-blacklist-desc'] = "Смотреть черный список";

    $TEXT['label-profile'] = "Профиль";

    $TEXT['label-email'] = "Email";

    $TEXT['label-password'] = "Пароль";

    $TEXT['label-old-password'] = "Текущий пароль";

    $TEXT['label-new-password'] = "Новый пароль";

    $TEXT['label-change-password'] = "Сменить пароль";

    $TEXT['label-facebook'] = "Facebook";

    $TEXT['label-placeholder-message'] = "Написать сообщение...";

    $TEXT['label-img-format'] = "Максимально 3 Mb. JPG, PNG";

    $TEXT['label-message'] = "Сообщение";

    $TEXT['label-subject'] = "Тема";

    $TEXT['label-support-message'] = "В чем Ваша проблема?";

    $TEXT['label-support-sub-title'] = "Мы рады слышать Вас! ";

    $TEXT['label-profile-reported'] = "Отчет отправлен!";

    $TEXT['label-profile-report-reason-1'] = "Спам.";

    $TEXT['label-profile-report-reason-2'] = "Грубое поведение.";

    $TEXT['label-profile-report-reason-3'] = "Порнография.";

    $TEXT['label-profile-report-reason-4'] = "Поддельный профиль.";

    $TEXT['label-profile-report-reason-5'] = "Пиратство.";

    $TEXT['label-success'] = "Успешно";

    $TEXT['label-password-reset-success'] = "Новый пароль успешно установлен!";

    $TEXT['label-verify'] = "проверен";

    $TEXT['label-account-verified'] = "Подлинный профиль";

    $TEXT['label-true'] = "true";

    $TEXT['label-false'] = "false";

    $TEXT['label-state'] = "account status";

    $TEXT['label-stats'] = "Статистика";

    $TEXT['label-id'] = "Id";

    $TEXT['label-count'] = "Count";

    $TEXT['label-repeat-password'] = "восстановить пароль";

    $TEXT['label-category'] = "Категория";

    $TEXT['label-from-user'] = "от";

    $TEXT['label-to-user'] = "для";

    $TEXT['label-reason'] = "Причина";

    $TEXT['label-action'] = "Действие";

    $TEXT['label-warning'] = "Внимание!";

    $TEXT['label-connected-with-facebook'] = "Подключить к Facebook";

    $TEXT['label-authorization-with-facebook'] = "Авторизация через Facebook.";

    $TEXT['label-services-facebook-connected'] = "Вы успешно связали свой аккаунт с Facebook!";

    $TEXT['label-services-facebook-disconnected'] = "Вы удалили связь с Facebook.";

    $TEXT['label-services-facebook-error'] = "Ваш аккаунт Facebook уже связан с другим аккаунтом.";

    $TEXT['action-login-with'] = "Войти через";

    $TEXT['action-signup-with'] = "Регистрация через";
    $TEXT['action-delete-profile-photo'] = "Удалить фото";
    $TEXT['action-delete-profile-cover'] = "Удалить обложку";
    $TEXT['action-change-photo'] = "Сменить фото";
    $TEXT['action-change-password'] = "Сменить пароль";

    $TEXT['action-more'] = "Показать еще";

    $TEXT['action-next'] = "Далее";



    $TEXT['action-add-img'] = "Добавить картинку";

    $TEXT['action-remove-img'] = "Удалить картинку";

    $TEXT['action-close'] = "Закрыть";

    $TEXT['action-go-to-conversation'] = "Перейти к беседе";

    $TEXT['action-post'] = "Запись";

    $TEXT['action-remove'] = "Удалить";

    $TEXT['action-report'] = "Жалоба";

    $TEXT['action-block'] = "Блокировать";

    $TEXT['action-unblock'] = "Разблокировать";

    $TEXT['action-send-message'] = "Сообщение";

    $TEXT['action-change-cover'] = "Сменить обложку";

    $TEXT['action-change'] = "Изменить";

    $TEXT['action-change-image'] = "Выбрать картинку";

    $TEXT['action-edit-profile'] = "Редактировать профиль";

    $TEXT['action-edit'] = "Редактировать";

    $TEXT['action-restore'] = "Восстановить";

    $TEXT['action-accept'] = "Принять";

    $TEXT['action-reject'] = "Отклонить";


    $TEXT['action-deactivation-profile'] = "Деактивировать профиль";

    $TEXT['action-connect-profile'] = "Подключиться к социальным сетям";

    $TEXT['action-connect-facebook'] = "Подключиться к Facebook";

    $TEXT['action-disconnect'] = "Разорвать связь";

    $TEXT['action-back-to-default-signup'] = "Обычная регистрация";

    $TEXT['action-back-to-main-page'] = "На главную";

    $TEXT['action-back-to-previous-page'] = "Вернуться назад";

    $TEXT['action-forgot-password'] = "Забыли пароль?";

    $TEXT['action-full-profile'] = "Смотреть полный профиль";

    $TEXT['action-delete-image'] = "Удалить картинку";

    $TEXT['action-send'] = "Отправить";

    $TEXT['action-cancel'] = "Отмена";

    $TEXT['action-upload'] = "Загрузить";

    $TEXT['action-search'] = "Поиск";

    $TEXT['action-change'] = "Изменить";

    $TEXT['action-save'] = "Сохранить";

    $TEXT['action-login'] = "Войти";

    $TEXT['action-signup'] = "Регистрация";

    $TEXT['action-join'] = "Регистрация";

    $TEXT['action-forgot-password'] = "Забыли пароль?";

    $TEXT['msg-loading'] = "Загрузка...";



    $TEXT['msg-login-taken'] = "Имя пользователя уже занято.";

    $TEXT['msg-login-incorrect'] = "Имя пользователя - не верный формат.";

    $TEXT['msg-fullname-incorrect'] = "Полное имя - не верный формат.";

    $TEXT['msg-password-incorrect'] = "Пароль - не верный формат.";

    $TEXT['msg-password-save-error'] = "Не верный формат нового пароля.";

    $TEXT['msg-email-incorrect'] = "Email не верный формат.";

    $TEXT['msg-email-taken'] = "Пользователь с таким Email уже зарегистрирован.";

    $TEXT['msg-email-not-found'] = "Пользователь с таким Email не найден в базе данных.";

    $TEXT['msg-reset-password-sent'] = "Ссылка на восстановление пароля выслана на Ваш email.";

    $TEXT['msg-error-unknown'] = "Ошибка. Повторите позже.";

    $TEXT['msg-error-authorize'] = "Не верный логин или пароль.";

    $TEXT['msg-error-deactivation'] = "Не верный пароль.";

    $TEXT['placeholder-users-search'] = "Искать пользователя по логину.";

	$TEXT['ticket-send-success'] = 'В ближайшее время Вы получите ответ на свой email.';

	$TEXT['ticket-send-error'] = 'Заполните все поля.';


    $TEXT['action-show-all'] = "Показать все";


    $TEXT['label-image-upload-description'] = "Поддерживается JPG, PNG or GIF files.";

    $TEXT['action-select-file-and-upload'] = "Выбрать файл";

     $TEXT['fb-linking'] = "Подключиться к Facebook";


    $TEXT['label-gender'] = "Пол";
    $TEXT['label-birth-date'] = "Дата рождения";
    $TEXT['label-join-date'] = "Дата регистрации";

    $TEXT['gender-unknown'] = "Не указан";
    $TEXT['gender-male'] = "Мужской";
    $TEXT['gender-female'] = "Женский";

    $TEXT['month-jan'] = "Январь";
    $TEXT['month-feb'] = "Февраль";
    $TEXT['month-mar'] = "Март";
    $TEXT['month-apr'] = "Апрель";
    $TEXT['month-may'] = "Май";
    $TEXT['month-june'] = "Июнь";
    $TEXT['month-july'] = "Июль";
    $TEXT['month-aug'] = "Август";
    $TEXT['month-sept'] = "Сентябрь";
    $TEXT['month-oct'] = "Октябрь";
    $TEXT['month-nov'] = "Ноябрь";
    $TEXT['month-dec'] = "Декабрь";

    $TEXT['topbar-stream'] = "Лента";
    $TEXT['page-categories'] = "Категории";
    $TEXT['topbar-categories'] = "Категории";
    $TEXT['page-favorites'] = "Избранное";
    $TEXT['topbar-favorites'] = "Избранное";

    $TEXT['msg-added-to-favorites'] = "Добавлено в избранное.";
    $TEXT['msg-removed-from-favorites'] = "Удалено из избранного.";

    $TEXT['page-create-item'] = "Создать объявление";
    $TEXT['page-edit-item'] = "Редактировать объявление";
    $TEXT['page-view-item'] = "Редактировать объявление";

    $TEXT['page-create-item'] = "Новое объявление";
    $TEXT['page-edit-item'] = "Редактировать объявление";
    $TEXT['page-view-item'] = "Смотреть объявление";

    $TEXT['action-create'] = "Создать";

    $TEXT['label-title'] = "Заголовок";
    $TEXT['label-category'] = "Категория";
    $TEXT['label-category-choose'] = "Выбрать категорию";
    $TEXT['label-subcategory-choose'] = "Выбрать подкатегорию";
    $TEXT['label-price'] = "Цена";
    $TEXT['label-description'] = "Описание";
    $TEXT['label-description-placeholder'] = "Описание объявления";
    $TEXT['label-image'] = "Картинка";
    $TEXT['label-image-placeholder'] = "Картинка объявления";
    $TEXT['label-allow-comments'] = "Разрешить комментариия для объявления";

    $TEXT['label-items'] = "Объявления";
    $TEXT['label-phone'] = "Мобильный номер телефона, пример: +15417543010";
    $TEXT['msg-phone-incorrect'] = "Номер телефона неверный формат.";
    $TEXT['msg-phone-taken'] = "Пользователь с таким номером телефона уже зарегистрирован.";

    $TEXT['msg-item-removed'] = "Объявление удалено.";
    $TEXT['msg-item-reported'] = "Отчет отправлен.";

    $TEXT['notify-comment'] = "сделал комментарий.";
    $TEXT['notify-comment-reply'] = "ответил на ваш комментарий.";

    $TEXT['label-placeholder-comment'] = "Написать комментарий...";
    $TEXT['label-placeholder-comments'] = "Комментарии";

    $TEXT['label-currency'] = "$";

    // new engine

    $TEXT['main-page-browser-title'] = "Сайт объявлений о покупке и продаже подержанных вещей";

    $TEXT['action-continue'] = "Продолжить";

    // New item

    $TEXT['label-ad-title'] = "Заголовок объявления";
    $TEXT['label-ad-category'] = "Категория";
    $TEXT['label-ad-subcategory'] = "Подкатегория";
    $TEXT['label-ad-currency'] = "Валюта";
    $TEXT['label-ad-price'] = "Цена";
    $TEXT['label-ad-description'] = "Описание";
    $TEXT['label-ad-photos'] = "Фотографии";
    $TEXT['label-ad-phone'] = "Номер телефона";
    $TEXT['label-ad-location'] = "Местоположение"; //Location

    $TEXT['label-ad-sub-title'] = "от 5 до 70 символов";
    $TEXT['label-ad-sub-price'] = "не должно быть 0";
    $TEXT['label-ad-sub-description'] = "от 10 до 500 символов";
    $TEXT['label-ad-sub-photos'] = "минимум одна фотография. до 5 фотографий. форматы: JPG, JPEG";
    $TEXT['label-ad-sub-phone'] = "пример: +14567894561";
    $TEXT['label-ad-sub-location'] = "Перетащите маркер или дважды кликните на нужном местоположении"; //Drag the marker or double click on the desired location.

    $TEXT['placeholder-ad-title'] = "Введите наименование товара, объекта или услуги.";
    $TEXT['placeholder-ad-description'] = "Добавьте описание вашего товара/услуги, укажите преимущества и важные детали.";
    $TEXT['placeholder-ad-phone'] = "Введите номер вашего телефона.";

    $TEXT['page-edit-ad-title'] = "Редактировать объявление";
    $TEXT['page-new-ad-title'] = "Создать объявление";
    $TEXT['action-new-ad'] = "Создать";

    $TEXT['msg-error-ad-title'] = "Введите заголовок объявления";
    $TEXT['msg-error-ad-category'] = "Выберите категорию";
    $TEXT['msg-error-ad-subcategory'] = "Выберите подкатегорию";
    $TEXT['msg-error-ad-currency'] = "Выберите валюту";
    $TEXT['msg-error-ad-price'] = "Введите цену";
    $TEXT['msg-error-ad-description'] = "Создайте описание для вашего продукта";
    $TEXT['msg-error-ad-photos'] = "Нужно добавить фотографию/картинку";
    $TEXT['msg-error-ad-phone'] = "Введите ваш номер телефона";
    $TEXT['msg-error-ad-phone-incorrect'] = "Некорректный формат номера";
    $TEXT['msg-error-ad-length-title'] = "не менее 5 символов";
    $TEXT['msg-error-ad-length-description'] = "не менее 10 символов";

    // Restore send

    $TEXT['label-restore-sent-title'] = "Письмо для сброса пароля было отправлено";
    $TEXT['label-restore-sent-msg'] = "Вам отправлен email с инструкциями по смене пароля.";

    // Restore success

    $TEXT['label-restore-success-title'] = "Восстановление пароля";
    $TEXT['label-restore-success-msg'] = "Поздравляем! Вы успешно установили новый пароль!";

    // Restore new

    $TEXT['label-restore-new-title'] = "Создайте новый пароль";
    $TEXT['label-restore-new-invalid-password-error-msg'] = "Неверный формат пароля";
    $TEXT['label-restore-new-match-passwords-error-msg'] = "Пароли не совпадают";

    // Login page

    $TEXT['label-signup-promo'] = "Не зарегистрирован? Присоединяйся сейчас!"; // Not registered? Join now!
    $TEXT['label-remember'] = "Запомнить меня"; // Remember me

    $TEXT['label-login-empty-field'] = "Это поле не должно быть пустым";

    // Signup page

    $TEXT['label-login-promo'] = "У Вас есть аккаунт? Войти"; // Do you have an account? Log in
    $TEXT['label-terms-start'] = "Нажимая кнопку Регистрация, вы подтверждаете что прочитали наши"; // By clicking Sign up button, you confirm that you have read our
    $TEXT['label-terms-link'] = "Условия использования"; // Terms of Use
    $TEXT['label-terms-and'] = "и"; // and
    $TEXT['label-terms-privacy-link'] = "Политика конфиденциальности"; // Privacy policy
    $TEXT['label-terms-cookies-link'] = "Использование cookies"; //Use of cookies

    $TEXT['label-signup-sex'] = "Пол";

    $TEXT['label-signup-tooltip-username'] = "Это Ваш логин. Используется для авторизации и как имя страницы для Вашего профиля. Только английские буквы и цифры. Минимум 5 символов";
    $TEXT['label-signup-tooltip-fullname'] = "Ваше настоящие имя и фамилия. Например: отображается на странице Вашего профиля и в сообщениях. Минимум 2 символа";
    $TEXT['label-signup-tooltip-password'] = "Пароль для вашей учетной записи. Не менее 6 символов";
    $TEXT['label-signup-tooltip-email'] = "Ваш действующий Email. Используется для восстановления пароля и связи с Вами (если это будет необходимо). Мы не рассылаем письма с рекламой и спам!";
    $TEXT['label-signup-tooltip-sex'] = "Укажите свой пол. Это сделает Ваш профиль более полным и информативным.";

    $TEXT['label-signup-placeholder-username'] = "Ваш логин";
    $TEXT['label-signup-placeholder-fullname'] = "Как Вас зовут?";
    $TEXT['label-signup-placeholder-password'] = "Введите пароль";
    $TEXT['label-signup-placeholder-email'] = "Адрес электронной почты";

    $TEXT['label-signup-error-username'] = "Некорректный формат. Только английские символы и цифры. Минимум 5 символов";
    $TEXT['label-signup-error-fullname'] = "Некорректный формат. Минимум 2 символа";
    $TEXT['label-signup-error-password'] = "Некорректный формат. Английские буквы и цифры. Минимум 6 символов";
    $TEXT['label-signup-error-email'] = "Некорректный формат";

    // Footer

    $TEXT['label-footer-about'] = "О сайте"; // About
    $TEXT['label-footer-terms'] = "Условия использования"; // Terms of Use
    $TEXT['label-footer-privacy'] = "Политика конфиденциальности"; // Privacy policy
    $TEXT['label-footer-cookies'] = "Использование cookies"; // Use of cookies
    $TEXT['label-footer-help'] = "Помощь";
    $TEXT['label-footer-support'] = "Поддержка";

    // Topbar

    $TEXT['label-topbar-home'] = "Главная";
    $TEXT['label-topbar-main'] = "Главная";
    $TEXT['label-topbar-messages'] = "Сообщения";
    $TEXT['label-topbar-notifications'] = "Уведомления";
    $TEXT['label-topbar-help'] = "Поддержка";
    $TEXT['label-topbar-search'] = "Поиск";
    $TEXT['label-topbar-favorites'] = "Избранное";

    // Actions

    $TEXT['action-favorites-promo-button'] = "Ищите сейчас!";
    $TEXT['action-new-classified'] = "Подать объявление";
    $TEXT['action-see-classified'] = "Посмотреть объявление";
    $TEXT['action-find'] = "Поиск"; //Search
    $TEXT['action-see-all'] = "Смотреть все"; //See all
    $TEXT['action-show'] = "Показать";
    $TEXT['action-yes'] = "Да";
    $TEXT['action-no'] = "Нет";
    $TEXT['action-sold'] = "Продано";
    $TEXT['action-remove-forever'] = "Удалить навсегда";
    $TEXT['action-item-inactivate'] = "Сделать неактивным";
    $TEXT['action-item-activate'] = "Сделать активным";
    $TEXT['action-show-map'] = "Показать на карте";

    // Error messages

    $TEXT['msg-photo-file-size-exceeded'] = "Превышен размер файла";
    $TEXT['msg-photo-file-size-error'] = "Размер файла слишком большой";
    $TEXT['msg-photo-format-error'] = "Неверный формат файла";
    $TEXT['msg-photo-width-height-error'] = "Высота и ширина должны быть более 300 пикселей";
    $TEXT['msg-photo-file-upload-limit'] = "Превышен лимит файлов для выгрузки";
    $TEXT['msg-empty-fields'] = "Все поля обязательны для заполнения";
    $TEXT['msg-ad-published'] = "Объявление успешно опубликовано.";
    $TEXT['msg-ad-saved'] = "Изменения успешно сохранены";
    $TEXT['msg-selected-location-error'] = "Местоположение не указано или некорректный выбор местоположения";
    $TEXT['msg-contact-promo'] = "Хотите связаться с %s? Присоединяйтесь!";
    $TEXT['msg-publish-ad-promo'] = "Опубликуйте свое первое объявление!"; // Post your first classified!
    $TEXT['msg-empty-profile-items'] = "Нет объявлений."; // No classifieds.
    $TEXT['msg-search-empty'] = "По вашему запросу ничего не найдено :(";
    $TEXT['msg-search-success'] = "Найдено %d объявлений";
    $TEXT['msg-confirm-delete'] = "Вы уверены, что хотите удалить это?";
    $TEXT['msg-feature-disabled'] = "На данный момент эта функция отключена администратором. Простите за временные неудобства. Пожалуйста попробуйте позже.";
    $TEXT['msg-block-user-text'] = "Пользователь %s будет добавлен в Ваш черный список. Вы не будете получать от пользователя %s личные сообщения и другие уведомления. Вы подтверждаете свое действие?";
    $TEXT['msg-unblock-user-text'] = "Пользователь %s будет удален из Вашего черного списка. Вы подтверждаете свое действие?";
    $TEXT['msg-unblock-user-text-2'] = "Пользователь будет удален из Вашего черного списка. Вы подтверждаете свое действие?";
    $TEXT['msg-item-success-removed'] = "Ваше объявление было успешно удалено";
    $TEXT['msg-item-success-inactivated'] = "Ваше объявление было успешно деактивировано";
    $TEXT['msg-favorites-added'] = "Добавлено в избранное";
    $TEXT['msg-favorites-removed'] = "Удалено из избранного";

    $TEXT['msg-item-not-active'] = "Объявление не активно.";
    $TEXT['msg-item-make-active-promo'] = "Чтобы сделать это объявление активным - Вам нужно отредактировать его.";
    $TEXT['msg-item-make-active-description'] = "Пожалуйста, исправьте ваше объявление. Введите корректный заголовок, выберите актуальную категорию, создайте описание и добавьте изображения.";

    $TEXT['msg-confirm-inactive-title'] = "Объявление будет отмечено как \"Не активно\". Объявление не будет отображатся в поиске и в вашем профиле. В объявлении будет скрыт номер Вашего телефона.";
    $TEXT['msg-confirm-inactive-hint'] = "Вы будете иметь возможность в любое время удалить, отредактировать и сделать это объявление снова активным.";
    $TEXT['msg-confirm-inactive-subtitle'] = "Вы уверены, что хотите сделать это?";

    // Info messages

    $TEXT['page-notifications-empty-list'] = "У вас нет новых уведомлений";
    $TEXT['page-messages-empty-list'] = "У вас еще нет бесед";
    $TEXT['page-classifieds-items-empty-list'] = "У вас нет активных объявлений";
    $TEXT['page-empty-list'] = "Список пуст";
    $TEXT['page-blacklist-empty-list'] = "У вас нет пользователей в Вашем черном списке";
    $TEXT['page-favorites-empty-list'] = "Пока что Вы ничего не добавили в свое избранное";

    // Item View

    $TEXT['page-item-view-title'] = "Объявление";
    $TEXT['msg-item-not-found'] = "Объявление не существует или было удалено.";

    // Pages

    $TEXT['page-about'] = "О сайте"; // About
    $TEXT['page-terms'] = "Условия использования"; // Terms of Use
    $TEXT['page-privacy'] = "Политика конфиденциальности"; // Privacy policy
    $TEXT['page-cookies'] = "Использование cookies"; // Use of cookies
    $TEXT['page-gdpr'] = "GDPR (Общий регламент по защите данных)";
    $TEXT['page-support'] = "Поддержка";
    $TEXT['page-profile'] = "Профиль";
    $TEXT['page-favorites'] = "Избранное";
    $TEXT['page-notifications'] = "Уведомления";
    $TEXT['page-messages'] = "Сообщения";
    $TEXT['page-chat'] = "Беседа";
    $TEXT['page-items'] = "Объявления";

    $TEXT['page-404'] = "Страница не найдена";
    $TEXT['page-404-description'] = "Запрашиваемая страница не найдена";

    $TEXT['page-under-construction'] = "Скоро";
    $TEXT['page-under-construction-description'] = "Наш веб-сайт в настоящее время проходит плановое техническое обслуживание. Мы должны вернуться в ближайшее время. Спасибо за терпеливость.";

    // Support

    $TEXT['label-support-subject'] = "Тема";
    $TEXT['label-support-details'] = "Подробнее";
    $TEXT['label-support-email-placeholder'] = "Ваш Email";
    $TEXT['label-support-subject-placeholder'] = "О чем хотите сообщить? Тема сообщения.";
    $TEXT['label-support-details-placeholder'] = "Опишите проблему детально";
    $TEXT['label-support-sent-title'] = "Ваш запрос получен";
    $TEXT['label-support-sent-msg'] = "В ближайшее время мы обработаем Ваш запрос и свяжемся с Вами, если это будет необходимо.";

    // Labels

    $TEXT['placeholder-login-username'] = "Введите Ваш логин или Email";
    $TEXT['placeholder-login-password'] = "Введите Ваш пароль";

    $TEXT['label-username-or-email'] = "Логин или Email";

    $TEXT['label-search-query'] = "Текст поиска";
    $TEXT['placeholder-search-query'] = "Что вы ищите?";
    $TEXT['label-all-categories'] = "Все категории";
    $TEXT['label-all-profile-items'] = "%d объявлений";
    $TEXT['label-cookie-message'] = "Для реализации основных услуг и функций нашего сайта, а также для сбора данных о том, как посетители взаимодействуют с нашими сайтом, продуктами и услугами, мы применяем различные инструменты, включая файлы \"cookies\". Используя веб-сайт, вы соглашаетесь с нашими  ";

    $TEXT['label-filters'] = "Фильтры";
    $TEXT['label-filters-all'] = "Все";
    $TEXT['label-filters-comments'] = "Комментарии";
    $TEXT['label-filters-likes'] = "Лайки";
    $TEXT['label-filters-replies'] = "Ответы";
    $TEXT['label-filters-approved'] = "Одобренные";
    $TEXT['label-filters-rejected'] = "Отклоненные";

    $TEXT['label-search-filters-moderation-type'] = "Модерация";
    $TEXT['label-search-filters-moderation-only'] = "Только проверенные модераторами";
    $TEXT['label-search-filters-sort-type'] = "Сортировать";
    $TEXT['label-search-filters-sort-by-new'] = "От новых к старым";
    $TEXT['label-search-filters-sort-by-old'] = "От старых к новым";

    $TEXT['label-search-filters-location-type'] = "Где искать?";
    $TEXT['label-search-filters-location-type-all'] = "Везде";
    $TEXT['label-search-filters-location-type-selected'] = "Выбранное местоположение";
    $TEXT['label-search-filters-distance-type'] = "Расстояние";
    $TEXT['label-search-filters-distance-type-all'] = "Везде";
    $TEXT['label-search-filters-distance-type-5'] = "5км";
    $TEXT['label-search-filters-distance-type-15'] = "15км";
    $TEXT['label-search-filters-distance-type-30'] = "30км";
    $TEXT['label-search-filters-distance-type-50'] = "50км";
    $TEXT['label-search-filters-distance-type-100'] = "100км";
    $TEXT['label-search-filters-distance-type-300'] = "300км";
    $TEXT['label-search-filters-distance-type-500'] = "500км";
    $TEXT['label-search-filters-distance-type-700'] = "700км";

    $TEXT['label-optional'] = "необязательный";
    $TEXT['label-detail'] = "подробно";

    $TEXT['label-just-now'] = "только что";

    $TEXT['label-item-approved'] = "Проверено";
    $TEXT['label-item-approved-title'] = "Проверено модератором";
    $TEXT['label-item-rejected'] = "Отклонено";
    $TEXT['label-item-rejected-title'] = "Отклонено модератором";

    $TEXT['label-item-active'] = "Активное";
    $TEXT['label-item-inactive'] = "Неактивное";
    $TEXT['label-item-hot'] = "Горячее";
    $TEXT['label-item-popular'] = "Популярное";
    $TEXT['label-item-new'] = "Новое";

    $TEXT['label-favorites-add'] = "Добавить в избранное";
    $TEXT['label-favorites-remove'] = "Удалить из избранного";

    $TEXT['label-notify-item'] = "Объявление";
    $TEXT['label-notify-item-approved'] = "Ваше %s проверено и одобрено модератором.";
    $TEXT['label-notify-item-rejected'] = "Ваше %s отклонено модератором.";

    $TEXT['label-safety-tips-title'] = "Советы по безопасности для покупателей";
    $TEXT['label-safety-tips-1'] = "Не отправляйте деньги до получения товара";
    $TEXT['label-safety-tips-2'] = "Проверьте товар перед покупкой";
    $TEXT['label-safety-tips-3'] = "Оплата после получения и проверки товара";
    $TEXT['label-safety-tips-4'] = "Познакомьтесь с продавцом в безопасном месте";

    $TEXT['label-created-by-web-app'] = "Опубликовано с сайта";
    $TEXT['label-created-by-android-app'] = "Опубликовано из приложения Android";
    $TEXT['label-created-by-ios-app'] = "Опубликовано из приложения iOS";

    $TEXT['label-item-stats'] = "Статистика";
    $TEXT['label-item-stats-views'] = "Просмотры";
    $TEXT['label-item-stats-likes'] = "Нравится";
    $TEXT['label-item-stats-favorites'] = "Добавлено в избранное";
    $TEXT['label-item-stats-phone-views'] = "Просмотры телефонного номера";

    $TEXT['label-item-disclaimer-title'] = "Отказ от ответственности";
    $TEXT['label-item-disclaimer-desc'] = "Мы не контролируем контент, размещенный участниками, и поэтому не несем никакой ответственности за любые последствия, прямо или косвенно связанные с какими-либо действиями или бездействием.";

    $TEXT['label-items-related'] = "Похожие объявления";
    $TEXT['label-items-more-from-author'] = "Еще от %s";
    $TEXT['label-items-latest'] = "Последние объявления";
    $TEXT['label-items-featured'] = "Особые объявления";
    $TEXT['label-items-popular'] = "Популярные объявления";

    // Settings

    $TEXT['page-settings'] = "Настройки";
    $TEXT['page-settings-account'] = "Настройки";
    $TEXT['page-settings-profile'] = "Профиль";
    $TEXT['page-settings-privacy'] = "Конфиденциальность";
    $TEXT['page-settings-password'] = "Сменить пароль";
    $TEXT['page-settings-blacklist'] = "Черный список";
    $TEXT['page-settings-connections'] = "Социальные сети";
    $TEXT['page-settings-deactivation'] = "Деактивировать аккаунт";

    $TEXT['label-privacy-messages'] = "Сообщения";
    $TEXT['label-privacy-allow-messages'] = "Получать сообщения";

    $TEXT['label-sex'] = "Пол";
    $TEXT['label-sex-unknown'] = "Не указан";
    $TEXT['label-sex-male'] = "Мужской";
    $TEXT['label-sex-female'] = "Женский";

    $TEXT['label-bio'] = "О себе";
    $TEXT['label-phone-number'] = "Номер телефона";
    $TEXT['placeholder-phone-number'] = "Номер телефона, например: +15417543010";

    $TEXT['placeholder-bio'] = "Расскажите немного о себе";
    $TEXT['placeholder-facebook-page'] = "Ссылка на страницу в Facebook";
    $TEXT['placeholder-instagram-page'] = "Ссылка на страницу в Instagram";

    $TEXT['action-deactivate'] = "Деактивировать";
    $TEXT['label-password'] = "Пароль";
    $TEXT['placeholder-password-current'] = "Текущий пароль";
    $TEXT['label-password-current'] = "Текущий пароль";
    $TEXT['label-password-new'] = "Новый пароль";
    $TEXT['placeholder-password-new'] = "Новый пароль";

    $TEXT['msg-deactivation-promo'] = "<b>Внимание!</b><br>Все ваши данные, фотографии, сообщения и профиль будут удалены! Вы не сможете восстановить эти данные!";
    $TEXT['msg-deactivation-error'] = "Неверный пароль.";

    $TEXT['msg-settings-saved'] = "Настройки сохранены.";
    $TEXT['msg-password-saved'] = "Пароль успешно изменен.";

    $TEXT['msg-password-new-format-error'] = "Пароль не изменен, неверный формат для нового пароля.";
    $TEXT['msg-password-current-format-error'] = "Пароль не изменен, неверный формат для текущего пароля.";
    $TEXT['msg-password-current-error'] = "Пароль не изменен, неверный текущий пароль.";

    // Dialogs

    $TEXT['dlg-confirm-block-title'] = "Заблокировать пользователя";
    $TEXT['dlg-confirm-unblock-title'] = "Разблокировать пользователя";
    $TEXT['dlg-confirm-action-title'] = "Подтвердите действие";
    $TEXT['dlg-item-title'] = "Пост";
    $TEXT['dlg-message-title'] = "Сообщение";
    $TEXT['dlg-message-placeholder'] = "Введите текст сообщения...";
    $TEXT['dlg-report-profile-title'] = "Жалоба на пользователя";
    $TEXT['dlg-report-item-title'] = "Жалоба";
    $TEXT['dlg-report-sub-title'] = "Причина Вашей жалобы";
    $TEXT['dlg-report-description-label'] = "Описание";
    $TEXT['dlg-report-description-placeholder'] = "Вы можете детально описать причину жалобы...";

    // Social connections

    $TEXT['page-settings-connections-sub-title'] = "Соедините %s с аккаунтом в социальной сети";

    $TEXT['label-notify-profile-photo-rejected'] = "Фотография вашего профиля была отклонена модератором. Пожалуйста, загрузите другое фото/изображение.";
    $TEXT['label-notify-profile-cover-rejected'] = "Обложка вашего профиля была отклонена модератором. Пожалуйста, загрузите другое фото/изображение.";

    //

    $TEXT['label-currency-choose'] = "Выберите валюту";
    $TEXT['label-currency-free'] = "Бесплатно";
    $TEXT['label-currency-negotiable'] = "Договорная";