<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    header("Content-type: application/json; charset=utf-8");

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

    if (!auth::isSession()) {

        header('Location: /');
        exit;
    }

    if (!empty($_POST)) {

        $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : '';
        $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

        $token = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $fileName = isset($_POST['file_name']) ? $_POST['file_name'] : '';

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN,
                        "items" => array());

        if (auth::getAuthenticityToken() !== $token) {

            echo json_encode($result);
            exit;
        }

        if ($action === "delete") {

            if (file_exists(TEMP_PATH.$fileName) && $fileName !== "index.php") {

                $result['error'] = false;

                unlink(TEMP_PATH.$fileName);
            }

            echo json_encode($result);
            exit;
        }

        if (!empty($_FILES)) {

            if (count($_FILES['images-upload-input']['name']) > 0) {


            }

            for ($i = 0; $i < count($_FILES['images-upload-input']['name']); $i++) {

                $error = false;
                $error_code = ERROR_UNKNOWN;
                $error_description = "";

                if (!$error && $_FILES['images-upload-input']['size'][$i] > FILE_ITEM_MAX_SIZE) {

                    $error = true;
                    $error_code = ERROR_FILE_SIZE_BIG;
                    $error_description = $LANG['msg-photo-file-size-exceeded']; // Exceeded file size limit.
                }

                $imglib = new imglib($dbo);

                if (!$error && !$imglib->isImageFile($_FILES['images-upload-input']['tmp_name'][$i], false, false)) {

                    $error = true;
                    $error_code = ERROR_IMAGE_FILE_FORMAT;
                    $error_description = $LANG['msg-photo-format-error'];
                }

                if (!$error) {

                    if (!$imglib->isWidthHeight($_FILES['images-upload-input']['tmp_name'][$i], 300, 300)) {

                        $error = true;
                        $error_code = ERROR_IMAGE_FILE_WIDTH_HEIGHT;
                        $error_description = $LANG['msg-photo-width-height-error'];
                    }
                }

                $ext = pathinfo($_FILES['images-upload-input']['name'][$i], PATHINFO_EXTENSION);
                $new_file_name = TEMP_PATH.sha1_file($_FILES['images-upload-input']['tmp_name'][$i]).".".$ext;

                if (!$error) {

                    @move_uploaded_file($_FILES['images-upload-input']['tmp_name'][$i], $new_file_name);
                }

                $f_result = array("error" => $error, "error_description" => $error_description, "index" => $i, "file_name" => APP_URL."/".$new_file_name);

                array_push($result['items'], $f_result);
            }

            echo json_encode($result);
            exit;
        }
    }
