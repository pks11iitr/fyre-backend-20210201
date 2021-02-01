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

header("Content-type: text/html; charset=utf-8");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Licenses</title>

    <style type="text/css">

        html {
            background-color: #fff;
        }

        body {
            margin: 20px;
        }

        h2 {
            display: block;
            font-weight: bold;
            font-size: 16px;
        }

        h3 {
            margin-top: 20px;
            display: block;
            font-weight: bold;
            font-size: 16px;
        }

        p {
            margin-bottom: 20px;
            margin-top: 20px;
            display: block;
        }

        span {
            display: block;
            margin-left: 20px;
            margin-top: 10px;
        }

    </style>

</head>
<body>

    <?php
        include_once("content/terms/en.inc.php");
    ?>

</body>
</html>