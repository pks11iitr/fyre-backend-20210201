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

    if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {

        header('Location: /');
        exit;
    }

    if (isset($_GET['access_token'])) {

        $accessToken = (isset($_GET['access_token'])) ? ($_GET['access_token']) : '';

        if (auth::getAccessToken() === $accessToken) {

            $account = new account($dbo, auth::getCurrentUserId());
            $account->setFacebookId(""); //remove connection. set facebook id to 0.

            header("Location: /account/connections/?oauth_provider=facebook&status=disconnected");
            exit;
        }
    }

    header("Location: /account/connections");
    exit;
