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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $admin = new admin($dbo);

    if (!empty($_POST)) {

        $accessToken = isset($_POST['access_token']) ? $_POST['access_token'] : '';

        $fromUserId = isset($_POST['fromUserId']) ? $_POST['fromUserId'] : 0;
        $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

        $act = isset($_POST['act']) ? $_POST['act'] : '';

        $fromUserId = helper::clearInt($fromUserId);
        $itemId = helper::clearInt($itemId);

        $items = new items($dbo);
        $items->setRequestFrom($fromUserId);

        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            switch ($act) {

                case 'delete': {

                    $result = $items->delete($itemId);

                    break;
                }

                case 'reject': {

                    $items->setRequestFrom(0);

                    $result = $items->reject($itemId, 1, $fromUserId);

                    break;
                }

                case 'approve': {

                    $items->setRequestFrom(0);

                    $result = $items->approve($itemId, 1, $fromUserId);

                    break;
                }

                default: {

                    break;
                }
            }
        }

        echo json_encode($result);
        exit;
    }