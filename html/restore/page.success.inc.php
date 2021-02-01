<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

    if (auth::isSession()) {

        header("Location: /");
        exit;
    }

    $page_id = "restore_success";

    $css_files = array();
    $page_title = $LANG['page-restore']." | ".APP_TITLE;

    include_once("common/header.inc.php");

?>

<body class="body-default">

    <div class="page">
        <div class="page-main">

            <?php

                include_once("common/topbar.inc.php");
            ?>

            <!-- End topbar -->

            <div class="content my-3 my-md-5">
                <div class="container">

                    <div class="my-message">

                        <div class="row justify-content-center">
                            <div class="card col-11 col-sm-10 col-md-8">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['label-restore-success-title']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info alert-dismissible"><?php echo $LANG['label-restore-success-msg']; ?></div>
                                    <div>
                                        <a class="btn btn-primary" href="/"><?php echo $LANG['action-back-to-main-page']; ?></a>
                                        <a class="btn btn-secondary" href="/login"><?php echo $LANG['action-login']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- End container -->
            </div> <!-- End  -->

        </div> <!-- End page main-->


        <?php

            include_once("common/footer.inc.php");
        ?>

    </div> <!-- End page -->

</body>
</html>