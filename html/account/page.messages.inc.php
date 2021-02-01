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

    $conversations = new conversations($dbo);
    $conversations->setRequestFrom(auth::getCurrentUserId());
    $conversations->setLanguage($LANG['lang-code']);

    if (!empty($_POST)) {

        $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

        $pageId = helper::clearInt($pageId);

        $result = $conversations->getItems($pageId);

        $result['items_count'] = count($result['items']);

        if (count($result['items']) != 0) {

            ob_start();

            foreach ($result['items'] as $key => $item) {

                draw::conversationItem($item, $LANG);
            }

            $result['html'] = ob_get_clean();
        }

        echo json_encode($result);
        exit;
    }

    $page_id = "messages";

    $css_files = array();
    $page_title = $LANG['page-messages']." | ".APP_TITLE;

    include_once("common/header.inc.php");

?>

<body class="body-directory-index">

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
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8 col-lg-9 order-1 order-md-0">

                            <div class="card">

                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $LANG['page-messages']; ?></h3>
                                </div>

                                <div class="card-body">

                                    <?php

                                        $result = $conversations->getItems(0);
                                    ?>

                                    <div class="messages-conversations">

                                        <div class="conversations items-list-view">

                                            <?php

                                            if (count($result['items']) > 0) {

                                                foreach ($result['items'] as $key => $value) {

                                                    draw::conversationItem($value, $LANG);
                                                }
                                            }

                                            ?>

                                        </div>
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
                                            <div class="empty-icon"><i class="fa fa-envelope"></i></div>
                                            <h5 class="empty-title"><?php echo $LANG['page-empty-list']; ?></h5>
                                            <p class="empty-subtitle"><?php echo $LANG['page-messages-empty-list']; ?></p>
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
                    url: "/account/messages",
                    data: 'pageId=' + pageId,
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