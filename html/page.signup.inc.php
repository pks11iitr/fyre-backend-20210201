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

    $user_username = '';
    $user_email = '';
    $user_fullname = '';
    $user_phone = '';
    $sex = 0;

    $error = false;
    $error_message = array();

    if (!empty($_POST)) {

        $error = false;

        $user_username = isset($_POST['username']) ? $_POST['username'] : '';
        $user_fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $user_password = isset($_POST['password']) ? $_POST['password'] : '';
        $user_email = isset($_POST['email']) ? $_POST['email'] : '';
        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $sex = isset($_POST['sex']) ? $_POST['sex'] : 0;

        $user_username = helper::clearText($user_username);
        $user_fullname = helper::clearText($user_fullname);
        $user_password = helper::clearText($user_password);
        $user_email = helper::clearText($user_email);

        $user_username = helper::escapeText($user_username);
        $user_fullname = helper::escapeText($user_fullname);
        $user_password = helper::escapeText($user_password);
        $user_email = helper::escapeText($user_email);

        $sex = helper::clearInt($sex);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_token = true;
            $error_message[] = $LANG['msg-error-unknown'];
        }

        if (!helper::isCorrectLogin($user_username)) {

            $error = true;
            $error_username = true;
            $error_message[] = $LANG['msg-login-incorrect'];
        }

        if ($helper->isLoginExists($user_username)) {

            $error = true;
            $error_username = true;
            $error_message[] = $LANG['msg-login-taken'];
        }

        if (!helper::isCorrectFullname($user_fullname)) {

            $error = true;
            $error_fullname = true;
            $error_message[] = $LANG['msg-fullname-incorrect'];
        }

        if (!helper::isCorrectPassword($user_password)) {

            $error = true;
            $error_password = true;
            $error_message[] = $LANG['msg-password-incorrect'];
        }

        if (!helper::isCorrectEmail($user_email)) {

            $error = true;
            $error_email = true;
            $error_message[] = $LANG['msg-email-incorrect'];
        }

        if ($helper->isEmailExists($user_email)) {

            $error = true;
            $error_email = true;
            $error_message[] = $LANG['msg-email-taken'];
        }

        if (!$error) {

            $account = new account($dbo);

            $result = array();
            $result = $account->signup($user_username, $user_fullname, $user_password, $user_email, "", $sex, 2000, 1, 1, $LANG['lang-code']);

            if ($result['error'] === false) {

                $clientId = 0; // Desktop version

                $auth = new auth($dbo);
                $access_data = $auth->create($result['accountId'], $clientId, APP_TYPE_WEB, "", $LANG['lang-code']);

                if ($access_data['error'] === false) {

                    auth::setSession($access_data['accountId'], $user_username, $user_fullname, "", 0, 0, $access_data['accessToken']);
                    auth::updateCookie($user_username, $access_data['accessToken']);

                    $language = $account->getLanguage();

                    //Facebook connect

                    if (isset($_SESSION['oauth']) && $_SESSION['oauth'] === 'facebook' && $helper->getUserIdByFacebook($_SESSION['oauth_id']) == 0) {

                        $account->setFacebookId($_SESSION['oauth_id']);

                        unset($_SESSION['oauth']);
                        unset($_SESSION['oauth_id']);
                        unset($_SESSION['oauth_name']);
                        unset($_SESSION['oauth_email']);
                        unset($_SESSION['oauth_link']);

                    } else {

                        $account->setFacebookId("");
                    }

                    auth::newAuthenticityToken(); // Re-generate token

                    header("Location: /");
                    exit;
                }

            } else {

                $action = new action($dbo);
                $action->add(APP_TYPE_WEB, auth::getCurrentUserId(), ACTIONS_FAIL_SIGNUP, $user_username, $user_fullname, $user_email);
                unset($action);

                $error = true;
            }

        } else {

            $action = new action($dbo);
            $action->add(APP_TYPE_WEB, auth::getCurrentUserId(), ACTIONS_FAIL_SIGNUP, $user_username, $user_fullname, $user_email);
            unset($action);
        }
    }

    if (isset($_SESSION['oauth']) && empty($user_username) && empty($user_email)) {

        $user_fullname = $_SESSION['oauth_name'];
        $user_email = $_SESSION['oauth_email'];
    }

    auth::newAuthenticityToken();

    $page_id = "signup";

    $css_files = array();
    $page_title = $LANG['page-signup']." | ".APP_TITLE;

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

                        if (!WEB_ALLOW_SIGNUP) {

                            ?>
                            <div class="my-message">

                                <div class="row justify-content-center">
                                    <div class="card col-11 col-sm-10 col-md-8">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo $LANG['page-signup']; ?></h3>
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
                            <div class="col-auth signup mx-auto">

                                <form id="signup-form" class="card" action="/signup" method="post">
                                    <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                    <div class="card-body">

                                        <div class="card-title"><?php echo $LANG['page-signup']; ?></div>

                                        <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                            <ul>
                                                <?php

                                                foreach ($error_message as $key => $value) {

                                                    echo "<li>".$value."</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                        <?php

                                        if (isset($_SESSION['oauth'])) {

                                            ?>

                                            <div class="form-group field-signup-form-username">
                                                <label class="form-label noselect"><?php echo $LANG['label-authorization-with-facebook']; ?></label>

                                                    <?php

                                                    if (function_exists('curl_version')) {

                                                        $curl = curl_init();

                                                        curl_setopt_array($curl, array(
                                                            CURLOPT_URL => 'https://graph.facebook.com/'.$_SESSION['oauth_id'].'/picture',
                                                            CURLOPT_HEADER => true,
                                                            CURLOPT_RETURNTRANSFER => true,
                                                            CURLOPT_NOBODY => true));

                                                        $data = curl_exec($curl);
                                                        curl_close($curl);

                                                        @list($header, $data) = @explode("\n\n", $data, 2);

                                                        $matches = array();

                                                        preg_match('/location:(.*?)\n/', $header, $matches);

                                                        $url = @parse_url($matches[0]);
                                                    }

                                                    if (isset($url) && $url) {

                                                        ?>

                                                        <img src="<?php echo $url['path']."?".$url['query']; ?>" alt="" style="width: 50px; float: left">

                                                        <?php

                                                    } else {

                                                        ?>

                                                        <img src="\img\profile_default_photo.png" alt="" style="width: 50px; float: left">

                                                        <?php
                                                    }
                                                    ?>

                                                    <div style="padding-left: 60px;">
                                                        <h5 class="mb-2"><?php echo $_SESSION['oauth_name']; ?></h5>
                                                        <a href="/facebook"><i class="fa fa-arrow-right"></i> <?php echo $LANG['action-back-to-default-signup']; ?></a>
                                                    </div>
                                            </div>

                                            <?php

                                        }
                                        ?>

                                        <div class="form-group field-signup-form-username required noselect">
                                            <label class="form-label" for="username"><?php echo $LANG['label-username']; ?> <i class="far fa-question-circle" title="<?php echo $LANG['label-signup-tooltip-username']; ?>" rel="tooltip"></i></label>
                                            <input placeholder="<?php echo $LANG['label-signup-placeholder-username']; ?>" maxlength="24" type="text" required id="username" class="form-control" name="username" value="<?php echo $user_username; ?>" aria-required="true">

                                            <div class="help-block"></div>
                                        </div>

                                        <div class="form-group field-signup-form-fullname required noselect">
                                            <label class="form-label" for="fullname"><?php echo $LANG['label-fullname']; ?> <i class="far fa-question-circle" title="<?php echo $LANG['label-signup-tooltip-fullname']; ?>" rel="tooltip"></i></label>
                                            <input placeholder="<?php echo $LANG['label-signup-placeholder-fullname']; ?>" maxlength="24" type="text" required id="fullname" class="form-control" name="fullname" value="<?php echo $user_fullname; ?>" aria-required="true">

                                            <div class="help-block"></div>
                                        </div>

                                        <div class="form-group field-signup-form-password required noselect">
                                            <label class="form-label" for="password"><?php echo $LANG['label-password']; ?> <i class="far fa-question-circle" title="<?php echo $LANG['label-signup-tooltip-password']; ?>" rel="tooltip"></i></label>
                                            <input placeholder="<?php echo $LANG['label-signup-placeholder-password']; ?>" maxlength="20" type="password" required id="password" class="form-control" name="password" value=""  aria-required="true">

                                            <div class="help-block"></div>
                                        </div>

                                        <div class="form-group field-signup-form-email required noselect">
                                            <label class="form-label" for="email"><?php echo $LANG['label-email']; ?> <i class="far fa-question-circle" title="<?php echo $LANG['label-signup-tooltip-email']; ?>" rel="tooltip"></i></label>
                                            <input placeholder="<?php echo $LANG['label-signup-placeholder-email']; ?>" maxlength="32" type="email" required id="email" class="form-control" name="email" value="<?php echo $user_email; ?>" aria-required="true">

                                            <div class="help-block"></div>
                                        </div>

                                        <div class="row mb-2">

                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="form-group field-signup-form-username required noselect">
                                                    <label class="form-label"><?php echo $LANG['label-signup-sex']; ?> <small>(<?php echo $LANG['label-optional']; ?>)</small> <i class="far fa-question-circle" title="<?php echo $LANG['label-signup-tooltip-sex']; ?>" rel="tooltip"></i></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6 text-right pr-0">
                                                <div class="select-group select-group-pills">

                                                    <label class="select-group-item">
                                                        <input type="radio" name="sex" value="0" class="select-group-input">
                                                        <span class="select-group-button select-group-button-icon" rel="tooltip" title="<?php echo $LANG['label-sex-unknown']; ?>">
                                                            <i class="fa fa-user-secret"></i>
                                                        </span>
                                                    </label>

                                                    <label class="select-group-item">
                                                        <input <?php if ($sex == 1) echo "checked"; ?> type="radio" name="sex" value="1" class="select-group-input">
                                                        <span class="select-group-button select-group-button-icon" rel="tooltip" title="<?php echo $LANG['label-sex-male']; ?>">
                                                            <i class="fa fa-male" aria-hidden="true"></i>
                                                        </span>
                                                    </label>

                                                    <label class="select-group-item">
                                                        <input <?php if ($sex == 2) echo "checked"; ?> type="radio" name="sex" value="2" class="select-group-input">
                                                        <span class="select-group-button select-group-button-icon" rel="tooltip" title="<?php echo $LANG['label-sex-female']; ?>">
                                                            <i class="fa fa-female"></i>
                                                        </span>
                                                    </label>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="terms text-muted pb-3 text-center"><?php echo $LANG['label-terms-start']; ?> <a href="/terms"><?php echo $LANG['label-terms-link']; ?></a>, <a href="/privacy"><?php echo $LANG['label-terms-privacy-link']; ?></a> <?php echo $LANG['label-terms-and']; ?> <a href="/cookie"><?php echo $LANG['label-terms-cookies-link']; ?></a></div>

                                        <button type="submit" class="btn btn-primary btn-block"><?php echo $LANG['action-signup']; ?></button>

                                        <?php

                                        if (WEB_ALLOW_SOCIAL_AUTHORIZATION && strlen(FACEBOOK_APP_ID) > 0 && !isset($_SESSION['oauth'])) {

                                            ?>

                                            <div id="social-buttons-block">
                                                <div class="text-center mt-2 noselect"><?php echo $LANG['label-or']; ?></div>
                                                <div class="auth-clients">
                                                    <a class="btn btn-icon btn-facebook auth-link d-block mt-2" href="/facebook/auth" title="Facebook"><i class="fab fa-facebook-f"></i> <?php echo $LANG['action-signup-with']." ".$LANG['label-facebook']; ?></a></li>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </form>

                                <p class="text-center"><a href="/login"><?php echo $LANG['label-login-promo']; ?></a></p>
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

            szUsernameError: "<?php echo $LANG['label-signup-error-username']; ?>",
            szFullnameError: "<?php echo $LANG['label-signup-error-fullname']; ?>",
            szPasswordError: "<?php echo $LANG['label-signup-error-password']; ?>",
            szEmailError: "<?php echo $LANG['label-signup-error-email']; ?>"
        };

        var error = false;

        // Get form and elements (fields)

        var $form = $('form#signup-form');
        var $username_field = $form.find('.field-signup-form-username');
        var $fullname_field = $form.find('.field-signup-form-fullname');
        var $password_field = $form.find('.field-signup-form-password');
        var $email_field = $form.find('.field-signup-form-email');

        $form.submit(function(e) {

            // Clear all errors

            error = false;

            $username_field.removeClass('has-error').find('.help-block').text('');
            $fullname_field.removeClass('has-error').find('.help-block').text('');
            $password_field.removeClass('has-error').find('.help-block').text('');
            $email_field.removeClass('has-error').find('.help-block').text('');

            // Check username

            var usernamePattern = /^([a-zA-Z]{4,24})?([a-zA-Z][a-zA-Z0-9_]{4,24})$/i;

            if (!usernamePattern.test($.trim($username_field.find('input').val()))) {

                $username_field.addClass('has-error');
                $username_field.find('.help-block').text(strings.szUsernameError);

                error = true;
            }

            // Check fullname

            if ($.trim($fullname_field.find('input').val()).length < 2) {

                $fullname_field.addClass('has-error');
                $fullname_field.find('.help-block').text(strings.szFullnameError);

                error = true;
            }

            // Check password

            var passwordPattern = /^[a-z0-9_\d$@$!%*?&]{6,20}$/i;

            if (!passwordPattern.test($.trim($password_field.find('input').val()))) {

                $password_field.addClass('has-error');
                $password_field.find('.help-block').text(strings.szPasswordError);

                error = true;
            }

            // Check email

            var emailPattern = /[0-9a-z_-]+@[-0-9a-z_^\.]+\.[a-z]{2,3}/i;

            if (!emailPattern.test($.trim($email_field.find('input').val()))) {

                $email_field.addClass('has-error');
                $email_field.find('.help-block').text(strings.szEmailError);

                error = true;
            }

            // Submit form only if no error (error=false)

            if (error) return false;
        });

        $username_field.find('input[name=username]').keyup(function() {

            // Clear error when text change

            $username_field.removeClass('has-error').find('.help-block').text('');
        });

        $fullname_field.find('input[name=fullname]').keyup(function() {

            // Clear error when text change

            $fullname_field.removeClass('has-error').find('.help-block').text('');
        });

        $password_field.find('input[name=password]').keyup(function() {

            // Clear error when text change

            $password_field.removeClass('has-error').find('.help-block').text('');
        });

        $email_field.find('input[name=email]').keyup(function() {

            // Clear error when text change

            $email_field.removeClass('has-error').find('.help-block').text('');
        });

    </script>

</body>
</html>
