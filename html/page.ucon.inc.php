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

    $page_id = "under_construction";

    $css_files = array();
    $page_title = $LANG['page-under-construction']." | ".APP_TITLE;

    include_once("common/header.inc.php");

?>

<body class="error-page">

    <div class="page">

        <div class="page-content">
            <div class="container">
                <div class="container text-center">
                    <div class="display-1 text-muted mb-5"><?php echo $LANG['page-under-construction']; ?></div>
                    <p class="h4 text-muted font-weight-normal mb-7"><?php echo $LANG['page-under-construction-description']; ?></p>

                    <?php

                        if (strlen(GOOGLE_PLAY_LINK) > 0) {

                            ?>
                                <a href="<?php echo GOOGLE_PLAY_LINK; ?>">
                                    <img width="200px" src="/img/googleplay.png"/>
                                </a>
                            <?php
                        }
                    ?>

                </div>
            </div>
        </div>

    </div> <!-- End page -->

</body>
</html>