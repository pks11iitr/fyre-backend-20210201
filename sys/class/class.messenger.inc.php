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

class messenger extends db_connect
{
	private $requestFrom = 0;
	private $itemsInRequest = 20;

    private $language = 'en';

    private $chatId = 0;

	private $tableName = "messages";

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

        $sortTypeSql = " ORDER BY id DESC";

        $chatSql = "";

        if ($this->chatId != 0) {

            $chatSql = "chatId = $this->chatId AND ";
        }

		$sql = "SELECT * FROM $this->tableName WHERE ".$chatSql."removeAt = 0".$sortTypeSql.$limitSql;

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

                    $time = new language($this->db, $this->language);

                    $profileInfo = array(
                        "id" => $row['fromUserId'],
                        "state" => 0,
                        "verified" => 0,
                        "online" => false,
                        "username" => "",
                        "fullname" => "",
                        "lowPhotoUrl" => "");

                    $itemInfo = array("error" => false,
                        "error_code" => ERROR_SUCCESS,
                        "id" => $row['id'],
                        "fromUserId" => $profileInfo['id'],
                        "fromUserState" => $profileInfo['state'],
                        "fromUserOnline" => $profileInfo['online'],
                        "fromUserVerify" => $profileInfo['verified'],
                        "fromUserVerified" => $profileInfo['verified'],
                        "fromUserUsername" => $profileInfo['username'],
                        "fromUserFullname" => $profileInfo['fullname'],
                        "fromUserPhotoUrl" => $profileInfo['lowPhotoUrl'],
                        "message" => htmlspecialchars_decode(stripslashes($row['message'])),
                        "imgUrl" => $row['imgUrl'],
                        "seenAt" => 0,
                        "createAt" => $row['createAt'],
                        "date" => date("Y-m-d H:i:s", $row['createAt']),
                        "timeAgo" => $time->timeAgo($row['createAt']),
                        "removeAt" => $row['removeAt']);

                    array_push($result['items'], $itemInfo);

                    unset($itemInfo);
                    unset($profileInfo);
				}
			}
		}

		return $result;
	}

	public function getItemsCount()
	{
        $chatSql = "";

        if ($this->chatId != 0) {

            $chatSql = "chatId = $this->chatId AND ";
        }

		$sql = "SELECT count(*) FROM $this->tableName WHERE ".$chatSql."removeAt = 0";
		$stmt = $this->db->prepare($sql);

		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

    public function getNewItems($itemId = 0)
    {
        $result = array("error" => false,
            "error_code" => ERROR_SUCCESS,
            "chatId" => $this->chatId,
            "itemId" => $itemId,
            "items" => array());

        $stmt = $this->db->prepare("SELECT * FROM messages WHERE chatId = (:chatId) AND id > (:itemId) AND removeAt = 0 ORDER BY id DESC");
        $stmt->bindParam(':chatId', $this->chatId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $time = new language($this->db, $this->language);

                $profileInfo = array(
                    "id" => $row['fromUserId'],
                    "state" => 0,
                    "verified" => 0,
                    "online" => false,
                    "username" => "",
                    "fullname" => "",
                    "lowPhotoUrl" => "");

                $itemInfo = array("error" => false,
                    "error_code" => ERROR_SUCCESS,
                    "id" => $row['id'],
                    "fromUserId" => $row['fromUserId'],
                    "fromUserState" => $profileInfo['state'],
                    "fromUserOnline" => $profileInfo['online'],
                    "fromUserVerify" => $profileInfo['verified'],
                    "fromUserVerified" => $profileInfo['verified'],
                    "fromUserUsername" => $profileInfo['username'],
                    "fromUserFullname" => $profileInfo['fullname'],
                    "fromUserPhotoUrl" => $profileInfo['lowPhotoUrl'],
                    "message" => htmlspecialchars_decode(stripslashes($row['message'])),
                    "imgUrl" => $row['imgUrl'],
                    "seenAt" => 0,
                    "createAt" => $row['createAt'],
                    "date" => date("Y-m-d H:i:s", $row['createAt']),
                    "timeAgo" => $time->timeAgo($row['createAt']),
                    "removeAt" => $row['removeAt']);

                array_push($result['items'], $itemInfo);

                unset($itemInfo);
                unset($profileInfo);
            }
        }

        return $result;
    }

    public function setChatId($chat_id)
    {
        $this->chatId = $chat_id;
    }

    public function getChatId()
    {
        return $this->chatId;
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

