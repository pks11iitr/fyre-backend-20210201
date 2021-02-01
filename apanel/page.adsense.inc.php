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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $error = false;
    $error_message = '';

    $stats = new stats($dbo);
    $admin = new admin($dbo);

    $f_adsense_wide_block = "common/adsense_wide.inc.php";
    $f_adsense_square_block = "common/adsense_square.inc.php";

    $adsense_wide = "";
    $adsense_square = "";

    if (!empty($_POST)) {

        $accessToken = isset($_POST['access_token']) ? $_POST['access_token'] : '';
        $adsense_wide = isset($_POST['adsense_wide']) ? $_POST['adsense_wide'] : '';
        $adsense_square = isset($_POST['adsense_square']) ? $_POST['adsense_square'] : '';

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            if (strlen($adsense_wide) != 0) {

                $adsense_wide = mb_convert_encoding($adsense_wide, 'UTF-8', 'OLD-ENCODING');
                file_put_contents($f_adsense_wide_block, $adsense_wide);

            } else {

                if (file_exists($f_adsense_wide_block)) {

                    unlink($f_adsense_wide_block);
                }
            }

            if (strlen($adsense_square) != 0) {

                $adsense_square = mb_convert_encoding($adsense_square, 'UTF-8', 'OLD-ENCODING');
                file_put_contents($f_adsense_square_block, $adsense_square);

            } else {

                if (file_exists($f_adsense_square_block)) {

                    unlink($f_adsense_square_block);
                }
            }
        }
    }

    if (file_exists($f_adsense_wide_block)) {

        $adsense_wide = file_get_contents($f_adsense_wide_block);
    }

    if (file_exists($f_adsense_square_block)) {

        $adsense_square = file_get_contents($f_adsense_square_block);
    }

    $page_id = "adsense";

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
                            <li class="breadcrumb-item active">Adsense</li>
                        </ol>
                    </div>
                </div>

                <?php
                    include_once("common/admin_banner.inc.php");
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Adsense units</h4>
                                <h6 class="card-subtitle">Add ad unit code to display Google ad units or remove ad code to prevent ads from showing.</h6>
                                <h6 class="card-subtitle">How to create units and get html code you can read here: <a href="https://ifsoft.co.uk/help/how_to_add_adsense_to_you_site/" target="_blank">https://ifsoft.co.uk/help/how_to_add_adsense_to_you_site/</a></h6>

                                <form class="form-material m-t-40" method="post" action="/<?php echo APP_ADMIN_PANEL; ?>/adsense">

                                    <input type="hidden" name="access_token" value="<?php echo admin::getAccessToken(); ?>">

                                    <div class="form-group">
                                        <label class="pb-2">Wide ad unit code</label>
                                        <textarea class="form-control" name="adsense_wide" placeholder="Paste here you wide ad unit code..." style="height: 250px"><?php echo $adsense_wide; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="pb-2">Square ad unit code</label>
                                        <textarea class="form-control" name="adsense_square" placeholder="Paste here you square ad unit code..." style="height: 250px"><?php echo $adsense_square; ?></textarea>
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
