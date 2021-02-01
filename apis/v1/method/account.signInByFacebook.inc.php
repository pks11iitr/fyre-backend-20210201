<?php

/*!
 * ifsoft.co.uk
 *
 * http://ifsoft.com.ua, http://ifsoft.co.uk
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2019 Demyanchuk Dmitry (raccoonsquare@gmail.com)
 */

if (!defined("APP_SIGNATURE")) {

    header("Location: /");
    exit;
}

if (!empty($_POST)) {

    $clientId = isset($_POST['clientId']) ? $_POST['clientId'] : 0;

    $fcm_regId = isset($_POST['fcm_regId']) ? $_POST['fcm_regId'] : '';

    $facebookId = isset($_POST['facebookId']) ? $_POST['facebookId'] : '';

    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';
    $appType = isset($_POST['appType']) ? $_POST['appType'] : 0; // 0 = APP_TYPE_UNKNOWN

    $clientId = helper::clearInt($clientId);

    $fcm_regId = helper::clearText($fcm_regId);
    $fcm_regId = helper::escapeText($fcm_regId);

    $facebookId = helper::clearText($facebookId);
    $facebookId = helper::escapeText($facebookId);

    $lang = helper::clearText($lang);
    $lang = helper::escapeText($lang);
    $appType = helper::clearInt($appType);

    $access_data = array("error" => true,
                         "error_code" => ERROR_UNKNOWN);

    $helper = new helper($dbo);

    $accountId = $helper->getUserIdByFacebook($facebookId);

    if ($accountId != 0) {

        $auth = new auth($dbo);
        $access_data = $auth->create($accountId, $clientId, $appType, $fcm_regId, $lang); //need add app_tpe, fcm_regId and lang

        if ($access_data['error'] === false) {

            $account = new account($dbo, $accountId);

            $access_data['account'] = array();

            array_push($access_data['account'], $account->get());
        }
    }

    echo json_encode($access_data);
    exit;
}
