<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, http://ifsoft.co.uk
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

    $messenger = new messenger($dbo);

    $pageId = 1;

    if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

		$pageId = helper::clearInt($pageId);

		$result = $messenger->getItems($pageId);

		$result['items_count'] = count($result['items']);

		if (count($result['items']) != 0) {

			ob_start();

			foreach ($result['items'] as $key => $value) {

				draw($dbo, $value, $LANG);
			}

			$result['html'] = ob_get_clean();
		}

		echo json_encode($result);
		exit;
	}

    $page_id = "messages";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-messages']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-messages']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

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

                                                        foreach ($result['items'] as $key => $value) {

                                                            draw($dbo, $value, $LANG);
                                                        }

                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>

                                    <div class="card-body more-items loading-more-container text-right <?php if (count($result['items']) < 20) echo 'hide'; ?>">
                                        <a class="more-items" href="javascript:void(0)" onclick="">
                                            <button type="button" class="btn  btn-info footable-show"><?php echo $LANG['apanel-action-view-more']; ?></button>
                                        </a>
                                    </div>

                                    <div class="card-body none-items <?php if (count($result['items']) != 0) echo 'hide'; ?>">
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

			var $none_container = $('div.none-items');

			var $tab_content = $('div.tab-content');

			var $more_container = $('div.loading-more-container');
			var $more_button = $('a.more-items');

			var $counter = $('span.count');

			var $items_content = $('tbody.items-content');

			$(document).on('click', 'a.more-items', function() {

				var $this = $(this);

				$more_container.addClass('hide');

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/messages",
					data: "pageId=" + pageId,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						if (response.hasOwnProperty('html')) {

							$items_content.append(response.html);
						}

						if (response.hasOwnProperty('items_count')) {

							if (response.items_count >= 20) {

								$more_container.removeClass('hide');

								pageId++;
							}
						}
					},
					error: function(xhr, status, error) {

						$more_container.removeClass('hide');
					}
				});
			});

			function updatePage() {

				if ($('.data-item').length == 0) {

					if (!$more_container.hasClass('hide')) {

                        pageId = 0;
						$("a.more-items").trigger("click");

					} else {

						$tab_content.addClass('hide');
						$none_container.removeClass('hide');
					}
				}
			}

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

						updatePage();

					},
					error: function(xhr, status, error) {

					}
				});

			});

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