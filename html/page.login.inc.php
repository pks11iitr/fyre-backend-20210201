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

    if (auth::isSession()) {

        header("Location: /");
        exit;
    }

    if (isset($_GET['continue'])) {

        $continue = isset($_GET['continue']) ? $_GET['continue'] : '';

    } else {

        $continue = "";
    }

    $user_username = '';
    $user_remember = true;

    $error = false;
    $error_message = array();

    if (!empty($_POST)) {

        $user_username = isset($_POST['user_username']) ? $_POST['user_username'] : '';
        $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        if (isset($_POST['user_remember'])) {

            $user_remember = true;

        } else {

            $user_remember = false;
        }

        $user_username = helper::clearText($user_username);
        $user_password = helper::clearText($user_password);

        $user_username = helper::escapeText($user_username);
        $user_password = helper::escapeText($user_password);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
        }

        if (!$error) {

            $access_data = array();

            $account = new account($dbo);

            $access_data = $account->signin($user_username, $user_password);

            unset($account);

            if (!$access_data['error']) {

                $account_id = $access_data['id'];
                $account_state = $access_data['state'];
                $account_username = $access_data['username'];
                $account_fullname = $access_data['fullname'];
                $account_photo_url = $access_data['photoUrl'];
                $account_verified = $access_data['verified'];
                $account_last_notify_view = $access_data['lastNotifyView'];

                switch ($account_state) {

                    case ACCOUNT_STATE_BLOCKED: {

                        break;
                    }

                    case ACCOUNT_STATE_DISABLED: {

                        break;
                    }

                    case ACCOUNT_STATE_DEACTIVATED: {

                        break;
                    }

                    default: {

                        $clientId = 0; // Desktop version

                        $auth = new auth($dbo);
                        $access_data = $auth->create($account_id, $clientId, APP_TYPE_WEB, "", $LANG['lang-code']);

                        if ($access_data['error'] === false) {

                            auth::setSession($account_id, $account_username, $account_fullname, $account_photo_url, $account_verified, 0, $access_data['accessToken']);

                            // Last notifications view | for new notifications counter
                            auth::setCurrentLastNotifyView($account_last_notify_view);

                            if ($user_remember) {

                                auth::updateCookie($user_username, $access_data['accessToken']);

                            } else {

                                auth::clearCookie();
                            }

                            unset($_SESSION['oauth']);
                            unset($_SESSION['oauth_id']);
                            unset($_SESSION['oauth_name']);
                            unset($_SESSION['oauth_email']);
                            unset($_SESSION['oauth_link']);

                            auth::newAuthenticityToken(); // Re-generate token

                            if (strlen($continue) > 0) {

                                header("Location: ".$continue);
                                exit;

                            } else {

                                header("Location: /");
                                exit;
                            }
                        }
                    }
                }

            } else {

                $action = new action($dbo);
                $action->add(APP_TYPE_WEB, auth::getCurrentUserId(), ACTIONS_FAIL_SIGNIN, $user_username);
                unset($action);

                $error = true;
            }
        }
    }

    auth::newAuthenticityToken();

    $page_id = "login";

    $css_files = array();
    $page_title = $LANG['page-login']." | ".APP_TITLE;

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

                    <?php

                        if (!WEB_ALLOW_LOGIN) {

                            ?>

                            <div class="my-message">

                                <div class="row justify-content-center">
                                    <div class="card col-11 col-sm-10 col-md-8">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo $LANG['page-login']; ?></h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-warning alert-dismissible"><?php echo $LANG['msg-feature-disabled']; ?></div>
                                            <div>
                                                <a class="btn btn-primary" href="/"><?php echo $LANG['action-back-to-main-page']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php

                        } else {

                            ?>
                            <div class="col-auth mx-auto">

                                <form id="login-form" class="card" action="/login<?php if (strlen($continue) > 0) echo "?continue=".$continue?>" method="post">
                                    <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                    <div class="card-body">

                                        <div class="card-title"><?php echo $LANG['page-login']; ?></div>

                                        <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                            <ul>
                                                <?php

                                                if ($error) echo $LANG['msg-error-authorize'];
                                                ?>
                                            </ul>
                                        </div>

                                        <div class="form-group field-login-form-username required">
                                            <label class="form-label" for="user_username"><?php echo $LANG['label-username-or-email']; ?></label>
                                            <input maxlength="24" type="text" id="user_username" class="form-control" name="user_username" autofocus="autofocus" tabindex="1" placeholder="<?php echo $LANG['placeholder-login-username']; ?>" value="<?php echo $user_username; ?>">

                                            <div class="help-block"></div>

                                        </div>

                                        <div class="form-group field-login-form-password required">
                                            <label class="form-label" for="user_password"><?php echo $LANG['label-password']; ?></label>
                                            <input maxlength="20" type="password" id="user_password" class="form-control" name="user_password" tabindex="2" placeholder="<?php echo $LANG['placeholder-login-password']; ?>" value="">

                                            <div class="help-block">
                                            </div>
                                        </div>

                                        <div class="form-group field-login-form-rememberme">
                                            <label class="custom-control custom-checkbox">
                                                <input <?php if ($user_remember) echo "checked" ?> type="checkbox" id="rememberme" class="custom-control-input" name="user_remember" value="remember" tabindex="3">
                                                <span class="custom-control-label"><?php echo $LANG['label-remember']; ?></span>
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block" tabindex="4"><?php echo $LANG['action-login']; ?></button>

                                        <?php

                                        if (WEB_ALLOW_SOCIAL_AUTHORIZATION && strlen(FACEBOOK_APP_ID) > 0) {

                                            ?>

                                            <div id="social-buttons-block">
                                                <div class="text-center mt-2"><?php echo $LANG['label-or']; ?></div>
                                                <div class="auth-clients">
                                                    <a class="btn btn-icon btn-facebook auth-link d-block mt-2" href="/facebook/auth" title="Facebook"><i class="fab fa-facebook-f"></i> <?php echo $LANG['action-login-with']." ".$LANG['label-facebook']; ?></a></li>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>

                                </form>

                                <p class="text-center"><a href="/restore" tabindex="5"><?php echo $LANG['action-forgot-password']; ?></a></p>
                                <p class="text-center"><a href="/signup" tabindex="6"><strong><?php echo $LANG['label-signup-promo']; ?></strong></a></p>

                            </div>
                            <?php
                        }
                    ?>

                </div> <!-- End container -->
            </div> <!-- End  -->

        </div> <!-- End page main-->


        <?php

            include_once("common/footer.inc.php");
        ?>

    </div> <!-- End page -->

    <script type="text/javascript">

        var strings = {

            szEmptyError: "<?php echo $LANG['label-login-empty-field']; ?>"
        };

        var error = false;

        // Get form and elements (fields)

        var $form = $('form#login-form');
        var $username_field = $form.find('.field-login-form-username');
        var $password_field = $form.find('.field-login-form-password');

        $form.submit(function(e) {

            // Clear all errors

            error = false;

            $username_field.removeClass('has-error').find('.help-block').text('');
            $password_field.removeClass('has-error').find('.help-block').text('');

            // Check username

            var usernamePattern = /^([a-zA-Z]{4,24})?([a-zA-Z][a-zA-Z0-9_]{4,24})$/i;

            if ($.trim($username_field.find('input').val()).length == 0 ) {

                $username_field.addClass('has-error');
                $username_field.find('.help-block').text(strings.szEmptyError);

                error = true;
            }

            // Check password

            if ($.trim($password_field.find('input').val()).length == 0 ) {

                $password_field.addClass('has-error');
                $password_field.find('.help-block').text(strings.szEmptyError);

                error = true;
            }

            // Submit form only if no error (error=false)

            if (error) return false;
        });

        $username_field.find('input[name=user_username]').keyup(function() {

            // Clear error when text change

            $username_field.removeClass('has-error').find('.help-block').text('');
        });

        $password_field.find('input[name=user_password]').keyup(function() {

            // Clear error when text change

            $password_field.removeClass('has-error').find('.help-block').text('');
        });

    </script>

</body>
</html>