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

    $error = false;
    $error_messages = array();

    $items = new items($dbo);
    $items->setLanguage($LANG['lang-code']);
	$items->setRequestFrom(auth::getCurrentUserId());

    $itemId = $request[1]; // Get item id

    if ($request[0] === "item") {

        $itemId = helper::clearInt($itemId);

        $itemInfo = $items->info($itemId);

    } else {

        $itemId = helper::clearText($itemId);
        $itemId = helper::escapeText($itemId);

        $itemInfo = $items->info($itemId, true);
    }

    if (!$itemInfo['error'] && $itemInfo['imagesCount'] > 0) {

        $images = new images($dbo);
        $images->setRequestFrom(auth::getCurrentUserId());

        $itemInfo['images'] = $images->get($itemInfo['id']);

        unset($images);
    }

    // Update views count
    // if not error, if not rejected, if not deleted and if not my item

    if (!$itemInfo['error'] && $itemInfo['rejectedAt'] == 0 && $itemInfo['removeAt'] == 0 && $itemInfo['fromUserId'] != auth::getCurrentUserId()) {

        $itemInfo['viewsCount']++;
        $itemInfo['rating'] = $itemInfo['rating'] + ITEM_RATING_VIEW_VALUE;

        $items->setViewsCount($itemInfo['id'], $itemInfo['viewsCount'], $itemInfo['rating']);
    }

    $page_id = "view_item";

    $css_files = array("blueimp-gallery.min.css");

    if (!$itemInfo['error'] && $itemInfo['removeAt'] == 0) {

        $page_title = $itemInfo['itemTitle']." | ".APP_TITLE;

    } else {

        $page_title = APP_TITLE;
    }

    include_once("common/header.inc.php");

?>

