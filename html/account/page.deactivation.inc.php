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

	if (!$auth->authorize(auth::getCurrentUserId(), auth::getAccessToken())) {

		header('Location: /');
		exit;
	}

	if (!empty($_POST)) {

		$token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
		$passw = isset($_POST['passw']) ? $_POST['passw'] : '';

		$passw = helper::clearText($passw);
		$passw = helper::escapeText($passw);

		if (auth::getAuthenticityToken() === $token) {

			$account = new account($dbo, auth::getCurrentUserId());

			$result = array("error" => true,
							"error_code" => ERROR_UNKNOWN);

			$result = $account->deactivation($passw);

			if (!$result['error']) {

				$items = new items($dbo);
				$items->setRequestFrom(auth::getCurrentUserId());
				$items->removeAll();

                // Remove all authorizations
				$auth->removeAll(auth::getCurrentUserId());

				header("Location: /account/logout?access_token=".auth::getAccessToken());
				exit;

			} else {

				header("Location: /account/deactivation?error=true");
				exit;
			}
		}
	}

	auth::newAuthenticityToken();

	$page_id = "settings_deactivation";

	$css_files = array();
	$page_title = $LANG['page-settings-deactivation']." | ".APP_TITLE;

	include_once("common/header.inc.php");

?>

<body class="page-profile">

	<div class="page">
		<div class="page-main">

			<?php

				include_once("common/topbar.inc.php");
			?>

			<!-- End topbar -->

			<div class="content my-3 my-md-5">
				<div class="container">

					<div class="page-content">
						<div class="row">

							<!-- Sidebar section -->

							<?php

								include_once("common/sidebar_settings.inc.php");
							?>

							<!-- End Sidebar section -->


							<!-- Start settings section -->

							<div class="col-lg-9">

								<div class="card">
									<div class="card-header">
										<h3 class="card-title"><?php echo $LANG['page-settings-deactivation']; ?></h3>
									</div>
									<div class="card-body">

										<div class="alert alert-warning"><?php echo $LANG['msg-deactivation-promo']; ?></div>

										<?php

											if (isset($_GET['error']) ) {

												?>

												<div class="alert alert-danger"><?php echo $LANG['msg-deactivation-error']; ?></div>

												<?php
											}
										?>

										<form id="profile-form" class="form-horizontal" action="/account/deactivation" method="post">

											<input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">

											<div class="row">

												<div class="col-sm-4">
													<div class="form-group field-password">
														<label class="form-label" for="password"><?php echo $LANG['label-password']; ?></label>
														<input type="password" placeholder="<?php echo $LANG['placeholder-password-current']; ?>" id="password" class="form-control" name="passw" value="">

														<div class="help-block"></div>
													</div>
												</div>

											</div>

											<button type="submit" class="btn btn-primary"><?php echo $LANG['action-deactivate']; ?></button>
										</form>

									</div>
								</div>

							</div>

							<!-- End settings section -->

						</div>
					</div>

				</div>
			</div> <!-- End content -->

		</div> <!-- End page-main -->

		<?php

			include_once("common/footer.inc.php");
		?>

	</div> <!-- End page -->

</body>
</html>
