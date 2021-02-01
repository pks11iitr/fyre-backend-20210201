<?php

	/*!
	 * ifsoft.co.uk
	 *
	 * http://ifsoft.com.ua, http://ifsoft.co.uk, https://raccoonsquare.com
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

	$finder = new finder($dbo);

	$query = "";
	$categoryId = 0;
	$sortType = 0;
	$moderationType = 2;
	$activeType = 0;

	if (isset($_GET['query']) || isset($_GET['category'])) {

		$query = isset($_GET['query']) ? $_GET['query'] : '';
		$categoryId = isset($_GET['category']) ? $_GET['category'] : 0;
		$sortType = isset($_GET['sortType']) ? $_GET['sortType'] : 0;
		$moderationType = isset($_GET['moderationType']) ? $_GET['moderationType'] : 0;
		$activeType = isset($_GET['activeType']) ? $_GET['activeType'] : 0;

		$query = helper::clearText($query);
		$query = helper::escapeText($query);

		$categoryId = helper::clearInt($categoryId);
		$sortType = helper::clearInt($sortType);
		$moderationType = helper::clearInt($moderationType);
		$activeType = helper::clearInt($activeType);
	}

	$pageId = 1;

	if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$categoryId = isset($_POST['category']) ? $_POST['category'] : 0;
		$sortType = isset($_POST['sortType']) ? $_POST['sortType'] : 0;
		$moderationType = isset($_POST['moderationType']) ? $_POST['moderationType'] : 0;
		$activeType = isset($_POST['activeType']) ? $_POST['activeType'] : 0;

		$pageId = helper::clearInt($pageId);

		$query = helper::clearText($query);
		$query = helper::escapeText($query);

		$categoryId = helper::clearInt($categoryId);
		$sortType = helper::clearInt($sortType);
		$moderationType = helper::clearInt($moderationType);
		$activeType = helper::clearInt($activeType);

		$finder->addCategoryFilter($categoryId);

		if ($activeType == 1) {

			$finder->setInactiveFilter(FILTER_ALL);

		} else {

			$finder->setInactiveFilter(FILTER_ONLY_NO);
		}

		if ($moderationType == 1) {

			$finder->setModerationFilter(FILTER_ONLY_YES);

		} else if ($moderationType == 2) {

			$finder->setModerationFilter(FILTER_ONLY_NO);

		} else {

			$finder->setModerationFilter(FILTER_ALL);
		}

		$result = $finder->getItems($query, $pageId, $sortType);

		$result['items_count'] = count($result['items']);

		if (count($result['items']) != 0) {

			ob_start();

			foreach ($result['items'] as $key => $value) {

                draw($dbo, $value, $LANG, $CURRENCY_ARRAY);
			}

			$result['html'] = ob_get_clean();
		}

		echo json_encode($result);
		exit;
	}

	$page_id = "market";

	$css_files = array("mytheme.css");
	$page_title = $LANG['apanel-market']." | Admin Panel";

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
							<li class="breadcrumb-item active"><?php echo $LANG['apanel-market']; ?></li>
						</ol>
					</div>
				</div>

				<?php

					include_once("common/admin_banner.inc.php");
				?>

				<?php

					$finder->addCategoryFilter($categoryId);

					if ($activeType == 1) {

						$finder->setInactiveFilter(FILTER_ALL);

					} else {

						$finder->setInactiveFilter(FILTER_ONLY_NO);
					}

					if ($moderationType == 1) {

						$finder->setModerationFilter(FILTER_ONLY_YES);

					} else if ($moderationType == 2) {

						$finder->setModerationFilter(FILTER_ONLY_NO);

					} else {

						$finder->setModerationFilter(FILTER_ALL);
					}

					$result = $finder->getItems($query, 0, $sortType);

					?>
						<div class="col-lg-12 ">

							<div class="row">
								<div class="col-sm-12">
									<div class="card card-body">
										<h4 class="card-title"><?php echo $LANG['apanel-label-search']; ?></h4>
										<div class="row">


											<div class="col-sm-12 col-xs-12">

												<form id="market-form" class="input-form-2" method="get" action="/<?php echo APP_ADMIN_PANEL; ?>/market">

													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
																<input type="text" class="form-control" id="query" name="query" value="<?php echo stripslashes($query); ?>" placeholder="<?php echo $LANG['apanel-placeholder-search']; ?>">
																<input type="hidden" name="pageId" value="1">
															</div>
														</div>
													</div>

													<div class="row p-t-20">
														<div class="col-md-6">
															<div class="form-group">
																<label><?php echo $LANG['apanel-label-category']; ?></label>
																<select class="form-control" name="category">
																	<?php

                                                                        $category = new category($dbo);
                                                                        $cat_result = $category->getItems(0);

                                                                        ?>
                                                                        <option <?php if ($categoryId == 0) echo "selected"; ?> value="0"><?php echo $LANG['label-all-categories']; ?></option>
                                                                        <?php

                                                                        foreach ($cat_result['items'] as $key => $value) {

                                                                            ?>
                                                                                <option <?php if ($value['id'] == $categoryId) echo "selected"; ?> value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                                                                            <?php
                                                                        }
																	?>
																</select>
															</div>
														</div>
														<!--/span-->
														<div class="col-md-6">
															<div class="form-group">
																<label><?php echo $LANG['apanel-label-sort-type']; ?></label>
																<select class="form-control" name="sortType">
																	<option <?php if ($sortType == 0) echo "selected"; ?> value="0"><?php echo $LANG['apanel-sort-type-new']; ?></option>
																	<option <?php if ($sortType == 1) echo "selected"; ?> value="1"><?php echo $LANG['apanel-sort-type-old']; ?></option>
																</select>
															</div>
														</div>
														<!--/span-->
													</div>

													<div class="row ">
														<div class="col-md-6">
															<div class="form-group">
																<label><?php echo $LANG['apanel-label-active-type']; ?></label>
																<select class="form-control" name="activeType">
																	<option <?php if ($activeType == 0) echo "selected"; ?> value="0"><?php echo $LANG['apanel-active-type-active']; ?></option>
																	<option <?php if ($activeType == 1) echo "selected"; ?> value="1"><?php echo $LANG['apanel-active-type-all']; ?></option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label><?php echo $LANG['apanel-label-moderation-type']; ?></label>
																<select class="form-control" name="moderationType">
																	<option <?php if ($moderationType == 0) echo "selected"; ?> value="0"><?php echo $LANG['apanel-moderation-type-all']; ?></option>
																	<option <?php if ($moderationType == 1) echo "selected"; ?> value="1"><?php echo $LANG['apanel-moderation-type-moderated']; ?></option>
																	<option <?php if ($moderationType == 2) echo "selected"; ?> value="2"><?php echo $LANG['apanel-moderation-type-unmoderated']; ?></option>
																</select>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-12">
															<div class="form-group mb-0 text-right">
																<button type="submit" class="btn btn-info" type="button"><?php echo $LANG['apanel-action-search']; ?></button>
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

							<div class="card">
								<div class="card-block">
									<h3 class="card-title"><?php echo $LANG['apanel-market']; ?> (<span class="count"><?php echo $result['itemsCount']; ?></span>)</h3>
								</div>

								<div class="tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">
									<div class="tab-pane active">
										<div class="card-block">
											<div class="profiletimeline items-content">

												<?php

													foreach ($result['items'] as $key => $value) {

														draw($dbo, $value, $LANG, $CURRENCY_ARRAY);
													}

												?>
											</div>
										</div>
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
					<?php
				?>

			</div> <!-- End Container fluid  -->

			<?php

				include_once("common/admin_footer.inc.php");
			?>

		<script type="text/javascript">

			var admin_panel = "<?php echo APP_ADMIN_PANEL; ?>";
			var admin_access_token = "<?php echo admin::getAccessToken(); ?>";

			var $none_container = $('div.none-items');

			var $tab_content = $('div.tab-content');

			var $more_container = $('div.loading-more-container');
			var $more_button = $('a.more-items');

			var $counter = $('span.count');

			var $items_content = $('div.items-content');

			var $form = $('form#market-form');

			$(document).on('click', 'a.more-items', function() {

				var $this = $(this);

				$more_container.addClass('hide');

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/market",
					data: $form.serialize(),
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						if (response.hasOwnProperty('html')) {

							$items_content.append(response.html);
						}

						if (response.hasOwnProperty('items_count')) {

							if (response.items_count >= 20) {

								$more_container.removeClass('hide');

								var pageId = $form.find('input[name=pageId]').val();

								$form.find('input[name=pageId]').val(++pageId);
							}
						}
					},
					error: function(xhr, status, error) {

						$more_container.removeClass('hide');
					}
				});
			});

			$(document).on('click', 'a.act-item', function() {

				var $this = $(this);

				var act = $this.attr("data-act");

				var itemId = $this.parents('.market-item').attr("data-id");
				var fromUserId = $this.parents('.market-item').attr("data-from-user-id");

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/market_item",
					data: "itemId=" + itemId + "&fromUserId=" + fromUserId + "&access_token=" + admin_access_token + "&act=" + act,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						$('div.market-item[data-id=' + itemId + ']').remove();

						$counter.text(parseInt($counter.text()) - 1);

						updatePage();

					},
					error: function(xhr, status, error) {


					}
				});

			});

			function updatePage() {

				if ($('div.market-item').length == 0) {

					if (!$more_container.hasClass('hide')) {

						$("a.more-items").trigger("click");

					} else {

						$tab_content.addClass('hide');
						$none_container.removeClass('hide');
					}
				}
			}


		</script>

		</div> <!-- End Page wrapper  -->
	</div> <!-- End Wrapper -->

</body>

</html>

<?php

	function draw($dbo, $item, $LANG, $CURRENCY_ARRAY)
	{
		$fromUser = new profile($dbo, $item['fromUserId']);
		$profileInfo = $fromUser->getVeryShort();

		if (!$item['error'] && $item['imagesCount'] > 0) {

			$images = new images($dbo);
			$images->setRequestFrom($item['fromUserId']);

			$item['images'] = $images->get($item['id']);

			unset($images);
		}

		?>

			<div class="sl-item market-item" data-id="<?php echo $item['id']; ?>" data-from-user-id="<?php echo $item['fromUserId']; ?>">
				<div class="sl-left">
					<a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $item['fromUserId']; ?>"><img src="<?php echo $profileInfo['lowThumbnailUrl']; ?>" alt="user" class="img-circle"></a>
				</div>
				<div class="sl-right">
					<div>
						<a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $item['fromUserId']; ?>" class="link"><?php echo $profileInfo['fullname']; ?></a>
						<span class="sl-date"><label class="label label-rounded label-light-inverse"><?php echo $item['date']; ?></label> <label class="label label-rounded label-light-inverse"><?php echo $item['timeAgo']; ?></label></span>
						<h3 class="mt-2"><?php echo $item['itemTitle']; ?></h3>
						<h5><?php echo $item['itemContent']; ?></h5>
						<label class="label-rounded label-light-danger px-1">
						<?php

							switch ($item['appType']) {

								case APP_TYPE_ANDROID: {

									echo "<i class=\"fa fa-android\" title=\"From Android App\"></i> ";

									break;
								}

								case APP_TYPE_IOS: {

									echo "<i class=\"fa fa-apple\" title=\"From iOS App\"></i> ";

									break;
								}

								default: {

									echo "<i class=\"fa fa-globe\" title=\"From Website\"></i> ";

									break;
								}
							}

						?>
						</label>
						<label class="label label-rounded label-inverse" title="ID"><i class="fa fa-hashtag"></i> <?php echo $item['id']; ?></label>
						<label class="label label-rounded label-custom" title="Category"><i class="fa fa-shopping-basket"></i>
                            <?php

                                $category = new category($dbo);
                                $result = $category->info($item['category']);

                                echo $result['title'];

                                unset($result);
                                unset($category);
                            ?>
                        </label>
						<label class="label label-rounded label-light-info" title="Price"><?php echo draw::generatePrice($item['currency'], $item['price'], $CURRENCY_ARRAY, $LANG); ?></label>
						<?php

							if (strlen($item['phoneNumber']) != 0) {

							?>
								<label class="label label-rounded label-warning"><i class="fa fa-phone"></i> <?php echo $item['phoneNumber']; ?></label>
							<?php
							}
						?>
						<?php

							if (strlen($item['location']) != 0) {

							?>
								<label class="label label-rounded label-light-danger"><i class="fa fa-map-pin"></i> <?php echo$item['location']; ?></label>
							<?php
							}
						?>

						<div class="row">

						<?php

							if (strlen($item['imgUrl']) != 0) {

							?>
								<div class="col-lg-3 col-md-6 m-b-20">
								<div style="width: 100%;height: 150px;display: inline-block; background-image: url('<?php echo $item['imgUrl']; ?>'); background-size: cover; background-position: center;" alt="user" class="img-responsive radius"></div>
								</div>
							<?php

							}

							if ($item['imagesCount'] > 0 && count($item['images']['items']) > 0) {

								for ($i = 0; $i < count($item['images']['items']); $i++) {

									$img = $item['images']['items'][$i];

									?>
										<div class="col-lg-3 col-md-6 m-b-20">
											<div style="width: 100%;height: 150px;display: inline-block; background-image: url('<?php echo $img['imgUrl']; ?>'); background-size: cover; background-position: center;" alt="user" class="img-responsive radius"></div>
										</div>
									<?php

								 }
							}
						?>

						</div>

						<div class="like-comm m-t-20">

							<label class="label label-rounded label-light-info" title="Rating"><i class="fa fa-fire"></i> <?php echo $item['rating']; ?></label>
							<label class="label label-rounded label-light-info" title="Favorites"><i class="fa fa-star"></i> <?php echo $item['likesCount']; ?></label>
							<label class="label label-rounded label-light-info" title="Reports"><i class="fa fa-list-alt"></i> <?php echo $item['reportsCount']; ?></label>
							<label class="label label-rounded label-light-info" title="Views"><i class="fa fa-eye"></i> <?php echo $item['viewsCount']; ?></label>

							<?php


							if ($item['inactiveAt'] == 0) {

								?>
									<label class="label label-rounded label-light-megna"><i class="fa fa-play"></i> <?php echo $LANG['apanel-label-item-active']; ?></label>
								<?php

							} else {

								?>
									<label class="label label-rounded label-light-inverse"><i class="fa fa-pause"></i> <?php echo $LANG['apanel-label-item-inactive']; ?></label>
								<?php
							}

							if ($item['rejectedAt'] != 0) {

								?>
									<label class="label label-rounded label-danger"><i class="fa fa-times"></i> <?php echo $LANG['apanel-label-item-rejected']; ?></label>
								<?php
							}

							if ($item['moderatedAt'] != 0) {

								?>
									<label class="label label-rounded label-success"><i class="fa fa-check-circle"></i> <?php echo $LANG['apanel-label-item-approved']; ?></label>
								<?php
							}

							?>
						</div>

						<div class="like-comm m-t-20 text-right">

							<a class="link m-r-10 act-item" data-act="delete" href="javascript: void(0)" onclick="">
								<i class="fa fa-trash text-danger"></i>
								<?php echo $LANG['apanel-action-delete']; ?>
							</a>

							<?php

								if ($item['inactiveAt'] == 0 && $item['rejectedAt'] == 0 && $item['moderatedAt'] == 0) {

									?>
										<a class="link m-r-10 act-item" data-act="reject" href="javascript: void(0)" onclick="">
											<i class="fa fa-times text-danger"></i>
											<?php echo $LANG['apanel-action-reject']; ?>
										</a>

										<a class="link m-r-10 act-item" data-act="approve" href="javascript: void(0)" onclick="">
											<i class="fa fa-check-circle text-success"></i>
											<?php echo $LANG['apanel-action-approve']; ?>
										</a>
									<?php
								}

							?>

						</div>

					</div>

				</div>
			</div>
			<hr data-id="<?php echo $item['id']; ?>">

		<?php
	}