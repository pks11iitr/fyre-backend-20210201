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
		$current_passw = isset($_POST['current_passw']) ? $_POST['current_passw'] : '';
        $new_passw = isset($_POST['new_passw']) ? $_POST['new_passw'] : '';

        $current_passw = helper::clearText($current_passw);
        $current_passw = helper::escapeText($current_passw);

        $new_passw = helper::clearText($new_passw);
        $new_passw = helper::escapeText($new_passw);

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

		if (auth::getAuthenticityToken() === $token) {

			$account = new account($dbo, auth::getCurrentUserId());

            if (strlen($current_passw) == 0 || strlen($new_passw) == 0) {

                header("Location: /account/password?error=empty_data");
                exit;
            }

            if (helper::isCorrectPassword($new_passw)) {

                $result = $account->setPassword($current_passw, $new_passw);

                if ($result['error'] === false) {

                    header("Location: /account/password?error=false");
                    exit;

                } else {

                    header("Location: /account/password?error=current_password");
                    exit;
                }

            } else {

                header("Location: /account/password?error=new_password");
                exit;
            }
		}
	}

	auth::newAuthenticityToken();

	$page_id = "settings_password";

	$css_files = array();
	$page_title = $LANG['page-settings-password']." | ".APP_TITLE;

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
										<h3 class="card-title"><?php echo $LANG['page-settings-password']; ?></h3>
									</div>
									<div class="card-body">

                                        <?php

                                            if (isset($_GET['error'])) {

                                                switch ($_GET['error']) {

                                                    case "empty_data" : {

                                                        ?>

                                                        <div class="alert alert-danger"><?php echo $LANG['msg-empty-fields']; ?></div>

                                                        <?php

                                                        break;
                                                    }

                                                    case "current_password" : {

                                                        ?>

                                                        <div class="alert alert-danger"><?php echo $LANG['msg-password-current-error']; ?></div>

                                                        <?php

                                                        break;
                                                    }

                                                    case "new_password" : {

                                                        ?>

                                                        <div class="alert alert-danger"><?php echo $LANG['msg-password-new-format-error']; ?></div>

                                                        <?php

                                                        break;
                                                    }

                                                    default: {

                                                        ?>

                                                        <div class="alert alert-success"><strong><?php echo $LANG['label-thanks']; ?></strong> <?php echo $LANG['label-password-saved']; ?></div>

                                                        <?php

                                                        break;
                                                    }
                                                }
                                            }
                                        ?>

										<form id="profile-form" class="form-horizontal" action="/account/password" method="post">

											<input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">

											<div class="row">

												<div class="col-sm-4">

													<div class="form-group field-password-current">
														<label class="form-label" for="password-current"><?php echo $LANG['label-password-current']; ?></label>
														<input type="password" placeholder="<?php echo $LANG['placeholder-password-current']; ?>" id="password-current" class="form-control" name="current_passw" value="">

														<div class="help-block"></div>
													</div>

													<div class="form-group field-password-new">
														<label class="form-label" for="password-new"><?php echo $LANG['label-password-new']; ?></label>
														<input type="password" placeholder="<?php echo $LANG['placeholder-password-new']; ?>" id="password-new" class="form-control" name="new_passw" value="">

														<div class="help-block"></div>
													</div>
												</div>

											</div>

											<button type="submit" class="btn btn-primary"><?php echo $LANG['action-change']; ?></button>
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
