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

    if (admin::isSession()) {

        header("Location: /");
        exit;
    }

    $admin = new admin($dbo);

    if ($admin->getCount() > 0) {

        header("Location: /");
        exit;
    }

    include_once("sys/core/initialize.inc.php");

    $page_id = "install";

    $itemId = 17214671; // Dating App Android = 14781822
                        // Dating App iOS = 19393764
                        // My Social Network Android = 13965025
                        // My Social Network iOS = 19414706
                        // My Marketplace = 17214671
                        // My Marketplace iOS = 19450018

    $error = false;
    $error_message = array();

    $pcode = '';
    $user_username = '';
    $user_fullname = '';
    $user_password = '';
    $user_password_repeat = '';

    $error_token = false;
    $error_username = false;
    $error_fullname = false;
    $error_password = false;
    $error_password_repeat = false;

    if (!empty($_POST)) {

        $error = false;

        $pcode = isset($_POST['pcode']) ? $_POST['pcode'] : '';
        $user_username = isset($_POST['user_username']) ? $_POST['user_username'] : '';
        $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
        $user_fullname = isset($_POST['user_fullname']) ? $_POST['user_fullname'] : '';
        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $pcode = helper::clearText($pcode);
        $user_username = helper::clearText($user_username);
        $user_fullname = helper::clearText($user_fullname);
        $user_password = helper::clearText($user_password);
        $user_password_repeat = helper::clearText($user_password_repeat);

        $pcode = helper::escapeText($pcode);
        $user_username = helper::escapeText($user_username);
        $user_fullname = helper::escapeText($user_fullname);
        $user_password = helper::escapeText($user_password);
        $user_password_repeat = helper::escapeText($user_password_repeat);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_token = true;
            $error_message[] = 'Error!';
        }

//        $pcode_result = helper::verify_pcode_curl($pcode, $itemId);
//
//        if (isset($pcode_result['verify']) && $pcode_result['verify']) {
//
//            $error = false;
//
//        } else {
//
//            $error = true;
//            $error_pcode = true;
//            $error_message[] = 'Incorrect purchase code.';
//        }

        if (!helper::isCorrectLogin($user_username)) {

            $error = true;
            $error_username = true;
            $error_message[] = 'Incorrect username.';
        }

        if (!helper::isCorrectPassword($user_password)) {

            $error = true;
            $error_password = true;
            $error_message[] = 'Incorrect password.';
        }

        if (!$error) {

            $admin = new admin($dbo);

            // Create admin account

            $result = array();
            $result = $admin->signup(ADMIN_ACCESS_LEVEL_FULL, $user_username, $user_password, $user_fullname);

            if ($result['error'] === false) {

                $access_data = $admin->signin($user_username, $user_password);

                if ($access_data['error'] === false) {

                    $clientId = 0; // Desktop version

                    admin::createAccessToken();
                    admin::setSession($access_data['accountId'], $access_data['accessLevel'], admin::getAccessToken(), $access_data['username'], $access_data['fullname']);

                    // Add standard settings

                    $settings = new settings($dbo);
                    $settings->createValue("admob", 1); //Default show admob
                    unset($settings);

                    // Redirect to Admin Panel main page

                    header("Location: /".APP_ADMIN_PANEL."/dashboard");
                    exit;
                }

                header("Location: /install");
                exit;
            }
        }
    }

    auth::newAuthenticityToken();

    $css_files = array();
    $page_title = APP_TITLE;

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

                    <div class="col-auth restore mx-auto">

                        <form id="install-form" class="card" action="/install" method="post">
                            <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                            <div class="card-body">

                                <div class="card-title">Create administrator account</div>

                                <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                    <ul>
                                        <?php

                                        foreach ($error_message as $key => $value) {

                                            echo $value."<br>";
                                        }
                                        ?>
                                    </ul>
                                </div>

<!--                                <div class="form-group field-install-form-pcode required">-->
<!--                                    <p>How to get purchase code you can read here: <a href="http://ifsoft.co.uk/help/how_to_get_purchase_code/" target="_blank">How to get purchase code?</a></p>-->
<!---->
<!--                                    <label class="form-label" for="pcode">Purchase code</label>-->
<!--                                    <input type="text" id="pcode" class="form-control" name="pcode" autofocus="" value="--><?php //echo $pcode; ?><!--">-->
<!---->
<!--                                    <div class="help-block"></div>-->
<!--                                </div>-->

                                <div class="form-group field-install-form-username required">
                                    <label class="form-label" for="user_username">Username</label>
                                    <input type="text" id="user_username" class="form-control" name="user_username" autofocus="" value="<?php echo $user_username; ?>">

                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group field-install-form-fullname required">
                                    <label class="form-label" for="user_fullname">Fullname</label>
                                    <input type="text" id="user_fullname" class="form-control" name="user_fullname" autofocus="" value="<?php echo $user_fullname; ?>">

                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group field-install-form-password required">
                                    <label class="form-label" for="user_password">Password</label>
                                    <input type="password" id="user_password" class="form-control" name="user_password" autofocus="" value="">

                                    <div class="help-block"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Create</button>
                            </div>
                        </form>

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