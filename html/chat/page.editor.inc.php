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

	$chat_id = helper::clearInt($request[1]); // Get chat id

	$msg = new msg($dbo);
	$msg->setRequestFrom(auth::getCurrentUserId());

	$chatInfo = $msg->chatInfo($chat_id);

	if (!$chatInfo['error'] && $chatInfo['removeAt'] == 0 && ($chatInfo['toUserId'] == auth::getCurrentUserId() || $chatInfo['fromUserId'] == auth::getCurrentUserId())) {

		$with_user = array(
			'id' => $chatInfo['withUserId'],
			'verified' => $chatInfo['withUserVerified'],
			'online' => $chatInfo['withUserOnline'],
			'state' => $chatInfo['withUserState'],
			'username' => $chatInfo['withUserUsername'],
			'fullname' => $chatInfo['withUserFullname'],
			'lowPhotoUrl' => $chatInfo['withUserPhotoUrl']);

		$my_info = array(
			'id' => auth::getCurrentUserId(),
			'verified' => auth::getCurrentUserVerified(),
			'online' => true,
			'state' => ACCOUNT_STATE_ENABLED,
			'username' => auth::getCurrentUserUsername(),
			'fullname' => auth::getCurrentUserFullname(),
			'lowPhotoUrl' => auth::getCurrentUserPhotoUrl());

	} else {

		header("Location: /account/messages");
		exit;
	}

	$messenger = new messenger($dbo);
	$messenger->setRequestFrom(auth::getCurrentUserId());
	$messenger->setLanguage($LANG['lang-code']);
	$messenger->setChatId($chat_id);

	$pageId = 1;


	if (!empty($_POST)) {

		//sleep(1);

		$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;
        $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : 0;

        $act = isset($_POST['act']) ? $_POST['act'] : '';

		$pageId = helper::clearInt($pageId);
        $itemId = helper::clearInt($itemId);

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        switch ($act) {

            case "newMessages": {

                $result = $messenger->getNewItems($itemId);

                $result['items_count'] = count($result['items']);

                if (count($result['items']) != 0) {

                    ob_start();

                    foreach (array_reverse($result['items']) as $key => $item) {

                        if ($item['fromUserId'] == auth::getCurrentUserId()) {

                            draw::messageItem($item, $my_info, $LANG);

                        } else {

                            draw::messageInboxItem($item, $with_user, $LANG);
                        }
                    }

                    $result['html'] = ob_get_clean();
                }

                break;
            }

            case "loadMore": {

                $result = $messenger->getItems($pageId);

                $result['items_count'] = count($result['items']);

                if (count($result['items']) != 0) {

                    ob_start();

                    foreach (array_reverse($result['items']) as $key => $item) {

                        if ($item['fromUserId'] == auth::getCurrentUserId()) {

                            draw::messageItem($item, $my_info, $LANG);

                        } else {

                            draw::messageInboxItem($item, $with_user, $LANG);
                        }
                    }

                    $result['html'] = ob_get_clean();
                }

                break;
            }

            default:

                break;
        }

		echo json_encode($result);
		exit;
	}

	$page_id = "chat";

	$css_files = array("blueimp-gallery.min.css");
	$page_title = $LANG['page-chat']." | ".APP_TITLE;

	include_once("common/header.inc.php");

?>

