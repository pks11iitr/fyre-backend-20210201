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

    $f_adsense_wide_block = "common/adsense_wide.inc.php";
    $f_adsense_square_block = "common/adsense_square.inc.php";

    if (file_exists($f_adsense_wide_block) && file_exists($f_adsense_square_block)) {

        $detect = new Mobile_Detect;

        if (isset($page_id) && $page_id === 'view_item') {

            ?>
                <div class="pb-4 google-adsense-block">
                <?php

                require_once($f_adsense_square_block);

                ?>
                </div>
            <?php

        } else if (isset($page_id) && $page_id === 'profile') {

            ?>
                <div class="py-4 google-adsense-block">
                    <?php

                    require_once($f_adsense_square_block);

                    ?>
                </div>
            <?php

        } else {

            ?>
                <div class="pb-4 google-adsense-block">
                    <?php

                    if ($detect->isMobile()) {

                        require_once($f_adsense_square_block);

                    } else {

                        require_once($f_adsense_wide_block);
                    }

                    ?>
                </div>
            <?php
        }
    }