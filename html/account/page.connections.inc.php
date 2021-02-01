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

    if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {

        header('Location: /');
        exit;
    }

	$error = false;
    $error_message = '';

    $account = new account($dbo, auth::getCurrentUserId());
    $accountInfo = $account->get();

    if (!empty($_POST)) {

    }

	$page_id = "settings_connections";

    $css_files = array();
    $page_title = $LANG['page-settings-connections']." | ".APP_TITLE;

    include_once("common/header.inc.php");

?>

<body class="page-profile">

<div class="page">
    <div class="page-main">

        <?php

        include_once("common/topbar.inc.php");
        ?>

        <!-- End topbar -->

        <div class="content my-3 my-md-5">
            <div class="container">

                <div class="page-content">
                    <div class="row">

                        <!-- Sidebar section -->

                        <?php

                        include_once("common/sidebar_settings.inc.php");
                        ?>

                        <!-- End Sidebar section -->


                        <!-- Start settings section -->

                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['page-settings-connections']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info alert-icon">
                                        <i class="fa fa-info-circle mr-2"></i>
                                        <?php echo sprintf($LANG['page-settings-connections-sub-title'], "<strong>".APP_NAME."</strong>"); ?>
                                    </div>

                                    <?php

                                    if (isset($_GET['status']) ) {


                                        if (isset($_GET['status'])) {

                                            switch($_GET['status']) {

                                                case "connected": {

                                                    echo "<div class=\"alert alert-success\">".$LANG['label-services-facebook-connected']."</div>";
                                                    break;
                                                }

                                                case "error": {

                                                    echo "<div class=\"alert alert-danger\">".$LANG['label-services-facebook-error']."</div>";
                                                    break;
                                                }

                                                case "disconnected": {

                                                    echo "<div class=\"alert alert-success\">".$LANG['label-services-facebook-disconnected']."</div>";
                                                    break;
                                                }

                                                default: {

                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                    <div class="row d-flex align-items-center pb-3">
                                        <div class="col d-flex align-items-center">
                                                <span class="d-inline float-left pr-2">
                                                    <button type="button" class="btn btn-icon btn-facebook">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </button>
                                                </span>
                                            <strong>Facebook</strong>
                                        </div>
                                        <div class="col">

                                            <?php

                                                if (strlen($accountInfo['fb_id']) == 0) {

                                                    ?>
                                                        <a class="btn btn-primary float-right" href="/facebook/connect?access_token=<?php echo auth::getAccessToken(); ?>"><?php echo $LANG['action-connect-facebook']; ?></a>
                                                    <?php

                                                } else {

                                                    ?>
                                                        <a class="btn btn-red float-right" href="/facebook/disconnect?access_token=<?php echo auth::getAccessToken(); ?>"><?php echo $LANG['action-disconnect']; ?></a>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- End settings section -->

                    </div>
                </div>

            </div>
        </div> <!-- End content -->

    </div> <!-- End page-main -->

    <?php

        include_once("common/footer.inc.php");
    ?>

</div> <!-- End page -->

</body>
</html>