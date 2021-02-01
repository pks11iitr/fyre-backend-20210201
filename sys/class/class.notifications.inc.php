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

class notifications extends db_connect
{
	private $requestFrom = 0;
	private $itemsInRequest = 20;

    private $language = 'en';

    private $itemsType = array();

	private $tableName = "notifications";

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);

	}

    // Create notification

    public function create($notifyToId, $notifyType, $itemId = 0)
    {
        $createAt = time();

        $stmt = $this->db->prepare("INSERT INTO notifications (notifyToId, notifyFromId, notifyType, itemId, createAt) value (:notifyToId, :notifyFromId, :notifyType, :itemId, :createAt)");
        $stmt->bindParam(":notifyToId", $notifyToId, PDO::PARAM_INT);
        $stmt->bindParam(":notifyFromId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->bindParam(":notifyType", $notifyType, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":createAt", $createAt, PDO::PARAM_INT);
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    // Clear all notifications

    public function clear()
    {
        $timeAt = time();

        $stmt = $this->db->prepare("UPDATE notifications SET removeAt = (:timeAt) WHERE notifyToId = (:notifyToId)");
        $stmt->bindParam(":timeAt", $timeAt, PDO::PARAM_INT);
        $stmt->bindParam(":notifyToId", $notifyToId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Delete notification by index (id)

    public function delete($notifyId)
    {
        $timeAt = time();

        $stmt = $this->db->prepare("UPDATE notifications SET removeAt = (:timeAt) WHERE id = (:notifyId)");
        $stmt->bindParam(":notifyId", $notifyId, PDO::PARAM_INT);
        $stmt->bindParam(":timeAt", $timeAt, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remove all notifications to itemId by itemType

    public function remove($notifyType, $itemId)
    {
        $timeAt = time();

        $stmt = $this->db->prepare("UPDATE notifications SET removeAt = (:timeAt) WHERE notifyType = (:notifyType) AND itemId = (:itemId)");
        $stmt->bindParam(":timeAt", $timeAt, PDO::PARAM_INT);
        $stmt->bindParam(":notifyType", $notifyType, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Extended function - remove all notifications to itemId by itemType, notifyTo and notifyFrom

    public function removeEx($notifyToId, $notifyType, $itemId)
    {
        $timeAt = time();

        $stmt = $this->db->prepare("UPDATE notifications SET removeAt = (:timeAt) WHERE notifyToId = (:notifyToId) AND notifyFromId = (:notifyFromId) AND notifyType = (:notifyType) AND itemId = (:itemId)");
        $stmt->bindParam(":timeAt", $timeAt, PDO::PARAM_INT);
        $stmt->bindParam(":notifyToId", $notifyToId, PDO::PARAM_INT);
        $stmt->bindParam(":notifyFromId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->bindParam(":notifyType", $notifyType, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Get new notifications count | Unread notifications

    public function getNewCount($lastNotifyView)
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM notifications WHERE notifyToId = (:notifyToId) AND createAt > (:lastNotifyView) AND removeAt = 0");
        $stmt->bindParam(":notifyToId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->bindParam(":lastNotifyView", $lastNotifyView, PDO::PARAM_INT);
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Get notifications list

    public function getItems($pageId = 0)
	{
		$itemsCount = 0;

		if ($pageId == 0) $itemsCount = $this->getItemsCount();

		$result = array("error" => false,
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

        $sortTypeSql = " ORDER BY id DESC";

		$sql = "SELECT * FROM $this->tableName WHERE removeAt = 0 and notifyToId = $this->requestFrom".$this->getItemsTypeSql().$sortTypeSql.$limitSql;

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

                    $time = new language($this->db, $this->language);

                    if ($row['notifyFromId'] == 0) {

                        $profileInfo = array("id" => 0,
                                             "state" => 0,
                                             "verified" => 1,
                                             "online" => true,
                                             "username" => "",
                                             "fullname" => "",
                                             "lowPhotoUrl" => APP_URL."/img/def_photo.png",
                                             "lowThumbnailUrl" => APP_URL."/img/def_photo.png");

                    } else {

                        $profile = new profile($this->db, $row['notifyFromId']);
                        $profileInfo = $profile->getVeryShort();
                        unset($profile);
                    }

                    $itemInfo = array("id" => $row['id'],
                                      "type" => $row['notifyType'],
                                      "itemType" => $row['notifyType'],
                                      "itemId" => $row['itemId'],
                                      "fromUserId" => $profileInfo['id'],
                                      "fromUserState" => $profileInfo['state'],
                                      "fromUserUsername" => $profileInfo['username'],
                                      "fromUserFullname" => $profileInfo['fullname'],
                                      "fromUserPhotoUrl" => $profileInfo['lowThumbnailUrl'],
                                      "fromUserOnline" => $profileInfo['online'],
                                      "fromUserVerified" => $profileInfo['verified'],
                                      "createAt" => $row['createAt'],
                                      "timeAgo" => $time->timeAgo($row['createAt']));

					array_push($result['items'], $itemInfo);
				}
			}
		}

		return $result;
	}

    // Get notifications count

	public function getItemsCount()
	{
		$sql = "SELECT count(*) FROM $this->tableName WHERE removeAt = 0 AND notifyToId = $this->requestFrom".$this->getItemsTypeSql();
		$stmt = $this->db->prepare($sql);

		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

    public function addItemsType($itemsType)
    {
        $this->itemsType[] = $itemsType;
    }

    public function getItemsType()
    {
        return $this->itemsType;
    }

    // Generate filters sql string

    public function getItemsTypeSql()
    {

        $itemsTypeSql = "";

        if (count($this->getItemsType()) > 0) {

            if (count($this->getItemsType()) == 1) {

                $itemsTypeSql = " AND notifyType = ".$this->getItemsType()[0];

            } else {

                $itemsTypeSql = " AND (notifyType = ".$this->getItemsType()[0]."";

                for ($i = 1; $i < count($this->getItemsType()); $i++) {

                    $itemsTypeSql = $itemsTypeSql." OR notifyType = ".$this->getItemsType()[$i];
                }

                $itemsTypeSql = $itemsTypeSql.")";
            }
        }

        return $itemsTypeSql;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setItemsInRequest($itemsInRequest)
    {
        $this->itemsInRequest = $itemsInRequest;
    }

    public function getItemsInRequest()
    {
        return $this->itemsInRequest;
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

