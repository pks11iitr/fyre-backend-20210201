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

    $chatFromUserId = isset($_POST['chatFromUserId']) ? $_POST['chatFromUserId'] : 0;
    $chatToUserId = isset($_POST['chatToUserId']) ? $_POST['chatToUserId'] : 0;

    $chatId = isset($_POST['chatId']) ? $_POST['chatId'] : 0;

    $lastMessage = isset($_POST['message']) ? $_POST['message'] : "";
    $lastImage = isset($_POST['image']) ? $_POST['image'] : "";
    $lastMessageId = isset($_POST['message_id']) ? $_POST['message_id'] : 0;

    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);

    $chatFromUserId = helper::clearInt($chatFromUserId);
    $chatToUserId = helper::clearInt($chatToUserId);

    $chatId = helper::clearInt($chatId);

    $lastMessage = helper::clearText($lastMessage);
    $lastMessage = helper::escapeText($lastMessage);
    $lastMessageId = helper::clearInt($lastMessageId); //new last message id in chat from device or browser

    $lastImage = helper::clearText($lastImage);
    $lastImage = helper::escapeText($lastImage);

    $result = array("error" => false,
                    "error_code" => ERROR_UNKNOWN);

//    $auth = new auth($dbo);
//
//    if (!$auth->authorize($accountId, $accessToken)) {
//
//        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
//    }

    // current last message id in chat
    $current_last_message_id = 0;

    $msg = new msg($dbo);
    $msg->setRequestFrom($accountId);

    if ($chatFromUserId == 0) {

        $chatInfo = $msg->chatInfo($chatId);

        if (!$chatInfo['error'] && $chatInfo['removeAt'] == 0 && ($chatInfo['toUserId'] == $accountId || $chatInfo['fromUserId'] == $accountId)) {

            $chatFromUserId = $chatInfo['fromUserId'];
            $chatToUserId = $chatInfo['toUserId'];

            $current_last_message_id = $chatInfo['lastMessageId'];
        }
    }

    $profileId = $chatFromUserId;

    $currentTime = time();

    if ($profileId == $accountId) {

        if ((strlen($lastMessage) != 0 || strlen($lastImage) != 0) && $lastMessageId != 0) {

            if ($current_last_message_id == 0) {

                // Get current last message id in chat
                $current_last_message_id = $msg->getCurrentMessageIdInChat($chatId);
            }

            // if current last message id in chat < new message id = save data to chat
            if ($current_last_message_id < $lastMessageId) {

                $msg->setLastMessageInChat_FromId($chatId, $currentTime, $lastMessage, $lastImage, $lastMessageId);

            } else {

                // update last view chat time
                $msg->setChatLastView_FromId($chatId);
            }

        } else {

            // update last view chat time
            $msg->setChatLastView_FromId($chatId);
        }

    } else {

        if ((strlen($lastMessage) != 0 || strlen($lastImage) != 0) && $lastMessageId != 0) {

            // Get current last message id in chat
            if ($current_last_message_id == 0) {

                $current_last_message_id = $msg->getCurrentMessageIdInChat($chatId);
            }

            // if current last message id in chat < new message id = save data to chat
            if ($current_last_message_id < $lastMessageId) {

                $msg->setLastMessageInChat_ToId($chatId, $currentTime, $lastMessage, $lastImage, $lastMessageId);

            } else {

                // update last view chat time
                $msg->setChatLastView_ToId($chatId);
            }

        } else {

            // update last view chat time
            $msg->setChatLastView_ToId($chatId);
        }

    }

    echo json_encode($result);
    exit;
}
