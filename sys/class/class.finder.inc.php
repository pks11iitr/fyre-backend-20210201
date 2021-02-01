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

class finder extends db_connect
{
    private $tableName = "items";

    private $requestFrom = 0;
    private $requestFromApp = 0;
    private $itemsInRequest = 20;
    private $profileId = 0;
    private $currency = 0;
    private $category = 0;

    private $_inactive = 0; // 0 = all, 1 =  inactive hide, 2 = only inactive, 3 = only active
    private $_moderation = 0; // 0 = all, 1 =  moderated hide, 2 = only moderated, 3 = only unmoderated

    public function __construct($dbo = NULL)
    {
        $this->setInactiveFilter(FILTER_HIDE); // Hide inactive items By default

        parent::__construct($dbo);

    }

    public function getItems($queryText = '', $pageId = 0, $sortType = 0, $lat = 0.000000, $lng = 0.000000, $distance = 30)
    {

        if (strlen($queryText) != 0 && $pageId == 0 && $this->getRequestFromApp() != 0) {

            $action = new action($this->db);
            $action->add($this->getRequestFromApp(), $this->getRequestFrom(), ACTIONS_ITEM_SEARCH, $queryText);
            unset($action);
        }

        $itemsCount = 0;

        if ($pageId == 0) $itemsCount = $this->getItemsCount($queryText, $lat, $lng, $distance);

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

        if ($this->getCurrencyFilter() > 0) {

            $currencySql = " AND currency = {$this->getCurrencyFilter()}";

        } else {

            $currencySql = "";
        }

        if ($this->getProfileIdFilter() != 0) {

            $profileSql = " AND fromUserId = {$this->getProfileIdFilter()}";

        } else {

            $profileSql = "";
        }

        switch($sortType) {

            case 0: {

                // usually sort by date from new to old
                $sortSql = " ORDER BY id DESC";

                break;
            }

            case 1: {

                // sort by date from old to new
                $sortSql = " ORDER BY id ASC";

                break;
            }

            case 2: {

                // sort by price from highest to smaller
                $sortSql = " ORDER BY price DESC";

                break;
            }

            default: {

                // sort by price from smaller to highest
                $sortSql = " ORDER BY price ASC";

                break;
            }
        }

        if ($this->getCategoryFilter() != 0) {

            $categorySql = " AND category = {$this->getCategoryFilter()}";

        } else {

            $categorySql = "";
        }

        if (strlen($queryText) > 0) {

            $searchSql = " AND (itemTitle LIKE (:query) OR itemDesc LIKE (:query) OR itemContent LIKE (:query))";

        } else {

            $searchSql = "";
        }


        $origLat = $lat;
        $origLon = $lng;
        $dist = $distance; // this is max distance (in miles) away from $origLat, $origLon in which to search

        if ($lat == 0.000000 && $lng == 0.000000) {

            $sql = "SELECT * FROM $this->tableName WHERE removeAt = 0".$searchSql.$profileSql.$this->getInactiveSql().$this->getModerationSql().$categorySql.$currencySql.$sortSql.$limitSql;

        } else {

            $sql = "SELECT *, lat, lng, 3956 * 2 *
                      ASIN(SQRT( POWER(SIN(($origLat - lat)*pi()/180/2),2)
                      +COS($origLat*pi()/180 )*COS(lat*pi()/180)
                      *POWER(SIN(($origLon-lng)*pi()/180/2),2)))
                      as distance FROM $this->tableName WHERE
                      lng between ($origLon-$dist/cos(radians($origLat))*69)
                      and ($origLon+$dist/cos(radians($origLat))*69)
                      and lat between ($origLat-($dist/69))
                      and ($origLat+($dist/69))
                      and (removeAt = 0)
                      and (lat <> 0.000000)
                      and (lng <> 0.000000)".$searchSql.$profileSql.$this->getInactiveSql().$this->getModerationSql().$categorySql.$currencySql." having distance < $dist".$sortSql.$limitSql;
        }

        $stmt = $this->db->prepare($sql);

        if (strlen($queryText) > 0) {

            $queryText = "%".$queryText."%";

            $stmt->bindParam(":query", $queryText, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                while ($row = $stmt->fetch()) {

                    $item = new items($this->db);
                    $item->setRequestFrom($this->requestFrom);

                    $itemInfo = $item->quickInfo($row);
//                    $itemInfo['distance'] = round($this->getDistance($lat, $lng, $itemInfo['lat'], $itemInfo['lng']), 1);

                    unset($item);

                    array_push($result['items'], $itemInfo);

                    $result['itemId'] = $row['id'];
                }
            }
        }

        return $result;
    }

