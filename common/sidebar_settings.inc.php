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

    <div class="col-lg-3 mb-4">
        <h3 class="page-title mb-3 d-flex justify-content-between align-items-center">
            <?php echo $LANG['page-settings']; ?>
            <div class="d-flex d-lg-none flex-fill sidebar-menu-line"></div>
            <button type="button" class="btn btn-sm btn-secondary btn-toggle-sidebar float-right d-block d-lg-none" data-icon-show="fa-angle-down" data-icon-hide="fa-angle-up">
                <i class="fa fa-angle-down"></i>
            </button>
        </h3>
        <div class="sidebar-menu list-group list-group-transparent mb-0 d-lg-block d-none">
            <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_profile') echo 'active'; ?>" href="/account/settings"> <span class="icon mr-3"><i class="fa fa-user-alt"></i></span><?php echo $LANG['page-settings-profile']; ?></a>
            <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_privacy') echo 'active'; ?>" href="/account/privacy"> <span class="icon mr-3"><i class="fa fa-shield-alt"></i></span><?php echo $LANG['page-settings-privacy']; ?></a>
            <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_password') echo 'active'; ?>" href="/account/password"><span class="icon mr-3"><i class="fa fa-lock"></i></span><?php echo $LANG['page-settings-password']; ?></a>
            <?php
                if (WEB_ALLOW_SOCIAL_AUTHORIZATION) {

                    ?>
                        <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_connections') echo 'active'; ?>" href="/account/connections"><span class="icon mr-3"><i class="fa fa-link"></i></span><?php echo $LANG['page-settings-connections']; ?></a>
                    <?php
                }
            ?>
            <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_blacklist') echo 'active'; ?>" href="/account/blacklist"><span class="icon mr-3"><i class="fa fa-user-lock"></i></span><?php echo $LANG['page-settings-blacklist']; ?></a>
            <a class="list-group-item list-group-item-action <?php if (isset($page_id) && $page_id === 'settings_deactivation') echo 'active'; ?>" href="/account/deactivation"><span class="icon mr-3"><i class="fa fa-trash"></i></span><?php echo $LANG['page-settings-deactivation']; ?></a>
        </div>

    </div>