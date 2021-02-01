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

    $page_id = "support_sent";

    $css_files = array();
    $page_title = $LANG['page-support']." | ".APP_TITLE;

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

                    <div class="my-message mx-auto">

                        <div class="row justify-content-center">
                            <div class="card col-11 col-sm-10 col-md-8">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['label-support-sent-title']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info alert-dismissible"><?php echo $LANG['label-support-sent-msg']; ?></div>
                                    <div>
                                        <a class="btn btn-primary" href="/"><?php echo $LANG['action-back-to-main-page']; ?></a>
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