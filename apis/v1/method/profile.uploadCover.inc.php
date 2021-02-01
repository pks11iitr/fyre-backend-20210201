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

if (!empty($_POST)) {

	$accountId = isset($_POST['accountId']) ? $_POST['accountId'] : '';
	$accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

	$accountId = helper::clearInt($accountId);

	if (!$auth->authorize($accountId, $accessToken)) {

		api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
	}

	$result = array("error" => true,
					"error_code" => ERROR_UNKNOWN,
                    "error_description" => '');

	$error = false;
    $error_code = ERROR_UNKNOWN;
	$error_description = "";

	if (!empty($_FILES['uploaded_file']['name'])) {

		switch ($_FILES['uploaded_file']['error']) {

			case UPLOAD_ERR_OK:

				break;

			case UPLOAD_ERR_NO_FILE:

                $error = true;
                $error_code = ERROR_UNKNOWN;
                $error_description = 'No file sent.'; // No file sent.

				break;

			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:

				$error = true;
                $error_code = ERROR_FILE_SIZE_BIG;
                $error_description = $LANG['msg-photo-file-size-exceeded']; // Exceeded file size limit.

				break;

			default:

                $error = true;
                $error_code = ERROR_UNKNOWN;
                $error_description = 'Unknown error.'; // Unknown errors
		}

        if (!$error && $_FILES['uploaded_file']['size'] > FILE_COVER_MAX_SIZE) {

            $error = true;
            $error_code = ERROR_FILE_SIZE_BIG;
            $error_description = $LANG['msg-photo-file-size-exceeded']; // Exceeded file size limit.
        }

		$imglib = new imglib($dbo);
		$imglib->setRequestFrom($accountId);

		if (!$error && !$imglib->isImageFile($_FILES['uploaded_file']['tmp_name'], true, false)) {

			$error = true;
            $error_code = ERROR_IMAGE_FILE_FORMAT;
			$error_description = $LANG['msg-photo-format-error']; // Error file format
		}

		if (!$error) {

			if (!$imglib->isWidthHeight($_FILES['uploaded_file']['tmp_name'], 300, 300)) {

				$error = true;
                $error_code = ERROR_IMAGE_FILE_WIDTH_HEIGHT;
				$error_description = $LANG['msg-photo-width-height-error']; // Error width/height in image
			}
		}

		if (!$error) {

			$ext = pathinfo($_FILES['uploaded_file']['name'], PATHINFO_EXTENSION);
			$new_file_name = TEMP_PATH.sha1_file($_FILES['uploaded_file']['tmp_name']).".".$ext;

			if (@move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $new_file_name)) {

				if (file_exists($new_file_name)) {

					$response = $imglib->createCoverImg($new_file_name, true, true);

					if (!$response['error']) {

						$result = array("error" => false,
                                        "error_code" => ERROR_SUCCESS,
                                        "error_description" => '',
										"originCoverUrl" => $response['fileUrl'],
										"normalCoverUrl" => $response['fileUrl']);

						$account = new account($dbo, $accountId);
						$account->setCoverUrl($result);

                        $moderator = new moderator($dbo);
                        $moderator->postCover($accountId, $result['originCoverUrl']);
                        unset($moderator);
					}
				}
			}

		} else {

			$result['error'] = $error;
            $result['error_code'] = $error_code;
			$result['error_description'] = $error_description;
		}

		unset($imglib);
	}

	echo json_encode($result);
}
