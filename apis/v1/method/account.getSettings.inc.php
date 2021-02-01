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

    $lastNotifyView = isset($_POST['lastNotifyView']) ? $_POST['lastNotifyView'] : 0;

    $accountId = helper::clearInt($accountId);

    $accessToken = helper::clearText($accessToken);
    $accessToken = helper::escapeText($accessToken);

    $lastNotifyView = helper::clearInt($lastNotifyView);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    $result = array("error" => false,
                    "error_code" => ERROR_SUCCESS);

    // Get new messages count | chats with new (unread) messages

    $messages_count = 0;

    if (APP_MESSAGES_COUNTERS) {

        $msg = new msg($dbo);
        $msg->setRequestFrom($accountId);

        $messages_count = $msg->getNewMessagesCount();

        unset($msg);
    }

    // Get notifications count | unread notifications

    $notifications_count = 0;

    $notifications = new notifications($dbo);
    $notifications->setRequestFrom($accountId);

    $notifications_count = $notifications->getNewCount($lastNotifyView);

    unset($notifications);

    // Set data to result

    $result['messagesCount'] = $messages_count;
    $result['notificationsCount'] = $notifications_count;

    // Send result to app

    echo json_encode($result);
    exit;
}
