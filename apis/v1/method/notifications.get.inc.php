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

    $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

    $pageId = helper::clearInt($pageId);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $auth = new auth($dbo);

    if (!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }

    if ($pageId == 0) {

        $account = new account($dbo, $accountId);
        $account->setLastNotifyView();
        unset($account);
    }

    $notifications = new notifications($dbo);
    $notifications->setRequestFrom($accountId);
    $result = $notifications->getItems($pageId);

    echo json_encode($result);
    exit;
}
