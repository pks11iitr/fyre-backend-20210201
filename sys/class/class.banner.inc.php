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

class banner extends db_connect
{

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}


public function getBannerCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM banner WHERE  status = 1");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }
    
public function quickInfo($row)
    {
       

        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "id" => $row['id'],
            "image" => $row['image'],
            "status" => $row['status']);

        return $result;
    }
    
    public function add( $image='',$status)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);
           

        if (strlen($status) == 0) {

            return $status;
        }
        

        $stmt = $this->db->prepare("INSERT INTO banner (image, status) value ( :image, :status)");
        
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $this->db->lastInsertId());
        }

        return $result;
    }


 public function edit($itemId, $status,$image='')
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if (strlen($status) == 0) {

            return $result;
        }

        $stmt = $this->db->prepare("UPDATE banner SET  status = (:status), image = (:image) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);

        }

        return $result;
    }
    
    public function deleteBanner($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error']) {

            return $result;
        }

        $currentTime = time();

        $stmt = $this->db->prepare("delete banner WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            // remove all subcategories

         
            // update all items category info

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }
    public function getList()
    {
        
        $banners=[];
        $stmt = $this->db->prepare("SELECT * FROM banner WHERE status=1 ORDER BY id ASC");
        
        
        
        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                 $itemInfo = $this->quickInfo($row);
                array_push($banners, $itemInfo);

                unset($itemInfo);
            }
        }

        return $banners;
    }

public function getItems()
    {
        $result = array(
            "error" => false,
            "error_code" => ERROR_SUCCESS,
            "items" => array());

        $stmt = $this->db->prepare("SELECT * FROM banner ORDER BY id ASC");
       // $stmt->bindParam(':mainCategoryId', $mainCategoryId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = $this->quickInfo($row);

                array_push($result['items'], $itemInfo);

                unset($itemInfo);
            }
        }

//var_dump($result); die;
        return $result;
    }
    
  
 public function info($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("SELECT * FROM banner WHERE id = (:itemId) LIMIT 1");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $result = $this->quickInfo($row);
            }
        }

        return $result;
    }

}
