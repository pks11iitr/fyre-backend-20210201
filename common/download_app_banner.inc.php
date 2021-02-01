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

?>

<?php

    require_once ("sys/lib/Mobile_Detect.php");

    $detect = new Mobile_Detect;

    if ($detect->isMobile()) {

        if (strlen(GOOGLE_PLAY_LINK) != 0) {

            ?>
                <div id="download-app-banner" class="card col-12 col-sm-12 col-md-12">
                    <a href="<?php echo GOOGLE_PLAY_LINK ?>" target="_blank">
                        <img src="/img/android_app_banner.png" width="100%">
                    </a>
                </div>
            <?php
        }
    }