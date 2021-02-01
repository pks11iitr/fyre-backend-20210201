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

    if (auth::isSession()) {

        header("Location: /");
        exit;
    }

    $user_email = '';

    $error = false;
    $error_message = array();

    if (!empty($_POST)) {

        $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $user_email = helper::clearText($user_email);
        $user_email = helper::escapeText($user_email);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_message[] = $LANG['msg-error-unknown'];
        }

        if (!helper::isCorrectEmail($user_email)) {

            $error = true;
            $error_message[] = $LANG['msg-email-incorrect'];
        }

        if ( !$error && !$helper->isEmailExists($user_email) ) {

            $error = true;
            $error_message[] = $LANG['msg-email-not-found'];
        }

        if (!$error) {

            $accountId = $helper->getUserIdByEmail($user_email);

            if ($accountId != 0) {

                $account = new account($dbo, $accountId);

                $accountInfo = $account->get();

                if ($accountInfo['error'] === false && $accountInfo['state'] != ACCOUNT_STATE_BLOCKED) {

                    $clientId = 0; // Desktop version

                    $restorePointInfo = $account->restorePointCreate($user_email, $clientId);

                    ob_start();

                    ?>

                    <html>
                    <body>
                    This is link <a href="<?php echo APP_URL;  ?>/restore/new?hash=<?php echo $restorePointInfo['hash']; ?>"><?php echo APP_URL;  ?>/restore/new?hash=<?php echo $restorePointInfo['hash']; ?></a> to reset your password.
                    </body>
                    </html>

                    <?php

                    $from = SMTP_EMAIL;

                    $to = $user_email;

                    $html_text = ob_get_clean();

                    $subject = APP_NAME." | Password reset";

                    $mail = new phpmailer();

                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = SMTP_HOST;                               // Specify main and backup SMTP servers
                    $mail->SMTPDebug = SMTP_DEBUG;
                    $mail->SMTPAuth = SMTP_AUTH;                               // Enable SMTP authentication
                    $mail->Username = SMTP_USERNAME;                      // SMTP username
                    $mail->Password = SMTP_PASSWORD;                      // SMTP password
                    $mail->SMTPSecure = SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = SMTP_PORT;                                    // TCP port to connect to

                    $mail->From = $from;
                    $mail->FromName = APP_TITLE;
                    $mail->addAddress($to);                               // Name is optional

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $html_text;

                    $mail->send();
                }
            }

            $sent = true;
            header("Location: /restore/sent");
        }
    }

    auth::newAuthenticityToken();

    $page_id = "restore";

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

                        <form id="remind-form" class="card" action="/restore" method="post">
                            <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                            <div class="card-body">

                                <div class="card-title"><?php echo $LANG['page-restore']; ?></div>

                                    <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                        <ul>
                                            <?php

                                                foreach ($error_message as $key => $value) {

                                                    echo $value."<br>";
                                                }
                                            ?>
                                        </ul>
                                    </div>

                                <div class="form-group field-restore-form-email required">
                                    <label class="form-label" for="user-email">Email</label>
                                    <input type="email" id="user-email" class="form-control" name="user_email" autofocus="" value="<?php echo $user_email; ?>">

                                    <div class="help-block"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block"><?php echo $LANG['action-continue']; ?></button>
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