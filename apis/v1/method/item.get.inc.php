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

    $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $itemId = helper::clearInt($itemId);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);


    $items = new items($dbo);
    $items->setRequestFrom($accountId);

    $itemInfo = $items->info($itemId);

    if (!$itemInfo['error'] && $itemInfo['removeAt'] == 0) {

        $result = array("error" => false,
                        "error_code" => ERROR_SUCCESS,
                        "itemId" => $itemId,
                        "items" => array(),
                        "images" => array());

        array_push($result['items'], $itemInfo);

        if ($itemInfo['imagesCount'] > 0) {

            $images = new images($dbo);
            $images->setRequestFrom($accountId);

            array_push($result['images'], $images->get($itemId));
        }

        // Update views count
        // if not rejected and if not my item

        if ($itemInfo['rejectedAt'] == 0 && $itemInfo['fromUserId'] != $accountId) {

            $itemInfo['viewsCount']++;
            $itemInfo['rating'] = $itemInfo['rating'] + ITEM_RATING_VIEW_VALUE;

            $items->setViewsCount($itemInfo['id'], $itemInfo['viewsCount'], $itemInfo['rating']);
        }
    }

    echo json_encode($result);
    exit;
}
