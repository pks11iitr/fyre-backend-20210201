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

	$accountId = auth::getCurrentUserId();

	$account = new account($dbo, $accountId);

	$error = false;
	$send_status = false;

	$allowMessages = 1;

	if (!empty($_POST)) {

		$token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

		if (isset($_POST['allowMessages'])) {

            $allowMessages = 1;

		} else {

            $allowMessages = 0;
		}

		if (auth::getAuthenticityToken() !== $token) {

			$error = true;
		}

		if (!$error) {

            $account->setAllowMessages($allowMessages);

			header("Location: /account/privacy?error=false");
			exit;
		}

		header("Location: /account/privacy?error=true");
		exit;
	}

	$accountInfo = $account->get();

	auth::newAuthenticityToken();

	$page_id = "settings_privacy";

	$css_files = array();
	$page_title = $LANG['page-settings-privacy']." | ".APP_TITLE;

	include_once("common/header.inc.php");

?>

<body class="body-directory-index page-profile">

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
										<h3 class="card-title"><?php echo $LANG['page-settings-privacy']; ?></h3>
									</div>

									<div class="card-body">

										<?php

											if (isset($_GET['error'])) {

												switch ($_GET['error']) {

													case "true" : {

														?>

														<div class="alert alert-danger"><?php echo $LANG['msg-error-unknown']; ?></div>

														<?php

														break;
													}

													default: {

														?>

														<div class="alert alert-success"><strong><?php echo $LANG['label-thanks']; ?></strong> <?php echo $LANG['label-settings-saved']; ?></div>

														<?php

														break;
													}
												}
											}
										?>

										<form id="profile-form" class="form-horizontal" action="/account/privacy" method="post">

											<input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">

											<div class="form-group field-allow-direct-messages">
												<div class="form-label"><?php echo $LANG['label-privacy-messages']; ?></div>
												<label class="custom-control custom-checkbox">
													<input type="checkbox" id="allow-direct-messages" class="custom-control-input" name="allowMessages" value="<?php echo $accountInfo['allowMessages']; ?>" <?php if ($accountInfo['allowMessages'] != 0) echo 'checked'; ?>>
													<span class="custom-control-label"><?php echo $LANG['label-privacy-allow-messages']; ?></span>
												</label>

												<div class="help-block"></div>
											</div>

											<button type="submit" class="btn float-right btn-primary"><?php echo $LANG['action-save']; ?></button>
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
