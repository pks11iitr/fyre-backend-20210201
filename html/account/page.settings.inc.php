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
	$fullname = "";
	$birthday = "2000-01-01";

	if (auth::isSession()) {

		$ticket_email = "";
	}

	if (!empty($_POST)) {

		$token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

		$sex = isset($_POST['sex']) ? $_POST['sex'] : 0;

		$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : "2000-01-01";

		$phoneNumber = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';

		$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
		$bio = isset($_POST['bio']) ? $_POST['bio'] : '';
		$location = isset($_POST['location']) ? $_POST['location'] : '';
		$facebook_page = isset($_POST['facebook_page']) ? $_POST['facebook_page'] : '';
		$instagram_page = isset($_POST['instagram_page']) ? $_POST['instagram_page'] : '';

		$sex = helper::clearInt($sex);

		$fullname = helper::clearText($fullname);
		$fullname = helper::escapeText($fullname);

        $bio = helper::clearText($bio);

        $bio = preg_replace( "/[\r\n]+/", "<br>", $bio); //replace all new lines to one new line
        $bio = preg_replace('/\s+/', ' ', $bio);         //replace all white spaces to one space

        $bio = helper::escapeText($bio);

		$location = helper::clearText($location);
		$location = helper::escapeText($location);

		$facebook_page = filter_var($facebook_page, FILTER_SANITIZE_URL);
		$facebook_page = helper::clearText($facebook_page);
		$facebook_page = helper::escapeText($facebook_page);

		$instagram_page = filter_var($instagram_page, FILTER_SANITIZE_URL);
		$instagram_page = helper::clearText($instagram_page);
		$instagram_page = helper::escapeText($instagram_page);

		if (auth::getAuthenticityToken() !== $token) {

			$error = true;
		}

		if (!$error) {

			if (helper::isCorrectFullname($fullname)) {

				auth::setCurrentUserFullname($fullname);

				$account->setFullname($fullname);
			}

			if (helper::isCorrectPhoneNew($phoneNumber)) {

				$account->setPhoneNumber($phoneNumber);

			} else {

                if (strlen($phoneNumber) == 0) {

                    $account->setPhoneNumber("");
                }
            }

			if (helper::validateDate($birthday)) {

				$new_date = date('Y-m-d', $birthday);

				$date = new DateTime($birthday);

				$account->setBirth($date->format('Y'), $date->format('m'), $date->format('d'));
			}

			$account->setSex($sex);
			$account->setBio($bio);
			$account->setLocation($location);

			if (filter_var($facebook_page, FILTER_VALIDATE_URL) !== false) {

				$account->setFacebookPage($facebook_page);

			} else {

				if (strlen($facebook_page) == 0) {

					$account->setFacebookPage("");
				}
			}

			if (filter_var($instagram_page, FILTER_VALIDATE_URL) !== false) {

				$account->setInstagramPage($instagram_page);

			} else {

				if (strlen($instagram_page) == 0) {

					$account->setInstagramPage("");
				}
			}

			header("Location: /account/settings?error=false");
			exit;
		}

		header("Location: /account/settings?error=true");
		exit;
	}

	$accountInfo = $account->get();

	auth::newAuthenticityToken();

	$page_id = "settings_profile";

	$css_files = array();
	$page_title = $LANG['page-settings-profile']." | ".APP_TITLE;

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
										<h3 class="card-title"><?php echo $LANG['page-settings-profile']; ?></h3>
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

										<form id="profile-form" class="form-horizontal" action="/account/settings" method="post">

											<input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">

											<div class="form-group field-fullname">
												<label class="form-label" for="fullname"><?php echo $LANG['label-fullname']; ?></label>
												<input type="text" maxlength="96" id="fullname" class="form-control" name="fullname" value="<?php echo $accountInfo['fullname']; ?>">

												<div class="help-block"></div>
											</div>

                                            <?php

                                                if (strlen($accountInfo['status']) != 0) $accountInfo['status'] = preg_replace("/<br>/", "\n", $accountInfo['status']);
                                            ?>

											<div class="form-group field-bio">
												<label class="form-label" for="bio"><?php echo $LANG['label-bio']; ?></label>
												<textarea style="min-height: 100px" maxlength="400" placeholder="<?php echo $LANG['placeholder-bio']; ?>" id="bio" class="form-control" name="bio"><?php echo $accountInfo['status']; ?></textarea>

												<div class="help-block"></div>
											</div>

											<div class="form-group field-facebook-page">
												<label class="form-label" for="facebook-page"><?php echo $LANG['label-facebook-link']; ?></label>
												<input type="text" maxlength="256" placeholder="<?php echo $LANG['placeholder-facebook-page']; ?>" id="facebook-page" class="form-control" name="facebook_page" value="<?php echo $accountInfo['fb_page']; ?>">

												<div class="help-block"></div>
											</div>

											<div class="form-group field-instagram-page">
												<label class="form-label" for="instagram-page"><?php echo $LANG['label-instagram-link']; ?></label>
												<input type="text" maxlength="256" placeholder="<?php echo $LANG['placeholder-instagram-page']; ?>" id="instagram-page" class="form-control" name="instagram_page" value="<?php echo $accountInfo['instagram_page']; ?>">

												<div class="help-block"></div>
											</div>

											<div class="row">

												<div class="col-sm-4">
													<div class="form-group field-phone-number">
														<label class="form-label" for="phone-number"><?php echo $LANG['label-phone-number']; ?></label>
														<input type="text" maxlength="16" placeholder="<?php echo $LANG['placeholder-phone-number']; ?>" id="phone-number" class="form-control" name="phone_number" value="<?php echo $accountInfo['phone']; ?>">

														<div class="help-block"></div>
													</div>
												</div>

											</div>

											<div class="row">

												<div class="col-sm-4">
													<div class="form-group field-profile-sex">
														<label class="form-label" for="profile-sex"><?php echo $LANG['label-sex']; ?></label>
														<select id="profile-sex" class="form-control" name="sex">
															<option value="0" <?php if ($accountInfo['sex'] == SEX_UNKNOWN) echo "selected=\"selected\""; ?>><?php echo $LANG['label-sex-unknown']; ?></option>
															<option value="1" <?php if ($accountInfo['sex'] == SEX_MALE) echo "selected=\"selected\""; ?>><?php echo $LANG['label-sex-male']; ?></option>
															<option value="2" <?php if ($accountInfo['sex'] == SEX_FEMALE) echo "selected=\"selected\""; ?>><?php echo $LANG['label-sex-female']; ?></option>
														</select>

														<div class="help-block"></div>
													</div>
												</div>

											</div>

											<div class="row">

												<div class="col-sm-4">
													<div class="form-group field-birthday">
														<label class="form-label" for="birthday"><?php echo $LANG['label-birth-date']; ?></label>
														<input type="date" id="birthday" class="form-control" name="birthday" value="<?php echo date('Y-m-d', strtotime($accountInfo['year'].'/'.$accountInfo['month'].'/'.$accountInfo['day'])); ?>">

														<div class="help-block"></div>
													</div>
												</div>

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
