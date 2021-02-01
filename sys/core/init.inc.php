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

    include_once("sys/config/db.inc.php");
    include_once("sys/config/constants.inc.php");
    include_once("sys/config/lang.inc.php");
    include_once("sys/config/currency.inc.php");

    foreach ($C as $name => $val) {

        define($name, $val);
    }

    foreach ($B as $name => $val) {

        define($name, $val);
    }

    

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;

    if (APP_EMOJI_SUPPORT) {

        $dbo = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));

    } else {

        $dbo = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    spl_autoload_register(function($class)
    {

        $filename = "sys/class/class.".$class.".inc.php";

        if (file_exists($filename)) {

            include_once($filename);
        }
    });
