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

<aside class="left-sidebar">

    <div class="scroll-sidebar"> <!-- Sidebar scroll-->

        <nav class="sidebar-nav"> <!-- Sidebar navigation-->

            <ul id="sidebarnav">

                <li class="nav-small-cap"><?php echo $LANG['apanel-label-general']; ?></li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "main") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/dashboard" aria-expanded="false">
                            <i class="ti-dashboard"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-dashboard']; ?></span>
                        </a>
                    </li>
                <li>
                    <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "categories") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/category" aria-expanded="false">
                        <i class="fa fa-th-list"></i>
                        <span class="hide-menu"><?php echo $LANG['apanel-categories']; ?></span>
                    </a>
                </li>
                 <li>
                    <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "banner") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/banner" aria-expanded="false">
                        <i class="fa fa-th-list"></i>
                        <span class="hide-menu">Banner</span>
                    </a>
                </li>
                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "adsense") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/adsense" aria-expanded="false">
                            <i class="ti-layout-media-overlay"></i>
                            <span class="hide-menu">Adsense</span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "admob") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/admob" aria-expanded="false">
                            <i class="ti-layout-list-post"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-admob']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "gcm") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/fcm" aria-expanded="false">
                            <i class="ti-bell"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-fcm']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "users") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/users" aria-expanded="false">
                            <i class=" ti-search"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-users']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "support") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/support" aria-expanded="false">
                            <i class="ti-help-alt"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-support']; ?></span>
                        </a>
                    </li>

                <li class="nav-devider"></li>

                <li class="nav-small-cap"><?php echo $LANG['apanel-label-stream']; ?></li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "market") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/market" aria-expanded="false">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-market']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "messages") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/messages" aria-expanded="false">
                            <i class="ti-comment-alt"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-messages']; ?></span>
                        </a>
                    </li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "reports") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/reports" aria-expanded="false">
                            <i class="ti-face-sad"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-reports']; ?></span>
                        </a>
                    </li>

                <li class="nav-devider"></li>

                <li class="nav-small-cap"><?php echo $LANG['apanel-label-moderation']; ?></li>

                <li>
                    <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "profile_photos_moderation") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/moderation_profile_photos" aria-expanded="false">
                        <i class="ti-image"></i>
                        <span class="hide-menu"><?php echo $LANG['apanel-label-moderation-photos']; ?></span>
                    </a>
                </li>

                <li>
                    <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "profile_covers_moderation") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/moderation_profile_covers" aria-expanded="false">
                        <i class="ti-gallery"></i>
                        <span class="hide-menu"><?php echo $LANG['apanel-label-moderation-covers']; ?></span>
                    </a>
                </li>



                <li class="nav-devider"></li>

                <li class="nav-small-cap"><?php echo $LANG['apanel-label-settings']; ?></li>

                    <li>
                        <a class="waves-effect waves-dark <?php if (isset($page_id) && $page_id === "settings") { echo "active";} ?>" href="/<?php echo APP_ADMIN_PANEL; ?>/settings" aria-expanded="false">
                            <i class="ti-settings"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-settings']; ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="/<?php echo APP_ADMIN_PANEL; ?>/logout?access_token=<?php echo admin::getAccessToken(); ?>&continue=/" aria-expanded="false">
                            <i class="ti-power-off"></i>
                            <span class="hide-menu"><?php echo $LANG['apanel-logout']; ?></span>
                        </a>
                    </li>

            </ul>
        </nav> <!-- End Sidebar navigation -->
    </div> <!-- End Sidebar scroll-->
</aside>