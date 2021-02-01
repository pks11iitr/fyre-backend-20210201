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

class home_category extends db_connect
{


	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

  

  

    public function quickInfo($row)
    {
        if (isset($this->LANG['category-'.$row['id']])) {

            //$row['title'] = $this->LANG['category-'.$row['id']];
        }

        $result = array(
           
            "id" => $row['id'],
            "mainCategoryId" => $row['mainCategoryId'],
            "title" => htmlspecialchars_decode(stripslashes($row['title'])),
            "createAt" => $row['createAt'],
            "date" => date("Y-m-d H:i:s", $row['createAt']),
            "removeAt" => $row['removeAt']);

        return $result;
    }

  
    public function getList()
    {
        $categoryies = array();

        $stmt = $this->db->prepare("SELECT * FROM category WHERE removeAt = 0 ORDER BY id ASC");

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = $this->quickInfo($row);

                array_push($categoryies, $itemInfo);

                unset($itemInfo);
            }
        }

        return $categoryies;
    }

   
}
