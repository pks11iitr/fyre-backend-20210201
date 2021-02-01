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

    $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
    $subcategoryId = isset($_POST['subcategoryId']) ? $_POST['subcategoryId'] : 0;
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

    $itemId = helper::clearInt($itemId);

    $categoryId = helper::clearInt($categoryId);
    $subcategoryId = helper::clearInt($subcategoryId);
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

    $item = new items($dbo);
    $item->setRequestFrom($accountId);

    $itemInfo = $item->info($itemId);

    if ($itemInfo['error'] || $itemInfo['fromUserId'] != $accountId) {

        return $result;
    }

    if (count($imagesArray) > 0) {

        $imgUrl = $imagesArray[0];
    }

    $result = $item->edit($itemId, $categoryId, $subcategoryId, $title, $imgUrl, $description, $allowComments, $price, $postArea, $postCountry, $postCity, $postLat, $postLng, $currency, $phoneNumber);

    $images = new images($dbo);
    $images->setRequestFrom($accountId);

    $images->removeAll($itemId);

    if (count($imagesArray) > 1) {

        for ($i = 1; $i < count($imagesArray); $i++) {

            $images->add($itemId, $imagesArray[$i], $imagesArray[$i], $imagesArray[$i]);
        }

        $item->setImagesCount($itemId, count($imagesArray) - 1);
    }

    echo json_encode($result);
    exit;
}
