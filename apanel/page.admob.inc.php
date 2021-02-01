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

    $stats = new stats($dbo);
    $settings = new settings($dbo);
    $admin = new admin($dbo);

    $default = $settings->getIntValue("admob");

    if (isset($_GET['act'])) {

        $accessToken = isset($_GET['access_token']) ? $_GET['access_token'] : 0;
        $act = isset($_GET['act']) ? $_GET['act'] : '';

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            switch ($act) {

                case "global_off": {

                    $settings->setValue("admob", 0);

                    header("Location: /".APP_ADMIN_PANEL."/admob");
                    break;
                }

                case "global_on": {

                    $settings->setValue("admob", 1);

                    header("Location: /".APP_ADMIN_PANEL."/admob");
                    break;
                }

                case "on": {

                    $admin->setAdmobValueForAccounts(1);

                    header("Location: /".APP_ADMIN_PANEL."/admob");
                    break;
                }

                case "off": {

                    $admin->setAdmobValueForAccounts(0);

                    header("Location: /".APP_ADMIN_PANEL."/admob");
                    break;
                }

                default: {

                    header("Location: /".APP_ADMIN_PANEL."/admob");
                    exit;
                }
            }
        }
    }

    $page_id = "admob";

    $error = false;
    $error_message = '';

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-admob']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-admob']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php
                    include_once("common/admin_banner.inc.php");
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $LANG['apanel-label-warning']; ?></h4>
                                <p class="card-text"><?php echo $LANG['apanel-label-app-changes-effect-desc']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $LANG['apanel-admob']; ?></h4>
                                <h6 class="card-subtitle">
                                    <?php

                                        if ($default == 1) {

                                            ?>

                                            <a href="/<?php echo APP_ADMIN_PANEL; ?>/admob?access_token=<?php echo admin::getAccessToken(); ?>&act=global_off">
                                                <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-admob-action-off-for-new-users']; ?></button>
                                            </a>

                                            <?php

                                        } else {

                                            ?>
                                            <a href="/<?php echo APP_ADMIN_PANEL; ?>/admob?access_token=<?php echo admin::getAccessToken(); ?>&act=global_on">
                                                <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-admob-action-on-for-new-users']; ?></button>
                                            </a>
                                            <?php

                                        }

                                    ?>

                                    <a href="/<?php echo APP_ADMIN_PANEL; ?>/admob?access_token=<?php echo admin::getAccessToken(); ?>&act=on">
                                        <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-admob-action-off-for-all-users']; ?></button>
                                    </a>
                                    <a href="/<?php echo APP_ADMIN_PANEL; ?>/admob?access_token=<?php echo admin::getAccessToken(); ?>&act=off">
                                        <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-admob-action-on-for-all-users']; ?></button>
                                    </a>

                                </h6>
                                <div class="table-responsive">

                                    <table class="table color-table info-table">

                                    <thead>
                                        <tr>
                                            <th class="text-left"><?php echo $LANG['apanel-label-name']; ?></th>
                                            <th><?php echo $LANG['apanel-label-count']; ?></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="text-left"><?php echo $LANG['apanel-label-admob-active-accounts']; ?></td>
                                            <td><?php echo $stats->getAccountsCountByAdmob(1); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left"><?php echo $LANG['apanel-label-admob-inactive-accounts']; ?></td>
                                            <td><?php echo $stats->getAccountsCountByAdmob(0); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left"><?php echo $LANG['apanel-label-admob-default-for-new-accounts']; ?></td>
                                            <td><?php if ($default == 1) {echo "On";} else {echo "Off"; } ?></td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
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
