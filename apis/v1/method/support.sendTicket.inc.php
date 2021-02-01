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

    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $subject = isset($_POST['subject']) ? $_POST['subject'] : "";
    $detail = isset($_POST['detail']) ? $_POST['detail'] : "";

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);
    $accountId = helper::clearInt($accountId);

    $email = helper::clearText($email);
    $email = helper::escapeText($email);

    $subject = helper::clearText($subject);
    $subject = helper::escapeText($subject);

    $detail = helper::clearText($detail);
    $detail = helper::escapeText($detail);

    if ($clientId != CLIENT_ID) {

        api::printError(ERROR_UNKNOWN, "");
    }

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $support = new support($dbo);
    $support->setRequestFrom($accountId);

    $result = $support->add($appType, $accountId, $email, $subject, $detail);

    echo json_encode($result);
    exit;
}
