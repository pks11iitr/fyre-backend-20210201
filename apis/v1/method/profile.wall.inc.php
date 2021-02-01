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

    $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 0;
    $accessToken = isset($_POST['accessToken']) ? $_POST['accessToken'] : '';

    $profileId = isset($_POST['profileId']) ? $_POST['profileId'] : 0;
    $pageId = isset($_POST['pageId']) ? $_POST['pageId'] : 0;
    $moderationType = isset($_POST['moderationType']) ? $_POST['moderationType'] : 0;

    $profileId = helper::clearInt($profileId);
    $pageId = helper::clearInt($pageId);
    $moderationType = helper::clearInt($moderationType);

    $result = array(
        "error" => true,
        "error_code" => ERROR_UNKNOWN
    );

    $finder = new finder($dbo);
    $finder->setRequestFrom($accountId);
    $finder->addProfileIdFilter($profileId);

    if ($accountId == $profileId) $finder->setInactiveFilter(FILTER_ALL); // Show all (active and inactive) items

    if ($accountId != $profileId) {

        if ($moderationType != 0) $finder->setModerationFilter(FILTER_ONLY_YES); // Show only moderated items
    }

    $result = $finder->getItems("", $pageId);

    echo json_encode($result);
    exit;
}
