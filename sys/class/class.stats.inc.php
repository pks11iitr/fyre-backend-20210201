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

class stats extends db_connect
{
	private $requestFrom = 0;

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);

	}

    // Chat and Messages

	public function getChatsCount($total = true)
	{
        if ($total) {

            $stmt = $this->db->prepare("SELECT count(*) FROM chats");

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM chats WHERE removeAt = 0");
        }

        $stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

	public function getMessagesCount($total = true)
	{
        if ($total) {

            $stmt = $this->db->prepare("SELECT count(*) FROM messages");

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM messages WHERE removeAt = 0");
        }

		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

	// Market Items

	public function getMarketItemsCount($total = true)
	{
        if ($total) {

            $stmt = $this->db->prepare("SELECT count(*) FROM items");

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0");
        }

		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

    public function getApprovedMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0 AND moderatedAt > 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getRejectedMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0 AND rejectedAt > 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getActiveMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0 AND inactiveAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getInactiveMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0 AND inactiveAt > 0 AND rejectedAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getRemovedMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt > 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getUnmoderatedMarketItemsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE removeAt = 0 AND rejectedAt = 0 AND inactiveAt = 0 AND moderatedAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

	// Accounts

    public function getAccountsCount($state = -1)
    {
        if ($state != -1) {

            $stmt = $this->db->prepare("SELECT count(*) FROM users WHERE state = (:state)");
            $stmt->bindParam(":state", $state, PDO::PARAM_INT);

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM users");
        }

        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Reports

    public function getReportsCount($item_type = -1)
    {
        if ($item_type != -1) {

            $stmt = $this->db->prepare("SELECT count(*) FROM reports WHERE itemType = (:itemType) AND removeAt = 0");
            $stmt->bindParam(":itemType", $item_type, PDO::PARAM_INT);

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM reports");
        }

        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Likes or Favorites

    public function getLikesCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM likes WHERE removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    // Support

    public function getTicketsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM support WHERE removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }






	private function getMaxAccountId()
	{
		$stmt = $this->db->prepare("SELECT MAX(id) FROM users");
		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

	public function getAccountsCountByAdmob($value)
	{
		$stmt = $this->db->prepare("SELECT count(*) FROM users WHERE admob = (:admob)");
		$stmt->bindParam(":admob", $value, PDO::PARAM_INT);
		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

	private function getMaxAuthId()
	{
		$stmt = $this->db->prepare("SELECT MAX(id) FROM access_data");
		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
	}

	public function getAccounts($userId = 0)
	{
		if ($userId == 0) {

			$userId = $this->getMaxAccountId();
			$userId++;
		}

		$users = array("error" => false,
						"error_code" => ERROR_SUCCESS,
						"itemId" => $userId,
						"items" => array());

		$stmt = $this->db->prepare("SELECT id FROM users WHERE id < (:userId) ORDER BY id DESC LIMIT 20");
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

		if ($stmt->execute()) {

			while ($row = $stmt->fetch()) {

				$account = new account($this->db, $row['id']);

				$accountInfo = $account->get();

				array_push($users['items'], $accountInfo);

				$users['itemId'] = $accountInfo['id'];

				unset($accountInfo);
			}
		}

		return $users;
	}

	public function searchAccounts($userId = 0, $query = "")
	{
		if ($userId == 0) {

			$userId = $this->getMaxAccountId();
			$userId++;
		}

		$users = array("error" => false,
						"error_code" => ERROR_SUCCESS,
						"userId" => $userId,
						"query" => $query,
						"users" => array());

		$searchText = '%'.$query.'%';

		$stmt = $this->db->prepare("SELECT id FROM users WHERE id < (:userId) AND login LIKE (:query) OR email LIKE (:query) OR fullname LIKE (:query) ORDER BY id DESC LIMIT 100");
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
		$stmt->bindParam(':query', $searchText, PDO::PARAM_STR);

		if ($stmt->execute()) {

			while ($row = $stmt->fetch()) {

				$account = new account($this->db, $row['id']);

				$accountInfo = $account->get();

				array_push($users['users'], $accountInfo);

				$users['userId'] = $accountInfo['id'];

				unset($accountInfo);
			}
		}

		return $users;
	}

	public function getAuthData($accountId, $authId = 0)
	{
		if ($authId == 0) {

			$authId = $this->getMaxAuthId();
			$authId++;
		}

		$result = array("error" => false,
						"error_code" => ERROR_SUCCESS,
						"authId" => $authId,
						"data" => array());

		$stmt = $this->db->prepare("SELECT * FROM access_data WHERE accountId = (:accountId) AND id < (:authId) ORDER BY id DESC LIMIT 200");
		$stmt->bindParam(':authId', $authId, PDO::PARAM_INT);
		$stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);

		if ($stmt->execute()) {

			while ($row = $stmt->fetch()) {;

				$dataInfo = array("id" => $row['id'],
								  "accountId" => $row['accountId'],
								  "accessToken" => $row['accessToken'],
								  "clientId" => $row['clientId'],
								  "appType" => $row['appType'],
								  "createAt" => $row['createAt'],
								  "removeAt" => $row['removeAt'],
								  "u_agent" => $row['u_agent'],
								  "ip_addr" => $row['ip_addr']);

				array_push($result['data'], $dataInfo);

				$result['authId'] = $row['id'];

				unset($dataInfo);
			}
		}

		return $result;
	}

	public function getAccountGcmHistory($accountId)
	{
		$result = array("error" => false,
						"error_code" => ERROR_SUCCESS,
						"data" => array());

		$stmt = $this->db->prepare("SELECT * FROM gcm_history WHERE accountId = (:accountId) ORDER BY id DESC LIMIT 20");
		$stmt->bindParam(':accountId', $accountId, PDO::PARAM_INT);

		if ($stmt->execute()) {

			while ($row = $stmt->fetch()) {;

				$dataInfo = array("id" => $row['id'],
								  "msg" => $row['msg'],
								  "msgType" => $row['msgType'],
								  "status" => $row['status'],
								  "success" => $row['success'],
								  "createAt" => $row['createAt']);

				array_push($result['data'], $dataInfo);

				unset($dataInfo);
			}
		}

		return $result;
	}

	public function getGcmHistory()
	{
		$result = array("error" => false,
						"error_code" => ERROR_SUCCESS,
						"data" => array());

		$stmt = $this->db->prepare("SELECT * FROM gcm_history WHERE accountId = 0 ORDER BY id DESC LIMIT 20");

		if ($stmt->execute()) {

			while ($row = $stmt->fetch()) {;

				$dataInfo = array("id" => $row['id'],
								  "msg" => $row['msg'],
								  "msgType" => $row['msgType'],
								  "status" => $row['status'],
								  "success" => $row['success'],
								  "createAt" => $row['createAt']);

				array_push($result['data'], $dataInfo);

				unset($dataInfo);
			}
		}

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