    public function getItemsCount($queryText = '', $lat = 0.000000, $lng = 0.000000, $distance = 30)
    {
        if ($this->getCurrencyFilter() > 0) {

            $currencySql = " AND currency = {$this->getCurrencyFilter()}";

        } else {

            $currencySql = "";
        }

        if ($this->getProfileIdFilter() != 0) {

            $profileSql = " AND fromUserId = {$this->getProfileIdFilter()}";

        } else {

            $profileSql = "";
        }

        if ($this->getCategoryFilter() != 0) {

            $categorySql = " AND category = {$this->getCategoryFilter()}";

        } else {

            $categorySql = "";
        }

        if (strlen($queryText) > 0) {

            $searchSql = " AND (itemTitle LIKE (:query) OR itemDesc LIKE (:query) OR itemContent LIKE (:query))";

        } else {

            $searchSql = "";
        }

        $origLat = $lat;
        $origLon = $lng;
        $dist = $distance; // this is the max distance (in miles) away from $origLat, $origLon in which to search

        if ($lat == 0.000000 && $lng == 0.000000) {

            $sql = "SELECT count(*) FROM $this->tableName WHERE removeAt = 0".$searchSql.$profileSql.$this->getInactiveSql().$this->getModerationSql().$categorySql.$currencySql;

        } else {

            $sql = "SELECT id, lat, lng, 3956 * 2 *
                      ASIN(SQRT( POWER(SIN(($origLat - lat)*pi()/180/2),2)
                      +COS($origLat*pi()/180 )*COS(lat*pi()/180)
                      *POWER(SIN(($origLon-lng)*pi()/180/2),2)))
                      as distance FROM $this->tableName WHERE
                      lng between ($origLon-$dist/cos(radians($origLat))*69)
                      and ($origLon+$dist/cos(radians($origLat))*69)
                      and lat between ($origLat-($dist/69))
                      and ($origLat+($dist/69))
                      and (removeAt = 0)
                      and (lat <> 0.000000)
                      and (lng <> 0.000000)".$searchSql.$profileSql.$this->getInactiveSql().$this->getModerationSql().$categorySql.$currencySql." having distance < $dist";
        }

        $stmt = $this->db->prepare($sql);

        if (strlen($queryText) > 0) {

            $queryText = "%".$queryText."%";

            $stmt->bindParam(":query", $queryText, PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($lat == 0.000000 && $lng == 0.000000) {

            return $number_of_rows = $stmt->fetchColumn();

        } else {

            return $number_of_rows = $stmt->rowCount();
        }
    }

    public function addCurrencyFilter($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrencyFilter()
    {
        return $this->currency;
    }

    public function addCategoryFilter($category)
    {
        $this->category = $category;
    }

    public function getCategoryFilter()
    {
        return $this->category;
    }

    public function addProfileIdFilter($profileId)
    {
        $this->profileId = $profileId;
    }

    public function getProfileIdFilter()
    {
        return $this->profileId;
    }

    public function setInactiveFilter($filter)
    {

        $this->_inactive = $filter;
    }

    public function getInactiveFilter()
    {

        return $this->_inactive;
    }

    public function getInactiveSql()
    {
        $inactiveSql = "";

        switch ($this->getInactiveFilter()) {

            case FILTER_ALL: {

                $inactiveSql = "";

                break;
            }

            case FILTER_HIDE: {

                $inactiveSql = " AND inactiveAt = 0";

                break;
            }

            case FILTER_ONLY_YES: {

                $inactiveSql = " AND inactiveAt > 0";

                break;
            }

            case FILTER_ONLY_NO: {

                $inactiveSql = " AND inactiveAt = 0";

                break;
            }

            default: {

                break;
            }
        }

        return $inactiveSql;
    }

    public function setModerationFilter($filter)
    {

        $this->_moderation = $filter;
    }

    public function getModerationFilter()
    {

        return $this->_moderation;
    }

    public function getModerationSql()
    {
        $moderateSql = "";

        switch ($this->getModerationFilter()) {

            case FILTER_ALL: {

                $moderateSql = "";

                break;
            }

            case FILTER_HIDE: {

                $moderateSql = " AND moderatedAt = 0";

                break;
            }

            case FILTER_ONLY_YES: {

                $moderateSql = " AND moderatedAt > 0";

                break;
            }

            case FILTER_ONLY_NO: {

                $moderateSql = " AND moderatedAt = 0";

                break;
            }

            default: {

                break;
            }
        }

        return $moderateSql;
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

    public function setRequestFromApp($requestFromApp)
    {
        $this->requestFromApp = $requestFromApp;
    }

    public function getRequestFromApp()
    {
        return $this->requestFromApp;
    }
}

