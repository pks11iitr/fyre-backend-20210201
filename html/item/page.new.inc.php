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

        auth::unsetSession();
        auth::clearCookie();

        header('Location: /');
        exit;
    }

    if (isset($_GET['get_subcategories'])) {

        $categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : 0;

        $categoryId = helper::clearInt($categoryId);

        $category = new category($dbo);
        $category->setLanguage($LANG['lang-code']);
        $result = $subcategories = $category->getItems($categoryId);
        unset($category);

        ob_start();

        ?>
            <option selected disabled value="0"><?php echo $LANG['label-subcategory-choose']; ?></option>
        <?php

        foreach ($subcategories['items'] as $key => $item) {

            ?>
                <option value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
            <?php
        }

        $result['html'] = ob_get_clean();

        echo json_encode($result);
        exit;
    }

    $edit_mode = false;
    $itemInfo = array();

    $error = false;
    $error_messages = array();

    $ad_lat = 37.773972;
    $ad_lng = -122.431297;

    if (isset($_COOKIE['item-editor-lat'])) {

        $ad_lat = $_COOKIE['item-editor-lat'];
    }

    if (isset($_COOKIE['item-editor-lng'])) {

        $ad_lng = $_COOKIE['item-editor-lng'];
    }

    $ad_title = "";
    $ad_category = 0;
    $ad_subcategory = 0;
    $ad_currency = 0;
    $ad_price = 1;
    $ad_description = "";
    $ad_photos = array();
    $ad_phone_number = "";

    $ad_area = "";
    $ad_country = "";
    $ad_city = "";

    if ($cnt == 3) {

        // Edit mode

        $edit_mode = true;

        $items = new items($dbo);
        $items->setRequestFrom(auth::getCurrentUserId());

        $itemId = helper::clearInt($request[1]); // Get item id

        $itemInfo = $items->info($itemId);

        if ($itemInfo['error'] || $itemInfo['id'] == 0 && $itemInfo['removeAt'] != 0 || $itemInfo['fromUserId'] != auth::getCurrentUserId()) {

            header('Location: /');
            exit;
        }

        if (!$itemInfo['error'] && $itemInfo['imagesCount'] > 0) {

            $images = new images($dbo);
            $images->setRequestFrom(auth::getCurrentUserId());

            $itemInfo['images'] = $images->get($itemId);

            unset($images);
        }

        $ad_photos[] = array("name" => $itemInfo['imgUrl'],
                             "size" => 12,
                             "uploaded" => true,
                             "type" => "image/jpeg");

        if (array_key_exists("images", $itemInfo)) {

            if (count($itemInfo['images']['items']) > 0) {

                for ($i = 0; $i < count($itemInfo['images']['items']); $i++) {

                    $img = $itemInfo['images']['items'][$i];

                    $ad_photos[] = array("name" => $img['imgUrl'],
                                         "uploaded" => true,
                                         "size" => 12,
                                         "type" => "image/jpeg");

                }
            }
        }

        $ad_title = $itemInfo['itemTitle'];
        $ad_category = $itemInfo['category'];
        $ad_subcategory = $itemInfo['subCategory'];
        $ad_currency = $itemInfo['currency'];
        $ad_price = $itemInfo['price'];
        $ad_description = $itemInfo['itemContent'];
        $ad_phone_number = $itemInfo['phoneNumber'];

        if ($ad_price < 1) $ad_price = 1;

        $ad_lat = $itemInfo['lat'];
        $ad_lng = $itemInfo['lng'];
    }

    if (!empty($_POST)) {

        $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
        $ajax_mode = isset($_POST['ajax']) ? $_POST['ajax'] : 0;

        $ad_title = isset($_POST['title']) ? $_POST['title'] : '';
        $ad_category = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
        $ad_subcategory = isset($_POST['subcategoryId']) ? $_POST['subcategoryId'] : 0;
        $ad_currency = isset($_POST['currency']) ? $_POST['currency'] : 0;
        $ad_price = isset($_POST['price']) ? $_POST['price'] : 0;
        $ad_description = isset($_POST['description']) ? $_POST['description'] : '';
        $ad_photos = isset($_POST['images']) ? $_POST['images'] : array();
        $ad_phone_number = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

        $ad_lat = isset($_POST['lat']) ? $_POST['lat'] : '0.000000';
        $ad_lng = isset($_POST['lng']) ? $_POST['lng'] : '0.000000';

        $ad_country = isset($_POST['country']) ? $_POST['country'] : '';
        $ad_city = isset($_POST['city']) ? $_POST['city'] : '';

        $ajax_mode = helper::clearInt($ajax_mode);

        $ad_title = helper::clearText($ad_title);
        $ad_title = helper::escapeText($ad_title);

        $ad_category = helper::clearInt($ad_category);
        $ad_subcategory = helper::clearInt($ad_subcategory);
        $ad_currency = helper::clearInt($ad_currency);
        $ad_price = helper::clearInt($ad_price);

        $ad_description = helper::clearText($ad_description);

        $ad_description = preg_replace( "/[\r\n]+/", "<br>", $ad_description); //replace all new lines to one new line
        $ad_description  = preg_replace('/\s+/', ' ', $ad_description);        //replace all white spaces to one space

        $ad_description = helper::escapeText($ad_description);

        $ad_phone_number = helper::clearText($ad_phone_number);
        $ad_phone_number = helper::escapeText($ad_phone_number);

        $ad_country = helper::clearText($ad_country);
        $ad_country = helper::escapeText($ad_country);

        $ad_city = helper::clearText($ad_city);
        $ad_city = helper::escapeText($ad_city);

        if (!helper::isFloat($ad_lat) || !helper::isFloat($ad_lng)) {

            $ad_country = "";
            $ad_city = "";

            $ad_lat = "37.773972";
            $ad_lng = "-122.431297";

        } else {

            if (!$edit_mode) {

                @setcookie('item-editor-lat', "{$ad_lat}", time() + 7 * 24 * 3600, "/");
                @setcookie('item-editor-lng', "{$ad_lng}", time() + 7 * 24 * 3600, "/");
            }
        }

        if (auth::getAuthenticityToken() !== $token) {

            $error = true;
            $error_messages[] = $LANG['msg-error-unknown'];
        }

        if (strlen($ad_title) == 0) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-title'];

        } else {

            if (strlen($ad_title) < 5) {

                $error = true;
                $error_messages[] = $LANG['label-ad-title']." ".$LANG['msg-error-ad-length-title'];
            }
        }

        if ($ad_category == 0) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-category'];
        }

        if ($ad_currency == 0) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-currency'];

        } else {

            if ($ad_currency > 2 && $ad_price == 0) {

                $error = true;
                $error_messages[] = $LANG['msg-error-ad-price'];
            }
        }

        if (strlen($ad_description) == 0) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-description'];

        } else {

            if (strlen($ad_description) < 10) {

                $error = true;
                $error_messages[] = $LANG['label-ad-description']." ".$LANG['msg-error-ad-length-description'];
            }
        }

        if (count($ad_photos) == 0) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-photos'];
        }

        if (!helper::isCorrectPhoneNew($ad_phone_number)) {

            $error = true;
            $error_messages[] = $LANG['msg-error-ad-phone-incorrect'];
        }

        if (!$error) {

            // copy files and get links

            $images_links = array();

            if (count($ad_photos) != 0) {

                for ($i = 0; $i < (max(array_keys($ad_photos))) + 1; $i++) {

                    if (isset($ad_photos[$i]["name"])) {

                        if (isset($ad_photos[$i]["uploaded"])) {

                            $images_links[] = $ad_photos[$i]["name"];

                        } else {

                            if (file_exists(TEMP_PATH.$ad_photos[$i]["name"])) {

                                $imglib = new imglib($dbo);
                                $imglib->setRequestFrom(auth::getCurrentUserId());

                                $response = $imglib->createItemImg(TEMP_PATH.$ad_photos[$i]["name"], true, true);

                                if (!$response['error']) {

                                    $images_links[] = $response["fileUrl"];
                                }
                            }
                        }
                    }
                }
            }

            // if links array > 0

            if (count($images_links) != 0) {

                $items = new items($dbo);
                $items->setRequestFrom(auth::getCurrentUserId());

                if (!$edit_mode) {

                    $result = $items->add(APP_TYPE_WEB, $ad_category, $ad_subcategory, $ad_title, $ad_title, $ad_description, $images_links[0], 0, $ad_price, $ad_area, $ad_country, $ad_city, $ad_lat, $ad_lng, $ad_currency, $ad_phone_number);

                    if (!$result['error'] && count($images_links) > 1) {

                        $images = new images($dbo);
                        $images->setRequestFrom(auth::getCurrentUserId());

                        for ($i = count($images_links) - 1; $i > 0 ; $i--) {

                            $images->add($result['itemId'], $images_links[$i], $images_links[$i], $images_links[$i]);
                        }

                        $items->setImagesCount($result['itemId'], count($images_links) - 1);
                    }

                } else {

                    $result = $items->edit($itemInfo['id'], $ad_category, $ad_subcategory, $ad_title, $images_links[0], $ad_description, 0, $ad_price, $ad_area, $ad_country, $ad_city, $ad_lat, $ad_lng, $ad_currency, $ad_phone_number);

                    if (!$result['error'] && count($images_links) > 1) {

                        $images = new images($dbo);
                        $images->setRequestFrom(auth::getCurrentUserId());

                        $images->removeAll($itemInfo['id']);

                        for ($i = count($images_links) - 1; $i > 0 ; $i--) {

                            $images->add($itemInfo['id'], $images_links[$i], $images_links[$i], $images_links[$i]);
                        }

                        $items->setImagesCount($itemInfo['id'], count($images_links) - 1);
                    }
                }

                if (!$result['error']) {

                    if ($ajax_mode == 0) {

                        header("Location: /");
                        exit;

                    } else {

                        auth::newAuthenticityToken();

                        header("Content-type: application/json; charset=utf-8");

                        echo json_encode($result);
                        exit;
                    }
                }
            }

        }

    }

    auth::newAuthenticityToken();

    $page_id = "new_item";

    $css_files = array();
    $page_title = $LANG['page-new-ad-title']." | ".APP_TITLE;

    if ($edit_mode) {

        $page_id = "edit_item";
        $page_title = $LANG['page-edit-ad-title']." | ".APP_TITLE;
    }

    include_once("common/header.inc.php");

