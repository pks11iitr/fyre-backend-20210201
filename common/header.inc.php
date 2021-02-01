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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo $page_title; ?></title>

    <meta name="google-site-verification" content="" />
    <meta name="yandex-verification" content="" />
    <meta name="msvalidate.01" content="" />

    <meta property="og:site_name" content="<?php echo APP_TITLE; ?>">

    <?php

        if (isset($page_id)) {

            switch ($page_id) {

                case "view_item": {

                    if (isset($itemInfo) && !$itemInfo['error']) {

                        ?>
                            <meta property="og:url" content="<?php echo APP_URL."/classified/".$itemInfo['itemUrl']; ?>" />
                            <meta property="og:image" content="<?php echo $itemInfo['previewImgUrl']; ?>" />
                            <meta property="og:image:width" content="255" />
                            <meta property="og:image:height" content="255" />
                            <meta property="og:title" content="<?php echo $itemInfo['itemTitle']; ?>" />
                            <meta property="og:description" content="<?php echo preg_replace("/<br>/", "\n", $itemInfo['itemContent']); ?>" />
                        <?php
                    }

                    break;
                }

                case "profile": {

                    if (isset($profileInfo) && !$profileInfo['error'] && $profileInfo['state'] == ACCOUNT_STATE_ENABLED) {

                        ?>
                        <meta property="og:url" content="<?php echo APP_URL."/".$profileInfo['username']; ?>" />
                        <meta property="og:image" content="<?php echo $profileInfo['bigThumbnailUrl']; ?>" />
                        <meta property="og:image:width" content="512" />
                        <meta property="og:image:height" content="512" />
                        <meta property="og:title" content="<?php echo $profileInfo['fullname']; ?>" />
                        <meta property="og:description" content="<?php echo $profileInfo['status']; ?>" />
                        <?php
                    }

                    break;
                }

                default: {

                    ?>
                        <meta property="og:title" content="<?php echo $page_title; ?>">
                    <?php

                    break;
                }
            }
        }

    ?>

    <link href="/img/favicon.png" rel="shortcut icon" type="image/x-icon">

    <link rel="stylesheet" href="/font/awesome/css/fontawesome.css">
    <link rel="stylesheet" href="/css/bootstrap-grid.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/css/main.css?x=5" type="text/css" media="screen">

    <?php
    foreach($css_files as $css): ?>
        <link rel="stylesheet" href="/css/<?php echo $css."?x=5"; ?>" type="text/css" media="screen">
        <?php
    endforeach;
    ?>

    <?php

        if (APP_HOST !== "localhost") {

            ?>
            
            <!-- Global site tag (gtag.js) - Google Analytics -->
            
            <?php
        }
    ?>

</head>