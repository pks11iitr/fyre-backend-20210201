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
    $query = '';
    $result = array();
    $result['users'] = array();

    $stats = new stats($dbo);
    $settings = new settings($dbo);
    $admin = new admin($dbo);

    if (isset($_GET['query'])) {

        $query = isset($_GET['query']) ? $_GET['query'] : '';

        $query = helper::clearText($query);
        $query = helper::escapeText($query);

        if (strlen($query) > 2) {

            $result = $stats->searchAccounts(0, $query);
        }
    }

    helper::newAuthenticityToken();

    $page_id = "users";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-users']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-users']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-body">
                            <h4 class="card-title"><?php echo $LANG['apanel-users']; ?></h4>
                            <h6 class="card-subtitle">Find users by username, full name, email. Minimum of 3 characters.</h6>
                            <div class="row">


                                <div class="col-sm-12 col-xs-12">
                                    <form class="input-form" method="get" action="/<?php echo APP_ADMIN_PANEL; ?>/users">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="query" name="query" value="<?php echo stripslashes($query); ?>" placeholder="Find users/communities by username, full name, email. Minimum of 3 characters.">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-info" type="button"><?php echo $LANG['apanel-action-search']; ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <!-- form-group -->
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php

                    if (count($result['users']) > 0) {

                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex no-block">
                                            <h4 class="card-title"><?php echo $LANG['apanel-users']; ?></h4>
                                        </div>

                                        <div class="table-responsive m-t-20">

                                            <table class="table stylish-table">

                                                <thead>
                                                <tr>
                                                    <th colspan="2"><?php echo $LANG['apanel-profile']; ?></th>
                                                    <th>State</th>
                                                    <th>Facebook</th>
                                                    <th>Email</th>
                                                    <th>SignUp Date</th>
                                                    <th>Ip address</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                    <?php

                                                        foreach ($result['users'] as $key => $value) {

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

                        if (strlen($query) < 3) {

                            ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-list-empty']; ?></h4>
                                            <p class="card-text">Enter in the search box username, full name or email. Minimum of 3 characters.</p>
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
                                            <h4 class="card-title">Matches found: 0</h4>
                                            <p class="card-text">This means that there is no data to display :)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
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

    function draw($user)
    {
        ?>

            <tr>
                <td style="width:50px;">

                    <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $user['id']; ?>">

                        <?php

                            if (strlen($user['lowPhotoUrl']) != 0) {

                                ?>
                                    <span class="round" style="background-size: cover; background-image: url(<?php echo $user['lowPhotoUrl']; ?>)"></span>
                                <?php

                            } else {

                                ?>
                                    <span class="round" style="background-size: cover; background-image: url(/img/profile_default_photo.png)"></span>
                                <?php
                            }
                        ?>

                    </a>
                </td>
                <td>
                    <h6><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $user['id']; ?>"><?php echo $user['fullname']; ?></a></h6>
                    <small class="text-muted">@<?php echo $user['username']; ?></small>
                </td>
                <td>
                    <h6><?php if ($user['state'] == 0) {echo "Enabled";} else {echo "Blocked";} ?></h6>
                </td>
                <td>
                    <h6><?php if (strlen($user['fb_id']) < 2) {echo "Not connected to facebook.";} else {echo "<a target=\"_blank\" href=\"https://www.facebook.com/app_scoped_user_id/{$user['fb_id']}\">Facebook account link</a>";} ?></h6>
                </td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo date("Y-m-d H:i:s", $user['regtime']); ?></td>
                <td><?php if (!APP_DEMO) {echo $user['ip_addr'];} else {echo "It is not available in the demo version";} ?></td>
            </tr>

        <?php
    }