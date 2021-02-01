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

    $fcm_regId = isset($_POST['fcm_regId']) ? $_POST['fcm_regId'] : '';

    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);

    $username = helper::clearText($username);
    $password = helper::clearText($password);

    $username = helper::escapeText($username);
    $password = helper::escapeText($password);

    $fcm_regId = helper::clearText($fcm_regId);
    $fcm_regId = helper::escapeText($fcm_regId);

    $lang = helper::clearText($lang);
    $lang = helper::escapeText($lang);

    if ($clientId != CLIENT_ID) {

        api::printError(ERROR_UNKNOWN, "Unknown");
    }

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $signin_data_arr = array();

    $account = new account($dbo);
    $signin_data_arr = $account->signin($username, $password);
    unset($account);

    if ($signin_data_arr["error"] === false) {

        switch ($signin_data_arr['state']) {

            case ACCOUNT_STATE_BLOCKED: {

                // Blocked by administrator/moderator

                break;
            }

            case ACCOUNT_STATE_DISABLED: {

                // Deleted by user

                break;
            }

            default: {

                // Create auth record in database

                $auth = new auth($dbo);
                $result = $auth->create($signin_data_arr['accountId'], $clientId, $appType, $fcm_regId, $lang);

                if ($result['error'] === false) {

                    $account = new account($dbo, $signin_data_arr['accountId']);

                    $result['account'] = array();
                    array_push($result['account'], $account->get());
                }

                break;
            }
        }

    } else {

        $action = new action($dbo);
        $action->add($appType, 0, ACTIONS_FAIL_SIGNIN, $username);
        unset($action);
    }

    echo json_encode($result);
    exit;
}