<body class="page-item-view">

    <div class="page">
        <div class="page-main">

            <?php

                include_once("common/topbar.inc.php");
            ?>

            <!-- End topbar -->

            <div class="content my-3 my-md-5">

                <div class="container">

                    <?php

                        if ($itemInfo['error'] || $itemInfo['removeAt'] != 0) {

                            ?>
                                <div class="my-message">
                                    <div class="row justify-content-center">
                                        <div class="card col-11 col-sm-10 col-md-8">
                                            <div class="card-header">
                                                <h3 class="card-title"><?php echo $LANG['page-item-view-title']; ?></h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-warning"><?php echo $LANG['msg-item-not-found']; ?></div>
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

                            <?php

                                    if ($itemInfo['inactiveAt'] != 0) {

                                        ?>
                                            <div class="row justify-content-center mx-0 inactive-card">
                                                <div class="card col-12 col-sm-12 col-md-12">
                                                    <div class="card-body">
                                                        <div class="alert alert-info">
                                                            <span class="d-block"><i class="fa fa-info mr-2"></i><strong><?php echo $LANG['msg-item-not-active']; ?></strong></span>

                                                            <?php

                                                                if ($itemInfo['fromUserId'] == auth::getCurrentUserId()) {

                                                                    ?>
                                                                        <span><?php echo $LANG['msg-item-make-active-promo']; ?></span>
                                                                    <?php

                                                                }

                                                                if ($itemInfo['rejectedAt'] != 0) {

                                                                    ?>
                                                                        <span class="d-block"><strong><?php echo $LANG['msg-item-make-active-description']; ?></strong></span>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                ?>

                                <div class="row item-column-main" data-id="<?php echo $itemInfo['id']; ?>">

                                    <!-- Left section with photos  -->

                                    <div id="item-column-content" class="item-column-content col-sm-12 col-md-7 col-lg-7 order-md-2 order-lg-2">

                                        <!-- Invite to download app banner -->

                                        <?php

                                            require_once ("common/download_app_banner.inc.php");
                                        ?>

                                        <!-- Item Stats -->

                                        <?php

                                            if ($itemInfo['fromUserId'] == auth::getCurrentUserId()) {

                                                ?>

                                                <div class="row justify-content-center mx-0 inactive-card">
                                                    <div class="card col-12 col-sm-12 col-md-12">
                                                        <div class="card-body">
                                                            <div class="item-info-block">
                                                                <div class="text-bold mb-2"><?php echo $LANG['label-item-stats']; ?></div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-4 mt-2">
                                                                        <div class="text-muted mb-2"><i class="fa fa-eye mr-1"></i><?php echo $LANG['label-item-stats-views']; ?>:</div>
                                                                        <div class="text-bolder"><?php echo $itemInfo['viewsCount']; ?></div>
                                                                    </div>
                                                                    <div class="col-12 col-md-4 mt-2">
                                                                        <div class="text-muted mb-2"><i class="fa fa-star mr-1"></i><?php echo $LANG['label-item-stats-favorites']; ?>:</div>
                                                                        <div class="text-bolder"><?php echo $itemInfo['likesCount']; ?></div>
                                                                    </div>
                                                                    <div class="col-12 col-md-4 mt-2">
                                                                        <div class="text-muted mb-2"><i class="fa fa-phone mr-1"></i><?php echo $LANG['label-item-stats-phone-views']; ?>:</div>
                                                                        <div class="text-bolder"><?php echo $itemInfo['phoneViewsCount']; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                        ?>

                                        <!-- Item Images -->

                                        <div class="card">

                                            <div class="item-images">

                                                <div class="item-main-image">
                                                    <div class="photo-wrapper d-flex justify-content-center" style="padding-top: 80%">

                                                        <?php

                                                            if (auth::isSession() && $itemInfo['fromUserId'] != auth::getCurrentUserId()) {

                                                                if ($itemInfo['myLike']) {

                                                                    ?>
                                                                    <div class="add-to-favorites">
                                                                        <div class="loader hidden"><i class="fa fa-spin fa-spin"></i></div>
                                                                        <span data-id="<?php echo $itemInfo['id']; ?>" class="add-to-favorites-button active" data-original-title="<?php echo $LANG['label-favorites-remove']; ?>" rel="tooltip">
                                                                            <i class="far fa-star"></i>
                                                                        </span>
                                                                    </div>
                                                                    <?php

                                                                } else {

                                                                    ?>
                                                                    <div class="add-to-favorites">
                                                                        <div class="loader hidden"><i class="fa fa-spin fa-spin"></i></div>
                                                                        <span data-id="<?php echo $itemInfo['id']; ?>" class="add-to-favorites-button" data-original-title="<?php echo $LANG['label-favorites-add']; ?>" rel="tooltip">
                                                                            <i class="far fa-star"></i>
                                                                        </span>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>

                                                        <div class="loader">
                                                            <i class="fa fa-spin fa-spin"></i>
                                                        </div>

                                                        <a href="<?php echo $itemInfo['imgUrl']; ?>">
                                                            <div class="profile-photo-img" src="" style="background-image: url(<?php echo $itemInfo['imgUrl']; ?>); background-size: cover; cursor: pointer" onclick="blueimp.Gallery($('.item-images-row a')); return false"></div>
                                                        </a>

                                                    </div>
                                                </div>

                                                <div class="item-other-images py-0">

                                                    <div class="item-images-row row">

                                                        <a class="col-4 image-item hidden" href="<?php echo $itemInfo['imgUrl']; ?>">
                                                            <div class="gallery-item-wrapper image-item">
                                                                <div  alt="" style="background-image: url(<?php echo $itemInfo['imgUrl']; ?>);"></div>
                                                            </div>
                                                        </a>

                                                        <?php

                                                            if (array_key_exists("images", $itemInfo)) {

                                                                if (count($itemInfo['images']['items']) > 0) {

                                                                    for ($i = 0; $i < count($itemInfo['images']['items']); $i++) {

                                                                        $img = $itemInfo['images']['items'][$i];

                                                                        switch($i) {

                                                                            case 0: {

                                                                                ?>
                                                                                    <a class="col-4 image-item" href="<?php echo $img['imgUrl']; ?>">
                                                                                        <div class="gallery-item-wrapper image-item">
                                                                                            <div  style="background-image: url(<?php echo $img['imgUrl']; ?>);"></div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php

                                                                                break;
                                                                            }

                                                                            case 1: {

                                                                                ?>
                                                                                    <a class="col-4 image-item" href="<?php echo $img['imgUrl']; ?>">
                                                                                        <div class="gallery-item-wrapper image-item">
                                                                                            <div  alt="" style="background-image: url(<?php echo $img['imgUrl']; ?>);"></div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php

                                                                                break;
                                                                            }

                                                                            case 2: {

                                                                                ?>
                                                                                    <a class="col-4 image-item" href="<?php echo $img['imgUrl']; ?>">
                                                                                        <div class="gallery-item-wrapper image-item">
                                                                                            <div  alt="" style="background-image: url(<?php echo $img['imgUrl']; ?>);"></div>
                                                                                            <?php

                                                                                                if (count($itemInfo['images']['items']) > 3) {

                                                                                                    ?>
                                                                                                        <div class="d-flex justify-content-center align-items-center hidden-photos">
                                                                                                            <span>+1 фото</span>
                                                                                                        </div>
                                                                                                    <?php
                                                                                                }
                                                                                            ?>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php

                                                                                break;
                                                                            }

                                                                            default: {

                                                                                ?>
                                                                                    <a class="col-4 image-item hidden" href="<?php echo $img['imgUrl']; ?>">
                                                                                        <div class="gallery-item-wrapper image-item">
                                                                                            <div style="background-image: url(<?php echo $img['imgUrl']; ?>); background-size: cover"></div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        ?>

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

                                                </div>

                                            </div> <!-- End item-images -->


                                            <div class="item-info">

                                                <div class="<?php if ($itemInfo['imagesCount'] == 0) echo 'pt-0 ' ?>item-info-block">
                                                    <h1 class="mb-2"><?php echo $itemInfo['itemTitle']; ?></h1>
                                                    <div class="row">
                                                        <?php

                                                            if (strlen($itemInfo['location']) != 0) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-location noselect"><i class="fa fa-map-marker mr-1"></i><?php echo $itemInfo['location']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>

                                                        <?php

                                                            if (strlen($itemInfo['categoryTitle']) != 0) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-category noselect"><i class="fa fa-folder mr-1"></i><?php echo $itemInfo['categoryTitle']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>

                                                        <div class="col-6">
                                                            <div class="text-muted item-time noselect"><i class="far fa-clock mr-1" title="<?php echo $itemInfo['timeAgo']; ?>" rel="tooltip"></i><?php echo $itemInfo['date']; ?></div>
                                                        </div>

                                                        <?php

                                                            if ($itemInfo['moderatedAt'] != 0) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-status noselect"><i class="fa fa-check-circle mr-1" title="<?php echo $LANG['label-item-approved-title']; ?>" rel="tooltip"></i><?php echo $LANG['label-item-approved']; ?> <small><a href="/terms#verified_items">?</a></small></div>
                                                                </div>
                                                                <?php
                                                            }

                                                            if ($itemInfo['appType'] == APP_TYPE_WEB) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-created-by noselect"><i class="fa fa-globe mr-1"></i><?php echo $LANG['label-created-by-web-app']; ?></div>
                                                                </div>
                                                                <?php

                                                            } else if ($itemInfo['appType'] == APP_TYPE_ANDROID) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-created-by noselect"><i class="fa fa-mobile-alt mr-1"></i><?php echo $LANG['label-created-by-android-app']; ?></div>
                                                                </div>
                                                                <?php

                                                            } else if ($itemInfo['appType'] == APP_TYPE_IOS) {

                                                                ?>
                                                                <div class="col-6">
                                                                    <div class="text-muted item-created-by noselect"><i class="fa fa-mobile-al mr-1"></i><?php echo $LANG['label-created-by-ios-app']; ?></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>

                                                </div>

                                                <div class="item-info-block">
                                                    <div class="text-content item-content"><?php echo $itemInfo['itemContent']; ?></div>
                                                </div>

                                                <div class="item-info-block">
                                                    <div class="row">
                                                        <div class="col-6 mb-0">
                                                            <div class="text-muted mb-2"><i class="fa fa-eye mr-1"></i><?php echo $LANG['label-item-stats-views']; ?>: <?php echo $itemInfo['viewsCount']; ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div> <!-- End Item Info Section -->

                                        <?php

                                        if ($itemInfo['fromUserId'] != auth::getCurrentUserId()) {

                                            $finder = new finder($dbo);
                                            $finder->setItemsInRequest(6);
                                            $finder->addCategoryFilter($itemInfo['category']);

                                            $r_pageId = rand(0, 2);
                                            $r_sortType = rand(0, 3);

                                            $result = $finder->getItems("", $r_pageId, $r_sortType, $itemInfo['lat'], $itemInfo['lng'], 300);

                                            if (count($result['items']) > 1) {

                                                ?>

                                                <div class="dashboard-block mb-3 d-none d-md-block">

                                                    <div class="list-view directory-list-view items-list-view">
                                                        <h3><?php echo $LANG['label-items-related']; ?></h3>

                                                        <div class="row row-cards row-deck items-grid-view">
                                                            <?php

                                                            if (count($result['items']) > 0) {

                                                                foreach ($result['items'] as $key => $value) {

                                                                    if ($value['id'] != $itemInfo['id']) {

                                                                        draw::item($value, $CURRENCY_ARRAY, $LANG, "col-6 col-sm-6 col-md-6 col-lg-4");
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                        }
                                        ?>

                                    </div> <!-- End Left section with photos  -->

                                    <!-- Right section -->

                                    <div id="item-column-info" class="item-column-info col-sm-12 col-md-5 col-lg-5 order-md-3 order-lg-3">

                                        <!-- Price Section -->

                                        <div class="card card-price-info">
                                            <div class="item-info">
                                                <div class="item-info-block border-0">
                                                    <div class="d-flex text-center">
                                                        <h1 class="w-100 mb-0">
                                                            <?php echo draw::generatePrice($itemInfo['currency'], $itemInfo['price'], $CURRENCY_ARRAY, $LANG); ?>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- End Price Section -->

                                        <!-- Item Author Section -->

                                        <div class="card card-profile-info">
                                            <div class="item-info">
                                                <div class="item-info-block ">
                                                    <div class="d-flex">

                                                        <div class="mr-3 ml-0 pl-0" style="border: none">
                                                            <a href="/<?php echo $itemInfo['fromUserUsername']; ?>"><img class="profile-icon" src="<?php echo $itemInfo['fromUserPhotoUrl']; ?>"/></a>
                                                        </div>

                                                        <div class="item-info-header justify-content-end">
                                                            <div class="fullname-line mb-1">
                                                                <h1 class="display-name"><a href="/<?php echo $itemInfo['fromUserUsername']; ?>"><?php echo $itemInfo['fromUserFullname']; ?></a></h1>
                                                                <?php

                                                                    if ($itemInfo['fromUserOnline']) {

                                                                        ?>
                                                                            <i class="online-status bg-green" rel="tooltip" title="Online"></i>
                                                                        <?php
                                                                    }
                                                                 ?>
                                                            </div>

                                                            <?php

                                                                if (strlen($itemInfo['fromUserLocation']) != 0) {

                                                                    ?>
                                                                        <div class="location-line text-muted d-flex align-content-center flex-column flex-sm-row">
                                                                            <div class="user-location mt-2 mt-sm-0 ml-0"><i class="fa fa-map-marker mr-1"></i><?php echo $itemInfo['fromUserLocation']; ?></div>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>

                                                <?php

                                                    if ($itemInfo['fromUserId'] == auth::getCurrentUserId()) {

                                                        ?>

                                                            <div class="item-info-block item-info-actions">

                                                                <button class="btn btn-red mb-2 mb-sm-0" data-toggle="modal" data-target="#delete-item">
                                                                    <i class="fa fa-trash mr-1"></i>
                                                                    <?php echo $LANG['action-remove']; ?>
                                                                </button>

                                                                <a href="/item/<?php echo $itemInfo['id']; ?>/edit" class="btn btn-primary mb-2 mb-sm-0">
                                                                    <i class="fa fa-pencil-alt mr-1"></i>
                                                                    <?php echo $LANG['action-edit']; ?>
                                                                </a>

                                                                <?php

                                                                    // if active

                                                                    if ($itemInfo['inactiveAt'] == 0) {

                                                                        ?>
                                                                            <button id="item-inactivate-button" class="btn btn-gray mb-2 mb-sm-0" data-toggle="modal" data-target="#inactivate-item">
                                                                                <i class="fa fa-pause mr-1"></i>
                                                                                <?php echo $LANG['action-item-inactivate']; ?>
                                                                            </button>
                                                                        <?php
                                                                    }

                                                                    // if inactive and not rejected

                                                                    if ($itemInfo['rejectedAt'] == 0 && $itemInfo['inactiveAt'] != 0) {

                                                                        ?>
                                                                        <button id="item-activate-button" class="btn btn-success mb-2 mb-sm-0" data-id="<?php echo $itemInfo['id']; ?>">
                                                                            <i class="fa fa-play mr-1"></i>
                                                                            <?php echo $LANG['action-item-activate']; ?>
                                                                        </button>
                                                                        <?php
                                                                    }
                                                                ?>

                                                            </div>

                                                        <?php

                                                    } else {

                                                        ?>
                                                            <div class="item-info-block item-info-actions">

                                                                <?php

                                                                    if ($itemInfo['inactiveAt'] == 0) {

                                                                        ?>
                                                                            <button id="phone-number-button" data-item-id="<?php echo $itemInfo['id']; ?>" data-phone-number="<?php echo $itemInfo['phoneNumber']; ?>" class="btn btn-primary mb-2 phone-hidden">
                                                                                <i class="fa fa-phone mr-1"></i>
                                                                                <span>XXX-XX<small> <?php echo $LANG['action-show']; ?></small></span>
                                                                            </button>

                                                                            <button id="new-message-button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#new-message">
                                                                                <i class="fa fa-envelope mr-1"></i>
                                                                                <?php echo $LANG['action-send-message']; ?>
                                                                            </button>
                                                                        <?php
                                                                    }
                                                                ?>

                                                                <div class="dropdown">
                                                                    <button type="button" class="btn btn-secondary dropdown-toggle mb-2" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-h"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <button class="dropdown-item" data-toggle="modal" data-target="#new-report"><?php echo $LANG['action-report']; ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>

                                            </div>
                                        </div>

                                        <!-- End Item Author Section -->

                                        <!-- Adsense banner -->

                                        <?php

                                            require_once ("common/adsense_banner.inc.php");
                                        ?>

                                        <!-- Tmp Item Author Section -->

                                        <?php

                                            if (strlen($itemInfo['location']) != 0) {

                                                ?>
                                                    <div class="card" id="map-block">
                                                        <div class="card-header">
                                                            <h3 class="card-title"><i class="fa fa-map-marker mr-1"></i><?php echo $itemInfo['location']; ?></h3>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <div id="default-map">
                                                                <button id="show-map" class="btn btn-secondary btn-lg"><i class="fa fa-map mr-2"></i><?php echo $LANG['action-show-map']; ?></button>
                                                            </div>
                                                            <div id="map" class="hidden" style="height: 250px;"></div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        ?>

                                        <div class="card <?php if ($itemInfo['fromUserId'] == auth::getCurrentUserId()) echo 'hidden'; ?>" id="safety-block">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fa fa-shield-alt mr-1"></i><?php echo $LANG['label-safety-tips-title']; ?></h3>
                                            </div>
                                            <div class="card-body p-4">
                                                <h6>1. <?php echo $LANG['label-safety-tips-1']; ?></h6>
                                                <h6>2. <?php echo $LANG['label-safety-tips-2']; ?></h6>
                                                <h6>3. <?php echo $LANG['label-safety-tips-3']; ?></h6>
                                                <h6>4. <?php echo $LANG['label-safety-tips-4']; ?></h6>
                                            </div>
                                        </div>

                                        <div class="card <?php if ($itemInfo['fromUserId'] == auth::getCurrentUserId()) echo 'hidden'; ?>" id="disclaimer-block">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fa fa-info-circle mr-1"></i><?php echo $LANG['label-item-disclaimer-title']; ?></h3>
                                            </div>
                                            <div class="card-body p-4">
                                                <p><?php echo $LANG['label-item-disclaimer-desc'] ?></p>
                                            </div>
                                        </div>

                                        <!-- End Tmp Item Author Section -->

                                    </div> <!-- End Right section -->

                                </div>

                                <?php

                                    if (auth::isSession() && $itemInfo['fromUserId'] == auth::getCurrentUserId() && $itemInfo['removeAt'] == 0) {

                                        ?>
                                            <div class="my-message hidden">
                                                <div class="row justify-content-center">
                                                    <div class="card col-11 col-sm-10 col-md-8">
                                                        <div class="card-header">
                                                            <h3 class="card-title"><?php echo $LANG['page-item-view-title']; ?></h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="alert alert-warning">
                                                                <?php echo $LANG['msg-item-success-removed']; ?>
                                                            </div>
                                                            <div>
                                                                <a class="btn btn-primary" href="/"><?php echo $LANG['action-back-to-main-page']; ?></a>
                                                                <a class="btn btn-add-item" href="/item/new"><i class="fa fa-plus mr-1"></i><?php echo $LANG['action-new-classified']; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                ?>
                            <?php
                        }
                    ?>

                </div> <!-- End container -->
            </div> <!-- End  -->

        </div> <!-- End page main-->

        <?php

            if (auth::isSession() && !$itemInfo['error'] && $itemInfo['removeAt'] == 0 && $itemInfo['fromUserId'] != auth::getCurrentUserId()) {

                ?>
                <div class="modal modal-form fade" id="new-message" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="new-message-form" action="/api/v1/method/msg.new" method="post">

                                <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                                <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                                <input type="hidden" name="profileId" value="<?php echo $itemInfo['fromUserId']; ?>">

                                <input type="hidden" name="adItemId" value="<?php echo $itemInfo['id']; ?>">
                                <input type="hidden" name="adItemTitle" value="<?php echo $itemInfo['itemTitle']; ?>">

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

            if (auth::isSession() && !$itemInfo['error'] && $itemInfo['removeAt'] == 0 && $itemInfo['fromUserId'] == auth::getCurrentUserId()) {

                ?>
                <div class="modal modal-form fade" id="delete-item" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="delete-item-form" action="/api/v1/method/items.remove" method="post">

                                <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                                <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                                <input type="hidden" name="itemId" value="<?php echo $itemInfo['id']; ?>">

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
                <?php

                if ($itemInfo['inactiveAt'] == 0) {

                    ?>
                    <div class="modal modal-form fade" id="inactivate-item" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="inactivate-item-form" action="/api/v1/method/items.inactivate" method="post">

                                    <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                                    <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                                    <input type="hidden" name="itemId" value="<?php echo $itemInfo['id']; ?>">

                                    <div class="modal-header">
                                        <h5 class="modal-title placeholder-title"><?php echo $LANG['dlg-confirm-action-title']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"></span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="error-summary alert alert-warning">

                                            <p><?php echo $LANG['msg-confirm-inactive-title']; ?></p>
                                            <p><?php echo $LANG['msg-confirm-inactive-hint']; ?></p>
                                            <p><?php echo $LANG['msg-confirm-inactive-subtitle']; ?></p>

                                        </div>

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
            }

            if (!auth::isSession() && !$itemInfo['error'] && $itemInfo['removeAt'] == 0) {

                ?>
                    <div class="modal modal-form fade" id="new-message" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title placeholder-title" id="profile-new-message-title"><?php echo APP_TITLE; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="error-summary alert alert-warning"><?php echo sprintf($LANG['msg-contact-promo'], "<strong>" . $itemInfo['fromUserFullname'] . "</strong>"); ?></div>

                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary mr-1" href="/signup"><?php echo $LANG['action-signup']; ?></a>
                                    <a class="btn btn-secondary" href="/login?continue=/item/<?php echo $itemInfo['id']; ?>"><?php echo $LANG['action-login']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }

            if (!$itemInfo['error'] && $itemInfo['removeAt'] == 0) {

                ?>
                    <div class="modal modal-form fade profile-report" id="new-report" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="new-report-form" action="/api/v1/method/items.report" method="post">

                                    <input type="hidden" name="accessToken" value="<?php echo auth::getAccessToken(); ?>">
                                    <input type="hidden" name="accountId" value="<?php echo auth::getCurrentUserId(); ?>">

                                    <input type="hidden" name="itemId" value="<?php echo $itemInfo['id']; ?>">

                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php echo $LANG['dlg-report-item-title']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="error-summary alert alert-danger" style="display:none"><ul></ul></div>
                                        <div class="pb-3"><strong><?php echo $LANG['dlg-report-sub-title']; ?></strong></div>
                                        <div class="form-group field-reason required">
                                            <input type="hidden" name="abuseId" value="-1">
                                            <div id="reason" aria-required="true">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="abuseId" value="0">
                                                    <div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-1']; ?></div>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="abuseId" value="1">
                                                    <div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-2']; ?></div>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="abuseId" value="2">
                                                    <div class="custom-control-label"><?php echo $LANG['label-profile-report-reason-3']; ?></div>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="abuseId" value="3">
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
                                        <button type="submit" disabled="disabled" class="btn btn-primary ajax-send-report"><?php echo $LANG['action-report']; ?></button>
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

    <?php

        if ($itemInfo['lat'] != 0.000000 && $itemInfo['lng'] != 0.000000 && $itemInfo['removeAt'] == 0) {

            ?>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&language=en"></script>
            <?php
        }
    ?>

    <script type="text/javascript">

        var strings = {

            szFavoritesAddTooltip: "<?php echo $LANG['label-favorites-add']; ?>",
            szFavoritesRemoveTooltip: "<?php echo $LANG['label-favorites-remove']; ?>",
            szItemRemoved: "<?php echo $LANG['msg-item-success-removed'] ?>"
        };

        var options = {};

        $(document).off('click.gallery', 'div.item-other-images a').on('click.gallery', 'div.item-other-images a', function() {

                var links = $(this).parent().find('a.image-item');
                options.index = $(this)[0];
                blueimp.Gallery(links, options);

                return false;
        });

        $(document).on("click", "button#item-activate-button", function() {

            var $this = $(this);

            var itemId = $this.attr('data-id');

            $this.addClass('disabled');

            $.ajax( {
                type: "POST",
                url: App.api_path + "items.activate",
                data: "accountId=" + account.id + "&accessToken=" + account.accessToken + "&itemId=" + itemId,
                dataType: 'json',
                success: function(response) {

                    window.location.reload();
                },
                error: function(xhr, status, error) {

                    $this.removeClass('disabled');
                }
            });
        });

        $("form#inactivate-item-form").submit(function(e) {

            var $button = $('button#item-inactivate-button');
            var form = $('form#inactivate-item-form');

            $button.addClass('disabled');

            $.ajax( {
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {

                    $('#inactivate-item').modal('hide');

                    $button.removeClass('disabled');

                    window.location.reload();
                },
                error: function(xhr, status, error) {

                    $button.removeClass('disabled');
                }
            });

            return false;
        });

        $(document).on("click", "button.delete-forever-item-button", function() {

            $('div.my-message').find('div.alert-warning').text(strings.szItemRemoved);
            $("form#delete-item-form").find("input[name=inactivate]").val("0").submit();
        });

        $(document).on("click", "button#phone-number-button", function() {

            var $this = $(this);

            $this.find('span').text($(this).attr('data-phone-number'));

            var itemId = $(this).attr('data-item-id');

            if ($this.hasClass("phone-hidden")) {

                $this.removeClass("phone-hidden");

                $.ajax( {
                    type: "POST",
                    url: App.api_path + "items.phone",
                    data: "accountId=" + account.id + "&accessToken=" + account.accessToken + "&itemId=" + itemId,
                    dataType: 'json',
                    success: function(response) {

                        // silent
                    },
                    error: function(xhr, status, error) {

                        // silent
                    }
                });
            }
        });

        $(document).on("click", "input[name=abuseId]", function() {

            var form = $('#new-report-form');

            form.find("button[type=submit]").removeAttr('disabled');
        });

        // Show Map

        $(document).on("click", "#show-map", function() {

            $('#default-map').addClass('hidden');

            initMap();
        });

        // Initialize and add the map

        function initMap() {

            var lat = <?php if (!isset($itemInfo['lat'])) {echo '0.000000';} else {echo $itemInfo['lat'];} ?>;
            var lng = <?php if (!isset($itemInfo['lng'])) {echo '0.000000';} else {echo $itemInfo['lng'];} ?>;

            var loc = {lat: 0.000000, lng: 0.000000};

            loc.lat = lat;
            loc.lng = lng;

            // The map, centered at location
            var map = new google.maps.Map(document.getElementById('map'), {zoom: 9, center: loc, draggable: true, scrollwheel: false, disableDoubleClickZoom: false, zoomControl: false, scaleControl: false, mapTypeControl: false, streetViewControl: false, fullscreenControl: false});

            var marker = new google.maps.Marker({position: loc, map: map, draggable: false});

            $('#map').removeClass('hidden');
        }

    </script>

</body>
</html>