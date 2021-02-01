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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $admin = new admin($dbo);

    if (!empty($_POST)) {

        $accessToken = isset($_POST['access_token']) ? $_POST['access_token'] : '';

        $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

        $act = isset($_POST['act']) ? $_POST['act'] : '';

        $itemId = helper::clearInt($itemId);

        $category = new category($dbo);

        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            switch ($act) {

                case 'delete-category': {

                    $result = $category->deleteCategory($itemId);

                    break;
                }

                case 'delete-subcategory': {

                    $result = $category->deleteSubcategory($itemId);

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