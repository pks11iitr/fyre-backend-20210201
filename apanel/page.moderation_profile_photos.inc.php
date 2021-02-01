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

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $stats = new stats($dbo);

    $moderator = new moderator($dbo);

    $inbox_all = $moderator->getAllCount();
    $inbox_loaded = 0;

    if (!empty($_POST)) {

        $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;
        $loaded = isset($_POST['loaded']) ? $_POST['loaded'] : 0;

        $itemId = helper::clearInt($itemId);
        $loaded = helper::clearInt($loaded);

        $result = $moderator->getNotModeratedPhotos($itemId);

        $inbox_loaded = count($result['items']);

        $result['inbox_loaded'] = $inbox_loaded + $loaded;
        $result['inbox_all'] = $inbox_all;

        if ($inbox_loaded != 0) {

            ob_start();

            foreach ($result['items'] as $key => $value) {

                draw($value, $LANG);
            }

            $result['html'] = ob_get_clean();

            if ($result['inbox_loaded'] < $inbox_all) {

                ob_start();

                ?>

                    <a href="javascript:void(0)" onclick="Stream.moreItems('<?php echo $result['itemId']; ?>'); return false;">
                        <button type="button" class="btn  btn-info footable-show"><?php echo $LANG['apanel-action-view-more']; ?></button>
                    </a>

                <?php

                $result['html2'] = ob_get_clean();
            }
        }

        echo json_encode($result);
        exit;
    }

    $page_id = "profile_photos_moderation";

    $css_files = array("mytheme.css");
    $page_title = "Profile Photos Moderation | Admin Panel";

    include_once("common/admin_header.inc.php");
?>