?>

<body class="body-directory-index page-item-new">

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

                            <div class="col-lg-8 mx-auto">

                                <div class="card" style="">

                                    <div class="hidden ajax-loader">
                                        <div class="row align-self-center w-100 h-100 progress-container">
                                            <div class="dimmer active w-100">
                                                <div class="loader"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header">
                                        <h3 class="card-title noselect">
                                            <?php

                                                if (!$edit_mode) {

                                                    echo $LANG['page-new-ad-title'];

                                                } else {

                                                    echo $LANG['page-edit-ad-title'];
                                                }

                                            ?>
                                        </h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-sm-12 promo-container hidden">

                                            <div class="error-summary alert alert-success" style="">
                                                <?php

                                                    if ($edit_mode) {

                                                        echo "<strong>".$LANG['label-thanks']."</strong> ".$LANG['msg-ad-saved'];

                                                    } else {

                                                        echo "<strong>".$LANG['label-thanks']."</strong> ".$LANG['msg-ad-published'];
                                                    }
                                                ?>
                                            </div>

                                            <div class="pt-2">
                                                <a class="btn btn-primary btn-lg" id="see-item-button" href="/item/"><?php echo $LANG['action-see-classified']; ?></a>
                                                <a class="btn btn-add-item btn-lg" id="new-item-button" href="/item/new"><?php echo $LANG['action-new-classified']; ?></a>
                                            </div>

                                        </div>

                                        <?php

                                            $link = "/item/new";

                                            if ($edit_mode) {

                                                $link = "/item/".$itemInfo['id']."/edit";
                                            }
                                        ?>

                                        <form id="form-new" action="<?php echo $link; ?>" method="post" data-id="<?php echo $edit_mode; ?>">

                                            <input autocomplete="off" type="hidden" name="authenticity_token" value="<?php echo auth::getAuthenticityToken(); ?>">
                                            <input autocomplete="off" type="hidden" name="lat" value="0.000000">
                                            <input autocomplete="off" type="hidden" name="lng" value="0.000000">
                                            <input autocomplete="off" type="hidden" name="country" value="">
                                            <input autocomplete="off" type="hidden" name="city" value="">
                                            <input autocomplete="off" type="hidden" name="ajax" value="0">

                                            <div class="form-container">

                                                <div class="col-sm-12" style="<?php if (!$error) echo "display: none"; ?>">
                                                    <div class="error-summary alert alert-danger">
                                                        <ul>
                                                            <?php

                                                            foreach ($error_messages as $key => $value) {

                                                                echo "<li>".$value."</li>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group group-title">
                                                        <label class="form-label noselect" for="title"><?php echo $LANG['label-ad-title']; ?> <small>(<?php echo $LANG['label-ad-sub-title']; ?>)</small></label>
                                                        <input maxlength="70" placeholder="<?php echo $LANG['placeholder-ad-title']; ?>" type="text" id="title" class="form-control" name="title" value="<?php echo $ad_title; ?>">

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group group-category">
                                                        <label class="form-label noselect" for="category"><?php echo $LANG['label-ad-category']; ?></label>
                                                        <select id="category" class="form-control" name="categoryId">
                                                            <option <?php if ($ad_category == 0) echo "selected disabled"; ?> value="0"><?php echo $LANG['label-category-choose']; ?></option>
                                                            <?php

                                                                $category = new category($dbo);
                                                                $category->setLanguage($LANG['lang-code']);
                                                                $categories = $category->getItems(0);

                                                                foreach ($categories['items'] as $key => $item) {

                                                                    ?>
                                                                    <option <?php if ($ad_category == $item['id']) echo "selected"; ?> value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                                                                    <?php
                                                                }

                                                            ?>
                                                        </select>

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                                <div id="subcategory-block" class="col-sm-12 col-md-6 col-lg-6 <?php if ($ad_category == 0) echo 'hidden' ?>">
                                                    <div class="form-group group-subcategory">
                                                        <label class="form-label noselect" for="subcategory"><?php echo $LANG['label-ad-subcategory']; ?></label>
                                                        <select id="subcategory" class="form-control" name="subcategoryId">
                                                            <option selected disabled value="0"><?php echo $LANG['label-subcategory-choose']; ?></option>

                                                            <?php

                                                                if ($ad_category != 0) {

                                                                    $category = new category($dbo);
                                                                    $category->setLanguage($LANG['lang-code']);
                                                                    $result = $subcategories = $category->getItems($ad_category);
                                                                    unset($category);

                                                                    foreach ($subcategories['items'] as $key => $item) {

                                                                        ?>
                                                                        <option <?php if ($ad_subcategory == $item['id']) echo 'selected'; ?> value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>

                                                        </select>

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                                <div class=" col-sm-12">

                                                    <div class="row">

                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group group-currency">
                                                            <label class="form-label noselect" for="currency"><?php echo $LANG['label-ad-currency']; ?></label>
                                                            <select id="currency" class="form-control" name="currency">
                                                                <?php

                                                                    array_unshift($CURRENCY_ARRAY, array(
                                                                        "code" => "",
                                                                        "name" => $LANG['label-currency-negotiable'],
                                                                        "symbol" => ""
                                                                    ));

                                                                    array_unshift($CURRENCY_ARRAY, array(
                                                                        "code" => "",
                                                                        "name" => $LANG['label-currency-free'],
                                                                        "symbol" => ""
                                                                    ));

                                                                    array_unshift($CURRENCY_ARRAY, array(
                                                                        "code" => "",
                                                                        "name" => $LANG['label-currency-choose'],
                                                                        "symbol" => ""
                                                                    ));

                                                                    for ($i = 0; $i < count($CURRENCY_ARRAY); $i++) {

                                                                        $currency_string = $CURRENCY_ARRAY[$i]['name'];

                                                                        if (strlen($CURRENCY_ARRAY[$i]['code']) != 0) {

                                                                            $currency_string = $CURRENCY_ARRAY[$i]['code']." (".$CURRENCY_ARRAY[$i]['name'].")";
                                                                        }

                                                                        ?>
                                                                            <option <?php if ($i == $ad_currency) echo "selected"; ?> <?php if ($i == 0) echo "disabled"; ?> value="<?php echo $i; ?>"><?php echo $currency_string; ?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>

                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-3 col-lg-3 price-container" style="<?php if ($ad_currency < 3) echo "display: none"; ?>">
                                                        <div class="form-group group-price">
                                                            <label class="form-label noselect" for="price"><?php echo $LANG['label-ad-price']; ?> <small>(<?php echo $LANG['label-ad-sub-price']; ?>)</small></label>
                                                            <input type="number" id="price" min="1" class="form-control" name="price" value="<?php echo $ad_price; ?>">

                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    </div>

                                                </div>

                                                <?php

                                                    if (strlen($ad_description) != 0) $ad_description = preg_replace("/<br>/", "\n", $ad_description);
                                                ?>

                                                <div class="col-sm-12">
                                                    <div class="form-group group-description">
                                                        <label class="form-label noselect" for="description"><?php echo $LANG['label-ad-description']; ?> <small>(<?php echo $LANG['label-ad-sub-description']; ?>)</small></label>
                                                        <textarea maxlength="500" placeholder="<?php echo $LANG['placeholder-ad-description']; ?>" style="min-height: 100px;" id="description" class="form-control" name="description"><?php echo $ad_description; ?></textarea>

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group group-images">
                                                        <label class="form-label noselect"><i class="ad-images fa fa-image"></i> <?php echo $LANG['label-ad-photos']; ?> <small>(<?php echo $LANG['label-ad-sub-photos']; ?>)</label>

                                                        <div class="error-summary alert alert-danger mt-2 file-error-alert" style="display: none"><ul></ul></div>

                                                        <div class="upload-kit">
                                                            <ul class="files">
                                                                <?php

                                                                    $index = 0;

                                                                    if (count($ad_photos) != 0) {

                                                                        for ($i = 0; $i < (max(array_keys($ad_photos))) + 1; $i++) {

                                                                            if (isset($ad_photos[$i]["name"])) {

                                                                                if (file_exists(TEMP_PATH.$ad_photos[$i]["name"]) || isset($ad_photos[$i]["uploaded"])) {

                                                                                    ?>
                                                                                        <li class="upload-kit-item done image <?php if (isset($ad_photos[$i]["uploaded"])) echo 'uploaded'; ?>">
                                                                                            <img src="<?php if (isset($ad_photos[$i]["uploaded"])) {echo $ad_photos[$i]["name"];} else {echo "/".TEMP_PATH.$ad_photos[$i]["name"];}; ?>">
                                                                                            <input name="images[<?php echo $index; ?>][name]" value="<?php echo $ad_photos[$i]["name"]; ?>" type="hidden">
                                                                                            <input name="images[<?php echo $index; ?>][size]" value="<?php echo $ad_photos[$i]["size"]; ?>" type="hidden">
                                                                                            <input name="images[<?php echo $index; ?>][type]" value="<?php echo $ad_photos[$i]["type"]; ?>" type="hidden">
                                                                                            <input name="images[<?php echo $index; ?>][uploaded]" value="<?php echo $ad_photos[$i]["uploaded"]; ?>" type="hidden">
                                                                                            <span class="fa fa-trash remove" file-name="/<?php if (isset($ad_photos[$i]["uploaded"])) {echo $ad_photos[$i]["name"];} else {echo TEMP_PATH.$ad_photos[$i]["name"];}; ?>" authenticity-token="<?php echo auth::getAuthenticityToken(); ?>"></span>
                                                                                        </li>
                                                                                    <?php

                                                                                    $index++;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                            </ul>
    <!--                                                        <div class="">-->
                                                                <input type="file" id="photo-upload" name="images-upload-input" multiple="multiple">
    <!--                                                        </div>-->
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group group-phone">
                                                        <label class="form-label noselect" for="phone"><i class="ad-phone fa fa-phone"></i> <?php echo $LANG['label-ad-phone']; ?> <small>(<?php echo $LANG['label-ad-sub-phone']; ?>)</label>
                                                        <input maxlength="20" placeholder="<?php echo $LANG['placeholder-ad-phone']; ?>" type="text" id="phone" class="form-control" name="phoneNumber" value="<?php echo $ad_phone_number; ?>">

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group group-location">
                                                        <label class="form-label noselect" for="map"><i class="ad-location fa fa-map-marked"></i> <?php echo $LANG['label-ad-location']; ?> <small>(<?php echo $LANG['label-ad-sub-location']; ?>)</small></label>

                                                        <div id="map" style="height: 250px;"></div>

                                                        <p class="mt-1" id="location">&nbsp;</p>

                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group form-actions text-right">
                                                    <?php

                                                        if (!$edit_mode) {

                                                            ?>
                                                                <button type="submit" class="btn btn-primary loading-more-button">
                                                                    <div class="btn-loader hidden rounded loading-more-progress d-inline mr-4 ml-1"></div>
                                                                    <span class="d-sm-inline"><?php echo $LANG['action-new-ad']; ?></span>
                                                                </button>
                                                            <?php

                                                        } else {

                                                            ?>
                                                                <a id="cancel-button" href="/item/<?php echo $itemInfo['id']; ?>" class="btn btn-secondary mr-1">
                                                                    <span class="d-sm-inline"><?php echo $LANG['action-cancel']; ?></span>
                                                                </a>

                                                                <button type="submit" class="btn btn-primary loading-more-button">
                                                                    <div class="btn-loader hidden rounded loading-more-progress d-inline mr-4 ml-1"></div>
                                                                    <span class="d-sm-inline"><?php echo $LANG['action-save']; ?></span>
                                                                </button>
                                                            <?php
                                                        }

                                                    ?>
                                                </div>
                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div> <!-- end mx-auto -->

                        </div> <!-- row -->
                    </div> <!-- end page-content -->

                </div> <!-- End container -->
            </div> <!-- End  -->

        </div> <!-- End page main-->


        <?php

            include_once("common/footer.inc.php");
        ?>

    </div> <!-- End page -->


        <script src="/js/load-image.all.min.js"></script>
        <script src="/js/jquery.ui.widget.js"></script>
        <script src="/js/jquery.iframe-transport.js"></script>
        <script src="/js/jquery.fileupload.js"></script>
        <script src="/js/jquery.fileupload-process.js"></script>
        <script src="/js/jquery.fileupload-image.js"></script>
        <script src="/js/jquery.fileupload-validate.js"></script>

        <script src="/js/geo.js"></script>

    <script>

        var latitude = <?php echo $ad_lat; ?>;
        var longitude = <?php echo $ad_lng; ?>;

        // Initialize and add the map

        function initializeMap() {

            initMap();
        }

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&language=en&callback=initializeMap"></script>

    <script type="text/javascript">

            var strings = {

                szTitleError: "<?php echo $LANG['msg-error-ad-title']; ?>",
                szCategoryError: "<?php echo $LANG['msg-error-ad-category']; ?>",
                szSubcategoryError: "<?php echo $LANG['msg-error-ad-subcategory']; ?>",
                szCurrencyError: "<?php echo $LANG['msg-error-ad-currency']; ?>",
                szPriceError: "<?php echo $LANG['msg-error-ad-price']; ?>",
                szDescriptionError: "<?php echo $LANG['msg-error-ad-description']; ?>",
                szPhotosError: "<?php echo $LANG['msg-error-ad-photos']; ?>",
                szPhoneError: "<?php echo $LANG['msg-error-ad-phone']; ?>",
                szPhoneIncorrect: "<?php echo $LANG['msg-error-ad-phone-incorrect']; ?>",
                szTitleLengthError: "<?php echo $LANG['msg-error-ad-length-title']; ?>",
                szDescriptionLengthError: "<?php echo $LANG['msg-error-ad-length-description']; ?>",
                szFilesLimitError: "<?php echo $LANG['msg-photo-file-upload-limit']; ?>",
                szFileSizeError: "<?php echo $LANG['msg-photo-file-size-error']; ?>",
                szLocationError: "<?php echo $LANG['msg-selected-location-error']; ?>"
            };

            jQuery(function ($) {

                $("form#form-new").submit(function(e) {

                    // Check title

                    var title = jQuery.trim($('#title').val());

                    if (title.length > 0) {

                        if (title.length < 5) {

                            $("input#title").focus();

                            $('div.group-title').addClass('has-error');
                            $('div.group-title').find('div.help-block').text(strings.szTitleLengthError);

                            return false;

                        } else {

                            $('div.group-title').removeClass('has-error');
                            $('div.group-title').find('div.help-block').text('');
                        }

                    } else {

                        $("input#title").focus();

                        $('div.group-title').addClass('has-error');
                        $('div.group-title').find('div.help-block').text(strings.szTitleError);

                        return false;
                    }

                    // Check category

                    if ($('select[name=categoryId]').val() == 0 || $('select[name=categoryId]').val() == null) {

                        $("select#category").focus();

                        $('div.group-category').addClass('has-error');
                        $('div.group-category').find('div.help-block').html(strings.szCategoryError);

                        return false;

                    } else {

                        $('div.group-category').removeClass('has-error');
                        $('div.group-category').find('div.help-block').html('');
                    }

                    // Check subcategory

                    if ($('select[name=subcategoryId]').val() == 0 || $('select[name=subcategoryId]').val() == null) {

                        $("select#subcategory").focus();

                        $('div.group-subcategory').addClass('has-error');
                        $('div.group-subcategory').find('div.help-block').html(strings.szSubcategoryError);

                        return false;

                    } else {

                        $('div.group-subcategory').removeClass('has-error');
                        $('div.group-subcategory').find('div.help-block').html('');
                    }

                    // Check currency

                    if ($('select[name=currency]').val() == 0 || $('select[name=currency]').val() == null) {

                        $("select#currency").focus();

                        $('div.group-currency').addClass('has-error');
                        $('div.group-currency').find('div.help-block').html(strings.szCurrencyError);

                        return false;

                    } else {

                        $('div.group-currency').removeClass('has-error');
                        $('div.group-currency').find('div.help-block').html('');
                    }

                    // Check price

                    if ($('select[name=currency]').val() > 2) {

                        $('div.price-container').css("display", "");

                        if ($("#price").val() > 0) {

                            $('div.group-price').removeClass('has-error');
                            $('div.group-price').find('div.help-block').html('');

                        } else {

                            $("#price").focus();

                            $('div.group-price').addClass('has-error');
                            $('div.group-price').find('div.help-block').html(strings.szPriceError);

                            return false
                        }
                    }

                    // Check description

                    var description = jQuery.trim($('#description').val());

                    if (description.length > 0) {

                        if (description.length < 10) {

                            $("#description").focus();

                            $('div.group-description').addClass('has-error');
                            $('div.group-description').find('div.help-block').text(strings.szDescriptionLengthError);

                            return false;

                        } else {

                            $('div.group-description').removeClass('has-error');
                            $('div.group-description').find('div.help-block').text('');
                        }

                    } else {

                        $("#description").focus();

                        $('div.group-description').addClass('has-error');
                        $('div.group-description').find('div.help-block').html(strings.szDescriptionError);

                        return false;
                    }

                    // Check images

                    if ($('li.upload-kit-item').length == 0) {

                        $('div.group-images').find('div.alert').text(strings.szPhotosError).css('display', '');

                        return false;

                    } else {

                        $('div.group-images').find('div.alert').text('').css('display', 'none');
                    }

                    // Check phone number

                    var phone_number = jQuery.trim($('#phone').val());

                    if (phone_number.length > 0) {

                        var phoneNumberPattern = /^\+?(?:[0-9] ?){4,14}[0-9]$/;

                        if (phoneNumberPattern.test(phone_number)) {

                            $('div.group-phone').removeClass('has-error');
                            $('div.group-phone').find('div.help-block').html('');

                        } else {

                            $("#phone").focus();

                            $('div.group-phone').addClass('has-error');
                            $('div.group-phone').find('div.help-block').html(strings.szPhoneIncorrect);
                        }

                    } else {

                        $("#phone").focus();

                        $('div.group-phone').addClass('has-error');
                        $('div.group-phone').find('div.help-block').html(strings.szPhoneError);

                        return false;
                    }

                    // Send data to server

                    $('.loading-more-button').attr('disabled', 'disabled');
                    $('.loading-more-progress').removeClass('hidden')
                    $('.ajax-loader').removeClass('hidden');

                    $('input[name=ajax]').val(1);

                    var form = $('#form-new');

                    $.ajax( {
                        type: "POST",
                        url: form.attr('action'),
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(response) {

                            $('.loading-more-button').removeAttr('disabled');
                            $('.loading-more-progress').addClass('hidden')
                            $('.ajax-loader').addClass('hidden');

                            if (response.hasOwnProperty('itemId')) {

                                $('#see-item-button').attr('href', $('#see-item-button').attr('href') + response.itemId);

                            } else {

                                $('#see-item-button').addClass('hidden');
                            }

                            $('form#form-new').remove();
                            $('div.promo-container').removeClass('hidden');
                        },
                        error: function(xhr, status, error) {

                            $('.loading-more-button').removeAttr('disabled')
                            $('.loading-more-progress').addClass('hidden')
                            $('.ajax-loader').addClass('hidden');
                        }
                    } );

                    return false;

                });

                $('#title').on('input',function(e){

                    var title = jQuery.trim($('#title').val());

                    if (title.length > 0) {

                        $('div.group-title').removeClass('has-error');
                        $('div.group-title').find('div.help-block').html('');

                    } else {

                        $('div.group-title').addClass('has-error');
                        $('div.group-title').find('div.help-block').html(strings.szTitleError);
                    }
                });

                $('#currency').on('change', function() {

                    $('div.group-price').removeClass('has-error');
                    $('div.group-price').find('div.help-block').html('');

                    if (this.value > 2) {

                        $('div.price-container').css("display", "");

                        $('div.group-currency').removeClass('has-error');
                        $('div.group-currency').find('div.help-block').html('');

                    } else {

                        if (this.value == 0) {

                            $('div.group-currency').addClass('has-error');
                            $('div.group-currency').find('div.help-block').html(strings.szCurrencyError);

                        } else {

                            $('div.group-currency').removeClass('has-error');
                            $('div.group-currency').find('div.help-block').html('');
                        }

                        $('div.price-container').css("display", "none");
                    }
                });

                $('select#category').on('change', function() {

                    if (this.value > 0) {

                        $('div.group-category').removeClass('has-error');
                        $('div.group-category').find('div.help-block').html('');

                    } else {

                        $('div.group-category').addClass('has-error');
                        $('div.group-category').find('div.help-block').html(strings.szCategoryError);
                    }

                    $.ajax( {
                        type: "GET",
                        url: "/item/new",
                        data: "get_subcategories=get&categoryId=" + this.value,
                        dataType: 'json',
                        success: function(response) {

                            if (response.hasOwnProperty("html")) {

                                $("div#subcategory-block").removeClass('hidden');
                                $('select#subcategory').html(response.html);
                            }
                        },
                        error: function(xhr, status, error) {

                            $("div#subcategory-block").removeClass('hidden');
                            $('select#subcategory').html("<option selected value=\"0\">Other</option>");
                        }
                    });
                });

                // subcategory change

                $('select#subcategory').on('change', function() {

                    if (this.value > 0) {

                        $('div.group-subcategory').removeClass('has-error');
                        $('div.group-subcategory').find('div.help-block').html('');

                    } else {

                        $('div.group-subcategory').addClass('has-error');
                        $('div.group-subcategory').find('div.help-block').html(strings.szSubcategoryError);
                    }
                });

                // phone number

                $('#phone').on('input',function(e){

                    var phone_number = jQuery.trim($('#phone').val());

                    if (phone_number.length > 0) {

                        var phoneNumberPattern = /^\+?(?:[0-9] ?){4,14}[0-9]$/;

                        if (phoneNumberPattern.test(phone_number)) {

                            $('div.group-phone').removeClass('has-error');
                            $('div.group-phone').find('div.help-block').html('');

                        } else {

                            $('div.group-phone').addClass('has-error');
                            $('div.group-phone').find('div.help-block').html(strings.szPhoneIncorrect);
                        }

                    } else {

                        $('div.group-phone').addClass('has-error');
                        $('div.group-phone').find('div.help-block').html(strings.szPhoneError);
                    }
                });

                window.Photos || ( window.Photos = {} );

                Photos.index = 0;
                Photos.authenticity_token = "<?php echo auth::getAuthenticityToken(); ?>";
                Photos.file_input = $('#photo-upload');
                Photos.files_container = null;

                Photos.init = function() {

                    Photos.files_container = $('<ul>', {"class":"files"}).insertBefore(Photos.file_input);

                    Photos.file_input.attr('multiple', true);
                    Photos.file_input.attr('name', Photos.file_input.attr('name') + '[]');

                    Photos.file_input.parent('div').addClass('upload-kit');

                    Photos.file_input.wrapAll($('<li class="upload-kit-input"></div>'))
                        .after($('<span class="fa fa-plus-circle add"></span>'))
                        .after($('<span class="fa fa-arrow-alt-circle-down drag"></span>'))
                        .after($('<span/>', {"data-toggle":"popover", "class":"fa fa-info-circle error-popover"}))
                        .after(
                        '<div class="progress">'+
                        '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
                        '</li>'
                    );

                    Photos.index = Photos.getNumberOfFiles();
                    Photos.checkVisibility();
                };

                Photos.createItem = function(file, file_name, authenticity_token) {

                    var name = "images";
                    var index = Photos.index;

                    name += '[' + index + ']';

                    var item = $('<li>', {"class": "upload-kit-item done"})
                        .append($('<input/>', {"name": name + '[name]', "value": file_name.split('/').reverse()[0], "type":"hidden"}))
                        .append($('<input/>', {"name": name + '[size]', "value": file.size, "type":"hidden"}))
                        .append($('<input/>', {"name": name + '[type]', "value": file.type, "type":"hidden"}))
                        .append($('<span/>', {"class": "fa fa-trash remove", "file-name": file_name, "authenticity-token": authenticity_token}));

                    $('div.file-error-alert').css("display", 'none').find('ul').text('');

                    if ((!file.type || file.type.search(/image\/.*/g) !== -1)) {

                        item.removeClass('not-image').addClass('image');
                        item.prepend($('<img/>', {src: file_name}));
                        item.find('span.type').text('');

                    } else {

                        item.removeClass('image').addClass('not-image');
                        item.css('backgroundImage', '');
                        item.find('span.name').text(file.name);
                    }

                    Photos.index++;

                    return item;
                }

                Photos.getNumberOfFiles = function () {

                    return $('div.upload-kit').find('.upload-kit-item').length;
                };

                Photos.checkVisibility = function () {

                    var inputContainer = $('div.upload-kit').find('.upload-kit-input');

                    if (Photos.getNumberOfFiles() >= 5) {

                        inputContainer.hide();

                    } else {

                        inputContainer.show();
                    }
                };

                $(document).on('click', '.upload-kit-item .remove', function(){

                    var $this =  $(this);

                    if ($this.parent('li').hasClass('uploaded')) {

                        $this.parents('.upload-kit-item').remove();
                        Photos.checkVisibility();

                        return;
                    }

                    var url = $this.attr('file-name');

                    var file_name = url.split('/').pop().split('#')[0].split('?')[0];

                    var authenticity_token = $this.attr('authenticity-token');

                    $.ajax({
                        type: 'POST',
                        url: "/item/photos_upload",
                        data: 'action=delete' + '&authenticity_token=' + authenticity_token + "&file_name=" + file_name,
                        dataType: 'json',
                        timeout: 30000,
                        success: function(response){

                            $this.parents('.upload-kit-item').remove();

                            Photos.checkVisibility();
                        },
                        error: function(xhr, status, error) {

                            // error
                        }
                    });
                });

                $(document).on('dragover', function () {

                    $('.upload-kit-input').addClass('drag-highlight');
                });

                $(document).on('dragleave drop', function () {

                    $('.upload-kit-input').removeClass('drag-highlight');
                });



                Photos.file_input.fileupload({
                    formData: {authenticity_token: Photos.authenticity_token},
                    name: 'images',
                    url: "/item/photos_upload",
                    dropZone:  Photos.file_input.parents('.upload-kit-input'),
                    dataType: 'json',
                    singleFileUploads: false,
                    multiple: true,
                    maxNumberOfFiles: 5,
                    maxFileSize: 3145728,
                    acceptFileTypes: "", // or regex: /(jpeg)|(jpg)|(png)$/i
                    "files":null,
                    minFileSize: null,
                    messages: {
                        "maxNumberOfFiles":"Maximum number of files exceeded",
                        "acceptFileTypes":"File type not allowed",
                        "maxFileSize":"File is too large",
                        "minFileSize":"File is too small"},
                    process: true,
                    getNumberOfFiles: Photos.getNumberOfFiles,
                    start: function (e, data) {

                        $("li.upload-kit-input").removeClass('error').addClass('in-progress');

                        Photos.file_input.parent('div').find('.upload-kit-input').removeClass('error').addClass('in-progress');
                        Photos.file_input.trigger('start');

//                        if (options.start !== undefined) options.start(e, data);
                    },
                    processfail: function(e, data) {

                        if (data.files.length > (5 - Photos.getNumberOfFiles())) {

                            $('div.file-error-alert').css("display", "none").find('ul').html('');
                            $('<li>').html(strings.szFilesLimitError).appendTo($('div.file-error-alert').find('ul'));
                            $('div.file-error-alert').css("display", "");

                        } else {

                            $('div.file-error-alert').css("display", "none").find('ul').html('');
                            $('<li>').html(strings.szFileSizeError).appendTo($('div.file-error-alert').find('ul'));
                            $('div.file-error-alert').css("display", "");
                        }
                    },
                    progressall: function (e, data) {

                        var progress = parseInt(data.loaded / data.total * 100, 10);

                        $('li.upload-kit-input').find('.progress-bar').attr('aria-valuenow', progress).css('width', progress + '%').text(progress + '%');
                    },
                    done: function (e, data) {

                        var result = jQuery.parseJSON(data.jqXHR.responseText);

                        var items = result.items;

                        for (var i = 0; i < items.length; i++) {

                            if (Photos.getNumberOfFiles() < 5) {

                                if (items[i].error) {

                                    $('<li>').html("<strong>" + data.files[i].name + "</strong> - " + items[i].error_description).appendTo($('div.file-error-alert').find('ul'));
                                    $('div.file-error-alert').css("display", "");

                                } else {

                                    var item = Photos.createItem(data.files[i], items[i].file_name, Photos.authenticity_token);
                                    item.appendTo(Photos.files_container);
                                }
                            }
                        }

                        Photos.checkVisibility();
                        Photos.file_input.trigger('done');
                    },
                    fail: function (e, data) {

                         console.log("fail");
                    },
                    always: function (e, data) {

                        $('li.upload-kit-input').removeClass('in-progress');
                        Photos.file_input.trigger('always');
                    }

                });


                Photos.init();

        });
    </script>

</body>
</html>
