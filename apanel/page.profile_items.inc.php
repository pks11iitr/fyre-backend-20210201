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

	$accountInfo = array();

	if (isset($_GET['id'])) {

		$accountId = isset($_GET['id']) ? $_GET['id'] : 0;

		$account = new account($dbo, $accountId);
		$accountInfo = $account->get();

	} else {

		header("Location: /".APP_ADMIN_PANEL."/dashboard");
		exit;
	}

	if ($accountInfo['error']) {

		header("Location: /".APP_ADMIN_PANEL."/dashboard");
		exit;
	}

	$finder = new finder($dbo);
	$finder->addProfileIdFilter($accountInfo['id']);
	$finder->setInactiveFilter(FILTER_ALL);

	$pageId = 1;

	if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

		$pageId = helper::clearInt($pageId);

		$result = $finder->getItems("", $pageId);

		$result['items_count'] = count($result['items']);

		if (count($result['items']) != 0) {

			ob_start();

			foreach ($result['items'] as $key => $value) {

				draw($dbo, $value, $LANG, $LANG_CATEGORIES_ARRAY, $CURRENCY_ARRAY);
			}

			$result['html'] = ob_get_clean();
		}

		echo json_encode($result);
		exit;
	}

	$page_id = "profile_items";

	$css_files = array("mytheme.css");
	$page_title = $LANG['apanel-label-stats-profile-items']." | Admin Panel";

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
							<li class="breadcrumb-item"><a href="/<?php echo APP_ADMIN_PANEL; ?>/profile?id=<?php echo $accountId; ?>"><?php echo $accountInfo['fullname']; ?></a></li>
							<li class="breadcrumb-item active"><?php echo $LANG['apanel-label-stats-profile-items']; ?></li>
						</ol>
					</div>
				</div>

				<?php

					include_once("common/admin_banner.inc.php");
				?>

				<?php

					$result = $finder->getItems("", 0);

					?>
						<div class="col-lg-12 ">

							<div class="card">
								<div class="card-block">
									<h3 class="card-title"><?php echo $LANG['apanel-label-stats-profile-items']; ?> (<span class="count"><?php echo $result['itemsCount']; ?></span>)</h3>
								</div>

								<div class="tab-content <?php if (count($result['items']) == 0) echo 'hide'; ?>">
									<div class="tab-pane active">
										<div class="card-block">
											<div class="profiletimeline items-content">

												<?php

													foreach ($result['items'] as $key => $value) {

                                                        draw($dbo, $value, $LANG, $LANG_CATEGORIES_ARRAY, $CURRENCY_ARRAY);
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

			var profile_id = <?php echo $accountInfo['id']; ?>;
			var pageId = <?php echo $pageId; ?>;

			var $none_container = $('div.none-items');

			var $tab_content = $('div.tab-content');

			var $more_container = $('div.loading-more-container');
			var $more_button = $('a.more-items');

			var $counter = $('span.count');

			var $items_content = $('div.items-content');

			$(document).on('click', 'a.more-items', function() {

				var $this = $(this);

				$more_container.addClass('hide');

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/profile_items?id=" + profile_id,
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

								$pageId++;
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

	function draw($dbo, $item, $LANG, $LANG_CATEGORIES_ARRAY, $CURRENCY_ARRAY)
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
						<label class="label label-rounded label-custom" title="Category"><i class="fa fa-shopping-basket"></i> <?php echo $LANG_CATEGORIES_ARRAY[$item['category']]; ?></label>
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