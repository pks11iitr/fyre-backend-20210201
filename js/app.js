$(document).ready(function() {

	// Tooltip plugin

	$('body').tooltip({

		selector: '[rel=tooltip]'
	});

	$(document).on("click", "button.close-message-button", function() {

		$("div.header-message").addClass("hidden");

		return false;
	});

	$(document).on("click", "button.close-privacy-message", function() {

		$("div.header-message").addClass("hidden");

		$.cookie("privacy", "close", { expires : 7, path: '/' });

		return false;
	});

	$(document).on('click', '.btn-toggle-sidebar', function(event) {

		var $sidebar = $('.sidebar-menu');

		$sidebar.toggleClass('d-none');
		$('.sidebar-menu-line').toggleClass('hidden');

		if ($sidebar.hasClass('d-none')) {

			$(this).find('.fa').removeClass($(this).attr('data-icon-hide')).addClass($(this).attr('data-icon-show'));

		} else {

			$(this).find('.fa').removeClass($(this).attr('data-icon-show')).addClass($(this).attr('data-icon-hide'));
		}
	});

	$('div.dropdown-notifications').on('shown.bs.dropdown', function () {

		var $this = $(this);

		if (!$this.hasClass('first-open')) {

            // load notifications
            loadNotifications();

		} else {

			if (!$this.find('.notifications-badge').hasClass('hidden')) {

				// hide badge
				$this.find('.notifications-badge').addClass('hidden');

                // load notifications
				loadNotifications();
			}
		}

		return true;
	});

	function loadNotifications() {

		var $dropdown = $('div.dropdown-notifications');

		// hide content
		$dropdown.find('.dropdown-notifications-content').addClass('hidden');

		// show loader
		$dropdown.find('.dropdown-notifications-loader').removeClass('hidden');

		$dropdown.addClass('first-open');

		$.ajax( {
			type: "GET",
			url: "/account/notifications",
			data: "act=get",
			dataType: 'json',
			success: function(response) {

				if (response.hasOwnProperty('error')) {

					if (!response.error) {

						if (response.hasOwnProperty('html')) {

							// show notifications list
							$dropdown.find('.dropdown-notifications-list').removeClass('hidden');

							// add notifications items to list
							$dropdown.find('.dropdown-notifications-list').html(response.html);

							// hide message "no notifications"
							$dropdown.find('.dropdown-notifications-message').addClass('hidden');

						} else {

							// hide notifications list
							$dropdown.find('.dropdown-notifications-list').addClass('hidden');

							// show message "no notifications"
							$dropdown.find('.dropdown-notifications-message').removeClass('hidden');
						}
					}
				}

				// hide loader
				$dropdown.find('.dropdown-notifications-loader').addClass('hidden');
				// show notifications content
				$dropdown.find('.dropdown-notifications-content').removeClass('hidden');
			},
			error: function(xhr, status, error) {

				// hide loader
				$dropdown.find('.dropdown-notifications-loader').addClass('hidden');

				// show notifications content
				$dropdown.find('.dropdown-notifications-content').removeClass('hidden');
			}
		});
	}

	// For all pages

	$("form#new-report-form").submit(function(e) {

		var form = $('form#new-report-form');

		var reason = form.find("input[type=radio]:checked").val();

		if (typeof reason === 'undefined') {

			return false;
		}

		$.ajax( {
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {

				$('#new-report').modal('hide');
				form.find('input[type=radio]').prop('checked', false);
				form.find('textarea[name=description]').val('');
				form.find("button[type=submit]").attr('disabled', 'disabled');
			},
			error: function(xhr, status, error) {

				$('#new-report').modal('hide');
				form.find('input[type=radio]').prop('checked', false);
				form.find("button[type=submit]").attr('disabled', 'disabled');
			}
		});

		return false;
	});

	$("form#new-message-form").submit(function(e) {

		var form = $('form#new-message-form');
		var editor = form.find('textarea[name=messageText]');

		if (editor.val().trim().length == 0) {

			editor.focus();

			return false;
		}

		$.ajax( {
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {

				if (response.hasOwnProperty("newChat")) {

					if (!response.newChat) {

						chatUpdate(response.chatId, account.id, account.accessToken, form.find('textarea[name=messageText]').val(), "", response.msgId, 0, 0);
					}
				}

				$('#new-message').modal('hide');
				form.find('textarea[name=messageText]').val('');
			},
			error: function(xhr, status, error) {

				$('#new-message').modal('hide');
				form.find('textarea[name=messageText]').val('');
			}
		});

		return false;
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

	// Items page

	$(document).on("click", ".add-to-favorites-button", function() {

		var $this = $(this);

		if (!$this.hasClass('loading')) {

			$this.addClass('loading');
			$this.parent('div').find('.loader').removeClass('hidden');

			$.ajax( {
				type: "POST",
				url: '/api/v1/method/items.like',
				data: 'itemId=' + $(this).attr('data-id') + '&accountId=' + account.id + '&accessToken=' + account.accessToken,
				dataType: 'json',
				success: function(response) {

					$this.removeClass('loading');
					$this.parent('div').find('.loader').addClass('hidden');

					if ($this.hasClass('active')) {

						$this.removeClass('active').attr('data-original-title', strings.szFavoritesAddTooltip).find('i.far').removeClass('fa-star').addClass('fa-star');

					} else {

						$this.addClass('active').attr('data-original-title', strings.szFavoritesRemoveTooltip).find('i.far').removeClass('fa-star').addClass('fa-star');
					}
				},
				error: function(xhr, status, error) {

					$this.removeClass('loading');
					$this.parent('div').find('.loader').addClass('hidden');
				}
			});
		}

		return false;
	});

	// Items and Chat remove

	$("form#delete-item-form").submit(function(e) {

		var form = $('form#delete-item-form');

		$.ajax( {
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {

				$('#delete-item').modal('hide');

				if (options.pageId === 'chat') {

                    window.location.href = '/account/messages';

				} else {

                    $('div.inactive-card').remove();
					$('div.item-column-main').remove();
					$('div.my-message').removeClass('hidden');
				}
			},
			error: function(xhr, status, error) {

				$('#delete-item').modal('hide');
			}
		});

		return false;
	});

	// Profile page

	$("form#profile-block-form").submit(function(e) {

		var form = $('form#profile-block-form');

		$.ajax( {
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {

				if (response.hasOwnProperty('error')) {

					if (!response.error) {

						$('button.block-button').text(strings.szActionUnblock).attr('data-target', '#profile-unblock-dlg');
					}
				}

				$('#profile-block-dlg').modal('hide');
			},
			error: function(xhr, status, error) {

				$('#profile-block-dlg').modal('hide');
			}
		});

		return false;
	});

	$("form#profile-unblock-form").submit(function(e) {

		var form = $('form#profile-unblock-form');
		var $dialog = $('#profile-unblock-dlg');

		$.ajax( {
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: 'json',
			success: function(response) {

				if (response.hasOwnProperty('error')) {

					if (!response.error) {

						if ($dialog.find('input[name=itemId]').length > 0) {

							// For blacklist page (remove user row from list)

							$('div.user-item[data-id=' + $dialog.find('input[name=itemId]').val() + ']').remove();

							if ($('div.user-item').length == 0) {

								$('div.page-empty').removeClass('hidden');
							}

						} else {

							// For profile page (set correct button title)

							$('button.block-button').text(strings.szActionBlock).attr('data-target', '#profile-block-dlg');
						}
					}
				}

				$('#profile-unblock-dlg').modal('hide');
			},
			error: function(xhr, status, error) {

				$('#profile-unblock-dlg').modal('hide');
			}
		});

		return false;
	});
});