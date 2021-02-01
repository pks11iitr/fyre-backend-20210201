<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk
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

    $hash = "";

    if (isset($_GET['hash'])) {

        $hash = isset($_GET['hash']) ? $_GET['hash'] : '';

        $hash = helper::clearText($hash);
        $hash = helper::escapeText($hash);

        $restorePointInfo = $helper->getRestorePoint($hash);

        if ($restorePointInfo['error'] !== false) {

            header("Location: /");
            exit;
        }

    } else {

        header("Location: /");
        exit;
    }

    $user_password = '';
    $user_password_repeat = '';

    $error = false;
    $error_messages = array();

    if (!empty($_POST)) {

        $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
        $user_password_repeat = isset($_POST['user_password_repeat']) ? $_POST['user_password_repeat'] : '';

        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $user_password = helper::clearText($user_password);
        $user_password_repeat = helper::clearText($user_password_repeat);

        $user_password = helper::escapeText($user_password);
        $user_password_repeat = helper::escapeText($user_password_repeat);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_messages[] = $LANG['msg-error-unknown'];
        }

        if (!helper::isCorrectPassword($user_password)) {

            $error = true;
            $error_messages[] = $LANG['label-restore-new-invalid-password-error-msg'];
        }

        if ($user_password != $user_password_repeat) {

            $error = true;
            $error_messages[] = $LANG['label-restore-new-match-passwords-error-msg'];
        }

        if (!$error) {

            $account = new account($dbo, $restorePointInfo['accountId']);

            $account->newPassword($user_password);
            $account->restorePointRemove();

            header("Location: /restore/success");
            exit;
        }
    }

    auth::newAuthenticityToken();

    $page_id = "restore_new";

    $css_files = array();
    $page_title = $LANG['page-restore']." | ".APP_TITLE;

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

                        <form id="remind-form" class="card" action="/restore/new?hash=<?php echo $hash; ?>" method="post">
                            <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                            <div class="card-body">

                                <div class="card-title"><?php echo $LANG['label-restore-new-title']; ?></div>

                                    <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                        <ul>
                                            <?php

                                                foreach ($error_messages as $key => $value) {

                                                    echo "<li>".$value."</li>";
                                                }
                                            ?>
                                        </ul>
                                    </div>

                                <div class="form-group field-register-form-password required">
                                    <label class="form-label" for="user_password"><?php echo $LANG['label-new-password']; ?></label>
                                    <input type="password" required id="user_password" class="form-control" name="user_password" value="">

                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group field-register-form-password required">
                                    <label class="form-label" for="user_password_repeat"><?php echo $LANG['label-repeat-password']; ?></label>
                                    <input type="password" required id="user_password_repeat" class="form-control" name="user_password_repeat" value="">

                                    <div class="help-block"></div>
                                </div>

                                <button type="submit" class="btn btn-primary"><?php echo $LANG['action-change']; ?></button>

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