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

    if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {

        header('Location: /');
        exit;
    }

    $pageId = 1;

    $notifications = new notifications($dbo);
    $notifications->setRequestFrom(auth::getCurrentUserId());
    $notifications->setLanguage($LANG['lang-code']);

    if (isset($_GET['act'])) {

        $act = isset($_GET['act']) ? $_GET['act'] : '';

        if ($act === 'get') {

            $notifications->setItemsInRequest(5);
            $result = $notifications->getItems(0);

            $result['items_count'] = count($result['items']);

            if (count($result['items']) != 0) {

                ob_start();

                foreach ($result['items'] as $key => $item) {

                    draw::dropdownNotificationItem($item, $LANG);
                }

                $result['html'] = ob_get_clean();
            }

            echo json_encode($result);
            exit;
        }

        exit;
    }

    if (!empty($_POST)) {

        $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

        $pageId = helper::clearInt($pageId);

        if (isset($_POST['filter_type_comments']) || isset($_POST['filter_type_replies']) || isset($_POST['filter_type_approved']) || isset($_POST['filter_type_rejected'])) {

            if (isset($_POST['filter_type_comments'])) {

                $notifications->addItemsType(NOTIFY_TYPE_COMMENT);
            }

            if (isset($_POST['filter_type_replies'])) {

                $notifications->addItemsType(NOTIFY_TYPE_COMMENT_REPLY);
            }

            if (isset($_POST['filter_type_approved'])) {

                $notifications->addItemsType(NOTIFY_TYPE_ITEM_APPROVED);
            }

            if (isset($_POST['filter_type_rejected'])) {

                $notifications->addItemsType(NOTIFY_TYPE_ITEM_REJECTED);
                $notifications->addItemsType(NOTIFY_TYPE_PROFILE_PHOTO_REJECT);
                $notifications->addItemsType(NOTIFY_TYPE_PROFILE_COVER_REJECT);
            }

        } else {

            $notifications->addItemsType(NOTIFY_TYPE_COMMENT);
            $notifications->addItemsType(NOTIFY_TYPE_COMMENT_REPLY);
            $notifications->addItemsType(NOTIFY_TYPE_ITEM_APPROVED);
            $notifications->addItemsType(NOTIFY_TYPE_ITEM_REJECTED);
            $notifications->addItemsType(NOTIFY_TYPE_PROFILE_PHOTO_REJECT);
            $notifications->addItemsType(NOTIFY_TYPE_PROFILE_COVER_REJECT);
        }

        $result = $notifications->getItems($pageId);

        $result['items_count'] = count($result['items']);

        if (count($result['items']) != 0) {

            ob_start();

            foreach ($result['items'] as $key => $item) {

                draw::notificationItem($item, $LANG);
            }

            $result['html'] = ob_get_clean();
        }

        echo json_encode($result);
        exit;
    }

    $account = new account($dbo, auth::getCurrentUserId());
    $account->setLastNotifyView();
    unset($account);

    // Last notifications view | for new notifications counter
    auth::setCurrentLastNotifyView(0);

    $page_id = "notifications";

    $css_files = array();
    $page_title = $LANG['page-notifications']." | ".APP_TITLE;

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

                    <!-- Start Content Block -->

                    <div class="row">

                        <div class="col-sm-12 col-md-4 col-lg-3 order-0 order-md-1">
                            <div class="card">

                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['label-filters']; ?></h3>
                                </div>

                                <div class="card-body">
                                    <div class="notification-categories custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-main-checkbox" name="filter_type_all" value="1" checked="" disabled>
                                            <span class="custom-control-label"><?php echo $LANG['label-filters-all']; ?></span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" name="filter_type_comments" value="1" checked="">
                                            <span class="custom-control-label"><?php echo $LANG['label-filters-comments']; ?></span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" name="filter_type_replies" value="1" checked="">
                                            <span class="custom-control-label"><?php echo $LANG['label-filters-replies']; ?></span>
                                        </label>

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" name="filter_type_approved" value="1" checked="">
                                            <span class="custom-control-label"><?php echo $LANG['label-filters-approved']; ?></span>
                                        </label>

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" name="filter_type_rejected" value="1" checked="">
                                            <span class="custom-control-label"><?php echo $LANG['label-filters-rejected']; ?></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8 col-lg-9 order-1 order-md-0">

                            <div class="card">

                                <div class="hidden ajax-loader">
                                    <div class="row align-self-center w-100 h-100 progress-container m-0">
                                        <div class="dimmer active w-100">
                                            <div class="loader"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['page-notifications']; ?></h3>
                                    <div class="card-options d-none">
                                        <a class="btn btn-primary btn-sm" href="javascript:void(0)">Clear</a>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <?php

                                        $notifications->addItemsType(NOTIFY_TYPE_COMMENT);
                                        $notifications->addItemsType(NOTIFY_TYPE_COMMENT_REPLY);
                                        $notifications->addItemsType(NOTIFY_TYPE_ITEM_APPROVED);
                                        $notifications->addItemsType(NOTIFY_TYPE_ITEM_REJECTED);
                                        $notifications->addItemsType(NOTIFY_TYPE_PROFILE_PHOTO_REJECT);
                                        $notifications->addItemsType(NOTIFY_TYPE_PROFILE_COVER_REJECT);

                                        $result = $notifications->getItems(0);
                                    ?>

                                    <div class="notifications-list items-list-view">

                                        <?php

                                        if (count($result['items']) > 0) {

                                            foreach ($result['items'] as $key => $value) {

                                                draw::notificationItem($value, $LANG);
                                            }
                                        }

                                        ?>

                                    </div>

                                    <div class="row row-cards row-deck loading-more-container <?php if (count($result['items']) < 20) echo 'hidden'; ?>">
                                        <div class="d-lg-block col-md-12 mb-0">
                                            <div class="directory-banner pt-3 d-flex justify-content-between align-items-center loading-more-banner">
                                                <h4 class="mb-0 d-flex flex-row align-items-center loading-more-text"></h4>
                                                <a class="btn btn-primary btn-lg float-right d-flex justify-content-between align-items-center loading-more-button" href="javascript:void(0)">
                                                    <div class="btn-loader hidden rounded justify-content-center align-items-center d-sm-flex loading-more-progress"></div>
                                                    <i class="fa fa-arrow-down loading-more-button-icon mr-1"></i>
                                                    <span class="ml-2 d-sm-inline"><?php echo $LANG['action-more']; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="page-empty <?php if (count($result['items']) > 0) echo 'hidden' ?>">
                                        <div class="empty-state noselect">
                                            <div class="empty-icon"><i class="fa fa-bell"></i></div>
                                            <h5 class="empty-title"><?php echo $LANG['page-empty-list']; ?></h5>
                                            <p class="empty-subtitle"><?php echo $LANG['page-notifications-empty-list']; ?></p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> <!-- End Row -->

                </div> <!-- End container -->
            </div> <!-- End  -->

        </div> <!-- End page main-->


        <?php

            include_once("common/footer.inc.php");
        ?>

    </div> <!-- End page -->





        <script type="text/javascript">

            var pageId = <?php echo $pageId; ?>;

            var $listView = $("div.items-list-view");
            var $pageEmpty = $('.page-empty');
            var $pageMore = $('div.loading-more-container');
            var $ajaxLoader = $('.ajax-loader');

            var $allFiltersCheckbox = $('.filter-main-checkbox');

            // check is all filters checked

            function isAllChecked() {

                var result = true;

                $('.filter-checkbox').each(function () {

                    if (!this.checked) {

                        result = false;
                    }
                });

                return result;
            }

            // check is all filters unchecked

            function isAllUnChecked() {

                var result = true;

                $('.filter-checkbox').each(function () {

                    if (this.checked) {

                        result = false;
                    }
                });

                return result;
            }

            // update main filters checkbox "all"

            function updateFilters() {

                if (isAllChecked()) {

                    $allFiltersCheckbox.attr("disabled", "disabled");
                    $allFiltersCheckbox.prop("checked", true);

                } else {

                    if (isAllUnChecked()) {

                        $allFiltersCheckbox.attr("disabled", "disabled");
                        $allFiltersCheckbox.prop("checked", true);

                    } else {

                        $allFiltersCheckbox.removeAttr("disabled");
                        $allFiltersCheckbox.prop("checked", false);
                    }
                }
            }

            // set all filter checkbox to checked

            function setAllFilters() {

                $('.filter-checkbox').each(function () {

                    $(this).prop("checked", true);
                });
            }

            // disable all checkboxes

            function disableFilters() {

                $('input[type=checkbox').each(function () {

                    $(this).attr("disabled", "disabled");
                });
            }

            // enable all checkboxes

            function enableFilters() {

                $('input[type=checkbox').each(function () {

                    $(this).removeAttr("disabled");
                });

                updateFilters();
            }

            // Format filters string for server

            function getFilters() {

                var s = "";

                $('.filter-checkbox').each(function () {

                    if (this.checked) {

                        s = s + "&" + $(this).attr('name') + "=" + 1;
                    }
                });

                return s;
            }

            // Change all filters checkbox

            $allFiltersCheckbox.change(function() {

                setAllFilters();
                updateFilters();

                load();
            });

            // Change filter

            $('.filter-checkbox').change(function() {

                updateFilters();

                if ($ajaxLoader.hasClass('hidden')) {

                    load();

                } else {

                    return false;
                }
            });

            function load() {

                pageId = 0;

                disableFilters();

                $ajaxLoader.removeClass('hidden');

                $.ajax({
                    type: 'POST',
                    url: "/account/notifications",
                    data: 'pageId=' + pageId + getFilters(),
                    dataType: 'json',
                    timeout: 30000,
                    success: function(response) {

                        enableFilters();

                        if (response.hasOwnProperty('html')) {

                            $pageEmpty.addClass('hidden');
                            $listView.removeClass('hidden');
                            $listView.html(response.html);

                        } else {

                            $listView.addClass('hidden');
                            $pageEmpty.removeClass('hidden');
                        }

                        if (response.hasOwnProperty('items_count')) {

                            if (response.items_count < 20) {

                                $pageMore.addClass('hidden');

                            } else {

                                $pageMore.removeClass('hidden');

                                pageId++;
                            }

                        } else {

                            $pageMore.addClass('hidden');
                        }

                        $ajaxLoader.addClass('hidden');
                    },
                    error: function(xhr, status, error) {

                        enableFilters();
                        $ajaxLoader.addClass('hidden');
                    }
                });
            }

            $(document).on('click', '.loading-more-button', function() {

                var $this = $(this);

                if ($this.hasClass('disabled')) {

                    return;
                }

                $this.addClass('disabled');
                $this.find('div.btn-loader').removeClass('hidden');
                $this.find('i.loading-more-button-icon').addClass('hidden');

                $.ajax({
                    type: 'POST',
                    url: "/account/notifications",
                    data: 'pageId=' + pageId + getFilters(),
                    dataType: 'json',
                    timeout: 30000,
                    success: function(response) {

                        if (response.hasOwnProperty('html')) {

                            $("div.items-list-view").append(response.html);
                        }

                        if (response.hasOwnProperty('items_count')) {

                            if (response.items_count < 20) {

                                $('div.loading-more-container').addClass('hidden');

                            } else {

                                pageId++;
                            }
                        }

                        $this.removeClass('disabled');
                        $this.find('div.btn-loader').addClass('hidden');
                        $this.find('i.loading-more-button-icon').removeClass('hidden');
                    },
                    error: function(xhr, status, error) {

                        $this.removeClass('disabled');
                        $this.find('div.btn-loader').addClass('hidden');
                        $this.find('i.loading-more-button-icon').removeClass('hidden');
                    }
                });

            });

        </script>

</body>
</html>