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

	$profileId = $helper->getUserId($request[0]);

	if ($profileId == 0) {

		header("Location: /");
		exit;
	}

	$myProfile = false;

	if ($profileId == auth::getCurrentUserId()) {

		$myProfile = true;
	}

	$profile = new profile($dbo, $profileId);

	$profile->setRequestFrom(auth::getCurrentUserId());
	$profileInfo = $profile->get();

	$finder = new finder($dbo);
	$finder->setRequestFrom(auth::getCurrentUserId());
	$finder->addProfileIdFilter($profileId);

	if ($myProfile) {

		$finder->setInactiveFilter(FILTER_ALL); // Show all (active and inactive) items

	}

	if (!$myProfile && WEB_SHOW_ONLY_MODERATED_ADS_BY_DEFAULT) {

        $finder->setModerationFilter(FILTER_ONLY_YES); // Show only moderated items
    }

	$pageId = 1;

	if (!empty($_POST)) {

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;

		$pageId = helper::clearInt($pageId);

		$result = $finder->getItems("", $pageId);

		$result['items_count'] = count($result['items']);

		if (count($result['items']) != 0) {

			ob_start();

			foreach ($result['items'] as $key => $value) {

				draw::item($value, $CURRENCY_ARRAY, $LANG, "col-6 col-sm-6 col-md-6 col-lg-3");
			}

			$result['html'] = ob_get_clean();
		}

		echo json_encode($result);
		exit;
	}

	$page_id = "profile";

	$css_files = array("blueimp-gallery.min.css");

	if ($profileInfo['state'] != ACCOUNT_STATE_ENABLED) {

		$page_title = $LANG['page-profile']." | ".APP_TITLE;

	} else {

		$page_title = $profileInfo['fullname']." | ".APP_TITLE;
	}

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

					<?php

						if ($profileInfo['state'] != ACCOUNT_STATE_ENABLED) {

							?>

							<div class="my-login">

								<div class="row justify-content-center">
									<div class="card col-11 col-sm-10 col-md-8">
										<div class="card-header">
											<h3 class="card-title"><?php echo $LANG['page-profile']; ?></h3>
										</div>
										<div class="card-body">
											<div class="alert alert-warning alert-dismissible">
												<?php
													if ($profileInfo['state'] == ACCOUNT_STATE_DISABLED) {

														echo $LANG['label-account-disabled'];

													} else {

														echo $LANG['label-account-blocked'];
													}
												?>
												</div>
											<div>
												<a class="btn btn-primary" href="/"><?php echo $LANG['action-back-to-main-page']; ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php

						} else {

							?>

							<div class="row" data-id="<?php echo $profileInfo['id']; ?>">

								<!-- Left section with photos  -->

								<div id="profile-column-left" class="col-sm-12 col-md-12 col-lg-12 order-md-1 order-lg-1">

                                    <!-- Adsense banner -->

									<div class="sidebar-wrapper">

										<div class="card">

											<!-- Profile Cover -->

											<div class="profile-cover">
												<div class="profile-main-cover">
													<div class="cover-wrapper d-flex">
														<div class="loader profile-cover-loader">
															<i class="fa fa-spin fa-spin"></i>
														</div>
														<div class="profile-cover-progress">
															<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<div class="profile-cover-img" style="background-image: url(<?php echo $profileInfo['normalCoverUrl']; ?>);"></div>
														<?php

															if ($myProfile) {

																?>
																	<div class="btn btn-secondary cover-upload-button">
																		<input type="file" id="cover-upload" name="uploaded_file">
																		<i class="fa fa-camera"></i>
																	</div>
																<?php
															}
														?>
													</div>
												</div>

												<div class="profile-other-photos p-0">

													<div id="blueimp-gallery"
														 class="blueimp-gallery blueimp-gallery-controls " style="display: none;">
														<div class="slides" style="width: 6400px;"></div>
														<h3 class="title"></h3>
														<a class="prev text-light">‹</a>
														<a class="next text-light">›</a>
														<a class="close text-light"></a>
														<a class="play-pause"></a>
														<ol class="indicator"></ol>
													</div>

												</div>
											</div> <!-- End Profile Cover -->

											<div class="profile-info">

												<div class="profile-info-block profile-main-info">

													<div class="d-flex">

														<div class="profile-photo-container">
															<div class="loader profile-photo-loader">
																<i class="fa fa-spin fa-spin"></i>
															</div>
															<div class="profile-photo-progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
															<a class="profile-photo-link" href="<?php echo $profileInfo['normalPhotoUrl']; ?>">
																<div class="profile-photo" style="background-image: url(<?php echo $profileInfo['bigThumbnailUrl']; ?>);" onclick="blueimp.Gallery($('.profile-photo-link')); return false"></div>
															</a>
															<?php

																if ($myProfile) {

																	?>
																		<div class="btn btn-secondary photo-upload-button">
																			<input type="file" id="photo-upload" name="uploaded_file">
																			<i class="fa fa-camera"></i>
																		</div>
																	<?php
																}
															?>
														</div>

														<div class="w-100 justify-content-end profile-main-info-container">
															<div class="fullname-line ">
																<h1 class="display-name"><?php echo $profileInfo['fullname']; ?></h1>
																<?php

																	if ($profileInfo['verified']) {

																		?>
																			<span class="user-badge user-verified-badge ml-1" rel="tooltip" title="<?php echo $LANG['label-account-verified']; ?>"><i class="fa fa-check"></i></span>
																		<?php
																	}

																	if ($profileInfo['online']) {

																		?>
																			<i class="online-status bg-green" rel="tooltip" title="Online"></i>
																		<?php

																	} else {

																		?>
																			<i class="online-status bg-gray" rel="tooltip" title="<?php echo $profileInfo['lastAuthorizeTimeAgo']; ?>"></i>
																		<?php
																	}
																?>

															</div>

															<?php

																if (strlen($profileInfo['location']) != 0) {

																	?>
																		<div class="addon-line d-flex align-content-center flex-column flex-sm-row">
																			<div class="user-location mt-2 mt-sm-0 ml-0">
																				<i class="fa fa-map-marker""></i>
																				<?php echo $profileInfo['location']; ?>
																			</div>
																		</div>
																	<?php
																}
															?>

															<?php

																if (strlen($profileInfo['fb_page']) != 0) {

																	?>
																		<div class="addon-line d-flex align-content-center flex-column flex-sm-row">
																			<div class="user-link mt-2 mt-sm-0 ml-0">
																				<i class="fa fa-link""></i>
																				<a target="_blank" rel="nofollow" href="/go?to=<?php echo $profileInfo['fb_page']; ?>"><?php echo $profileInfo['fb_page']; ?></a>
																			</div>
																		</div>
																	<?php
																}
															?>

															<?php

																if (strlen($profileInfo['instagram_page']) != 0) {

																	?>
																		<div class="addon-line d-flex align-content-center flex-column flex-sm-row">
																			<div class="user-link mt-2 mt-sm-0 ml-0">
																				<i class="fa fa-link"></i>
																				<a target="_blank" rel="nofollow" href="/go?to=<?php echo $profileInfo['instagram_page']; ?>"><?php echo $profileInfo['instagram_page']; ?></a>
																			</div>
																		</div>
																	<?php
																}
															?>

															<?php

																if (strlen($profileInfo['bio']) != 0) {

																	?>
																		<div class="addon-line d-flex align-content-center flex-column flex-sm-row">
																			<div class="user-bio mt-2 mt-sm-0 ml-0">
																				<i class="fa fa-info"></i>
																				<span><?php echo $profileInfo['bio']; ?></span>
																			</div>
																		</div>
																	<?php
																}
															?>

														</div>

													</div>

												</div>

												<?php

												if (auth::getCurrentUserId() != 0) {

													?>

													<div class="profile-info-block profile-main-actions text-right">

														<?php

															if ($myProfile) {

																?>
																	<a class="btn btn-primary mb-2 mb-sm-0" href="/account/settings">
																		<i class="fa fa-pencil-alt mr-1"></i>
																		<?php echo $LANG['action-edit-profile']; ?>
																	</a>
																<?php
															} else {

																?>
																	<button class="btn btn-primary mb-2 mb-sm-0" data-toggle="modal" data-target="#new-message">
																		<i class="fa fa-envelope mr-1"></i>
																		<?php echo $LANG['action-send-message']; ?>
																	</button>

																	<div class="dropdown">
																		<button type="button" class="btn btn-secondary dropdown-toggle mb-2 mb-sm-0" data-toggle="dropdown">
																			<i class="fa fa-ellipsis-h"></i>
																		</button>

																		<div class="dropdown-menu">
																			<button class="dropdown-item report-button" data-toggle="modal" data-target="#new-report"><?php echo $LANG['action-report']; ?></button>
																			<?php

																			if (!$myProfile && !$profileInfo['error'] && $profileInfo['state'] == ACCOUNT_STATE_ENABLED) {

																				if ($profileInfo['blocked']) {

																					?>
																						<button class="dropdown-item block-button" data-toggle="modal" data-target="#profile-unblock-dlg"><?php echo $LANG['action-unblock']; ?></button>
																					<?php

																				} else {

																					?>
																						<button class="dropdown-item block-button" data-toggle="modal" data-target="#profile-block-dlg"><?php echo $LANG['action-block']; ?></button>
																					<?php

																				}
																			}
																			?>
																		</div>
																	</div>
																<?php
															}
														?>

													</div>

													<?php

												} else {

													?>
														<div class="profile-info-block profile-main-actions">
															<span class="promo-msg mr-3"><?php echo sprintf($LANG['msg-contact-promo'], "<strong>" . $profileInfo['fullname'] . "</strong>"); ?></span>
															<a class="btn btn-primary mr-1" href="/signup"><?php echo $LANG['action-signup']; ?></a>
															<a class="btn btn-secondary" href="/login?continue=/<?php echo $profileInfo['username']; ?>"><?php echo $LANG['action-login']; ?></a>
														</div>
													<?php
												}
												?>

											</div>

										</div>
										<!-- end photos card -->

									</div>
								</div>

								<!-- Left section with photos end -->


								<div id="profile-column-content"class="col-sm-12 col-md-12 col-lg-12 order-md-2 order-lg-2">

									<div class="dashboard-block mb-3">

										<?php

										$result = $finder->getItems();

										if (count($result['items']) > 0) {

											?>
											<h3><?php echo sprintf($LANG['label-all-profile-items'], $result['itemsCount']); ?></h3>
											<?php
										}

										?>

										<div class="list-view items-list-view">

											<div class="row row-cards row-deck items-grid-view">

												<?php

												if (count($result['items']) > 0) {

													foreach ($result['items'] as $key => $value) {

														draw::item($value, $CURRENCY_ARRAY, $LANG, "col-6 col-sm-6 col-md-6 col-lg-3");
													}

												} else {

													?>
													<div
														class="col-sm-12 col-sm-md-12 col-lg-12 d-flex align-content-center justify-content-center flex-column mt-sm-3">

														<?php

														if ($myProfile) {

															?>
															<div class="text-center">
																<h3><?php echo $LANG['msg-publish-ad-promo']; ?></h3>
																<a class="btn btn-primary" href="/item/new">
																	<i class="fa fa-plus"></i>
																	<span class="d-none d-sm-inline"><?php echo $LANG['action-new-classified']; ?></span>
																</a>
															</div>
															<h4 class="mb-0 d-flex flex-row align-items-center"></h4>

															<?php

														} else {

															?>
															<div class="text-center">
																<h3><?php echo $LANG['msg-empty-profile-items']; ?></h3>
															</div>
															<?php
														}
														?>
													</div>
													<?php
												}

												?>

											</div>

											<div class="row row-cards row-deck loading-more-container <?php if (count($result['items']) < 20) echo 'hidden'; ?>">
												<div class="d-lg-block col-md-12 mb-5">
													<div class="list-view-banner p-3 d-flex justify-content-between align-items-center loading-more-banner">
														<h4 class="mb-0 d-flex flex-row align-items-center loading-more-text"></h4>
														<a class="btn btn-primary btn-lg float-right d-flex justify-content-between align-items-center loading-more-button" href="javascript:void(0)">
															<div class="btn-loader hidden rounded justify-content-center align-items-center d-sm-flex loading-more-progress"></div>
															<i class="fa fa-arrow-down loading-more-button-icon mr-1"></i>
															<span class="ml-2 d-sm-inline"><?php echo $LANG['action-more']; ?></span>
														</a>
													</div>
												</div>
											</div>

										</div>

                                        <?php

                                            require_once ("common/adsense_banner.inc.php");
                                        ?>

									</div>
									<!-- End Content Block -->

								</div>

							</div> <!-- End row -->

							<?php

						}
					?>

				</div>
			</div>
		</div>  <!-- End page-main -->

		<?php

			if (auth::isSession() && !$myProfile && !$profileInfo['error'] && $profileInfo['state'] == ACCOUNT_STATE_ENABLED) {

				?>
				<div class="modal modal-form fade" id="new-message" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form id="new-message-form" action="/api/v1/method/msg.new" method="post">

								<input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
								<input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

								<input type="hidden" name="profileId" value="<?php echo $profileInfo['id']; ?>">

								<div class="modal-header">
									<h5 class="modal-title placeholder-title" id="profile-new-message-title"><?php echo $LANG['dlg-message-title']; ?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"></span>
									</button>
								</div>
								<div class="modal-body">

									<div class="error-summary alert alert-danger" style="display:none"><ul></ul></div>

									<div class="form-group field-message required">
										<textarea id="message" class="form-control" name="messageText" rows="3" placeholder="<?php echo $LANG['dlg-message-placeholder']; ?>" aria-required="true"></textarea>
										<div class="help-block"></div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['action-cancel']; ?></button>
									<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane mr-1"></i><?php echo $LANG['action-send']; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php
			}

			if (!$myProfile && !$profileInfo['error'] && $profileInfo['state'] == ACCOUNT_STATE_ENABLED) {

				?>
				<div class="modal modal-form fade profile-report" id="new-report" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form id="new-report-form" action="/api/v1/method/profile.report" method="post">

								<input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
								<input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

								<input type="hidden" name="profileId" value="<?php echo $profileInfo['id']; ?>">

								<div class="modal-header">
									<h5 class="modal-title"><?php echo $LANG['dlg-report-profile-title']; ?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
								</div>

								<div class="modal-body">
									<div class="error-summary alert alert-danger" style="display:none"><ul></ul></div>
									<div class="pb-3"><strong><?php echo $LANG['dlg-report-sub-title']; ?></strong></div>
									<div class="form-group field-reason required">
										<input type="hidden" name="reason" value="-1">
										<div id="reason" aria-required="true">
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="reason" value="0">
												<div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-1']; ?></div>
											</label>
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="reason" value="1">
												<div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-2']; ?></div>
											</label>
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="reason" value="2">
												<div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-3']; ?></div>
											</label>
											<label class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="reason" value="3">
												<div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-4']; ?></div>
											</label>
										</div>

										<div class="help-block"></div>
									</div>

									<div class="form-group field-description">
										<label class="form-label" for="description"><?php echo $LANG['dlg-report-description-label']; ?></label>
										<textarea id="description" class="form-control" name="description" placeholder="<?php echo $LANG['dlg-report-description-placeholder']; ?>"></textarea>

										<div class="help-block"></div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary " data-dismiss="modal"><?php echo $LANG['action-cancel']; ?></button>
									<button type="submit" disabled="disabled" class="btn btn-primary"><?php echo $LANG['action-report']; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal modal-form fade profile-block-dlg" id="profile-block-dlg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">

							<form id="profile-block-form" action="/api/v1/method/blacklist.add" method="post">

								<input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
								<input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

								<input type="hidden" name="profileId" value="<?php echo $profileInfo['id']; ?>">
								<input type="hidden" name="reason" value="">

								<div class="modal-header">
									<h5 class="modal-title placeholder-title"><?php echo $LANG['dlg-confirm-block-title']; ?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"></span>
									</button>
								</div>

								<div class="modal-body">

									<div class="error-summary alert alert-warning"><?php echo sprintf($LANG['msg-block-user-text'], "<strong>".$profileInfo['fullname']."</strong>", "<strong>".$profileInfo['fullname']."</strong>"); ?></div>

								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['action-no']; ?></button>
									<button type="submit" class="btn btn-primary"><?php echo $LANG['action-yes']; ?></button>
								</div>
							</form>

						</div>
					</div>
				</div>

				<div class="modal modal-form fade profile-unblock-dlg" id="profile-unblock-dlg" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">

							<form id="profile-unblock-form" action="/api/v1/method/blacklist.remove" method="post">

								<input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
								<input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

								<input type="hidden" name="profileId" value="<?php echo $profileInfo['id']; ?>">

								<div class="modal-header">
									<h5 class="modal-title placeholder-title"><?php echo $LANG['dlg-confirm-unblock-title']; ?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"></span>
									</button>
								</div>

								<div class="modal-body">

									<div class="error-summary alert alert-warning"><?php echo sprintf($LANG['msg-unblock-user-text'], "<strong>".$profileInfo['fullname']."</strong>"); ?></div>

								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['action-no']; ?></button>
									<button type="submit" class="btn btn-primary"><?php echo $LANG['action-yes']; ?></button>
								</div>
							</form>

						</div>
					</div>
				</div>
				<?php
			}
		?>


			<?php

				include_once("common/footer.inc.php");
			?>

	</div> <!-- End page -->

	<script src="/js/blueimp-gallery.min.js"></script>
	<script src="/js/load-image.all.min.js"></script>
	<script src="/js/jquery.ui.widget.js"></script>
	<script src="/js/jquery.iframe-transport.js"></script>
	<script src="/js/jquery.fileupload.js"></script>
	<script src="/js/jquery.fileupload-process.js"></script>
	<script src="/js/jquery.fileupload-image.js"></script>
	<script src="/js/jquery.fileupload-validate.js"></script>

	<script>

		var FILE_COVER_MAX_SIZE = <?php echo FILE_COVER_MAX_SIZE; ?>;
		var FILE_PHOTO_MAX_SIZE = <?php echo FILE_PHOTO_MAX_SIZE; ?>;

		var strings = {

			szFileSizeError: "<?php echo $LANG['msg-photo-file-size-error']; ?>",
			szActionBlock: "<?php echo $LANG['action-block']; ?>",
			szActionUnblock: "<?php echo $LANG['action-unblock']; ?>"
		};

		var $infobox = $('#info-box');

		$("#cover-upload").fileupload({
			formData: {accountId: <?php echo auth::getCurrentUserId(); ?>, accessToken: "<?php echo auth::getAccessToken(); ?>"},
			name: 'images',
			url: "/api/v1/method/profile.uploadCover",
			dropZone:  '',
			dataType: 'json',
			singleFileUploads: true,
			multiple: false,
			maxNumberOfFiles: 1,
			maxFileSize: FILE_COVER_MAX_SIZE,
			acceptFileTypes: "", // or regex: /(jpeg)|(jpg)|(png)$/i
			"files":null,
			minFileSize: null,
			messages: {
				"maxNumberOfFiles": "Maximum number of files exceeded",
				"acceptFileTypes": "File type not allowed",
				"maxFileSize": strings.szFileSizeError,
				"minFileSize": "File is too small"},
			process: true,
			start: function (e, data) {

				console.log("start");

				$('div.profile-cover-progress').css("display", "block");
				$('div.profile-cover-loader').addClass('hidden');
				$('div.cover-upload-button').addClass('hidden');
				$('div.profile-cover-img').addClass('hidden');
			},
			processfail: function(e, data) {

				console.log("processfail");

				if (data.files.error) {

					$infobox.find('#info-box-message').text(data.files[0].error);
					$infobox.modal('show');
				}
			},
			progressall: function (e, data) {

				console.log("progressall");

				 var progress = parseInt(data.loaded / data.total * 100, 10);

				 $('div.profile-cover-progress').find('.progress-bar').attr('aria-valuenow', progress).css('width', progress + '%').text(progress + '%');
			},
			done: function (e, data) {

				console.log("done");

				var result = jQuery.parseJSON(data.jqXHR.responseText);

				if (result.hasOwnProperty('error')) {

					if (result.error === false) {

						if (result.hasOwnProperty('normalCoverUrl')) {

							$("div.profile-cover-img").css("background-image", "url(" + result.normalCoverUrl + ")");
						}

					} else {

						$infobox.find('#info-box-message').text(result.error_description);
						$infobox.modal('show');
					}
				}
			},
			fail: function (e, data) {

				console.log("always");
			},
			always: function (e, data) {

				console.log("always");

				$('div.profile-cover-progress').css("display", "none");
				$('div.profile-cover-loader').removeClass('hidden');
				$('div.cover-upload-button').removeClass('hidden');
				$('div.profile-cover-img').removeClass('hidden');
			}

		});

		$("#photo-upload").fileupload({
					formData: {accountId: <?php echo auth::getCurrentUserId(); ?>, accessToken: "<?php echo auth::getAccessToken(); ?>"},
					name: 'images',
					url: "/api/v1/method/profile.uploadPhoto",
					dropZone:  '',
					dataType: 'json',
					singleFileUploads: true,
					multiple: false,
					maxNumberOfFiles: 1,
					maxFileSize: FILE_PHOTO_MAX_SIZE,
					acceptFileTypes: "", // or regex: /(jpeg)|(jpg)|(png)$/i
					"files":null,
					minFileSize: null,
					messages: {
						"maxNumberOfFiles":"Maximum number of files exceeded",
						"acceptFileTypes":"File type not allowed",
						"maxFileSize": strings.szFileSizeError,
						"minFileSize":"File is too small"},
					process: true,
					start: function (e, data) {

						console.log("start");

						$('div.profile-photo-progress').css("display", "block");
						$('div.profile-photo-loader').addClass('hidden');
						$('div.photo-upload-button').addClass('hidden');
						$('a.profile-photo-link').addClass('hidden');

						$("#photo-upload").trigger('start');
					},
					processfail: function(e, data) {

						console.log("processfail");

						if (data.files.error) {

							$infobox.find('#info-box-message').text(data.files[0].error);
							$infobox.modal('show');
						}
					},
					progressall: function (e, data) {

						console.log("progressall");

						var progress = parseInt(data.loaded / data.total * 100, 10);

						$('div.profile-photo-progress').find('.progress-bar').attr('aria-valuenow', progress).css('width', progress + '%').text(progress + '%');
					},
					done: function (e, data) {

						console.log("done");

						var result = jQuery.parseJSON(data.jqXHR.responseText);

						if (result.hasOwnProperty('error')) {

							if (result.error === false) {

								if (result.hasOwnProperty('lowPhotoUrl')) {

									$("div.profile-photo").css("background-image", "url(" + result.lowPhotoUrl + ")");
									$("span.avatar").css("background-image", "url(" + result.lowPhotoUrl + ")");
									$("a.profile-photo-link").first().attr("href", result.originPhotoUrl);
								}

							} else {

								$infobox.find('#info-box-message').text(result.error_description);
								$infobox.modal('show');
							}
						}

						$("#photo-upload").trigger('done');
					},
					fail: function (e, data) {

						console.log(data.errorThrown);
					},
					always: function (e, data) {

						console.log("always");

						$('div.profile-photo-progress').css("display", "none");
						$('div.profile-photo-loader').removeClass('hidden');
						$('div.photo-upload-button').removeClass('hidden');
						$('a.profile-photo-link').removeClass('hidden');

						$("#photo-upload").trigger('always');
					}
				});

		var options = {};

		$(document).off('click.gallery', '#w0 a').on('click.gallery', '#w0 a', function() {

				var links = $(this).parent().find('a.gallery-item');
				options.index = $(this)[0];
				blueimp.Gallery(links, options);

				return false;
		});

		$(document).on("click", "input[name=reason]", function() {

			var form = $('#new-report-form');

			form.find("button[type=submit]").removeAttr('disabled');
		});

	</script>



		<script type="text/javascript">

			var pageId = <?php echo $pageId; ?>;
			var username = "<?php echo $profileInfo['username']; ?>";

			$(document).on('click', '.loading-more-button', function() {

				var $this = $(this);

				if ($this.hasClass('disabled')) {

					return;
				}

				$this.addClass('disabled');
				$this.find('div.btn-loader').removeClass('hidden');
				$this.find('i.loading-more-button-icon').addClass('hidden');

				$.ajax({
					type: 'POST',
					url: "/" + username,
					data: 'pageId=' + pageId,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						if (response.hasOwnProperty('html')) {

							$("div.items-grid-view").append(response.html);
						}

						if (response.hasOwnProperty('items_count')) {

							if (response.items_count < 20) {

								$('div.loading-more-container').addClass('hidden');

							} else {

								pageId++;
							}
						}

						$this.removeClass('disabled');
						$this.find('div.btn-loader').addClass('hidden');
						$this.find('i.loading-more-button-icon').removeClass('hidden');
					},
					error: function(xhr, status, error) {

						$this.removeClass('disabled');
						$this.find('div.btn-loader').addClass('hidden');
						$this.find('i.loading-more-button-icon').removeClass('hidden');
					}
				});
			});

		</script>

</body>
</html>