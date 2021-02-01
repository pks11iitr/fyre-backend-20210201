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

    if (isset($_COOKIE['lang'])) {

        $language = $_COOKIE['lang'];

        $result = "en";

        if (in_array($language, $LANGS)) {

            $result = $language;
        }

        @setcookie("lang", $result, time() + 14 * 24 * 3600, "/");
        include_once("sys/lang/".$result.".php");

    }  else {

        $language = "en";

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }

        $result = "en";

        if (in_array($language, $LANGS)) {

            $result = $language;
        }

        @setcookie("lang", $result, time() + 14 * 24 * 3600, "/");
        include_once("sys/lang/".$result.".php");
    }

    $LANG = $TEXT;
