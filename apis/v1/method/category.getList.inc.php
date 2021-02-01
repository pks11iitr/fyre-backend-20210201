<?php

/*!
 * ifsoft.co.uk
 *
 * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
 */

if (!defined("APP_SIGNATURE")) {

    header("Location: /");
    exit;
}

if (!empty($_POST)) {

    $clientId = isset($_POST['clientId']) ? $_POST['clientId'] : 0;

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $language = isset($_POST['lang']) ? $_POST['lang'] : 'en';

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $language = helper::clearText($language);
    $language = helper::escapeText($language);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $category = new category($dbo);
    $category->setLanguage($language);
    $category->setRequestFrom($accountId);

    $result = $category->getList();
    //die('sdsfsfsfs');
    echo json_encode($result);
    exit;
}
