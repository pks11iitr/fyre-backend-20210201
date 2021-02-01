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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $stats = new stats($dbo);
    $admin = new admin($dbo);

    $page_id = "main";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-dashboard']." | Admin Panel";

    include_once("common/admin_header.inc.php");
?>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <?php

            include_once("common/admin_topbar.inc.php");
        ?>

        <?php

            include_once("common/admin_sidebar.inc.php");
        ?>

        <div class="page-wrapper"> <!-- Page wrapper  -->

            <div class="container-fluid"> <!-- Container fluid  -->

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><?php echo $LANG['apanel-dashboard']; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $LANG['apanel-home']; ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-dashboard']; ?></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info">
                                        <i class="ti-user"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light"><?php echo $stats->getAccountsCount(); ?></h3>
                                        <h5 class="text-muted m-b-0"><?php echo $LANG['apanel-label-total-accounts']; ?></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning">
                                        <i class="fa fa-shopping-bag"></i>
                                    </div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $stats->getMarketItemsCount(); ?></h3>
                                        <h5 class="text-muted m-b-0"><?php echo $LANG['apanel-label-total-market-items']; ?></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="ti-comment-alt"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $stats->getMessagesCount(); ?></h3>
                                        <h5 class="text-muted m-b-0"><?php echo $LANG['apanel-label-total-messages']; ?></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="ti-comments"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $stats->getChatsCount(); ?></h3>
                                        <h5 class="text-muted m-b-0"><?php echo $LANG['apanel-label-total-chats']; ?></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title m-b-0"><?php echo $LANG['apanel-label-stats-accounts']; ?></h4>
                            </div>
                            <div class="card-body collapse show">
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-total-items']; ?></td>
                                                <td><?php echo $stats->getAccountsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-items']; ?></td>
                                                <td><?php echo $stats->getAccountsCount(ACCOUNT_STATE_ENABLED); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-inactive-items']; ?></td>
                                                <td><?php echo $stats->getAccountsCount(ACCOUNT_STATE_DISABLED); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-blocked-items']; ?></td>
                                                <td><?php echo $stats->getAccountsCount(ACCOUNT_STATE_BLOCKED); ?></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title m-b-0"><?php echo $LANG['apanel-label-stats-messages']; ?></h4>
                            </div>
                            <div class="card-body collapse show">
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-total-chats']; ?></td>
                                                <td><?php echo $stats->getChatsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-active-chats']; ?></td>
                                                <td><?php echo $stats->getChatsCount(false); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-total-messages']; ?></td>
                                                <td><?php echo $stats->getMessagesCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-active-messages']; ?></td>
                                                <td><?php echo $stats->getMessagesCount(false); ?></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title m-b-0"><?php echo $LANG['apanel-label-stats-market']; ?></h4>
                            </div>
                            <div class="card-body collapse show">
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-total-items']; ?></td>
                                                <td><?php echo $stats->getMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-approved-items']; ?></td>
                                                <td><?php echo $stats->getApprovedMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-rejected-items']; ?></td>
                                                <td><?php echo $stats->getRejectedMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-items']; ?></td>
                                                <td><?php echo $stats->getActiveMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-inactive-items']; ?></td>
                                                <td><?php echo $stats->getInactiveMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-removed-items']; ?></td>
                                                <td><?php echo $stats->getRemovedMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-unmoderated-items']; ?></td>
                                                <td><?php echo $stats->getUnmoderatedMarketItemsCount(); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-likes']; ?></td>
                                                <td><?php echo $stats->getLikesCount(); ?></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title m-b-0"><?php echo $LANG['apanel-label-stats-other']; ?></h4>
                            </div>
                            <div class="card-body collapse show">
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-items-reports']; ?></td>
                                                <td><?php echo $stats->getReportsCount(REPORT_TYPE_ITEM); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-profiles-reports']; ?></td>
                                                <td><?php echo $stats->getReportsCount(REPORT_TYPE_PROFILE); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><?php echo $LANG['apanel-label-stats-active-support-items']; ?></td>
                                                <td><?php echo $stats->getTicketsCount(); ?></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php

                    $result = $stats->getAccounts(0);

                    $inbox_loaded = count($result['items']);

                    if ($inbox_loaded != 0) {

                        ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card">

                                    <div class="card-block bg-info">
                                        <h4 class="text-white card-title"><?php echo $LANG['apanel-label-stats-recently-profiles-list']; ?></h4>
                                        <h6 class="card-subtitle text-white m-b-0 op-5"><?php echo $LANG['apanel-label-stats-recently-profiles-list-desc']; ?></h6>
                                    </div>

                                    <div class="card-block">
                                        <div class="message-box contact-box">
                                            <div class="message-widget contact-widget">

                                                <?php

                                                    foreach ($result['items'] as $key => $value) {

                                                        draw($value);
                                                    }

                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                    }
                ?>


            </div> <!-- End Container fluid  -->

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

        </div> <!-- End Page wrapper  -->

    </div> <!-- End Main Wrapper -->

</body>

</html>

<?php

    function draw($item)
    {
        ?>

            <a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $item['id']; ?>" class="data-item" data-id="<?php echo $item['id']; ?>">
                <div class="user-img">

                <?php

                        if (strlen($item['lowPhotoUrl']) != 0) {

                            ?>
                                <img src="<?php echo $item['lowPhotoUrl']; ?>" alt="user" class="img-circle">
                            <?php

                        } else {

                            ?>
                                <img src="/img/profile_default_photo.png" alt="user" class="img-circle">
                            <?php
                        }

                    if (strlen($item['online'])) {

                        ?>
                            <span class="profile-status online pull-right" title="online"></span>
                        <?php

                    }
                ?>

                </div>
                <div class="mail-contnet">
                    <h5><?php echo $item['fullname']; ?> <span class="mail-desc d-inline">@<?php echo $item['username']; ?></span></h5>
                    <span class="mail-desc"><?php echo $item['email']; ?></span>
                    <span class="mail-desc"><?php echo date("Y-m-d H:i:s", $item['regtime']); ?></span>
                </div>
            </a>

        <?php
    }