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

    $reports = new reports($dbo);

    $itemType = REPORT_TYPE_ITEM;

    if (isset($_GET['itemType'])) {

        $itemType = isset($_GET['itemType']) ? $_GET['itemType'] : 0;

        $itemType = helper::clearInt($itemType);
    }

    $pageId = 1;

    if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;
		$itemType = isset($_POST['itemType']) ? $_POST['itemType'] : 0;

		$pageId = helper::clearInt($pageId);
		$itemType = helper::clearInt($itemType);

		$result = $reports->getItems($pageId, $itemType);

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

    $page_id = "reports";

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-reports']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-reports']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    $result = $reports->getItems(0, $itemType);

                ?>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex no-block">
                                            <h4 class="card-title"><?php echo $LANG['apanel-label-reports']; ?> (<span class="count"><?php echo $result['itemsCount']; ?></span>)</h4>
                                            <div class="ml-auto">
                                                <select class="custom-select item-type">
                                                    <option <?php if ($itemType == REPORT_TYPE_ITEM) echo "selected"; ?> value="0"><?php echo $LANG['apanel-report-type-item']; ?></option>
                                                    <option <?php if ($itemType == REPORT_TYPE_PROFILE) echo "selected"; ?> value="1"><?php echo $LANG['apanel-report-type-profile']; ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="table-responsive m-t-20 tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">

                                            <table class="table stylish-table">

                                                <thead>
                                                <tr>
                                                    <th class="text-left">Id</th>
                                                    <th class="text-left" colspan="2"><?php echo $LANG['apanel-label-from']; ?></th>
                                                    <th class="text-left" colspan="2"><?php echo $LANG['apanel-label-to']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-to-item']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-abuse']; ?></th>
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

			var pageId = "<?php echo $pageId; ?>";
			var itemType = "<?php echo $itemType; ?>";

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
					url: "/" + admin_panel + "/reports",
					data: "pageId=" + pageId + "&itemType=" + itemType,
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

			$('select.item-type').on('change', function() {

			    switch (this.value) {

			        case "0": {

			            window.location.href = '/' + admin_panel + '/reports';

			            break;
			        }

			        case "1": {

			            window.location.href = '/' + admin_panel + '/reports?itemType=1';

			            break;
			        }

			        default: {

			            return;
			        }
			    }
            });

            $(document).on('click', 'a.act-item', function() {

				var $this = $(this);

				var act = $this.attr("data-act");

				var itemId = $this.parents('.data-item').attr("data-id");
				var fromUserId = $this.parents('.data-item').attr("data-from-user-id");

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/report_item",
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
        ?>

        <tr class="data-item" data-id="<?php echo $value['id']; ?>">
            <td class="text-left"><?php echo $value['id']; ?></td>
            <td style="width:50px;">

            <?php

                if ($value['fromUserId'] != 0 && strlen($value['fromUserPhotoUrl']) != 0) {

                    ?>
                        <span class="round" style="background-size: cover; background-image: url(<?php echo $value['fromUserPhotoUrl']; ?>)"></span>
                    <?php

                } else {

                    ?>
                        <span class="round" style="background-size: cover; background-image: url(/img/profile_default_photo.png)"></span>
                    <?php
                }
            ?>
            </td>
            <td>

            <?php

                if ($value['fromUserId'] != 0) {

                    ?>
                        <h6><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $value['fromUserId']; ?>"><?php echo $value['fromUserFullname']; ?></a></h6>
                        <small class="text-muted">@<?php echo $value['fromUserUsername']; ?></small>
                    <?php

                } else {

                    ?>
                        <h6><?php echo $LANG['apanel-label-unknown']; ?></h6>
                    <?php
                }
            ?>
            </td>
            <td style="width:50px;">

            <?php

                if ($value['toUserId'] != 0 && strlen($value['toUserPhotoUrl']) != 0) {

                    ?>
                        <span class="round" style="background-size: cover; background-image: url(<?php echo $value['toUserPhotoUrl']; ?>)"></span>
                    <?php

                } else {

                    ?>
                        <span class="round" style="background-size: cover; background-image: url(/img/profile_default_photo.png)"></span>
                    <?php
                }
            ?>
            </td>
            <td>

            <?php

                if ($value['toUserId'] != 0) {

                    ?>
                        <h6><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $value['toUserId']; ?>"><?php echo $value['toUserFullname']; ?></a></h6>
                        <small class="text-muted">@<?php echo $value['toUserUsername']; ?></small>
                    <?php

                } else {

                    ?>
                        <h6><?php echo $LANG['apanel-label-unknown']; ?></h6>
                    <?php
                }
            ?>
            </td>
            <td class="text-left">
            <?php
                if ($value['itemType'] == REPORT_TYPE_ITEM) {

                    ?>
                    <a href="/<?php echo APP_ADMIN_PANEL; ?>/market_view?id=<?php echo $value['itemId']; ?>"><?php echo $LANG['apanel-action-view']; ?></a>
                    <?php

                } else {

                    echo "-";
                }
            ?>
            </td>
            <td class="text-left" style="word-break: break-all;">
            <?php

                switch ($value['abuseId']) {

                    case 0: {

                        echo $LANG['label-profile-report-reason-1'];

                        break;
                    }

                    case 1: {

                        echo $LANG['label-profile-report-reason-2'];

                        break;
                    }

                    case 2: {

                        echo $LANG['label-profile-report-reason-3'];

                        break;
                    }

                    case 3: {

                        echo $LANG['label-profile-report-reason-4'];

                        break;
                    }

                    default: {

                        echo $LANG['label-profile-report-reason-5'];

                        break;
                    }
                }
            ?>
            </td>
            <td class="text-left" style="word-break: break-all;"><?php echo $value['description']; ?></td>
            <td class="text-left" style="white-space: nowrap;"><?php echo $value['date']; ?></td>
            <td><a class="act-item" data-act="delete" href="javascript:void(0)"><?php echo $LANG['apanel-action-delete']; ?></a></td>
        </tr>

        <?php
    }