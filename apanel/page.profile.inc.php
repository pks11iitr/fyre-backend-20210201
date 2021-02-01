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

    $accountInfo = array();

    if (isset($_GET['id'])) {

        $accountId = isset($_GET['id']) ? $_GET['id'] : 0;
        $accessToken = isset($_GET['access_token']) ? $_GET['access_token'] : 0;
        $act = isset($_GET['act']) ? $_GET['act'] : '';

        $accountId = helper::clearInt($accountId);

        $account = new account($dbo, $accountId);
        $accountInfo = $account->get();

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            switch ($act) {

                case "disconnect": {

                    $account->setFacebookId('');

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "showAdmob": {

                    $account->setAdmob(1);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "hideAdmob": {

                    $account->setAdmob(0);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "close": {

                    // Close all user authorization sessions for all devices
                    $auth->removeAll($accountId);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "block": {

                    $account->setState(ACCOUNT_STATE_BLOCKED);

                    // Close all user authorization sessions for all devices
                    $auth->removeAll($accountId);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "unblock": {

                    $account->setState(ACCOUNT_STATE_ENABLED);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "verify": {

                    $account->setVerified(1);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "unverify": {

                    $account->setVerified(0);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "delete-cover": {

                    $data = array("originCoverUrl" => '',
                                  "normalCoverUrl" => '');

                    $account->setCoverUrl($data);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                case "delete-photo": {

                    $data = array("originPhotoUrl" => '',
                                  "normalPhotoUrl" => '',
                                  "lowPhotoUrl" => '');

                    $account->setPhotoUrl($data);

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    break;
                }

                default: {

                    if (!empty($_POST)) {

                        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
                        $username = isset($_POST['username']) ? $_POST['username'] : '';
                        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
                        $location = isset($_POST['location']) ? $_POST['location'] : '';
                        $balance = isset($_POST['balance']) ? $_POST['balance'] : 0;
                        $fb_page = isset($_POST['fb_page']) ? $_POST['fb_page'] : '';
                        $instagram_page = isset($_POST['instagram_page']) ? $_POST['instagram_page'] : '';
                        $email = isset($_POST['email']) ? $_POST['email'] : '';

                        $username = helper::clearText($username);
                        $username = helper::escapeText($username);

                        $fullname = helper::clearText($fullname);
                        $fullname = helper::escapeText($fullname);

                        $location = helper::clearText($location);
                        $location = helper::escapeText($location);

                        $balance = helper::clearInt($balance);

                        $fb_page = helper::clearText($fb_page);
                        $fb_page = helper::escapeText($fb_page);

                        $instagram_page = helper::clearText($instagram_page);
                        $instagram_page = helper::escapeText($instagram_page);

                        $email = helper::clearText($email);
                        $email = helper::escapeText($email);

                         if ($authToken === helper::getAuthenticityToken()) {

                            $account->setUsername($username);
                            $account->setFullname($fullname);
                            $account->setLocation($location);
                            $account->setBalance($balance);
                            $account->setFacebookPage($fb_page);
                            $account->setInstagramPage($instagram_page);
                            $account->setEmail($email);
                         }
                    }

                    header("Location: /".APP_ADMIN_PANEL."/profile?id=".$accountInfo['id']);
                    exit;
                }
            }
        }

    } else {

        header("Location: /".APP_ADMIN_PANEL."/dashboard");
        exit;
    }

    if ($accountInfo['error']) {

        header("Location: /".APP_ADMIN_PANEL."/dashboard");
        exit;
    }

    $stats = new stats($dbo);

    $page_id = "account";

    $error = false;
    $error_message = '';

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-profile']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-profile']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <?php

                                if (strlen($accountInfo['coverUrl']) != 0) {

                                    ?>
                                        <div style="height: 250px; background-image: url('<?php echo $accountInfo['coverUrl'] ?>'); background-size: cover; background-position: center" alt="user"></div>
                                    <?php

                                } else {

                                    ?>
                                        <div style="height: 250px; background-image: url('/img/profile_default_cover.png'); background-size: cover; background-position: center" alt="user"></div>
                                    <?php
                                }
                            ?>

                            <div class="card-block little-profile text-center">

                                <div class="pro-img">

                                    <?php

                                        if (strlen($accountInfo['lowPhotoUrl']) != 0) {

                                            ?>
                                                <img src="<?php echo $accountInfo['normalPhotoUrl'] ?>" alt="user" />
                                            <?php

                                        } else {

                                            ?>
                                                <img src="/img/profile_default_photo.png" alt="user" />
                                            <?php
                                        }
                                    ?>

                                </div>

                                <?php

                                    if (strlen($accountInfo['coverUrl']) != 0) {

                                        ?>
                                            <p><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=delete-cover"><?php echo $LANG['apanel-action-delete-cover']; ?></a></p>
                                        <?php

                                    }

                                    if (strlen($accountInfo['lowPhotoUrl']) != 0) {

                                        ?>
                                            <p><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=delete-photo"><?php echo $LANG['apanel-action-delete-photo']; ?></a></p>
                                        <?php

                                    }
                                ?>

                                <h3 class="m-b-0"><?php echo $accountInfo['fullname']; ?></h3>
                                <p>@<?php echo $accountInfo['username']; ?></p>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>

                </div>


                <div class="row">

                    <div class="col-lg-7">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $LANG['apanel-profile']; ?></h4>
                                <h6 class="card-subtitle">
                                    <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile_fcm/?id=<?php echo $accountInfo['id']; ?>">
                                        <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-create-fcm']; ?></button>
                                    </a>
                                </h6>
                                <div class="table-responsive">

                                    <table class="table color-table info-table">
                                        <thead>
                                            <tr>
                                                <th><?php echo $LANG['apanel-label-name']; ?></th>
                                                <th><?php echo $LANG['apanel-label-value']; ?>/<?php echo $LANG['apanel-label-count']; ?></th>
                                                <th><?php echo $LANG['apanel-label-action']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Username/Login:</td>
                                                <td><?php echo $accountInfo['username']; ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-fullname']; ?>:</td>
                                                <td><?php echo $accountInfo['fullname']; ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Email:</td>
                                                <td><?php echo $accountInfo['email']; ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-facebook-connected']; ?>:</td>
                                                <td><?php if (strlen($accountInfo['fb_id']) == 0) {echo $LANG['apanel-label-not-connected'];} else {echo $LANG['apanel-label-connected'];} ?></td>
                                                <td><?php if (strlen($accountInfo['fb_id']) == 0) {echo "";} else {echo "<a href=\"/".APP_ADMIN_PANEL."/profile?id={$accountInfo['id']}&access_token=".admin::getAccessToken()."&act=disconnect\">".$LANG['apanel-action-remove-connection']."</a>";} ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">SignUp Ip address:</td>
                                                <td><?php if (!APP_DEMO) {echo $accountInfo['ip_addr'];} else {echo "It is not available in the demo version";} ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-signup-at']; ?>:</td>
                                                <td><?php echo date("Y-m-d H:i:s", $accountInfo['regtime']); ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-admob-state']; ?>:</td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['admob'] == 1) {

                                                            echo "<span>".$LANG['apanel-label-admob-state-active']."</span>";

                                                        } else {

                                                            echo "<span>".$LANG['apanel-label-admob-state-inactive']."</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['admob'] == 1) {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=hideAdmob"><?php echo $LANG['apanel-action-admob-off']; ?></a>
                                                            <?php

                                                        } else {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=showAdmob"><?php echo $LANG['apanel-action-admob-on']; ?></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-state']; ?>:</td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['state'] == ACCOUNT_STATE_ENABLED) {

                                                            echo "<span>".$LANG['apanel-label-account-state-enabled']."</span>";

                                                        } else if ($accountInfo['state'] == ACCOUNT_STATE_BLOCKED) {

                                                            echo "<span>".$LANG['apanel-label-account-state-blocked']."</span>";

                                                        } else {

                                                            echo "<span>".$LANG['apanel-label-account-state-disabled']."</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['state'] == ACCOUNT_STATE_ENABLED) {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=block"><?php echo $LANG['apanel-action-account-block']; ?></a>
                                                            <?php

                                                        } else {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=unblock"><?php echo $LANG['apanel-action-account-unblock']; ?></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-state-verified']; ?>:</td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['verified'] == 1) {

                                                            echo "<span>".$LANG['apanel-label-account-verified']."</span>";

                                                        } else {

                                                            echo "<span>".$LANG['apanel-label-account-unverified']."</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php

                                                        if ($accountInfo['verified'] == 1) {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=unverify"><?php echo $LANG['apanel-action-verified-unset']; ?></a>
                                                            <?php

                                                        } else {

                                                            ?>
                                                                <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=verify"><?php echo $LANG['apanel-action-verified-set']; ?></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-chats']; ?>:</td>
                                                <td>
                                                    <?php

                                                        $conversations = new conversations($dbo);
                                                        $conversations->setRequestFrom($accountId);

                                                        $active_chats = $conversations->getItemsCount();

                                                        echo $active_chats;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($active_chats > 0) {

                                                            ?>
                                                                <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile_chats?id=<?php echo $accountInfo['id']; ?>" ><?php echo $LANG['apanel-action-view']; ?></a></td>
                                                            <?php
                                                        }
                                                    ?>
                                            </tr>

                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-items']; ?>:</td>
                                                <td>
                                                    <?php

                                                        $finder = new finder($dbo);
                                                        $finder->setInactiveFilter(FILTER_ALL);
                                                        $finder->addProfileIdFilter($accountId);

                                                        $active_items = $finder->getItemsCount();

                                                        echo $active_items;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($active_items > 0) {

                                                            ?>
                                                                <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile_items?id=<?php echo $accountInfo['id']; ?>" ><?php echo $LANG['apanel-action-view']; ?></a></td>
                                                            <?php
                                                        }
                                                    ?>
                                            </tr>

                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-account-reports']; ?>:</td>
                                                <td>
                                                    <?php

                                                        $reports = new reports($dbo);
                                                        $active_reports = $reports->getItemsCount(REPORT_TYPE_PROFILE, $accountId);

                                                        echo $active_reports;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if ($active_reports > 0) {

                                                            ?>
                                                                <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile_reports?id=<?php echo $accountInfo['id']; ?>" ><?php echo $LANG['apanel-action-view']; ?></a></td>
                                                            <?php
                                                        }
                                                    ?>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-5">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $LANG['apanel-label-account-edit']; ?></h4>

                                    <form class="form-material m-t-40" method="post" action="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>">

                                        <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                        <div class="form-group">
                                            <label class="col-md-12">Username/Login</label>
                                            <div class="col-md-12">
                                                <input placeholder="Username" id="username" type="text" name="username" maxlength="255" value="<?php echo $accountInfo['username']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo $LANG['apanel-label-fullname']; ?></label>
                                            <div class="col-md-12">
                                                <input placeholder="Fullname" id="fullname" type="text" name="fullname" maxlength="255" value="<?php echo $accountInfo['fullname']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo $LANG['apanel-label-location']; ?></label>
                                            <div class="col-md-12">
                                                <input placeholder="Location" id="location" type="text" name="location" maxlength="255" value="<?php echo $accountInfo['location']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12">Facebook page</label>
                                            <div class="col-md-12">
                                                <input placeholder="Facebook page" id="fb_page" type="text" name="fb_page" maxlength="255" value="<?php echo $accountInfo['fb_page']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12">Instagram page</label>
                                            <div class="col-md-12">
                                                <input placeholder="Instagram page" id="instagram_page" type="text" name="instagram_page" maxlength="255" value="<?php echo $accountInfo['instagram_page']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input placeholder="Email" id="email" type="text" name="email" maxlength="255" value="<?php echo $accountInfo['email']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo $LANG['apanel-label-balance']; ?></label>
                                            <div class="col-md-12">
                                                <input placeholder="Balance" id="balance" type="text" name="balance" maxlength="255" value="<?php echo $accountInfo['balance']; ?>" class="form-control form-control-line">
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-info text-uppercase waves-effect waves-light" type="submit"><?php echo $LANG['apanel-action-save']; ?></button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                    </div>

                </div>

                <?php
                    $result = $stats->getAuthData($accountInfo['id'], 0);

                    $inbox_loaded = count($result['data']);

                    if ($inbox_loaded != 0) {

                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $LANG['apanel-auth-label-title']; ?></h4>
                                        <h6 class="card-subtitle">
                                            <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=close">
                                                <button class="btn waves-effect waves-light btn-info"><?php echo $LANG['apanel-action-close-all-auth']; ?></button>
                                            </a>
                                        </h6>
                                        <div class="table-responsive">

                                            <table class="table color-table info-table">

                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Id</th>
                                                        <th>Access token</th>
                                                        <th><?php echo $LANG['apanel-label-app-type']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-create-at']; ?></th>
                                                        <th><?php echo $LANG['apanel-label-close-at']; ?></th>
                                                        <th>User agent</th>
                                                        <th>Ip address</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php

                                                        foreach ($result['data'] as $key => $value) {

                                                            draw($value);
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

    function draw($authObj)
    {
        ?>

        <tr>
            <td class="text-left"><?php echo $authObj['id']; ?></td>
            <td><?php echo $authObj['accessToken']; ?></td>
            <td>
            <label class="label-rounded label-light-danger px-1">
            <?php

                switch ($authObj['appType']) {

                    case APP_TYPE_ANDROID: {

                        echo "<i class=\"fa fa-android\" title=\"From Android App\"></i>";

                        break;
                    }

                    case APP_TYPE_IOS: {

                        echo "<i class=\"fa fa-apple\" title=\"From iOS App\"></i>";

                        break;
                    }

                    case APP_TYPE_WEB: {

                        echo "<i class=\"fa fa-globe\" title=\"From Website\"></i>";

                        break;
                    }

                    default: {

                        echo "<i class=\"fa fa-question\" title=\"From Website\"></i>";

                        break;
                    }
                }
            ?>
            </label>
            </td>
            <td><?php echo date("Y-m-d H:i:s", $authObj['createAt']); ?></td>
            <td><?php if ($authObj['removeAt'] == 0) {echo "-";} else {echo date("Y-m-d H:i:s", $authObj['removeAt']);} ?></td>
            <td><?php echo $authObj['u_agent']; ?></td>
            <td><?php if (!APP_DEMO) {echo $authObj['ip_addr'];} else {echo "It is not available in the demo version";} ?></td>
        </tr>

        <?php
    }
