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

    header("HTTP/1.0 404 Not Found");

    $page_id = "error";

    $css_files = array();
    $page_title = $LANG['page-404']." | ".APP_TITLE;

    include_once("common/header.inc.php");

?>

<body class="error-page">

    <div class="page">

        <div class="page-content">
            <div class="container">
                <div class="container text-center">
                    <div class="display-1 text-muted mb-5"><i class="si si-exclamation"></i>404</div>
                    <h1 class="h2 mb-3"><?php echo $LANG['page-404']; ?></h1>
                    <p class="h4 text-muted font-weight-normal mb-7"><?php echo $LANG['page-404-description']; ?></p>
                    <a class="btn btn-primary" href="/"><i class="ic icon-arrow-left mr-1"></i><?php echo $LANG['action-back-to-main-page']; ?></a>
                </div>
            </div>
        </div>

    </div> <!-- End page -->

</body>
</html>