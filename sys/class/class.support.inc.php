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

class support extends db_connect
{
	private $requestFrom = 0;
    private $itemsInRequest = 20;
    private $tableName = "support";

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

    public function count()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM support WHERE removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Add item

    public function add($appType, $accountId, $email, $subject, $text)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $currentTime = time();
        $ip_addr = helper::ip_addr();
        $u_agent = helper::u_agent();

        $stmt = $this->db->prepare("INSERT INTO support (appType, accountId, email, subject, text, createAt, ip_addr, u_agent) value (:appType, :accountId, :email, :subject, :text, :createAt, :ip_addr, :u_agent)");
        $stmt->bindParam(":appType", $appType, PDO::PARAM_INT);
        $stmt->bindParam(":accountId", $accountId, PDO::PARAM_INT);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":subject", $subject, PDO::PARAM_STR);
        $stmt->bindParam(":text", $text, PDO::PARAM_STR);
        $stmt->bindParam(":createAt", $currentTime, PDO::PARAM_INT);
        $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);
        $stmt->bindParam(":u_agent", $u_agent, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    // Delete item

    public function delete($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE support SET removeAt = (:removeAt) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    // Get items list

    public function getItems($pageId = 0)
    {
        $itemsCount = 0;

        if ($pageId == 0) $itemsCount = $this->getItemsCount();

        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "pageId" => $pageId,
            "itemsCount" => $itemsCount,
            "items" => array());

        if ($pageId == 0) {

            $limitSql = " LIMIT 0, {$this->itemsInRequest}";

        } else {

            $offset = $pageId * $this->itemsInRequest;
            $count  = $this->itemsInRequest;

            $limitSql = " LIMIT {$offset}, {$count}";
        }

        $sql = "SELECT * FROM $this->tableName WHERE removeAt = 0 ORDER BY id DESC $limitSql";

        $stmt = $this->db->prepare($sql);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                while ($row = $stmt->fetch()) {

                    array_push($result['items'], $this->quickInfo($row));
                }
            }
        }

        return $result;
    }

    // Get items count

    public function getItemsCount()
    {
        $sql = "SELECT count(*) FROM $this->tableName WHERE removeAt = 0";
        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Get item info

    public function quickInfo($row)
    {
        $time = new language($this->db, "en");

        $profileInfo = array(
            "username" => "",
            "fullname" => "",
            "lowThumbnailUrl" => "/img/profile_default_photo.png",
            "online" => false,
            "verified" => false,
            "location" => "");

        if ($row['accountId'] != 0) {

            $profile = new profile($this->db, $row['accountId']);
            $profileInfo = $profile->getVeryShort();
            unset($profile);
        }

        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "id" => $row['id'],
            "appType" => $row['appType'],
            "accountId" => $row['accountId'],
            "fromUserId" => $row['accountId'],
            "fromUserUsername" => $profileInfo['username'],
            "fromUserFullname" => $profileInfo['fullname'],
            "fromUserPhotoUrl" => $profileInfo['lowThumbnailUrl'],
            "fromUserOnline" => $profileInfo['online'],
            "fromUserVerified" => $profileInfo['verified'],
            "fromUserLocation" => $profileInfo['location'],
            "email" => $row['email'],
            "subject" => htmlspecialchars_decode(stripslashes($row['subject'])),
            "text" => htmlspecialchars_decode(stripslashes($row['text'])),
            "reply" => htmlspecialchars_decode(stripslashes($row['reply'])),
            "replyAt" => $row['replyAt'],
            "replyFrom" => $row['replyFrom'],
            "removeAt" => $row['removeAt'],
            "createAt" => $row['createAt'],
            "date" => date("Y-m-d H:i:s", $row['createAt']),
            "timeAgo" => $time->timeAgo($row['createAt']),
            "u_agent" => $row['u_agent'],
            "ip_addr" => $row['ip_addr']);

        return $result;
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

