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

    if (!auth::isSession()) {

        header('Location: /');
        exit;
    }

    $favorites = new favorites($dbo);
    $favorites->setRequestFrom(auth::getCurrentUserId());

    $pageId = 1;

    if (!empty($_POST)) {

        $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

        $pageId = helper::clearInt($pageId);

        $result = $favorites->getItems($pageId);

        $result['items_count'] = count($result['items']);

        if (count($result['items']) != 0) {

            ob_start();

            foreach ($result['items'] as $key => $value) {

                draw::item($value, $CURRENCY_ARRAY, $LANG);
            }

            $result['html'] = ob_get_clean();
        }

        echo json_encode($result);
        exit;
    }

    $page_id = "favorites";

    $css_files = array();
    $page_title = $LANG['page-favorites']." | ".APP_TITLE;

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

                    <div class="dashboard-block mb-3">

                        <?php

                            $result = $favorites->getItems(0);
                        ?>

                            <div class="list-view items-list-view">

                                <div class="row row-cards row-deck items-grid-view">

                                    <?php

                                        if (count($result['items']) > 0) {

                                            foreach ($result['items'] as $key => $value) {

                                                draw::item($value, $CURRENCY_ARRAY, $LANG);
                                            }
                                        }

                                     ?>

                                </div>

                                <div class="row row-cards row-deck loading-more-container <?php if (count($result['items']) < 20) echo 'hidden'; ?>">
                                    <div class="d-lg-block col-md-12 mb-5">
                                        <div class="list-view-banner p-3 d-flex justify-content-between align-items-center loading-more-banner">
                                            <h4 class="mb-0 d-flex flex-row align-items-center loading-more-text"></h4>
                                            <a class="btn btn-primary btn-lg float-right d-flex justify-content-between align-items-center loading-more-button" href="javascript:void(0)">
                                                <div class="btn-loader hidden rounded justify-content-center align-items-center d-sm-flex loading-more-progress"></div>
                                                <i class="fa fa-arrow-down loading-more-button-icon mr-1"></i>
                                                <span class="ml-2 d-sm-inline"><?php echo $LANG['action-more']; ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="my-message page-empty <?php if (count($result['items']) > 0) echo 'hidden' ?>">
                                <div class="empty-state noselect">
                                    <div class="empty-icon"><i class="fa fa-star"></i></div>
                                    <h5 class="empty-title"><?php echo $LANG['page-empty-list']; ?></h5>
                                    <p class="empty-subtitle"><?php echo $LANG['page-favorites-empty-list']; ?></p>
                                    <div><a class="btn btn-primary" href="/"><?php echo $LANG['action-favorites-promo-button']; ?></a></div>
                                </div>
                            </div>

                    </div> <!-- End Content Block -->

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
                    url: "/account/favorites",
                    data: 'pageId=' + pageId,
                    dataType: 'json',
                    timeout: 30000,
                    success: function(response) {

                        if (response.hasOwnProperty('html')) {

                            $("div.items-grid-view").append(response.html);
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