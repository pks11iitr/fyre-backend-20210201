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

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

    $accountId = helper::clearInt($accountId);

    $accessToken = helper::clearText($accessToken);
    $accessToken = helper::escapeText($accessToken);

    $itemId = helper::clearInt($itemId);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $items = new items($dbo);
    $items->setRequestFrom($accountId);

    $itemInfo = $items->info($itemId);

    if (!$itemInfo['error'] && $itemInfo['fromUserId'] != $accountId && $itemInfo['removeAt'] == 0) {

        $itemInfo['sharesCount']++;
        $itemInfo['rating'] = $itemInfo['rating'] + ITEM_RATING_SHARE_VALUE;

        $items->setSharesCount($itemId, $itemInfo['sharesCount'], $itemInfo['rating']);
    }

    echo json_encode($result);
    exit;
}
