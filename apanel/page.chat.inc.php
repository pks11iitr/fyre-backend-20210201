<?php

	/*!
	 * ifsoft.co.uk
	 *
	 * http://ifsoft.com.ua, https://ifsoft.co.uk
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

    $admin = new admin($dbo);

    $messenger = new messenger($dbo);

    if (isset($_GET['id'])) {

        $chatId = isset($_GET['id']) ? $_GET['id'] : 0;

        $chatId = helper::clearInt($chatId);

        $messenger->setChatId($chatId);

    } else {

        header("Location: /".APP_ADMIN_PANEL."/dashboard");
        exit;
    }

    $pageId = 1;

    $page_id = "chat";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-chat']." | Admin Panel";

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
							<li class="breadcrumb-item active"><?php echo $LANG['apanel-chat']; ?></li>
						</ol>
					</div>
				</div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    $messenger->setItemsInRequest(1000); // Get full chat

                    $result = $messenger->getItems(0);
                ?>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex no-block">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-messages']; ?> (<span class="count"><?php echo $result['itemsCount']; ?></span>)</h4>
                                        </div>

                                        <div class="table-responsive m-t-20 tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">

                                            <table class="table stylish-table">

                                                <thead>
                                                <tr>
                                                    <th class="text-left">Id</th>
                                                    <th class="text-left" colspan="2"><?php echo $LANG['apanel-label-from']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-img']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-text']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-date']; ?></th>
                                                    <th><?php echo $LANG['apanel-label-action']; ?></th>
                                                </tr>
                                                </thead>

                                                <tbody class="items-content">
                                                    <?php

                                                        foreach (array_reverse($result['items']) as $key => $item) {

                                                            draw($dbo, $item, $LANG);
                                                        }

                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>

                                    <div class="card-body more-items loading-more-container text-right hide">
                                        <a class="more-items" href="javascript:void(0)" onclick="">
                                            <button type="button" class="btn  btn-info footable-show"><?php echo $LANG['apanel-action-view-more']; ?></button>
                                        </a>
                                    </div>

                                    <div class="card-body none-items hide">
                                        <h4 class="card-title"><?php echo $LANG['apanel-label-list-empty']; ?></h4>
                                        <p class="card-text"><?php echo $LANG['apanel-label-list-empty-desc']; ?></p>
                                    </div>


                                </div>

                            </div>
                        </div>

            </div> <!-- End Container fluid  -->

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

        <script type="text/javascript">

            var admin_panel = "<?php echo APP_ADMIN_PANEL; ?>";
			var admin_access_token = "<?php echo admin::getAccessToken(); ?>";

			var pageId = <?php echo $pageId; ?>;

			var $counter = $('span.count');

            $(document).on('click', 'a.act-item', function() {

				var $this = $(this);

				var act = $this.attr("data-act");

				var itemId = $this.parents('.data-item').attr("data-id");
				var fromUserId = $this.parents('.data-item').attr("data-from-user-id");

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/message_item",
					data: "itemId=" + itemId + "&access_token=" + admin_access_token + "&act=" + act,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						$('.data-item[data-id=' + itemId + ']').remove();

						$counter.text(parseInt($counter.text()) - 1);

					},
					error: function(xhr, status, error) {

					}
				});

			})

        </script>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>

<?php

    function draw($dbo, $value, $LANG)
    {
        $fromUser = new profile($dbo, $value['fromUserId']);
		$profileInfo = $fromUser->getVeryShort();

        ?>

        <tr class="data-item" data-id="<?php echo $value['id']; ?>">
            <td class="text-left"><?php echo $value['id']; ?></td>
            <td style="width:50px;">
                <span class="round" style="background-size: cover; background-image: url(<?php echo $profileInfo['lowThumbnailUrl']; ?>)"></span>
            </td>
            <td>
                <h6><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $value['fromUserId']; ?>"><?php echo $profileInfo['fullname']; ?></a></h6>
                <small class="text-muted">@<?php echo $profileInfo['username']; ?></small>
            </td>
            <td class="text-left">
            <?php
                if (strlen($value['imgUrl']) != 0) {

                    ?>
                    <img width="300px" src="<?php echo $value['imgUrl']; ?>"/>
                    <?php

                } else {

                    echo "-";
                }
            ?>
            </td>
            <td class="text-left" style="word-break: break-all;">
            <?php
                if (strlen($value['message']) != 0) {

                    echo $value['message'];

                } else {

                    echo "-";
                }
            ?>
            </td>
            <td class="text-left" style="white-space: nowrap;"><?php echo $value['date']; ?></td>
            <td><a class="act-item" data-act="delete" href="javascript:void(0)"><?php echo $LANG['apanel-action-delete']; ?></a></td>
        </tr>

        <?php
    }