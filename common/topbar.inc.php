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

	?>
		<div class="header py-2">
			<div class="container">
				<div class="d-flex">

					<a class="header-brand" href="/">
						<img class="header-brand-img" src="/img/topbar_logo.png" alt="<?php echo APP_NAME; ?>" title="<?php echo APP_TITLE; ?>">
					</a>

				<?php

					if (isset($page_id) && $page_id !== "main" && $page_id !== "login" && $page_id !== "signup") {

						?>
							<form class="navbar-form navbar-left d-none d-md-block col-4 col-lg-4" action="/">

								<div class="form-group">
									<input type="text" class="form-control" placeholder="<?php echo $LANG['placeholder-search-query']; ?>" name="query">
									<button type="submit" class="btn btn-secondary">
										<span class="fa fa-search"></span>
									</button>
								</div>

							</form>
						<?php
					}
				?>

				<?php

					if (!auth::isSession()) {

                        ?>

                        <div class="d-flex align-items-center order-lg-2 ml-auto">

                            <?php

                                if (isset($page_id) && $page_id != "login") {

                                    ?>

                                        <a class="btn btn-outline-primary" href="/login"><?php echo $LANG['action-login']; ?></a>

                                    <?php

                                } else {

                                    ?>

                                        <a class="btn btn-outline-primary" href="/signup"><?php echo $LANG['action-signup']; ?></a>

                                    <?php
                                }
					        ?>

                                <div class="nav-item">
                                    <a href="/login?continue=/item/new" class="btn btn-add-item" title="<?php echo $LANG['action-new-classified']; ?>" rel="tooltip">
                                        <i class="fa fa-plus"></i>
                                        <span class="d-none d-sm-inline-block"><?php echo $LANG['action-new-classified']; ?></span>
                                    </a>
                                </div>

                        </div>

                        <?php

					} else {

						?>

							<div class="d-flex align-items-center order-lg-2 ml-auto">

                                <div class="d-none d-sm-block">

                                    <a class="nav-link py-2 icon position-relative" href="/account/favorites">
                                        <i class="fa fa-star"></i>
                                        <span class="nav-unread hidden favorites-badge"></span>
                                    </a>
                                </div>

                                <div class="d-none d-sm-block">

                                    <a class="nav-link py-2 icon position-relative" href="/account/messages">
                                        <i class="fa fa-envelope"></i>
                                        <span class="nav-unread hidden messages-badge"></span>
                                    </a>
                                </div>

								<?php

									if (isset($page_id) && $page_id != "notifications") {

										?>
											<div class="dropdown dropdown-notifications d-none d-sm-block">
												<a class="nav-link py-2 icon dropdown-notifications-button" data-toggle="dropdown" href="/account/notifications">
													<i class="fa fa-bell"></i>
													<span class="nav-unread hidden notifications-badge"></span>
												</a>
												<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow dropdown-menu-notifications" style="right: 0; left: auto;">
													<div class="text-center p-5 dropdown-notifications-loader hidden">
														<div class="loader d-inline"><i class="fa fa-spin fa-spin"></i></div>
													</div>
													<div class="dropdown-notifications-content">
														<div class="dropdown-notifications-list"></div>
														<div class="text-muted text-center py-2 dropdown-notifications-message"><?php echo $LANG['page-notifications-empty-list']; ?></div>
														<div class="dropdown-divider"></div>
														<a href="/account/notifications" class="dropdown-notifications-link dropdown-item text-center text-muted-dark"><?php echo $LANG['action-see-all']; ?></a>
													</div>
												</div>
											</div>
										<?php
									}
								?>

								<?php

									if (isset($page_id) && $page_id != "new_item") {

										?>
											<div class="nav-item d-sm-block">
												<a href="/item/new" class="btn btn-add-item btn-sm" title="<?php echo $LANG['action-new-classified']; ?>" rel="tooltip">
													<i class="fa fa-plus"></i>
													<span class="new-item d-none d-sm-inline-block"><?php echo $LANG['action-new-classified']; ?></span>
												</a>
											</div>
										<?php
									}
								?>

								<div class="dropdown">
									<a href="/<?php echo auth::getCurrentUserUsername(); ?>" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar" style="background-image: url(<?php echo auth::getCurrentUserPhotoUrl(); ?>); background-position: center; background-size: cover;"></span>
										<span class="ml-2 d-none d-lg-block profile-menu-nav-link">
											<span class="text-default"><?php echo auth::getCurrentUserFullname(); ?></span>
											<small class="text-muted d-block mt-1"><?php echo auth::getCurrentUserUsername(); ?></small>
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="/<?php echo auth::getCurrentUserUsername(); ?>"><i class="dropdown-icon fa fa-user-alt"></i><?php echo $LANG['topbar-profile']; ?></a>
                                        <a class="dropdown-item d-block d-md-none" href="/account/favorites">
											<span class="float-right">
												<span class="badge badge-primary favorites-badge favorites-primary-badge hidden">0</span>
											</span>
                                            <i class="dropdown-icon fa fa-star"></i><?php echo $LANG['topbar-favorites']; ?>
                                        </a>
                                        <a class="dropdown-item d-block d-md-none" href="/account/messages">
											<span class="float-right">
												<span class="badge badge-primary messages-badge messages-primary-badge hidden">0</span>
											</span>
                                            <i class="dropdown-icon fa fa-envelope"></i><?php echo $LANG['topbar-messages']; ?>
                                        </a>
										<a class="dropdown-item d-block d-md-none" href="/account/notifications">
											<span class="float-right">
												<span class="badge badge-primary notifications-badge notifications-primary-badge hidden">0</span>
											</span>
											<i class="dropdown-icon fa fa-bell"></i><?php echo $LANG['topbar-notifications']; ?>
										</a>
										<a class="dropdown-item" href="/account/settings"><i class="dropdown-icon fa fa-cog"></i><?php echo $LANG['topbar-settings']; ?></a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="/support"><i class="dropdown-icon fa fa-question-circle"></i><?php echo $LANG['label-topbar-help']; ?></a>
										<a class="dropdown-item" href="/account/logout?access_token=<?php echo auth::getAccessToken(); ?>&continue=/"><i class="dropdown-icon fa fa-sign-out-alt"></i><?php echo $LANG['topbar-logout']; ?></a>
									</div>
								</div>

							</div>

						<?php
					}
				?>
				</div>
			</div>
		</div>


    <?php

        if (!isset($_COOKIE['privacy'])) {

            if (isset($page_id) && $page_id !== 'signup' && $page_id !== 'login' && $page_id !== 'privacy' && $page_id !== 'cookie' && $page_id !== 'terms') {

                ?>
                    <div class="header header-message" id="cookie-message">
                        <div class="container">
                            <div class="d-flex">
                                <span class="mb-0 w-100 header-text-message">
                                    <?php echo $LANG['label-cookie-message']; ?> <a href="/terms"><?php echo $LANG['label-terms-link']; ?></a>, <a href="/privacy"><?php echo $LANG['label-terms-privacy-link']; ?></a> <?php echo $LANG['label-terms-and']; ?> <a href="/cookie"><?php echo $LANG['label-terms-cookies-link']; ?></a>
                                </span>
                                <div class="d-flex align-items-center order-lg-2 ml-auto">
                                    <div class="nav-item d-sm-block">
                                        <button class="close close-message-button close-privacy-message" title="<?php echo $LANG['action-close']; ?>" rel="tooltip"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }
        }
    ?>