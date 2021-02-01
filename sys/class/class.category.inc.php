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

class category extends db_connect
{
	private $requestFrom = 0;
    private $language = 'en';
    private $LANG = array();

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

    public function getSubcategoriesCount($mainCategoryId = 0)
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM category WHERE mainCategoryId = (:mainCategoryId) AND removeAt = 0");
        $stmt->bindParam(':mainCategoryId', $mainCategoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getCategoriesCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM category WHERE mainCategoryId = 0 AND removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function add($mainCategoryId, $title,$image='')
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if (strlen($title) == 0) {

            return $result;
        }
        
        $timeAt = time();

        $stmt = $this->db->prepare("INSERT INTO category (mainCategoryId, title,image, createAt) value (:mainCategoryId, :title, :image, :createAt)");
        $stmt->bindParam(":mainCategoryId", $mainCategoryId, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);
        $stmt->bindParam(":createAt", $timeAt, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $this->db->lastInsertId());
        }

        return $result;
    }

    public function edit($itemId, $mainCategoryId, $title,$image='')
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if (strlen($title) == 0) {

            return $result;
        }

        $stmt = $this->db->prepare("UPDATE category SET mainCategoryId = (:mainCategoryId), title = (:title), image = (:image) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":mainCategoryId", $mainCategoryId, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);

        }

        return $result;
    }

    public function deleteCategory($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error']) {

            return $result;
        }

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE category SET removeAt = (:removeAt) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            // remove all subcategories

            $this->removeSubcategories($itemId);

            // update all items category info

            $this->itemsUpdateCategory($itemId);

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function deleteSubcategory($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error']) {

            return $result;
        }

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE category SET removeAt = (:removeAt) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            // update all items subcategory info

            $this->itemsUpdateSubcategory($itemId);

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function removeSubcategories($mainCategoryId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE category SET removeAt = (:removeAt) WHERE mainCategoryId = (:mainCategoryId)");
        $stmt->bindParam(":mainCategoryId", $mainCategoryId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function itemsUpdateCategory($mainCategoryId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("UPDATE items SET category = 0, subCategory = 0 WHERE category = (:mainCategoryId)");
        $stmt->bindParam(":mainCategoryId", $mainCategoryId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function itemsUpdateSubcategory($subCategoryId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("UPDATE items SET subCategory = 0 WHERE subCategory = (:subCategoryId)");
        $stmt->bindParam(":subCategoryId", $subCategoryId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function info($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("SELECT * FROM category WHERE id = (:itemId) LIMIT 1");
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
        if (isset($this->LANG['category-'.$row['id']])) {

            //$row['title'] = $this->LANG['category-'.$row['id']];
        }

        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "id" => $row['id'],
            "mainCategoryId" => $row['mainCategoryId'],
            "title" => htmlspecialchars_decode(stripslashes($row['title'])),
            "image" => $row['image'],
            "createAt" => $row['createAt'],
            "date" => date("Y-m-d H:i:s", $row['createAt']),
            "removeAt" => $row['removeAt']);

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

        $stmt = $this->db->prepare("SELECT * FROM category WHERE removeAt = 0 ORDER BY id ASC");

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = $this->quickInfo($row);

                array_push($result['items'], $itemInfo);

                unset($itemInfo);
            }
        }

        return $result;
    }

    public function getTitle($category_id)
    {
        $title = "";

        if (isset($this->LANG['category-'.$category_id])) {

            $title = $this->LANG['category-'.$category_id];
        }

        return $title;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        if (file_exists("sys/lang/category_".$this->language.".php")) {

            include("sys/lang/category_".$this->language.".php");

        } else {

            include("sys/lang/category_en.php");
        }

        $this->LANG = $TEXT;
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
