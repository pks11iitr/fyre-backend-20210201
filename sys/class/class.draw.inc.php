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

class draw extends db_connect
{
	private $LANG = array();
	private $LANG_CURRENCY_ARRAY = array();

	public function __construct($dbo = NULL, $LANG = array())
	{
		parent::__construct($dbo);

		$this->LANG = $LANG;
	}

	static function item($item, $CURRENCY_ARRAY, $LANG, $css_style = "col-6 col-sm-6 col-md-4 col-lg-3")
	{
		?>

		<div class="<?php echo $css_style; ?> list-view-item grid-item" data-id="<?php echo $item['id']; ?>">
			<div class="card" data-id="<?php echo $item['id']; ?>">
				<a href="/classified/<?php echo $item['itemUrl']; ?>" class="item-image">
					<div class="card-img-top-wrapper d-flex justify-content-center">
						<div class="loader"><i class="ic icon-spin icon-spin"></i></div>
						<div class="card-img-top" style="background-image: url(<?php echo $item['previewImgUrl']; ?>);"></div>
					</div>

					<?php

						if ($item['inactiveAt'] != 0) {

							?>
							<div class="item-status inactive">
								<i class="fa fa-exclamation-circle pl-1"></i>
								<?php echo $LANG['label-item-inactive']; ?>
							</div>
							<?php
						}
					?>

					<div style="<?php if ($item['imagesCount'] == 0) echo 'display: none' ?>" class="item-images-count"><?php echo $item['imagesCount']; ?>
						<i class="fa fa-camera pl-1"></i>
					</div>
				</a>
				<div class="card-body d-flex flex-column">
					<h4 class="d-flex justify-content-start align-items-center">
						<a href="/classified/<?php echo $item['itemUrl']; ?>" class="w-100 grid-title">
							<span class="display-name" title="<?php echo $item['itemTitle']; ?>"><?php echo $item['itemTitle']; ?></span>
						</a>
					</h4>
					<div class="grid-location">
						<?php

						if (strlen($item['location']) > 0) {

							?>
							<h5><i class="fa fa-map-marker"></i> <?php echo $item['location']; ?></h5>
							<?php
						}
						?>
					</div>
					<div class="grid-currency">
						<h4 class="mb-0"><?php echo draw::generatePrice($item['currency'], $item['price'], $CURRENCY_ARRAY, $LANG); ?></h4>
					</div>

				</div>
			</div>
		</div>


		<?php
	}

	static function dropdownNotificationItem($item, $LANG)
	{
		?>

		<div class="dropdown-item d-flex dropdown-notification-item" data-id="<?php echo $item['id']; ?>">

            <?php

                if ($item['fromUserId'] != 0) {

                    ?>
                    <a href="/<?php echo $item['fromUserUsername']; ?>">
                        <span class="avatar mr-3 mt-1 align-self-center" style="background-image: url('<?php echo $item['fromUserPhotoUrl']; ?>')"></span>
                    </a>
                    <?php

                } else {

                    ?>
                    <span>
                        <span class="avatar mr-3 mt-1 align-self-center" style="background-image: url('<?php echo $item['fromUserPhotoUrl']; ?>')"></span>
                    </span>
                    <?php
                }
            ?>

			<div class="dropdown-notification-content">

				<?php

					switch ($item['itemType']) {

						case NOTIFY_TYPE_COMMENT: {

                            ?>
                                <strong><a href="/<?php echo $item['fromUserUsername']; ?>"><?php echo $item['fromUserFullname']; ?></a></strong>
                            <?php

							echo $LANG['notify-comment'];

							break;
						}

						case NOTIFY_TYPE_COMMENT_REPLY: {

                            ?>
                                <strong><a href="/<?php echo $item['fromUserUsername']; ?>"><?php echo $item['fromUserFullname']; ?></a></strong>
                            <?php

							echo $LANG['notify-comment-reply'];

							break;
						}

                        case NOTIFY_TYPE_ITEM_APPROVED: {

                            echo sprintf($LANG['label-notify-item-approved'], "<a href=\"/item/{$item['itemId']}\"><strong>".$LANG['label-notify-item']."</strong></a>");

                            break;
                        }

                        case NOTIFY_TYPE_ITEM_REJECTED: {

                            echo sprintf($LANG['label-notify-item-rejected'], "<a href=\"/item/{$item['itemId']}\"><strong>".$LANG['label-notify-item']."</strong></a>");

                            break;
                        }

                        case NOTIFY_TYPE_PROFILE_PHOTO_REJECT: {

                            echo $LANG['label-notify-profile-photo-rejected'];

                            break;
                        }

                        case NOTIFY_TYPE_PROFILE_COVER_REJECT: {

                            echo $LANG['label-notify-profile-cover-rejected'];

                            break;
                        }

						default: {

							echo 'undefined';

							break;
						}
					}
				?>

				<div class="small text-muted"><?php echo $item['timeAgo']; ?></div>
			</div>
		</div>

		<?php
	}

