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

    $username = isset($_POST['username']) ? $_POST['username'] : '';

    $username = helper::clearText($username);
    $username = helper::escapeText($username);

    $result = array("error" => true,
                    "error_code" => ERROR_UNKNOWN);

    $clientId = helper::clearInt($clientId);

    if (!$helper->isLoginExists($username)) {

        $result = array("error" => false,
                        "error_code" => ERROR_SUCCESS);
    }

    echo json_encode($result);
    exit;
}
