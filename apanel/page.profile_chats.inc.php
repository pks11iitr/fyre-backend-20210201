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

		$conversations = new conversations($dbo);
		$conversations->setRequestFrom($accountId);

	} else {

		header("Location: /".APP_ADMIN_PANEL."/dashboard");
		exit;
	}

	if ($accountInfo['error']) {

		header("Location: /".APP_ADMIN_PANEL."/dashboard");
		exit;
	}

	$pageId = 0;

	if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

		$pageId = helper::clearInt($pageId);

		$result = $conversations->getItems($pageId);

		$result['items_count'] = count($result['items']);

		if (count($result['items']) != 0) {

			ob_start();

			foreach ($result['items'] as $key => $value) {

				draw($value);
			}

			$result['html'] = ob_get_clean();
		}

		echo json_encode($result);
		exit;
	}

	$page_id = "profile_chats";

	$css_files = array("mytheme.css");
	$page_title = $LANG['apanel-label-stats-profile-chats']." | Admin Panel";

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
							<li class="breadcrumb-item active"><?php echo $LANG['apanel-label-stats-profile-chats']; ?></li>
						</ol>
					</div>
				</div>

				<?php

					include_once("common/admin_banner.inc.php");
				?>

                        <div class="row">
							<div class="col-md-12">

								<div class="card">

									<div class="card-block bg-info">
										<h4 class="text-white card-title"><?php echo $LANG['apanel-label-stats-profile-chats']; ?></h4>
										<h6 class="card-subtitle text-white m-b-0 op-5"><?php echo $LANG['apanel-label-stats-profile-chats-desc']; ?></h6>
									</div>

									<?php

                    					$result = $conversations->getItems(0);
				                    ?>

									<div class="card-block tab-content">
										<div class="message-box contact-box">
											<div class="message-widget contact-widget items-content">

												<?php

														foreach ($result['items'] as $key => $value) {

															draw($value);
														}

													?>

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
						</div>

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

			var $items_content = $('div.items-content');

			$(document).on('click', 'a.more-items', function() {

				var $this = $(this);

				$more_container.addClass('hide');

				$.ajax({
					type: 'POST',
					url: "/" + admin_panel + "/profile_chats?id=" + profile_id,
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

		</script>

		</div> <!-- End Page wrapper  -->
	</div> <!-- End Wrapper -->

</body>

</html>

<?php

	function draw($item)
	{
		?>

			<a href="/<?php echo APP_ADMIN_PANEL; ?>/chat?id=<?php echo $item['id']; ?>" class="data-item" data-id="<?php echo $item['id']; ?>">
				<div class="user-img">

				<?php

						if (strlen($item['withUserPhotoUrl']) != 0) {

							?>
								<img src="<?php echo $item['withUserPhotoUrl']; ?>" alt="user" class="img-circle">
							<?php

						} else {

							?>
								<img src="/img/profile_default_photo.png" alt="user" class="img-circle">
							<?php
						}

					if (strlen($item['withUserOnline'])) {

						?>
							<span class="profile-status online pull-right"></span>
						<?php

					}
				?>

				</div>
				<div class="mail-contnet">
					<h5><?php echo $item['withUserFullname']; ?></h5>
					<span class="mail-desc">@<?php echo $item['withUserUsername']; ?></span>
					<?php

						if ($item['toItemId'] != 0) {

							?>
								<span class="mail-desc">#<?php echo $item['itemTitle']; ?></span>
							<?php
						}

 					?>
				</div>
			</a>

		<?php
	}