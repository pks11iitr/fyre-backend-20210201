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

    $mainCategoryId = 0;
    $mainCategoryInfo = array();

    $category = new category($dbo);

    if (isset($_GET['id'])) {

		$mainCategoryId = isset($_GET['id']) ? $_GET['id'] : 0;

		$mainCategoryId = helper::clearInt($mainCategoryId);

		if ($mainCategoryId == 0) {

            header("Location: /".APP_ADMIN_PANEL."/category");
            exit;
		}

	} else {

	    header("Location: /".APP_ADMIN_PANEL."/category");
        exit;
	}

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
		$title = isset($_POST['title']) ? $_POST['title'] : "";

		$title = helper::clearText($title);
		$title = helper::escapeText($title);

		if ($authToken === helper::getAuthenticityToken() && !APP_DEMO && strlen($title) != 0) {

		    $category->add($mainCategoryId, $title);

            header("Location: /".APP_ADMIN_PANEL."/subcategory?id=".$mainCategoryId);
            exit;
		}
	}

    $page_id = "subcategories";

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-subcategories']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-subcategories']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    $result = $category->getItems($mainCategoryId);

                ?>

                        <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $LANG['apanel-subcategory-new']; ?></h4>

                                    <div class="row">

                                        <div class="col-sm-12 col-xs-12">

                                            <form id="new-category-form" class="input-form-2" method="post" action="/<?php echo APP_ADMIN_PANEL; ?>/subcategory?id=<?php echo $mainCategoryId; ?>">

                                                <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

												<div class="row">

													<div class="col-lg-12">
														<div class="input-group">
															<input type="text" class="form-control" id="title" name="title" value="" placeholder="<?php echo $LANG['apanel-placeholder-category-title']; ?>">
														</div>
													</div>

													<div class="col-lg-12">
														<div class="form-group mb-0 mt-2 text-right">
															<button type="submit" class="btn btn-info" type="button"><?php echo $LANG['apanel-action-create']; ?></button>
														</div>
													</div>

												</div>

													<!-- form-group -->
											</form>
										</div>

									</div>

                                </div>
                            </div>
                        </div>



                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex no-block">
                                            <h4 class="card-title"><?php echo $LANG['apanel-subcategories']; ?> (<span class="count"><?php echo count($result['items']); ?></span>)</h4>
                                        </div>

                                        <div class="table-responsive m-t-20 tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">

                                            <table class="table stylish-table">

                                                <thead>
                                                <tr>
                                                    <th class="text-left">Id</th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-name']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-category']; ?></th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-date']; ?></th>
                                                    <th><?php echo $LANG['apanel-label-action']; ?></th>
                                                </tr>
                                                </thead>

                                                <tbody class="items-content">
                                                    <?php

                                                        $mainCategoryInfo = $category->info($mainCategoryId);

                                                        foreach ($result['items'] as $key => $value) {

                                                            draw($dbo, $value, $mainCategoryInfo, $LANG);
                                                        }

                                                    ?>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>

                                    <div class="card-body none-items <?php if (count($result['items']) != 0) echo 'hide'; ?>">
                                        <h4 class="card-title"><?php echo $LANG['apanel-label-list-empty']; ?></h4>
                                        <p class="card-text"><?php echo $LANG['apanel-label-list-empty-desc']; ?></p>
                                    </div>

                                </div>

                            </div>
                        </div>


            </div> <!-- End Container fluid  -->

            <div id="delete-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="vcenter"><?php echo $LANG['apanel-delete-dialog-title']; ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4><?php echo $LANG['apanel-delete-dialog-header']; ?></h4>
                            <p><?php echo $LANG['apanel-delete-subcategory-dialog-sub-header']; ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><?php echo $LANG['apanel-action-cancel']; ?></button>
                            <button class="delete-item btn btn-info waves-effect" data-act="delete-subcategory"><?php echo $LANG['apanel-action-delete']; ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

		<script type="text/javascript">

			var admin_panel = "<?php echo APP_ADMIN_PANEL; ?>";
			var admin_access_token = "<?php echo admin::getAccessToken(); ?>";

			var $none_container = $('div.none-items');

			var $tab_content = $('div.tab-content');

			var $counter = $('span.count');

			var $items_content = $('tbody.items-content');

			function updatePage() {

				if ($('.data-item').length == 0) {

					$tab_content.addClass('hide');
					$none_container.removeClass('hide');
				}
			}

            $(document).on('click', 'a.act-item', function() {

				var $this = $(this);

				var act = $this.attr("data-act");

				var itemId = $this.parents('.data-item').attr("data-id");

				$('button.delete-item').attr("data-id", itemId);

				$('#delete-dialog').modal('show');
			});

            $(document).on('click', 'button.delete-item', function() {

				var $this = $(this);

				var act = $this.attr("data-act");

				var itemId = $this.attr("data-id");


				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/category_item",
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

				$('#delete-dialog').modal('hide');

			});

		</script>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>

<?php

    function draw($dbo, $value, $mainCategoryInfo, $LANG)
    {
        ?>

        <tr class="data-item" data-id="<?php echo $value['id']; ?>">
            <td class="text-left"><?php echo $value['id']; ?></td>
            <td class="text-left" style="word-break: break-all;"><?php echo $value['title']; ?></td>
            <td class="text-left"><span class="mr-2"><?php echo $mainCategoryInfo['title']; ?></span></td>
            <td class="text-left" style="white-space: nowrap;"><?php echo $value['date']; ?></td>
            <td>
                <a href="/<?php echo APP_ADMIN_PANEL; ?>/category_edit?id=<?php echo $value['id']; ?>"><i class="fa far fa-edit"></i></a>
                <span>&nbsp;</span>
                <a class="act-item" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
            </td>
        </tr>

        <?php
    }