	static function notificationItem($item, $LANG, $css_new = false)
	{
		?>

		<div class="list-item" data-id="<?php echo $item['id']; ?>">
			<div class="notification-item d-flex mt-2 <?php if ($css_new) echo 'new'; ?>">

                <?php

                if ($item['fromUserId'] != 0) {

                    ?>
                    <a href="/<?php echo $item['fromUserUsername']; ?>">
                        <div class="avatar mr-3 mt-1 align-self-center" style="background-image: url('<?php echo $item['fromUserPhotoUrl']; ?>')"></div>
                    </a>
                    <?php

                } else {

                    ?>
					<a href="javascript:void(0)">
                        <div class="avatar mr-3 mt-1 align-self-center" style="background-image: url('<?php echo $item['fromUserPhotoUrl']; ?>')"></div>
					</a>
                    <?php
                }
                ?>

				<div>
					<?php

					switch ($item['itemType']) {

						case NOTIFY_TYPE_COMMENT: {

                            ?>
                                <strong><a href="/<?php echo $item['fromUserUsername']; ?>"><?php echo $item['fromUserFullname']; ?></a></strong>
                            <?php

							echo $LANG['notify-comment'];

							break;
						}

						case NOTIFY_TYPE_COMMENT_REPLY: {

                            ?>
                                <strong><a href="/<?php echo $item['fromUserUsername']; ?>"><?php echo $item['fromUserFullname']; ?></a></strong>
                            <?php

							echo $LANG['notify-comment-reply'];

							break;
						}

                        case NOTIFY_TYPE_ITEM_APPROVED: {

                            echo sprintf($LANG['label-notify-item-approved'], "<a href=\"/item/{$item['itemId']}\"><strong>".$LANG['label-notify-item']."</strong></a>");

                            break;
                        }

                        case NOTIFY_TYPE_ITEM_REJECTED: {

                            echo sprintf($LANG['label-notify-item-rejected'], "<a href=\"/item/{$item['itemId']}\"><strong>".$LANG['label-notify-item']."</strong></a>");

                            break;
                        }

                        case NOTIFY_TYPE_PROFILE_PHOTO_REJECT: {

                            echo $LANG['label-notify-profile-photo-rejected'];

                            break;
                        }

                        case NOTIFY_TYPE_PROFILE_COVER_REJECT: {

                            echo $LANG['label-notify-profile-cover-rejected'];

                            break;
                        }

						default: {

							echo 'undefined';

							break;
						}
					}
					?>

					<div class="small text-muted"><?php echo $item['timeAgo']; ?></div>
				</div>
			</div>
		</div>

		<?php
	}

	static function blacklistItem($item, $LANG)
	{
		?>

		<div class="row d-flex align-items-center pb-3 user-item" data-id="<?php echo $item['id']; ?>">
			<div class="col">
				<a href="/<?php echo $item['blockedUserUsername']; ?>" class="d-flex align-items-center text-dark">
					<span class="avatar mr-5" style="background-image: url('<?php echo $item['blockedUserPhotoUrl']; ?>')"></span>
					<strong><?php echo $item['blockedUserFullname']; ?></strong>
				</a>
			</div>
			<div class="col">
				<a class="unblock-button float-right btn btn-danger" href="javascript:void(0)" data-id="<?php echo $item['id']; ?>" data-user-id="<?php echo $item['blockedUserId']; ?>"><?php echo $LANG['action-unblock']; ?></a>
			</div>
		</div>

		<?php
	}

