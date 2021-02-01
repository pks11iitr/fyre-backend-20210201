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
    $adItemTitle = isset($_POST['adItemTitle']) ? $_POST['adItemTitle'] : "";

    $chatFromUserId = isset($_POST['chatFromUserId']) ? $_POST['chatFromUserId'] : 0;
    $chatToUserId = isset($_POST['chatToUserId']) ? $_POST['chatToUserId'] : 0;

    $chatId = isset($_POST['chatId']) ? $_POST['chatId'] : 0;
    $messageText = isset($_POST['messageText']) ? $_POST['messageText'] : "";
    $messageImg = isset($_POST['messageImg']) ? $_POST['messageImg'] : "";

    $listId = isset($_POST['listId']) ? $_POST['listId'] : 0;

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $profileId = helper::clearInt($profileId);

    $adItemId = helper::clearInt($adItemId);
    $adItemTitle = helper::clearText($adItemTitle);
    $adItemTitle = helper::escapeText($adItemTitle);

    $chatFromUserId = helper::clearInt($chatFromUserId);
    $chatToUserId = helper::clearInt($chatToUserId);

    $chatId = helper::clearInt($chatId);

    $listId = helper::clearInt($listId);

    $messageText = helper::clearText($messageText);

    $messageText = preg_replace( "/[\r\n]+/", "<br>", $messageText); //replace all new lines to one new line
    $messageText  = preg_replace('/\s+/', ' ', $messageText);        //replace all white spaces to one space

    $messageText = helper::escapeText($messageText);

    $messageImg = helper::clearText($messageImg);
    $messageImg = helper::escapeText($messageImg);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    if ($profileId == $accountId) {

        // You can not send messages to yourself

        echo json_encode($result);
        exit;
    }

    $profile = new profile($dbo, $profileId);
    $profile->setRequestFrom($accountId);

    $profileInfo = $profile->getVeryShort();

    if ($profileInfo['error']) {

        echo json_encode($result);
        exit;
    }

    if ($profileInfo['state'] != ACCOUNT_STATE_ENABLED) {

        echo json_encode($result);
        exit;
    }

    if ($profileInfo['allowMessages'] == 0) {

        echo json_encode($result);
        exit;
    }

    // is my profile exists in blacklist

    $inBlackList = false;

    $blacklist = new blacklist($dbo);
    $blacklist->setRequestFrom($profileId);

    if ($blacklist->isExists($accountId)) {

        $inBlackList = true;
    }

    unset($blacklist);

    // Send message

    if (!$inBlackList) {

        $messages = new msg($dbo);
        $messages->setRequestFrom($accountId);

        $result = $messages->create($profileId, $chatId, $messageText, $messageImg, $adItemId, $adItemTitle, $listId);
    }

    echo json_encode($result);
    exit;
}