<body class="fix-header fix-sidebar card-no-border">

    <div id="main-wrapper">

        <?php

            include_once("common/admin_topbar.inc.php");
        ?>

        <?php

            include_once("common/admin_sidebar.inc.php");
        ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><?php echo $LANG['apanel-dashboard']; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/<?php echo APP_ADMIN_PANEL; ?>/dashboard"><?php echo $LANG['apanel-home']; ?></a></li>
                            <li class="breadcrumb-item active">Profile Photos Moderation</li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    $result = $moderator->getNotModeratedPhotos(0);

                    $inbox_loaded = count($result['items']);

                    if ($inbox_loaded != 0) {

                        ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-body collapse show">
                                        <h4 class="card-title">Reject and Approve - what is it?</h4>
                                        <p class="card-text">Reject - send a message to the user asking him to set the correct photo. After the user has installed another photo, his profile will be displayed here again for repeated moderation.</p>
                                        <p class="card-text">Approve - the user profile will be "moderated" and will be displayed for all users.</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title m-b-0">Profile Photos Moderation</h4>
                                    </div>
                                    <div class="card-body collapse show">
                                        <div class="table-responsive">
                                            <table class="table product-overview">
                                                <thead>
                                                <tr>
                                                    <th colspan="2"><?php echo $LANG['apanel-label-from']; ?></th>
                                                    <th><?php echo $LANG['apanel-label-img']; ?></th>
                                                    <th><?php echo $LANG['apanel-label-date']; ?></th>
                                                    <th><?php echo $LANG['apanel-label-action']; ?></th>
                                                </tr>
                                                </thead>
                                                <tbody class="data-table">
                                                    <?php

                                                        foreach ($result['items'] as $key => $value) {

                                                            draw($value, $LANG);
                                                        }

                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                    <?php

                                        if ($inbox_loaded >= 20) {

                                            ?>

                                            <div class="card-body more-items loading-more-container">
                                                <a href="javascript:void(0)" onclick="Stream.moreItems('<?php echo $result['itemId']; ?>'); return false;">
                                                    <button type="button" class="btn  btn-info footable-show"><?php echo $LANG['apanel-action-view-more']; ?></button>
                                                </a>
                                            </div>

                                            <?php
                                        }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <?php

                    } else {

                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-list-empty']; ?></h4>
                                            <p class="card-text"><?php echo $LANG['apanel-label-list-empty-desc']; ?></p>
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

        <script type="text/javascript">

            var admin_panel = "<?php echo APP_ADMIN_PANEL; ?>";
            var admin_access_token = "<?php echo admin::getAccessToken(); ?>";

            var inbox_all = <?php echo $inbox_all; ?>;
            var inbox_loaded = <?php echo $inbox_loaded; ?>;

            window.Stream || ( window.Stream = {} );

            Stream.reject = function (offset, accessToken, act) {

                $.ajax({
                    type: 'GET',
                    url: '/' + admin_panel + '/moderation_actions?account_id=' + offset  + '&access_token=' + accessToken + "&act=" + act,
                    data: 'itemId=' + offset + "&access_token=" + accessToken,
                    timeout: 30000,
                    success: function(response) {

                        $('tr.data-item[data-id=' + offset + ']').remove();
                    },
                    error: function(xhr, type){

                    }
                });
            };

            Stream.approve = function (offset, accessToken, act) {

                $.ajax({
                    type: 'GET',
                    url: '/' + admin_panel + '/moderation_actions?account_id=' + offset  + '&access_token=' + accessToken + "&act=" + act,
                    data: 'itemId=' + offset + "&access_token=" + accessToken,
                    timeout: 30000,
                    success: function(response) {

                        $('tr.data-item[data-id=' + offset + ']').remove();
                    },
                    error: function(xhr, type){

                    }
                });
            };

            Stream.moreItems = function (offset) {

                $('div.loading-more-container').hide();

                $.ajax({
                    type: 'POST',
                    url: '/' + admin_panel + '/moderation_profile_photos',
                    data: 'itemId=' + offset + "&loaded=" + inbox_loaded,
                    dataType: 'json',
                    timeout: 30000,
                    success: function(response){

                        if (response.hasOwnProperty('html2')){

                            $("div.loading-more-container").html("").append(response.html2).show();
                        }

                        if (response.hasOwnProperty('html')){

                            $("tbody.data-table").append(response.html);
                        }

                        inbox_loaded = response.inbox_loaded;
                        inbox_all = response.inbox_all;
                    },
                    error: function(xhr, type){

                        $('div.loading-more-container').show();
                    }
                });
            };

        </script>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>

<?php

    function draw($item, $LANG)
    {
        ?>

            <tr class="data-item" data-id="<?php echo $item['id']; ?>">

                <td style="width:50px;">

                    <?php

                        if (strlen($item['lowPhotoUrl']) != 0) {

                            ?>
                                <span class="round" style="background-size: cover; background-image: url(<?php echo $item['lowPhotoUrl']; ?>)"></span>
                            <?php

                        } else {

                            ?>
                                <span class="round" style="background-size: cover; background-image: url(/img/profile_default_photo.png)"></span>
                            <?php
                        }
                    ?>
                </td>
                <td>
                    <h6><a href="/admin/<?php if ($item['accountType'] == ACCOUNT_TYPE_USER) {echo "profile";} else { echo "group"; } ?>?id=<?php echo $item['id']; ?>"><?php echo $item['fullname']; ?></a></h6>
                    <small class="text-muted">@<?php echo $item['username']; ?></small>
                </td>
                <td>
                    <?php

                    if (strlen($item['normalPhotoUrl']) != 0) {

                        ?>
                        <img src="<?php echo $item['normalPhotoUrl']; ?>" alt="photo" width="180">
                        <?php

                    } else {

                        ?>
                        No Photo!
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <h6><?php echo date("Y-m-d H:i:s", $item['photoPostModerateAt']); ?></h6>
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="Stream.reject('<?php echo $item['id']; ?>', '<?php echo admin::getAccessToken(); ?>', 'photo_reject'); return false;" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Reject"><i class="ti-trash"></i> <?php echo $LANG['apanel-action-reject']; ?></a>
                    <span> | </span>
                    <a href="javascript:void(0)" onclick="Stream.approve('<?php echo $item['id']; ?>', '<?php echo admin::getAccessToken(); ?>', 'photo_approve'); return false;" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Approve"><i class="ti-check"></i> <?php echo $LANG['apanel-action-approve']; ?></a>
                </td>
            </tr>

        <?php
    }