<body class="body-messages">

	<div class="page page-fill-wrapper d-flex min-h-100">
		<div class="page-fill d-flex flex-fill flex-column align-items-stretch">

			<?php

				include_once("common/topbar.inc.php");
			?>

			<!-- End topbar -->

			<div class="content d-flex flex-column col-12 mx-auto p-0" style="flex: 1; ">
				<div class="container d-flex flex-row" style=" flex: 1;">

					<div class="card card-messages my-0 my-sm-3 my-md-5">

						<div class="col-md-12 col-lg-12 col-messages-conversation p-0 h-100">
							<div class="messages-conversation d-flex flex-column">

								<div class="conversation-header bg-blue-lightest pl-5 pt-3 pb-3 pr-3">
									<div class="row align-items-center justify-content-sm-start h-100">

										<div class="col-8 col-sm-9 col-md-9 col-lg-9 pl-0">
                                            <a class="avatar float-left mr-2" style="background-image: url('<?php if (strlen($with_user['lowPhotoUrl']) != 0) { echo $with_user['lowPhotoUrl']; } else { echo "/img/profile_default_photo.png"; } ?>');" href="/<?php echo $with_user['username']; ?>">
                                                <span class="avatar-status bg-green <?php if (!$with_user['online']) echo 'hidden'; ?>"></span>
                                            </a>
											<div class="chat-title">
												<a href="/<?php echo $with_user['username']; ?>">
													<strong><?php echo $with_user['fullname']; ?></strong>
												</a>
												<div class="d-inline-block verified user-verified-badge <?php if ($with_user['verified'] == 0) echo 'hidden'; ?>" rel="tooltip" title="<?php echo $LANG['label-account-verified']; ?>">
													<i class="fa fa-check"></i>
												</div>
											</div>

											<?php

												if ($chatInfo['toItemId'] != 0) {

													?>
														<div class="chat-sub-title">
															<a href="/item/<?php echo $chatInfo['toItemId']; ?>"><i class="fa fa-hashtag"></i> <?php echo $chatInfo['itemTitle']; ?></a>
														</div>
													<?php
												}
											?>
										</div>

										<div class="col-4 col-sm-3 col-md-3 col-lg-3 text-right">

											<div class="dropdown">
												<a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="fa fa-ellipsis-h"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(47px, 27px, 0px);">
													<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#new-report">
                                                        <?php echo $LANG['action-report']; ?>
													</a>
													<a class="dropdown-item delete-conversation" href="javascript:void(0)" data-toggle="modal" data-target="#delete-item">
                                                        <?php echo $LANG['action-remove']; ?>
													</a>
												</div>
											</div>
										</div>

									</div>
								</div>

								<div class="conversation-items d-flex">
									<div class="wrapper-items w-100">

										<?php

											$result = $messenger->getItems(0);
										?>

										<div class="items p-5 messages-list-view <?php if (count($result['items']) >= 20) echo 'load-more'; ?>">

										<?php

											if (count($result['items']) > 0) {

												foreach (array_reverse($result['items']) as $key => $item) {

													if ($item['fromUserId'] == auth::getCurrentUserId()) {

														draw::messageItem($item, $my_info, $LANG);

													} else {

														draw::messageInboxItem($item, $with_user, $LANG);
													}
												}
											}
										?>

										</div>
									</div>
								</div>

								<div class="chat-image-progress hidden">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>

								<div class="conversation-input py-3 px-3">

									<div class="input-group">

										<input maxlength="512" type="text" class="form-control message-input" placeholder="<?php echo $LANG['dlg-message-placeholder']; ?>">

                                        <div class="input-group-append">
                                            <div class="btn btn-secondary chat-image-upload-button">
                                                <input type="file" id="photo-upload" name="uploaded_file" class="">
                                                <i class="fa fa-camera"></i>
                                            </div>
                                        </div>

                                        <div class="input-group-append">

                                            <div class="dropdown emoji-dropdown dropup" style="">

                                                <div class="btn btn-secondary btn-emoji-picker" data-toggle="dropdown">
                                                    <i class="btn-emoji-picker far fa-smile"></i>
                                                </div>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <div class="emoji-items">
                                                        <div class="emoji-item">😀</div>
                                                        <div class="emoji-item">😁</div>
                                                        <div class="emoji-item">😂</div>
                                                        <div class="emoji-item">😃</div>
                                                        <div class="emoji-item">😄</div>
                                                        <div class="emoji-item">😅</div>
                                                        <div class="emoji-item">😆</div>
                                                        <div class="emoji-item">😉</div>
                                                        <div class="emoji-item">😊</div>
                                                        <div class="emoji-item">😋</div>
                                                        <div class="emoji-item">😎</div>
                                                        <div class="emoji-item">😍</div>
                                                        <div class="emoji-item">😘</div>
                                                        <div class="emoji-item">🤗</div>
                                                        <div class="emoji-item">🤩</div>
                                                        <div class="emoji-item">🤔</div>
                                                        <div class="emoji-item">🤨</div>
                                                        <div class="emoji-item">😐</div>
                                                        <div class="emoji-item">🙄</div>
                                                        <div class="emoji-item">😏</div>
                                                        <div class="emoji-item">😣</div>
                                                        <div class="emoji-item">😥</div>
                                                        <div class="emoji-item">😮</div>
                                                        <div class="emoji-item">🤐</div>
                                                        <div class="emoji-item">😯</div>
                                                        <div class="emoji-item">😪</div>
                                                        <div class="emoji-item">😫</div>
                                                        <div class="emoji-item">😴</div>
                                                        <div class="emoji-item">😌</div>
                                                        <div class="emoji-item">😜</div>
                                                        <div class="emoji-item">🤤</div>
                                                        <div class="emoji-item">😓</div>
                                                        <div class="emoji-item">😔</div>
                                                        <div class="emoji-item">🤑</div>
                                                        <div class="emoji-item">😲</div>
                                                        <div class="emoji-item">🙁</div>
                                                        <div class="emoji-item">😖</div>
                                                        <div class="emoji-item">😞</div>
                                                        <div class="emoji-item">😟</div>
                                                        <div class="emoji-item">😤</div>
                                                        <div class="emoji-item">😢</div>
                                                        <div class="emoji-item">😭</div>
                                                        <div class="emoji-item">😦</div>
                                                        <div class="emoji-item">😧</div>
                                                        <div class="emoji-item">😨</div>
                                                        <div class="emoji-item">😩</div>
                                                        <div class="emoji-item">😰</div>
                                                        <div class="emoji-item">😱</div>
                                                        <div class="emoji-item">😳</div>
                                                        <div class="emoji-item">🤪</div>
                                                        <div class="emoji-item">😵</div>
                                                        <div class="emoji-item">😡</div>
                                                        <div class="emoji-item">😠</div>
                                                        <div class="emoji-item">🤬</div>
                                                        <div class="emoji-item">😷</div>
                                                        <div class="emoji-item">🤒</div>
                                                        <div class="emoji-item">🤕</div>
                                                        <div class="emoji-item">🤢</div>
                                                        <div class="emoji-item">🤮</div>
                                                        <div class="emoji-item">🤧</div>
                                                        <div class="emoji-item">😇</div>
                                                        <div class="emoji-item">🤠</div>
                                                        <div class="emoji-item">🤡</div>
                                                        <div class="emoji-item">🤥</div>
                                                        <div class="emoji-item">🤫</div>
                                                        <div class="emoji-item">🤭</div>
                                                        <div class="emoji-item">🧐</div>
                                                        <div class="emoji-item">🤓</div>
                                                        <div class="emoji-item">😈</div>
                                                        <div class="emoji-item">👿</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="input-group-append">
                                            <button id="btn-message-send" type="button" class="btn btn-secondary btn-message-send" disabled="disabled">
                                                <i class="fa fa-paper-plane"></i>
                                                <?php  echo $LANG['action-send']; ?>
                                            </button>
                                        </div>



									</div>

								</div>

							</div>

							<div class="conversation-banned-contact d-flex justify-content-center align-items-center h-100 hidden" style="min-height: 200px">
							</div>

						</div>

					</div> <!-- End messages card -->

				</div>

		    </div> <!-- End page main-->

            <div class="modal modal-form fade profile-report" id="new-report" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="new-report-form" action="/api/v1/method/profile.report" method="post">

                            <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                            <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                            <input type="hidden" name="profileId" value="<?php echo $with_user['id']; ?>">

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

            <div class="modal modal-form fade" id="delete-item" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="delete-item-form" action="/api/v1/method/chat.remove" method="post">

                            <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                            <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                            <input type="hidden" name="profileId" value="<?php echo $with_user['id']; ?>">

                            <input type="hidden" name="chatId" value="<?php echo $chatInfo['id']; ?>">
                            <input type="hidden" name="adItemId" value="<?php echo $chatInfo['toItemId']; ?>">

                            <div class="modal-header">
                                <h5 class="modal-title placeholder-title"><?php echo $LANG['dlg-confirm-action-title']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="error-summary alert alert-warning"><?php echo $LANG['msg-confirm-delete']; ?></div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $LANG['action-no']; ?></button>
                                <button type="submit" class="btn btn-primary"><?php echo $LANG['action-yes']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

			<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls " style="display: none;">
				<div class="slides" style="width: 6400px;"></div>
				<h3 class="title"></h3>
				<a class="prev text-light">‹</a>
				<a class="next text-light">›</a>
				<a class="close text-light"></a>
				<a class="play-pause"></a>
				<ol class="indicator"></ol>
			</div>


		<?php

			include_once("common/footer.inc.php");
		?>

        </div>

	</div> <!-- End page -->

	<script src="/js/blueimp-gallery.min.js"></script>
	<script src="/js/load-image.all.min.js"></script>
	<script src="/js/jquery.ui.widget.js"></script>
	<script src="/js/jquery.iframe-transport.js"></script>
	<script src="/js/jquery.fileupload.js"></script>
	<script src="/js/jquery.fileupload-process.js"></script>
	<script src="/js/jquery.fileupload-image.js"></script>
	<script src="/js/jquery.fileupload-validate.js"></script>


		<script type="text/javascript">

			var FILE_PHOTO_MAX_SIZE = <?php echo FILE_PHOTO_MAX_SIZE; ?>;

			var pageId = <?php echo $pageId; ?>;

			var chatId = <?php echo $chat_id; ?>;
			var chatFromUserId = <?php echo $chatInfo['fromUserId']; ?>;
			var chatToUserId = <?php echo $chatInfo['toUserId']; ?>;
			var fromUserId_lastView = <?php echo $chatInfo['fromUserId_lastView']; ?>;
			var toUserId_lastView = <?php echo $chatInfo['toUserId_lastView']; ?>;
			var profileId = <?php echo $with_user['id']; ?>;

			var chat = {

				loaded: false,
				modified: false,
				last_loaded_message_id: 0,
				last_loaded_message_create_at: 0
			};

            chat.hTimer = 0;
            chat.time_ms = 4000; // 4 seconds

            chat.init = function() {

                if (chat.hTimer) clearTimeout(chat.hTimer);

                getNewMessages();
            };

			var strings = {

				szJustNow: "<?php echo $LANG['label-just-now']; ?>",
				szFileSizeError: "<?php echo $LANG['msg-photo-file-size-error']; ?>"
			};

			var $infobox = $('#info-box');

			var $uploadProgressBar = $('div.chat-image-progress');
			var $uploadButton = $('div.chat-image-upload-button');
			var $photoUpload = $('#photo-upload');

			var $sendButton = $('button.btn-message-send');
			var $editor = $('input[type=text].message-input');
			var $itemsWrapper = $('div.wrapper-items');
			var $listView = $('div.messages-list-view');
			var $messagesLoader = $('div.messages-loader');

			$(window).on('load', function () {

				$itemsWrapper.animate({scrollTop: $itemsWrapper[0].scrollHeight}, 200, function() {

					chat.loaded = true;

					chat.last_loaded_message_id = $listView.find('div.message-item').not(".tmp").last().attr('data-id');
					chat.last_loaded_message_create_at = $listView.find('div.message-item').not(".tmp").last().attr('data-create-at');

					var last_chat_view = 0;

					if (account.id == chatFromUserId) {

						last_chat_view = fromUserId_lastView;

					} else {

						last_chat_view = toUserId_lastView;
					}

					if (last_chat_view != 0 && last_chat_view < chat.last_loaded_message_create_at) {

						// Need update chat if exists (unread) messages

						chatUpdate(chatId, account.id, account.accessToken, "", "", 0, chatFromUserId, chatToUserId);
					}
				});
			});

			function showEmojiPicker() {

				var $picker = $('div.popover-emoji');

				$picker.css('right', $('.btn-message-send').outerWidth() - 25);

				$picker.addClass('show');
				$picker.removeClass('hidden');
			}

			function hideEmojiPicker() {

				var $picker = $('div.popover-emoji');

				$picker.addClass('hidden');
				$picker.removeClass('show');
			}

			function toggleEmojiPicker() {

				var $picker = $('div.popover-emoji');

				if ($picker.hasClass('show')) {

					hideEmojiPicker();

				} else {

					showEmojiPicker();
				}
			}

			// send message to server

			function sendMessage(imageUrl = "") {

				var messageText = "";

				var textHtml = "";
				var imageHtml = "";

				if (imageUrl.length == 0) {

					// if send only text message

					messageText = $('<div>').text($.trim($editor.val())).html();

					textHtml = "<span class=\"d-block message-item-text\">" + messageText + "</span>";

					$editor.val('');
					$sendButton.attr('disabled', 'disabled');
					hideEmojiPicker();

				} else {

					// if send only image

					imageHtml = "<img class=\"message-item-image\" src=\"" + imageUrl + "\">";
				}

				$listView.append("<div class=\"message-item tmp\">" +
					"<div class=\"date hidden\"></div>" +
					"<div class=\"item read\">" +
						"<div class=\"item-body d-flex flex-row align-items-end flex-row-reverse\">" +
							"<span class=\"avatar\" style=\"background-image: url(\'" + account.photoUrl + "\')\"></span>" +
							"<span class=\"text bg-azure text-white p-2 rounded\">" +
								textHtml +
								imageHtml +
							"</span>" +
							"<small class=\"time text-gray message-item-time hidden\">" + strings.szJustNow + "</small>" +
							"<span class=\"spinner\"><i class=\"fa fa-spinner fa-spin\"></i></span>" +
						"</div>" +
					"</div>" +
					"</div>");

				var last_element_index = $(".message-item").last().index();
				var $item = $('.message-item').eq(last_element_index);

				$itemsWrapper.animate({

					scrollTop: $itemsWrapper[0].scrollHeight

				}, 1000);

				$.ajax({
					type: 'POST',
					url: App.api_path + "msg.new",
					data: "accountId=" + account.id + "&accessToken=" + account.accessToken + "&chatId=" + chatId + "&profileId=" + profileId + "&chatToUserId=" + chatToUserId + "&chatFromUserId=" + chatFromUserId + "&messageText=" + encodeURIComponent(messageText) + "&messageImg=" + imageUrl,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

						if (response.hasOwnProperty('error')) {

							if (!response.error) {

								chat.modified = true;

								$item.attr('data-id', response.msgId).removeClass('tmp').find('.item').addClass('sent').find('.spinner').addClass('hidden');
								$item.find('.message-item-time').removeClass('hidden');

							} else {

								$item.find('.spinner').addClass('hidden');
								$item.find('.message-item-time').removeClass('hidden').html('<i style=\"color: red\" title=\"error\" rel=\"tooltip\" class=\"ic icon-alert-circle\"></i>');
							}
						}
					},
					error: function(xhr, status, error) {

						$item.find('.spinner').addClass('hidden');
						$item.find('.message-item-time').removeClass('hidden').html('<i style=\"color: red\" title=\"error\" rel=\"tooltip\" class=\"ic icon-alert-circle\"></i>');
					}
				});
			}

            $(document).on('click', '.emoji-items', function() {

                return false;
            });

			$(document).on('click', '.emoji-item', function() {

				$editor.val($editor.val() + $(this).text());

				$editor.change();
				$editor.focus();

				return false;
			});

			$(document).on('click', '.btn-message-send', function() {

				sendMessage();
			});

			$editor.on('change paste keyup', function(e) {

				if ($.trim($editor.val()).length != 0) {

					$sendButton.removeAttr('disabled');

				} else {

					$sendButton.attr('disabled', 'disabled');
				}
			});

			$editor.on("keypress", function(e) {

				if (e.which === 13) {

					if ($.trim($editor.val()).length != 0) {

						sendMessage();
					}
				}
			});

			$(window).on('beforeunload', function () {

				var message = '';
				var image = '';

				var last_current_message_id = $listView.find('div.message-item').not(".tmp").last().attr('data-id');

				if (chat.last_loaded_message_id != last_current_message_id) {

					// Chat has bee modified

					message = $listView.find('.message-item').not(".tmp").last().find('.message-item-text').text();
					image = $listView.find('.message-item').not(".tmp").last().find('.message-item-image').attr('src');

					chatUpdate(chatId, account.id, account.accessToken, message, image, last_current_message_id, chatFromUserId, chatToUserId);
				}
			});

			function chatUpdate(chat_id, account_id, access_token, message, image, message_id, chatFromUserId, chatToUserId) {

				$.ajax({
					type: 'POST',
					url: App.api_path + "chat.update",
					data: 'chatId=' + chat_id + "&accountId=" + account_id + "&accessToken=" + access_token + "&chatFromUserId=" + chatFromUserId + "&chatToUserId=" + chatToUserId + "&message=" + encodeURIComponent(message) + "&image=" + image + "&message_id=" + message_id,
					dataType: 'json',
					timeout: 30000,
					success: function(response) {

					},
					error: function(xhr, status, error) {

					}
				});
			}

            function getNewMessages() {

                var itemId = $listView.find('div.message-item').not(".tmp").last().attr('data-id');

				if (!chat.loaded) {

					chat.hTimer = setTimeout(function() {

						chat.init();

					}, chat.time_ms);

					return false;
				}

                $.ajax({
                    type: 'POST',
                    url: "/chat/" + chatId,
                    data: 'itemId=' + itemId + "&act=newMessages",
                    dataType: 'json',
                    timeout: 30000,
                    success: function(response) {

                        if (response.hasOwnProperty('html')) {

                            var $current_list_view_height = $listView.outerHeight();

                            var $current_scroll_position = $itemsWrapper.scrollTop();

                            $("div.messages-list-view").append(response.html);

//                            var $new_list_view_height = $listView.outerHeight();

//                            $itemsWrapper.scrollTop($new_list_view_height - $current_list_view_height);
                        }
                    },
                    error: function(xhr, status, error) {

                        // silent error ;)
                    },
                    complete: function() {

                        // add 2 seconds to next update
                        chat.time_ms = App.time_ms + 2000;

                        chat.hTimer = setTimeout(function() {

                            chat.init();

                        }, chat.time_ms);
                    }
                });
            }

			$itemsWrapper.on('scroll', function() {

				if ($itemsWrapper.scrollTop() < 10 && $listView.hasClass('load-more') && chat.loaded) {

					$listView.removeClass('load-more');
					$messagesLoader.removeClass('hidden');

					$.ajax({
						type: 'POST',
						url: "/chat/" + chatId,
						data: 'pageId=' + pageId + "&act=loadMore",
						dataType: 'json',
						timeout: 30000,
						success: function(response) {

							$messagesLoader.addClass('hidden');

							if (response.hasOwnProperty('html')) {

								var $current_list_view_height = $listView.outerHeight();

								var $current_scroll_position = $itemsWrapper.scrollTop();

								$("div.messages-list-view").prepend(response.html);

								var $new_list_view_height = $listView.outerHeight();

								$itemsWrapper.scrollTop($new_list_view_height - $current_list_view_height);
							}

							if (response.hasOwnProperty('items_count')) {

								if (response.items_count < 20) {

									$listView.removeClass('load-more');

								} else {

									$listView.addClass('load-more');
									pageId++;
								}
							}
						},
						error: function(xhr, status, error) {

							$listView.addClass('load-more');
							$messagesLoader.addClass('hidden');
						}
					});
				}

				return false;
			});

			// Send image

			$photoUpload.fileupload({
				formData: {accountId: account.id, accessToken: account.accessToken},
				name: 'images',
				url: App.api_path + "msg.uploadImg",
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

					$uploadProgressBar.removeClass('hidden');
					$uploadButton.addClass('disabled');
					$('#photo-upload').addClass('hidden');

					$photoUpload.trigger('start');
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

					$uploadProgressBar.find('.progress-bar').attr('aria-valuenow', progress).css('width', progress + '%');
				},
				done: function (e, data) {

					console.log("done");

					var result = jQuery.parseJSON(data.jqXHR.responseText);

					if (result.hasOwnProperty('error')) {

						if (result.error === false) {

							if (result.hasOwnProperty('imgUrl')) {

								sendMessage(result.imgUrl);
							}

						} else {

							$infobox.find('#info-box-message').text(result.error_description);
							$infobox.modal('show');
						}
					}

					$photoUpload.trigger('done');
				},
				fail: function (e, data) {

					console.log(data.errorThrown);
				},
				always: function (e, data) {

					console.log("always");

					$uploadButton.removeClass('disabled');
					$uploadProgressBar.addClass('hidden');
					$('#photo-upload').removeClass('hidden');

					$photoUpload.trigger('always');
				}
			});

            // For report dialog

            $(document).on("click", "input[name=reason]", function() {

                var form = $('#new-report-form');

                form.find("button[type=submit]").removeAttr('disabled');
            });

			$(document).on("click", ".message-item-image", function() {

				var options = {container: '#blueimp-gallery', urlProperty: 'src'};

				blueimp.Gallery($(this), options);
			});

            // Initialize timer

            chat.init();

		</script>

</body>
</html>