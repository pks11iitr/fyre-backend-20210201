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
    $appType = isset($_POST['appType']) ? $_POST['appType'] : 0; // 0 = APP_TYPE_UNKNOWN

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $query = isset($_POST['query']) ? $_POST['query'] : '';

    $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

    $sortType = isset($_POST['sortType']) ? $_POST['sortType'] : 0;
    $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
    $moderationType = isset($_POST['moderationType']) ? $_POST['moderationType'] : 0;
    $currency = isset($_POST['currency']) ? $_POST['currency'] : 0;

    $distance = isset($_POST['distance']) ? $_POST['distance'] : 30;

    $lat = isset($_POST['lat']) ? $_POST['lat'] : '0.000000';
    $lng = isset($_POST['lng']) ? $_POST['lng'] : '0.000000';

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);

    $accountId = helper::clearInt($accountId);

    $query = helper::clearText($query);
    $query = helper::escapeText($query);

    $pageId = helper::clearInt($pageId);

    $sortType = helper::clearInt($sortType);
    $categoryId = helper::clearInt($categoryId);
    $moderationType = helper::clearInt($moderationType);
    $currency = helper::clearInt($currency);

    $distance = helper::clearInt($distance);

    $lat = helper::clearText($lat);
    $lat = helper::escapeText($lat);

    $lng = helper::clearText($lng);
    $lng = helper::escapeText($lng);

    $result = array(
        "error" => true,
        "error_code" => ERROR_UNKNOWN
    );

    $finder = new finder($dbo);
    $finder->setRequestFrom($accountId);
    $finder->setRequestFromApp($appType);
    $finder->addCategoryFilter($categoryId);
    $finder->addCurrencyFilter($currency);

    if ($moderationType != 0) $finder->setModerationFilter(FILTER_ONLY_YES); // Show only moderated items

    $result = $finder->getItems($query, $pageId, $sortType, $lat, $lng, $distance);
    
    //banner
    $banners = new banner($dbo);
    $banners = $banners->getList();
    $result['banners']=$banners;
    
    //category
    $category = new home_category($dbo);
  
    $categoryies = $category->getList();
    $result['category']=$categoryies;

    echo json_encode($result);
    exit;
}
