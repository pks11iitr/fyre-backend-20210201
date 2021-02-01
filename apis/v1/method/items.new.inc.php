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

    $appType = isset($_POST['appType']) ? $_POST['appType'] : 0; // 0 = APP_TYPE_UNKNOWN

    $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
    $subCategoryId = isset($_POST['subcategoryId']) ? $_POST['subcategoryId'] : 0;
    $price = isset($_POST['price']) ? $_POST['price'] : 0;
    $currency = isset($_POST['currency']) ? $_POST['currency'] : 3;
    $allowComments = isset($_POST['allowComments']) ? $_POST['allowComments'] : 0;

    $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $imgUrl = isset($_POST['imgUrl']) ? $_POST['imgUrl'] : '';

    $postArea = isset($_POST['postArea']) ? $_POST['postArea'] : '';
    $postCountry = isset($_POST['postCountry']) ? $_POST['postCountry'] : '';
    $postCity = isset($_POST['postCity']) ? $_POST['postCity'] : '';
    $postLat = isset($_POST['postLat']) ? $_POST['postLat'] : '0.000000';
    $postLng = isset($_POST['postLng']) ? $_POST['postLng'] : '0.000000';

    $imagesArray = isset($_POST['images']) ? $_POST['images'] : array();

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $appType = helper::clearInt($appType);

    $categoryId = helper::clearInt($categoryId);
    $subCategoryId = helper::clearInt($subCategoryId);
    $price = helper::clearInt($price);
    $currency = helper::clearInt($currency);
    $allowComments = helper::clearInt($allowComments);

    $phoneNumber = helper::clearText($phoneNumber);
    $phoneNumber = helper::escapeText($phoneNumber);

    $title = helper::clearText($title);
    $title = helper::escapeText($title);

    $description = helper::clearText($description);

    $description = preg_replace( "/[\r\n]+/", "<br>", $description); //replace all new lines to one new line
    $description  = preg_replace('/\s+/', ' ', $description);        //replace all white spaces to one space

    $description = helper::escapeText($description);

    $imgUrl = helper::clearText($imgUrl);
    $imgUrl = helper::escapeText($imgUrl);

    $postArea = helper::clearText($postArea);
    $postArea = helper::escapeText($postArea);

    $postCountry = helper::clearText($postCountry);
    $postCountry = helper::escapeText($postCountry);

    $postCity = helper::clearText($postCity);
    $postCity = helper::escapeText($postCity);

    $postLat = helper::clearText($postLat);
    $postLat = helper::escapeText($postLat);

    $postLng = helper::clearText($postLng);
    $postLng = helper::escapeText($postLng);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    $items = new items($dbo);
    $items->setRequestFrom($accountId);

    if (count($imagesArray) > 0) {

        $imgUrl = $imagesArray[0];
    }

    $result = $items->add($appType, $categoryId, $subCategoryId, $title, $title, $description, $imgUrl, $allowComments, $price, $postArea, $postCountry, $postCity, $postLat, $postLng, $currency, $phoneNumber);

    $images = new images($dbo);
    $images->setRequestFrom($accountId);

    if (count($imagesArray) > 1) {

        for ($i = 1; $i < count($imagesArray); $i++) {

            $images->add($result['itemId'], $imagesArray[$i], $imagesArray[$i], $imagesArray[$i]);
        }

        $items->setImagesCount($result['itemId'], count($imagesArray) - 1);
    }

    echo json_encode($result);
    exit;
}
