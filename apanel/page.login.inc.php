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

    if (admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/dashboard");
        exit;
    }

    $page_id = "login";

    $user_username = '';

    $error = false;
    $error_message = '';

    if (!empty($_POST)) {

        $user_username = isset($_POST['user_username']) ? $_POST['user_username'] : '';
        $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $user_username = helper::clearText($user_username);
        $user_password = helper::clearText($user_password);

        $user_username = helper::escapeText($user_username);
        $user_password = helper::escapeText($user_password);

        if (helper::getAuthenticityToken() !== $token) {

            $error = true;
            $error_message = 'Error!';
        }

        if (!$error) {

            $access_data = array();

            $admin = new admin($dbo);
            $access_data = $admin->signin($user_username, $user_password);

            if ($access_data['error'] === false) {

                $clientId = 0; // Desktop version

                admin::createAccessToken();

                admin::setSession($access_data['accountId'], admin::getAccessToken(), $access_data['username'], $access_data['fullname'], $access_data['accessLevel']);

                header("Location: /".APP_ADMIN_PANEL."/dashboard");
                exit;

            } else {

                $error = true;
                $error_message = 'Incorrect login or password.';
            }
        }
    }

    helper::newAuthenticityToken();

    $page_id = "login";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-login']." | Admin Panel";

    include_once("common/admin_header.inc.php");
?>

<body>

    <section id="wrapper">

        <div class="login-register light-gray-bg">

            <div class="login-box card">
                <div class="card-body">

                    <form class="form-horizontal form-material" id="loginform" action="/<?php echo APP_ADMIN_PANEL; ?>/login" method="post">

                        <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                        <h3 class="box-title m-b-20"><?php echo $LANG['apanel-login']; ?></h3>

                        <p class="form-error-message" style="<?php if (!$error) echo "display: none"; ?>"><?php echo $error_message; ?></p>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control form-control-line" type="text" required="" placeholder="<?php echo $LANG['apanel-placeholder-username']; ?>" name="user_username" value="<?php echo $user_username; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="<?php echo $LANG['apanel-placeholder-password']; ?>" name="user_password" value="">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit"><?php echo $LANG['apanel-action-login']; ?></button>
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div>

    </section>

</body>
</html>
