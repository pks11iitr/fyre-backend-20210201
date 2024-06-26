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

class fcm extends db_connect
{
    private $requestFrom = 0; // Sender Account ID
    private $language = 'en';

    private $requestTo = 0; // Identifier of the recipient account

    private $type = 0; // Notification type
    private $title = 0; // Notification title
    private $itemId = 0; // Notifications for: object or item identifier

    private $appType = -1; // Notifications for apps types

    private $message = array();

	private $url = "https://fcm.googleapis.com/fcm/send";
	private $ids = array();
	private $data = array();

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);
	}

    public function send()
    {
        $result = array(
            "error" => true,
            "description" => "regId not found");

        if (empty($this->ids)) {

            return $result;
        }

        $post = array(
            'registration_ids'  => $this->ids,
            'data'              => $this->data,
        );

        $headers = array(
            'Authorization: key='.FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);

        @curl_exec($ch);

        $result = array(
            "error" => false,
            "success" => 1,
            "description");

        curl_close($ch);

        $obj = json_encode($result, true);

        return $obj;
    }

    public function prepare() {

        if ($this->getAppType() == APP_TYPE_ALL) {

            $stmt = $this->db->prepare("SELECT fcm_regId FROM access_data WHERE accountId = (:accountId) AND removeAt = 0 AND appType > 1 AND fcm_regId <> ''"); // appType = 1 -> APP_TYPE_WEB
            $stmt->bindParam(":accountId", $this->requestTo, PDO::PARAM_INT);

        } else {

            $stmt = $this->db->prepare("SELECT fcm_regId FROM access_data WHERE accountId = (:accountId) AND removeAt = 0 AND appType = (:appType) AND fcm_regId <> ''");
            $stmt->bindParam(":accountId", $this->requestTo, PDO::PARAM_INT);
            $stmt->bindParam(":appType", $this->appType, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $this->ids[] = $row['fcm_regId'];
            }
        }

        $this->data = array("type" => $this->getType(),
                            "msg" => $this->getTitle(),
                            "id" => $this->getItemId(),
                            "accountId" => $this->getRequestTo());

        if (count($this->getMessage()) != 0) {

            $this->data['msgId'] = $this->message['id'];
            $this->data['msgFromUserId'] = $this->message['fromUserId'];
            $this->data['msgFromUserState'] = $this->message['fromUserState'];
            $this->data['msgFromUserVerify'] = $this->message['fromUserVerify'];
            $this->data['msgFromUserOnline'] = $this->message['fromUserOnline'];
            $this->data['msgFromUserUsername'] = $this->message['fromUserUsername'];
            $this->data['msgFromUserFullname'] = $this->message['fromUserFullname'];
            $this->data['msgFromUserPhotoUrl'] = $this->message['fromUserPhotoUrl'];
            $this->data['msgMessage'] = $this->message['message'];
            $this->data['msgImgUrl'] = $this->message['imgUrl'];
            $this->data['msgCreateAt'] = $this->message['createAt'];
            $this->data['msgDate'] = $this->message['date'];
            $this->data['msgTimeAgo'] = $this->message['timeAgo'];
            $this->data['msgRemoveAt'] = $this->message['removeAt'];
        }
    }

	public function add_regId_to_regIds($fcm_regId, $app_type, $client_id, $lang = "")
	{
		$result = array("error" => true,
						"error_code" => ERROR_UNKNOWN);

		$currentTime = time();

		$u_agent = helper::u_agent();
		$ip_addr = helper::ip_addr();

		$stmt = $this->db->prepare("INSERT INTO fcm_reg_ids (fcm_regId, appType, clientId, lang, createAt, u_agent, ip_addr) value (:fcm_regId, :appType, :clientId, :lang, :createAt, :u_agent, :ip_addr)");
		$stmt->bindParam(":fcm_regId", $fcm_regId, PDO::PARAM_STR);
		$stmt->bindParam(":appType", $app_type, PDO::PARAM_INT);
		$stmt->bindParam(":clientId", $client_id, PDO::PARAM_INT);
		$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
		$stmt->bindParam(":createAt", $currentTime, PDO::PARAM_INT);
		$stmt->bindParam(":u_agent", $u_agent, PDO::PARAM_STR);
		$stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);

		if ($stmt->execute()) {

			$result = array('error' => false,
							'error_code' => ERROR_SUCCESS);
		}

		return $result;
	}

	public function search_regId_in_regIds($fcm_regId)
	{
		$stmt = $this->db->prepare("SELECT id FROM fcm_reg_ids WHERE fcm_regId = (:fcm_regId) AND removeAt = 0 LIMIT 1");
		$stmt->bindParam(":fcm_regId", $fcm_regId, PDO::PARAM_STR);

		if ($stmt->execute()) {

			$row = $stmt->fetch();

			return $row['id'];
		}

		return 0;
	}

	public function remove_regId_from_regIds($fcm_regId)
	{
		$currentTime = time(); //current time

		$stmt = $this->db->prepare("UPDATE fcm_reg_ids SET removeAt = (:removeAt) WHERE fcm_regId = (:fcm_regId) AND removeAt = 0");
		$stmt->bindParam(":fcm_regId", $fcm_regId, PDO::PARAM_STR);
		$stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return true;
		}

		return false;
	}

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setAppType($appType)
    {
        $this->appType = $appType;
    }

    public function getAppType()
    {
        return $this->appType;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setRequestTo($requestTo)
    {
        $this->requestTo = $requestTo;
    }

    public function getRequestTo()
    {
        return $this->requestTo;
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