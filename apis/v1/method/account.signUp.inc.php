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

    $hash = isset($_POST['hash']) ? $_POST['hash'] : '';

    $fcm_regId = isset($_POST['fcm_regId']) ? $_POST['fcm_regId'] : '';

    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';

    $facebookId = isset($_POST['facebookId']) ? $_POST['facebookId'] : '';

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    $language = isset($_POST['lang']) ? $_POST['lang'] : 'en';

    $user_sex = isset($_POST['sex']) ? $_POST['sex'] : 0;
    $user_year = isset($_POST['year']) ? $_POST['year'] : 0;
    $user_month = isset($_POST['month']) ? $_POST['month'] : 0;
    $user_day = isset($_POST['day']) ? $_POST['day'] : 0;

    $user_sex = helper::clearInt($user_sex);
    $user_year = helper::clearInt($user_year);
    $user_month = helper::clearInt($user_month);
    $user_day = helper::clearInt($user_day);

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);

    $facebookId = helper::clearText($facebookId);

    $username = helper::clearText($username);
    $fullname = helper::clearText($fullname);
    $password = helper::clearText($password);
    $email = helper::clearText($email);
    $phone = helper::clearText($phone);
    $language = helper::clearText($language);

    $facebookId = helper::escapeText($facebookId);
    $username = helper::escapeText($username);
    $fullname = helper::escapeText($fullname);
    $password = helper::escapeText($password);
    $email = helper::escapeText($email);
    $phone = helper::escapeText($phone);
    $language = helper::escapeText($language);

    $fcm_regId = helper::clearText($fcm_regId);
    $fcm_regId = helper::escapeText($fcm_regId);

    $lang = helper::clearText($lang);
    $lang = helper::escapeText($lang);

    if ($clientId != CLIENT_ID) {

        api::printError(ERROR_CLIENT_ID, "Error client id.");
    }

    if (APP_USE_CLIENT_SECRET) {

        if ($hash !== md5(md5($username).CLIENT_SECRET)) {

            api::printError(ERROR_CLIENT_SECRET, "Error hash.");
        }
    }

    $result = array(
        "error" => true,
        "error_code" => ERROR_UNKNOWN
    );

    $account = new account($dbo);
    $result = $account->signup($username, $fullname, $password, $email, $phone, $user_sex, $user_year, $user_month, $user_day, $language);
    unset($account);

    if (!$result['error']) {

        $account = new account($dbo);
        $result = $account->signin($username, $password);
        unset($account);

        if ($result['error'] === false) {

            $auth = new auth($dbo);
            $result = $auth->create($result['accountId'], $clientId, $appType, $fcm_regId, $lang);

            if ($result['error'] === false) {

                $account = new account($dbo, $result['accountId']);

                if (strlen($facebookId) != 0) {

                    $helper = new helper($dbo);

                    if ($helper->getUserIdByFacebook($facebookId) == 0) {

                        $account->setFacebookId($facebookId);
                    }
                }

                $result['account'] = array();

                array_push($result['account'], $account->get());
            }
        }

    } else {

        $action = new action($dbo);
        $action->add($appType, 0, ACTIONS_FAIL_SIGNUP, $username, $fullname, $email);
        unset($action);
    }

    echo json_encode($result);
    exit;
}
