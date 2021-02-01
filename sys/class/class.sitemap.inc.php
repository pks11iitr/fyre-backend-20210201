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

class sitemap extends db_connect
{
	private $requestFrom = 0;
	private $itemsInRequest = 20;

	public function __construct($dbo = NULL)
	{
		parent::__construct($dbo);

	}

	public function getItems()
	{
		$result = array(
			"error" => false,
			"error_code" => ERROR_SUCCESS,
			"items" => array());

		$limitSql = " LIMIT 0, {$this->itemsInRequest}";

		$sql = "SELECT id, itemUrl FROM items WHERE removeAt = 0 ORDER BY id DESC $limitSql";

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

					$itemInfo = array(
						"id" => $row['id'],
						"itemUrl" => $row['itemUrl']);

					array_push($result['items'], $itemInfo);
				}
			}
		}

		return $result;
	}

	public function getProfiles()
	{
		$result = array(
			"error" => false,
			"error_code" => ERROR_SUCCESS,
			"items" => array());

		$limitSql = " LIMIT 0, {$this->itemsInRequest}";

		$sql = "SELECT login FROM users WHERE state = 0 ORDER BY id DESC $limitSql";

		$stmt = $this->db->prepare($sql);

		if ($stmt->execute()) {

			if ($stmt->rowCount() > 0) {

				while ($row = $stmt->fetch()) {

					$itemInfo = array("username" => $row['login']);

					array_push($result['items'], $itemInfo);
				}
			}
		}

		return $result;
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

