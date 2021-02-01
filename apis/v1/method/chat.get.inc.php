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

    $profileId = isset($_POST['profileId']) ? $_POST['profileId'] : 0;

    $adItemId = isset($_POST['adItemId']) ? $_POST['adItemId'] : 0;

    $chatFromUserId = isset($_POST['chatFromUserId']) ? $_POST['chatFromUserId'] : 0;
    $chatToUserId = isset($_POST['chatToUserId']) ? $_POST['chatToUserId'] : 0;

    $chatId = isset($_POST['chatId']) ? $_POST['chatId'] : 0;
    $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $profileId = helper::clearInt($profileId);

    $adItemId = helper::clearInt($adItemId);

    $chatFromUserId = helper::clearInt($chatFromUserId);
    $chatToUserId = helper::clearInt($chatToUserId);

    $chatId = helper::clearInt($chatId);
    $pageId = helper::clearInt($pageId);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    $msg = new msg($dbo);
    $msg->setRequestFrom($accountId);

    if ($chatId == 0) {

        $chatId = $msg->getAdChatId($accountId, $profileId, $adItemId);
    }

    $chatInfo = $msg->chatInfo($chatId);

    if (!$chatInfo['error'] && $chatInfo['removeAt'] == 0 && ($chatInfo['toUserId'] == $accountId || $chatInfo['fromUserId'] == $accountId)) {

        $messenger = new messenger($dbo);
        $messenger->setRequestFrom(auth::getCurrentUserId());
        $messenger->setChatId($chatId);
        $result = $messenger->getItems($pageId);

        $result['chatFromUserId'] = $chatInfo['fromUserId'];
        $result['chatToUserId'] = $chatInfo['toUserId'];
        $result['chatId'] = $chatInfo['id'];

        $result['lastMessageCreateAt'] = $chatInfo['lastMessageCreateAt'];
        $result['fromUserId_lastView'] = $chatInfo['fromUserId_lastView'];
        $result['toUserId_lastView'] = $chatInfo['toUserId_lastView'];
    }

    echo json_encode($result);
    exit;
}
