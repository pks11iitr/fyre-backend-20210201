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

    $category = new category($dbo);

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
		$title = isset($_POST['title']) ? $_POST['title'] : "";
    	$image=	$_FILES["image"]["name"];
        $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["image"]["name"]);
       move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
 
		$title = helper::clearText($title);
		$title = helper::escapeText($title);
  // $imgurl=APP_URL.'/'.$image;
  // var_dump($imgurl);die;
		if ($authToken === helper::getAuthenticityToken() && !APP_DEMO && strlen($title) != 0) {

		    $category->add(0, $title,$image);

            header("Location: /".APP_ADMIN_PANEL."/category");
            exit;
		}
	}

    $page_id = "categories";

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = $LANG['apanel-categories']." | Admin Panel";

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
                            <li class="breadcrumb-item active"><?php echo $LANG['apanel-categories']; ?></li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                <?php

                    $result = $category->getItems(0);

                ?>

                        <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $LANG['apanel-category-new']; ?></h4>

                                    <div class="row">

                                        <div class="col-sm-12 col-xs-12">

                                            <form id="new-category-form" class="input-form-2" method="post"enctype="multipart/form-data" action="/<?php echo APP_ADMIN_PANEL; ?>/category">

                                                <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

												<div class="row">

													<div class="col-lg-12">
														<div class="input-group">
															<input type="text" class="form-control" id="title" name="title" value="" placeholder="<?php echo $LANG['apanel-placeholder-category-title']; ?>">
														</div>
													</div>
													<br><br>
														<div class="col-lg-12">
														<div class="input-group">
															<input type="file" class="form-control" id="catimg" name="image">
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

                            <?php

                                if ($category->getCategoriesCount() == 0) {

                                    ?>
                                        <div class="col-md-12">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h4 class="card-title">Info!</h4>
                                                    <p class="card-text">You can create default categories with one click!</p>
                                                    <a class="" href="/<?php echo APP_ADMIN_PANEL; ?>/category_init">
                                                        <button class="btn waves-effect waves-light btn-info">Create default categories</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>


                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-flex no-block">
                                            <h4 class="card-title"><?php echo $LANG['apanel-categories']; ?> (<span class="count"><?php echo count($result['items']); ?></span>)</h4>
                                        </div>

                                        <div class="table-responsive m-t-20 tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">

                                            <table class="table stylish-table">

                                                <thead>
                                                <tr>
                                                    <th class="text-left">Id</th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-name']; ?></th>
                                                    <th>Image</th>
                                                    <th class="text-left"><?php echo $LANG['apanel-label-subcategories']; ?></th>
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
                            <p><?php echo $LANG['apanel-delete-category-dialog-sub-header']; ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"><?php echo $LANG['apanel-action-cancel']; ?></button>
                            <button class="delete-item btn btn-info waves-effect" data-act="delete-category"><?php echo $LANG['apanel-action-delete']; ?></button>
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

    function draw($dbo, $value, $LANG)
    {
        $category = new category($dbo);
        $count = $category->getSubcategoriesCount($value['id']);
        unset($category);

        ?>

        <tr class="data-item" data-id="<?php echo $value['id']; ?>">
            <td class="text-left"><?php echo $value['id']; ?></td>
            <td class="text-left" style="word-break: break-all;"><a href="/<?php echo APP_ADMIN_PANEL; ?>/subcategory?id=<?php echo $value['id']; ?>"><?php echo $value['title']; ?></a></td>
            
            
            <td><img src="../uploads/<?php echo $value['image']; ?>" alt="" width="80" height="80"></td>
            <td class="text-left"><span class="mr-2"><?php echo $count; ?></span></td>
            <td class="text-left" style="white-space: nowrap;"><?php echo $value['date']; ?></td>
            <td>
                <a href="/<?php echo APP_ADMIN_PANEL; ?>/category_edit?id=<?php echo $value['id']; ?>"><i class="fa far fa-edit"></i></a>
                <span>&nbsp;</span>
                <a class="act-item" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
            </td>
        </tr>

        <?php
    }