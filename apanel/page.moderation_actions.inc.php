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

    $stats = new stats($dbo);
    $admin = new admin($dbo);

    if (isset($_GET['account_id'])) {

        $action = isset($_GET['act']) ? $_GET['act'] : '';

        $accountId = isset($_GET['account_id']) ? $_GET['account_id'] : 0;
        $accessToken = isset($_GET['access_token']) ? $_GET['access_token'] : '';

        $accountId = helper::clearInt($accountId);

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            $moderator = new moderator($dbo);

            switch ($action) {

                case "photo_approve": {

                    $moderator->approvePhoto($accountId);

                    break;
                }

                case "photo_reject": {

                    $moderator->rejectPhoto($accountId);

                    break;
                }

                case "cover_approve": {

                    $moderator->approveCover($accountId);

                    break;
                }

                case "cover_reject": {

                    $moderator->rejectCover($accountId);

                    break;
                }

                default: {

                    break;
                }
            }

            unset($moderator);
        }

    } else {

        header("Location: /".APP_ADMIN_PANEL."/dashboard");
        exit;
    }
