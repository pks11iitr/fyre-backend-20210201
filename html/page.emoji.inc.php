<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    $page_id = "emoji";

    include_once("sys/core/initialize.inc.php");

    if (APP_EMOJI_SUPPORT) {

        $update = new update($dbo);
        $update->setCommentEmojiSupport();
        $update->setChatEmojiSupport();
        $update->setDialogsEmojiSupport();

        $update->setItemsTitleEmojiSupport();
        $update->setItemDetailsEmojiSupport();

        $update->setProfileFullnameEmojiSupport();
        $update->setProfileBioEmojiSupport();

        unset($update);
    }

    $css_files = array();
    $page_title = APP_TITLE;

    include_once("common/header.inc.php");
?>

<body class="">

<div class="page">
    <div class="page-main">

        <?php

        include_once("common/topbar.inc.php");
        ?>

        <!-- End topbar -->

        <div class="content my-3 my-md-5">
            <div class="container">

                <div class="card">
                    <div class="card-body">
                        <div class="text-wrap p-lg-6">

                            <div class="error-summary alert alert-success" style="">
                                <strong>Success!</strong>
                                Database refactoring success!
                            </div>

                            <br>
                            Your MySQL version:
                            <?php

                            if (function_exists('mysql_get_client_info')) {

                                print mysql_get_client_info();

                            } else {

                                echo $dbo->query('select version()')->fetchColumn();
                            }
                            ?>
                            <br>

                        </div>
                    </div>
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