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

class conversations extends db_connect
{
	private $requestFrom = 0;
	private $itemsInRequest = 20;

    private $language = 'en';

    private $itemsType = array();

	private $tableName = "chats";

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);

	}

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

        $sortTypeSql = " ORDER BY messageCreateAt DESC";

		$sql = "SELECT * FROM $this->tableName WHERE (fromUserId = $this->requestFrom OR toUserId = $this->requestFrom) AND removeAt = 0".$sortTypeSql.$limitSql;

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

                    $time = new language($this->db, $this->language);

                    // chat opponent
                    $profileId = $row['fromUserId'];

                    if ($profileId == $this->getRequestFrom()) {

                        $profileId = $row['toUserId'];
                    }

                    $profile = new profile($this->db, $profileId);
                    $profile->setRequestFrom($this->getRequestFrom());
                    $profileInfo = $profile->getVeryShort();
                    unset($profile);

                    $new_messages_count = 0;
                    $read_new_messages_count = false;

                    if ($this->getRequestFrom() == $row['fromUserId']) {

                        if ($row['messageCreateAt'] > $row['fromUserId_lastView']) {

                            $read_new_messages_count = true;
                        }

                    } else {

                        if ($row['messageCreateAt'] > $row['toUserId_lastView']) {

                            $read_new_messages_count = true;
                        }
                    }

                    if (APP_MESSAGES_COUNTERS && $read_new_messages_count) {

                        $msg = new msg($this->db);
                        $msg->setRequestFrom($this->getRequestFrom());

                        $new_messages_count = $msg->getNewMessagesInChat($row['id'], $row['fromUserId'], $row['fromUserId_lastView'], $row['toUserId_lastView']);
                    }

                    $itemInfo = array(
                        "error" => false,
                        "error_code" => ERROR_SUCCESS,
                        "id" => $row['id'],
                        "fromUserId" => $row['fromUserId'],
                        "toUserId" => $row['toUserId'],
                        "itemTitle" => $row['itemTitle'],
                        "toItemId" => $row['toItemId'],
                        "fromUserId_lastView" => $row['fromUserId_lastView'],
                        "toUserId_lastView" => $row['toUserId_lastView'],
                        "withUserId" => $profileInfo['id'],
                        "withUserVerify" => $profileInfo['verify'],
                        "withUserVerified" => $profileInfo['verified'],
                        "withUserOnline" => $profileInfo['online'],
                        "withUserState" => $profileInfo['state'],
                        "withUserUsername" => $profileInfo['username'],
                        "withUserFullname" => $profileInfo['fullname'],
                        "withUserPhotoUrl" => $profileInfo['lowThumbnailUrl'],
                        "lastMessage" => $row['message'],
                        "lastMessageAgo" => $time->timeAgo($row['messageCreateAt']),
                        "lastMessageCreateAt" => $row['messageCreateAt'],
                        "newMessagesCount" => $new_messages_count,
                        "createAt" => $row['createAt'],
                        "date" => date("Y-m-d H:i:s", $row['createAt']),
                        "timeAgo" => $time->timeAgo($row['createAt']),
                        "removeAt" => $row['removeAt']);

                    unset($profileInfo);

					array_push($result['items'], $itemInfo);
				}
			}
		}

		return $result;
	}

	public function getItemsCount()
	{
		$sql = "SELECT count(*) FROM $this->tableName WHERE (fromUserId = $this->requestFrom OR toUserId = $this->requestFrom) AND removeAt = 0";
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

