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

class profile extends db_connect
{
    private $language = 'en';

    private $id = 0;
    private $requestFrom = 0;

    public function __construct($dbo = NULL, $profileId)
    {
        parent::__construct($dbo);

        $this->setId($profileId);
    }

    // Get profile - with calculations (check blacklists)

    public function get()
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_ACCOUNT_ID);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = (:id) LIMIT 1");
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $result = $this->quickInfo($row);

                // test to blocked
                $blocked = false;

                if ($this->getRequestFrom() != 0 && $this->getRequestFrom() != $this->getId()) {

                    $blacklist = new blacklist($this->db);
                    $blacklist->setRequestFrom($this->getRequestFrom());

                    if ($blacklist->isExists($this->getId())) {

                        $blocked = true;
                    }

                    unset($blacklist);
                }

                // is my profile exists in blacklist
                $inBlackList = false;

                if ($this->getRequestFrom() != 0 && $this->getRequestFrom() != $this->getId()) {

                    $blacklist = new blacklist($this->db);
                    $blacklist->setRequestFrom($this->getId());

                    if ($blacklist->isExists($this->getRequestFrom())) {

                        $inBlackList = true;
                    }

                    unset($blacklist);
                }

                $result['blocked'] = $blocked;
                $result['inBlackList'] = $inBlackList;
            }
        }

        return $result;
    }

    // Get profile - without calculations

    public function getVeryShort()
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_ACCOUNT_ID);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = (:id) LIMIT 1");
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $result = $this->quickInfo($row);
            }
        }

        return $result;
    }

    // Get profile info to array

    public function quickInfo($row)
    {
        $time = new language($this->db, $this->language);

        $online = false;

        $current_time = time();

        if ($row['last_authorize'] != 0 && $row['last_authorize'] > ($current_time - 15 * 60)) {

            $online = true;
        }

        $inBlackList = false; // if $requestFrom is exists in $profileId (this->id) blacklist
        $blocked = false; // if $profileId (this->id) is exists in $requestFrom blacklist

        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "id" => $row['id'],
            "gcm_regid" => $row['gcm_regid'],
            "ios_fcm_regid" => $row['ios_fcm_regid'],
            "state" => $row['state'],
            "sex" => $row['sex'],
            "year" => $row['bYear'],
            "month" => $row['bMonth'],
            "day" => $row['bDay'],
            "phone" => $row['phone'],
            "username" => $row['login'],
            "fullname" => htmlspecialchars_decode(stripslashes($row['fullname'])),
            "location" => stripcslashes($row['country']),
            "status" => stripcslashes($row['status']),
            "bio" => stripcslashes($row['status']),
            "fb_page" => stripcslashes($row['fb_page']),
            "instagram_page" => stripcslashes($row['my_page']),
            "my_page" => stripcslashes($row['my_page']),
            "verify" => $row['verify'],
            "verified" => $row['verify'],
            "lat" => $row['lat'],
            "lng" => $row['lng'],
            "lowPhotoUrl" => $row['lowPhotoUrl'],
            "bigPhotoUrl" => $row['bigPhotoUrl'],
            "lowThumbnailUrl" => $row['lowPhotoUrl'],
            "bigThumbnailUrl" => $row['bigPhotoUrl'],
            "normalPhotoUrl" => $row['normalPhotoUrl'],
            "normalCoverUrl" => $row['normalCoverUrl'],
            "originCoverUrl" => $row['originCoverUrl'],
            "coverPosition" => $row['coverPosition'],
            "itemsCount" => $row['items_count'],
            "reviewsCount" => $row['reviews_count'],
            "commentsCount" => $row['comments_count'],
            "allowMessages" => $row['allowMessages'],
            "inBlackList" => $inBlackList,
            "blocked" => $blocked,
            "createAt" => $row['regtime'],
            "createDate" => date("Y-m-d", $row['regtime']),
            "lastAuthorize" => $row['last_authorize'],
            "lastAuthorizeDate" => date("Y-m-d H:i:s", $row['last_authorize']),
            "lastAuthorizeTimeAgo" => $time->timeAgo($row['last_authorize']),
            "online" => $online,
            "photoModerateAt" => $row['photoModerateAt'],
            "photoModerateUrl" => $row['photoModerateUrl'],
            "photoPostModerateAt" => $row['photoPostModerateAt'],
            "coverModerateAt" => $row['coverModerateAt'],
            "coverModerateUrl" => $row['coverModerateUrl'],
            "coverPostModerateAt" => $row['coverPostModerateAt']);

        if (strlen($row['lowPhotoUrl']) == 0) {

            $result['lowPhotoUrl'] = APP_URL.DEFAULT_PHOTO_IMG;
            $result['bigPhotoUrl'] = APP_URL.DEFAULT_PHOTO_IMG;
            $result['lowThumbnailUrl'] = APP_URL.DEFAULT_PHOTO_IMG;
            $result['bigThumbnailUrl'] = APP_URL.DEFAULT_PHOTO_IMG;
            $result['normalPhotoUrl'] = APP_URL.DEFAULT_PHOTO_IMG;
        }

        if (strlen($row['normalCoverUrl']) == 0) {

            $result['normalCoverUrl'] = APP_URL.DEFAULT_COVER_IMG;
            $result['originCoverUrl'] = APP_URL.DEFAULT_COVER_IMG;
        }

        return $result;
    }

    public function setId($profileId)
    {
        $this->id = $profileId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setRequestFrom($requestFrom)
    {
        $this->requestFrom = $requestFrom;
    }

    public function getRequestFrom()
    {
        return $this->requestFrom;
    }
}