	static function conversationItem($item, $LANG)
	{
		?>

		<a href="/chat/<?php echo $item['id']; ?>" class="conversation list-group-item list-group-item-action flex-column align-items-start" data-id="<?php echo $item['id']; ?>">
			<div class="d-flex w-100 justify-content-start align-content-center">
				<span class="time m-1"><?php echo $item['lastMessageAgo']; ?></span>
				<div class="pr-3">
					<div class="avatar" style="background-image: url('<?php echo $item['withUserPhotoUrl']; ?>');">
						<span class="avatar-status bg-green <?php if (!$item['withUserOnline']) echo 'hidden'; ?>"></span>
					</div>
				</div>
				<div class="align-self-center">
					<h5 class="name mb-1"><?php echo $item['withUserFullname']; ?></h5>
					<?php

						if ($item['toItemId'] != 0) {

							?>
								<div><i class="fa fa-hashtag"></i> <?php echo $item['itemTitle']; ?></div>
							<?php
						}
					?>
					<small class="message"><?php echo $item['lastMessage']; ?></small>
				</div>
				<div class="align-self-end ml-auto ">
					<span class="badge badge-success badge-pill mr-auto <?php if ($item['newMessagesCount'] == 0) echo 'hidden'; ?>"><?php echo $item['newMessagesCount']; ?></span>
				</div>
			</div>
		</a>

		<?php
	}

	static function messageInboxItem($item, $profile, $LANG)
	{
		?>

		<div class="message-item message-item-inbox" data-id="<?php echo $item['id']; ?>" data-create-at="<?php echo $item['createAt']; ?>">
			<div class="date hidden">
				<span><?php echo $item['date']; ?></span>
			</div>
			<div class="item inbox read">
				<div class="item-body d-flex flex-row align-items-end ">
					<span class="avatar" style="background-image: url('<?php echo $profile['lowPhotoUrl']; ?>');"></span>
					<span class="text bg-gray-lightest text-gray-dark p-2 rounded">
						<?php

							if (strlen($item['message']) != 0) {

								?>
									<span class="d-block message-item-text"><?php echo $item['message']; ?></span>
								<?php
							}

							if (strlen($item['imgUrl']) > 0) {

								?>
									<img class="message-item-image <?php if (strlen($item['message']) != 0) echo 'mt-2'; ?>" src="<?php echo $item['imgUrl']; ?>">
								<?php
							}
						?>
					</span>
					<small class="time text-gray message-item-time"><?php echo $item['timeAgo']; ?></small>
					<span class="spinner hidden"><i class="fa fa-spinner fa-spin"></i></span>
				</div>
			</div>
		</div>

		<?php
	}

	static function messageItem($item, $profile, $LANG)
	{
		?>

		<div class="message-item" data-id="<?php echo $item['id']; ?>" data-create-at="<?php echo $item['createAt']; ?>">
			<div class="date hidden">
				<span><?php echo $item['date']; ?></span>
			</div>
			<div class="item sent read">
				<div class="item-body d-flex flex-row align-items-end flex-row-reverse">
					<span class="avatar" style="background-image: url('<?php echo $profile['lowPhotoUrl']; ?>');"></span>
					<span class="text bg-azure text-white p-2 rounded text-right">
						<?php

							if (strlen($item['message']) != 0) {

								?>
								<span class="d-block message-item-text"><?php echo $item['message']; ?></span>
								<?php
							}

							if (strlen($item['imgUrl']) > 0) {

								?>
									<img class="message-item-image <?php if (strlen($item['message']) != 0) echo 'mt-2'; ?>" src="<?php echo $item['imgUrl']; ?>">
								<?php
							}
						?>
					</span>
					<small class="time text-gray d-block message-item-time"><?php echo $item['timeAgo']; ?></small>
					<span class="spinner hidden"><i class="fa fa-spinner fa-spin"></i></span>
				</div>
			</div>
		</div>

		<?php
	}

	static function generatePrice($currency, $price, $LANG_CURRENCY_ARRAY, $LANG)
	{
		switch ($currency) {

            case 0: {

                return "";
            }

			case 1: {

				return $LANG['label-currency-free'];
			}

			case 2: {

                return $LANG['label-currency-negotiable'];
			}

			default: {

				return $LANG_CURRENCY_ARRAY[$currency - 3]['symbol']." ".number_format($price)." <span class=\"currency-label\">".$LANG_CURRENCY_ARRAY[$currency - 3]['name']."</span>";
			}
		}
	}
}

