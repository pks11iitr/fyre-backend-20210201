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

    $user_email = '';
    $subject = '';
    $details = '';

    $error = false;
    $error_message = array();

    if (!empty($_POST)) {

        $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $details = isset($_POST['details']) ? $_POST['details'] : '';

        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $user_email = helper::clearText($user_email);
        $user_email = helper::escapeText($user_email);

        $subject = helper::clearText($subject);
        $subject = helper::escapeText($subject);

        $details = helper::clearText($details);
        $details = helper::escapeText($details);

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_message[] = $LANG['msg-error-unknown'];
        }

        if (!helper::isCorrectEmail($user_email)) {

            $error = true;
            $error_message[] = $LANG['msg-email-incorrect'];
        }

        if (strlen($user_email) < 1 || strlen($subject) < 1 || strlen($details) < 1) {

            $error = true;
            $error_message[] = $LANG['msg-empty-fields'];
        }

        if (!$error) {

            $support = new support($dbo);
            $support->add(APP_TYPE_WEB, auth::getCurrentUserId(), $user_email, $subject, $details);

            $send_status = true;
            header("Location: /support/sent");
            exit;
        }
    }

    auth::newAuthenticityToken();

    $page_id = "support";

    $css_files = array();
    $page_title = $LANG['page-support']." | ".APP_TITLE;

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

                    <div class="col-auth support mx-auto">

                        <form id="support-form" class="card" action="/support" method="post">
                            <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                            <div class="card-body">

                                <div class="card-title"><?php echo $LANG['page-support']; ?></div>

                                    <div class="error-summary alert alert-danger" style="<?php if (!$error) echo "display: none"; ?>">
                                        <ul>
                                            <?php

                                                foreach ($error_message as $key => $value) {

                                                    echo "<li>".$value."</li>";
                                                }
                                            ?>
                                        </ul>
                                    </div>

                                <div class="form-group field-support-form-email required">
                                    <label class="form-label" for="user-email">Email</label>
                                    <input maxlength="100" placeholder="<?php echo $LANG['label-support-email-placeholder']; ?>" type="email" id="user-email" class="form-control" name="user_email" autofocus="" value="<?php echo $user_email; ?>">

                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group field-support-form-subject required">
                                    <label class="form-label" for="subject"><?php echo $LANG['label-support-subject']; ?></label>
                                    <input maxlength="100" placeholder="<?php echo $LANG['label-support-subject-placeholder']; ?>" type="text" id="subject" class="form-control" name="subject" autofocus="" value="<?php echo $subject; ?>">

                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group field-support-form-subject required">
                                    <label class="form-label" for="details"><?php echo $LANG['label-support-details']; ?></label>
                                    <textarea maxlength="500" placeholder="<?php echo $LANG['label-support-details-placeholder']; ?>" style="min-height: 100px;" id="details" class="form-control" name="details"><?php echo $details; ?></textarea>

                                    <div class="help-block"></div>
                                </div>

                                <button type="submit" class="btn btn-primary float-right"><?php echo $LANG['action-send']; ?></button>
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