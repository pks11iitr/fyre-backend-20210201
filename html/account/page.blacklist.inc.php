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

    $blacklist = new blacklist($dbo);
    $blacklist->setRequestFrom(auth::getCurrentUserId());

    if (!empty($_POST)) {

        $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

        $itemId = helper::clearInt($itemId);

        $result = $blacklist->get($itemId);

        $items_count = count($result['items']);

        $result['items_count'] = $items_count;

        if ($items_count != 0) {

            ob_start();

            foreach ($result['items'] as $key => $value) {

                draw::blacklistItem($value, $LANG);
            }

            $result['html'] = ob_get_clean();
        }

        echo json_encode($result);
        exit;
    }

	auth::newAuthenticityToken();

	$page_id = "settings_blacklist";

	$css_files = array();
	$page_title = $LANG['page-settings-blacklist']." | ".APP_TITLE;

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
										<h3 class="card-title"><?php echo $LANG['page-settings-blacklist']; ?></h3>
									</div>
									<div class="card-body">

										<div id="blocked-users-items" class="items-list-view">

                                            <?php

                                                $result = $blacklist->get(0);

                                                $items_loaded = count($result['items']);

                                                if ($items_loaded != 0) {

                                                    foreach ($result['items'] as $key => $item) {

                                                        draw::blacklistItem($item, $LANG);
                                                    }
                                                }
                                            ?>

										</div>

                                        <div class="page-empty <?php if ($items_loaded > 0) echo 'hidden' ?>">
                                            <div class="empty-state noselect">
                                                <div class="empty-icon"><i class="fa fa-user-alt"></i></div>
                                                <h5 class="empty-title"><?php echo $LANG['page-empty-list']; ?></h5>
                                                <p class="empty-subtitle"><?php echo $LANG['page-blacklist-empty-list']; ?></p>
                                            </div>
                                        </div>

                                        <div class="row row-cards row-deck loading-more-container <?php if (count($result['items']) < 20) echo 'hidden'; ?>">
                                            <div class="d-lg-block col-md-12">
                                                <div class="directory-banner pt-3 d-flex justify-content-between align-items-center loading-more-banner" style="border-top: 1px solid #e0e5ec;">
                                                    <h4 class="mb-0 d-flex flex-row align-items-center loading-more-text"></h4>
                                                    <a data-id="<?php echo $result['itemId']; ?>" class="btn btn-primary btn-lg float-right d-flex justify-content-between align-items-center loading-more-button" href="javascript:void(0)">
                                                        <div class="btn-loader hidden rounded justify-content-center align-items-center d-sm-flex loading-more-progress"></div>
                                                        <i class="ic icon-arrow-down loading-more-button-icon mr-1"></i>
                                                        <span class="ml-2 d-sm-inline"><?php echo $LANG['action-more']; ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

									</div>
								</div>

							</div>

							<!-- End settings section -->

						</div>
					</div>

				</div>
			</div> <!-- End content -->

		</div> <!-- End page-main -->

        <div class="modal modal-form fade profile-unblock-dlg" id="profile-unblock-dlg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form id="profile-unblock-form" action="/api/v1/method/blacklist.remove" method="post">

                        <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                        <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                        <input type="hidden" name="profileId" value="">
                        <input type="hidden" name="itemId" value="">

                        <div class="modal-header">
                            <h5 class="modal-title placeholder-title"><?php echo $LANG['dlg-confirm-unblock-title']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="error-summary alert alert-warning"><?php echo $LANG['msg-unblock-user-text-2']; ?></div>

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

			include_once("common/footer.inc.php");
		?>

	</div> <!-- End page -->

    <script>

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
                url: "/account/blacklist",
                data: 'itemId=' + $this.attr('data-id'),
                dataType: 'json',
                timeout: 30000,
                success: function(response) {

                    if (response.hasOwnProperty('html')) {

                        $("div.items-list-view").append(response.html);
                    }

                    if (response.hasOwnProperty('items_count')) {

                        if (response.items_count < 20) {

                            $('div.loading-more-container').addClass('hidden');
                        }
                    }

                    if (response.hasOwnProperty('itemId')) {

                        $this.attr('data-id', response.itemId)
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

        $(document).on("click", "a.unblock-button", function() {

            var $dialog = $('#profile-unblock-dlg');

            $dialog.find('input[name=profileId]').val($(this).attr('data-user-id'));
            $dialog.find('input[name=itemId]').val($(this).attr('data-id'));

            $dialog.modal('show');
        });

    </script>

</body>
</html>
