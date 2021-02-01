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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $error = false;
    $error_message = '';

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
        $current_passw = isset($_POST['current_passw']) ? $_POST['current_passw'] : '';
        $new_passw = isset($_POST['new_passw']) ? $_POST['new_passw'] : '';

        $current_passw = helper::clearText($current_passw);
        $current_passw = helper::escapeText($current_passw);

        $new_passw = helper::clearText($new_passw);
        $new_passw = helper::escapeText($new_passw);

        if ($authToken === helper::getAuthenticityToken() && !APP_DEMO) {

            $admin = new admin($dbo);
            $admin->setId(admin::getCurrentAdminId());

            $result = $admin->setPassword($current_passw, $new_passw);

            if ($result['error'] === false) {

                header("Location: /".APP_ADMIN_PANEL."/settings/?result=success");
                exit;

            } else {

                header("Location: /".APP_ADMIN_PANEL."/settings/?result=error");
                exit;
            }
        }

        header("Location: /".APP_ADMIN_PANEL."/settings");
        exit;
    }

    $page_id = "settings";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-settings']." | Admin Panel";

    include_once("common/admin_header.inc.php");
?>

<body class="fix-header fix-sidebar card-no-border">

    <div id="main-wrapper">

        <?php

            include_once("common/admin_topbar.inc.php");
        ?>

        <?php

            include_once("common/admin_sidebar.inc.php");
        ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><?php echo $LANG['apanel-dashboard']; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/<?php echo APP_ADMIN_PANEL; ?>/dashboard"><?php echo $LANG['apanel-home']; ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-settings']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    if (isset($_GET['result'])) {

                        $result = isset($_GET['result']) ? $_GET['result'] : '';

                        switch ($result) {

                            case "success": {

                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h4 class="card-title"><?php echo $LANG['apanel-label-thanks']; ?></h4>
                                                <p class="card-text"><?php  echo $LANG['apanel-settings-label-password-saved']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                break;
                            }

                            case "error": {

                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h4 class="card-title"><?php echo $LANG['apanel-label-error']; ?></h4>
                                                <p class="card-text"><?php  echo $LANG['apanel-settings-label-password-error']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                break;
                            }

                            default: {

                                break;
                            }
                        }
                    }
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $LANG['apanel-settings-label-change-password']; ?></h4>
                                <h6 class="card-subtitle"><?php echo $LANG['apanel-settings-label-change-password-desc']; ?></h6>

                                <form class="form-material m-t-40" method="post" action="/<?php echo APP_ADMIN_PANEL; ?>/settings">

                                    <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                    <div class="form-group">
                                        <label><?php echo $LANG['apanel-settings-label-current-password']; ?></label>
                                        <input type="password" class="form-control" name="current_passw" id="current_passw">
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $LANG['apanel-settings-label-new-password']; ?></label>
                                        <input type="password" class="form-control"  name="new_passw" id="new_passw">
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <button class="btn btn-info text-uppercase waves-effect waves-light" type="submit"><?php echo $LANG['apanel-action-save']; ?></button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>



            </div> <!-- End Container fluid  -->

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>