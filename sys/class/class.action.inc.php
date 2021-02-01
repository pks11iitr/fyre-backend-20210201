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

class action extends db_connect
{
	private $requestFrom = 0;
    private $language = 'en';

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

    public function add($appType, $accountId, $actionId, $text_request_1 = "", $text_request_2 = "", $text_request_3 = "", $numeric_request_1 = 0, $numeric_request_2 = 0, $numeric_request_3 = 0)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $timeAt = time();
        $u_agent = helper::u_agent();
        $ip_addr = helper::ip_addr();

        $stmt = $this->db->prepare("INSERT INTO actions (appType, accountId, actionId, text_request_1, text_request_2, text_request_3, numeric_request_1, numeric_request_2, numeric_request_3, createAt, u_agent, ip_addr) value (:appType, :accountId, :actionId, :text_request_1, :text_request_2, :text_request_3, :numeric_request_1, :numeric_request_2, :numeric_request_3, :createAt, :u_agent, :ip_addr)");
        $stmt->bindParam(":appType", $appType, PDO::PARAM_INT);
        $stmt->bindParam(":accountId", $accountId, PDO::PARAM_INT);
        $stmt->bindParam(":actionId", $actionId, PDO::PARAM_INT);
        $stmt->bindParam(":text_request_1", $text_request_1, PDO::PARAM_STR);
        $stmt->bindParam(":text_request_2", $text_request_2, PDO::PARAM_STR);
        $stmt->bindParam(":text_request_3", $text_request_3, PDO::PARAM_STR);
        $stmt->bindParam(":numeric_request_1", $numeric_request_1, PDO::PARAM_INT);
        $stmt->bindParam(":numeric_request_2", $numeric_request_2, PDO::PARAM_INT);
        $stmt->bindParam(":numeric_request_3", $numeric_request_3, PDO::PARAM_INT);
        $stmt->bindParam(":createAt", $timeAt, PDO::PARAM_INT);
        $stmt->bindParam(":u_agent", $u_agent, PDO::PARAM_STR);
        $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $this->db->lastInsertId());
        }

        return $result;
    }

    public function info($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("SELECT * FROM actions WHERE id = (:itemId) LIMIT 1");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $result = $this->quickInfo($row);
            }
        }

        return $result;
    }

    public function quickInfo($row)
    {
        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "id" => $row['id'],
            "appType" => $row['appType'],
            "accountId" => $row['accountId'],
            "actionId" => $row['actionId'],
            "text_request_1" => htmlspecialchars_decode(stripslashes($row['text_request_1'])),
            "text_request_2" => htmlspecialchars_decode(stripslashes($row['text_request_2'])),
            "text_request_3" => htmlspecialchars_decode(stripslashes($row['text_request_3'])),
            "numeric_request_1" => $row['numeric_request_1'],
            "numeric_request_2" => $row['numeric_request_2'],
            "numeric_request_3" => $row['numeric_request_3'],
            "createAt" => $row['createAt'],
            "date" => date("Y-m-d H:i:s", $row['createAt']),
            "removeAt" => $row['removeAt'],
            "u_agent" => $row['u_agent'],
            "ip_addr" => $row['ip_addr']);

        return $result;
    }

    public function getItems($mainCategoryId = 0)
    {
        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "mainCategoryId" => $mainCategoryId,
            "items" => array());

        $stmt = $this->db->prepare("SELECT * FROM category WHERE removeAt = 0 AND mainCategoryId = (:mainCategoryId) ORDER BY id ASC");
        $stmt->bindParam(':mainCategoryId', $mainCategoryId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = $this->quickInfo($row);

                array_push($result['items'], $itemInfo);

                unset($itemInfo);
            }
        }

        return $result;
    }

    public function getList()
    {
        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "items" => array());

        $stmt = $this->db->prepare("SELECT * FROM actions WHERE removeAt = 0 ORDER BY id ASC");

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = $this->quickInfo($row);

                array_push($result['items'], $itemInfo);

                unset($itemInfo);
            }
        }

        return $result;
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
