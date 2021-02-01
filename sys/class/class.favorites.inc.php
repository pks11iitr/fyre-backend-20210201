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

class favorites extends db_connect
{
	private $requestFrom = 0;
	private $itemsInRequest = 20;
	private $tableName = "likes";

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

		$sql = "SELECT itemId FROM $this->tableName WHERE removeAt = 0 and fromUserId = $this->requestFrom ORDER BY id DESC $limitSql";

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

					$item = new items($this->db);
					$item->setRequestFrom($this->requestFrom);
					$itemInfo = $item->info($row['itemId']);
					unset($item);

					array_push($result['items'], $itemInfo);
				}
			}
		}

		return $result;
	}

	public function getItemsCount()
	{
		$sql = "SELECT count(*) FROM $this->tableName WHERE removeAt = 0 AND fromUserId = $this->requestFrom";
		$stmt = $this->db->prepare($sql);

		$stmt->execute();

		return $number_of_rows = $stmt->fetchColumn();
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

