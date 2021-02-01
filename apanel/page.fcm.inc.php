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
    $admin = new admin($dbo);

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : 1;

        $message = helper::clearText($message);
        $message = helper::escapeText($message);

        $type = helper::clearInt($type);

        if ($authToken === helper::getAuthenticityToken() && !APP_DEMO) {

            if (strlen($message) != 0) {

                $gcm = new gcm($dbo, 0);
                $gcm->setData($type, $message, 0);
                $gcm->forAll();
                $gcm->sendToAll();
            }
        }

        header("Location: /".APP_ADMIN_PANEL."/fcm");
        exit;
    }

    $page_id = "fcm";

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-fcm']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-fcm']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php
                    if (APP_DEMO) {

                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-warning']; ?></h4>
                                            <p class="card-text"><?php echo $LANG['apanel-label-demo-fcm-off-desc']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>


                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $LANG['apanel-fcm-label-title']; ?></h4>

                                <form class="form-material m-t-40"  method="post" action="/<?php echo APP_ADMIN_PANEL; ?>/fcm">

                                    <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                    <div class="form-group">
                                        <label><?php echo $LANG['apanel-label-type']; ?></label>
                                        <select class="form-control" name="type">
                                            <option selected="selected" value="<?php echo GCM_NOTIFY_SYSTEM; ?>"><?php echo $LANG['apanel-fcm-type-for-all-users']; ?></option>
                                            <option value="<?php echo GCM_NOTIFY_CUSTOM; ?>"><?php echo $LANG['apanel-fcm-type-for-authorized-users']; ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><?php echo $LANG['apanel-label-text']; ?></label>
                                        <input placeholder="Message text" id="message" type="text" name="message" maxlength="100" class="form-control form-control-line">
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <button class="btn btn-info text-uppercase waves-effect waves-light" type="submit"><?php echo $LANG['apanel-action-send']; ?></button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>


                </div>

                <?php
                    $result = $stats->getGcmHistory();

                    $inbox_loaded = count($result['data']);

                    if ($inbox_loaded != 0) {

                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $LANG['apanel-fcm-label-recently-title']; ?></h4>
                                        <div class="table-responsive">

                                            <table class="table color-table info-table">

                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Id</th>
                                                        <th><?php echo $LANG['apanel-label-text']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-type']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-status']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-delivered']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-date']; ?></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php

                                                        foreach ($result['data'] as $key => $value) {

                                                            draw($value, $LANG);
                                                        }

                                                    ?>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                    } else {

                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-list-empty']; ?></h4>
                                            <p class="card-text"><?php echo $LANG['apanel-label-list-empty-desc']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                ?>


            </div> <!-- End Container fluid  -->

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>

<?php

    function draw($itemObj, $LANG)
    {
        ?>

        <tr>
            <td class="text-left"><?php echo $itemObj['id']; ?></td>
            <td><?php echo $itemObj['msg']; ?></td>
            <td>
                <?php

                    switch ($itemObj['msgType']) {

                        case GCM_NOTIFY_SYSTEM: {

                            echo $LANG['apanel-fcm-type-for-all-users'];
                            break;
                        }

                        case GCM_NOTIFY_CUSTOM: {

                            echo $LANG['apanel-fcm-type-for-authorized-users'];
                            break;
                        }

                        default: {

                            break;
                        }
                    }
                ?>
            </td>
            <td><?php if ($itemObj['status'] == 1) {echo "success";} else {echo "failure";} ?></td>
            <td><?php echo $itemObj['success']; ?></td>
            <td><?php echo date("Y-m-d H:i:s", $itemObj['createAt']); ?></td>
        </tr>

        <?php
    }
