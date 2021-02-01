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

    $fcm_regId = isset($_POST['fcm_regId']) ? $_POST['fcm_regId'] : '';

    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);

    $accountId = helper::clearInt($accountId);

    $fcm_regId = helper::clearText($fcm_regId);
    $fcm_regId = helper::escapeText($fcm_regId);

    $lang = helper::clearText($lang);
    $lang = helper::escapeText($lang);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    if (strlen($fcm_regId) == 0) {

        echo json_encode($result);
        exit;
    }

    if ($clientId != CLIENT_ID) {

        api::printError(ERROR_UNKNOWN, "Unknown");
    }

    if ($accountId == 0 || strlen($accessToken) == 0) {

        $fcm = new fcm($dbo);

        $index = $fcm->search_regId_in_regIds($fcm_regId);

        if ($index == 0) {

            $result = $fcm->add_regId_to_regIds($fcm_regId, $appType, $clientId, $lang);
        }

        unset($fcm);

    } else {

        $auth = new auth($dbo);

        $auth_id = $auth->getAuthorizationId($accountId, $accessToken);

        if ($auth_id == 0) {

            $fcm = new fcm($dbo);

            $index = $fcm->search_regId_in_regIds($fcm_regId);

            if ($index == 0) {

                $result = $fcm->add_regId_to_regIds($fcm_regId, $appType, $clientId);
            }

            unset($fcm);

        } else {

            $auth->updateAuthorizationId($auth_id, $fcm_regId);
        }
    }

    echo json_encode($result);
    exit;
}
