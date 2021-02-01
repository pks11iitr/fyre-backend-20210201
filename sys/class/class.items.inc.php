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

class items extends db_connect
{
	private $requestFrom = 0;
    private $language = 'en';

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

    // Get items count for this user

    public function getItemsCount($item_type = -1)
    {
        if ($item_type == ITEM_TYPE_ALL) {

            $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE fromUserId = (:fromUserId) AND removeAt = 0");
            $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM items WHERE itemType = (:itemType) AND fromUserId = (:fromUserId) AND removeAt = 0");
            $stmt->bindParam(":itemType", $item_type, PDO::PARAM_INT);
            $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // Generate thumbnail for item

    private function createThumbnail($imgUrl)
    {
        $fileName = parse_url($imgUrl);
        $fileNameArr = explode('/', $fileName['path']);
        $fileName =  $fileNameArr[count($fileNameArr) - 1];

        if (!file_exists(ITEMS_PHOTO_PATH.$fileName)) {

            return "";
        }

        if (!file_exists(ITEMS_PHOTO_PATH."t_".$fileName)) {

            $imglib = new imglib($this->db);
            $imglib->setRequestFrom($this->getRequestFrom());
            $response = $imglib->createItemImgThumbnail(ITEMS_PHOTO_PATH.$fileName);
            unset($imglib);

            return $response['fileUrl'];

        } else {

            return APP_URL."/".ITEMS_PHOTO_PATH."t_".$fileName;
        }
    }

    // Add new item

    public function add($appType, $category, $subCategoryId, $title, $description, $content, $imgUrl, $allowComments = 1, $price = 0, $postArea = "", $postCountry = "", $postCity = "", $postLat = "0.000000", $postLng = "0.000000", $currency = 3, $phoneNumber = "")
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        if (strlen($title) == 0) {

            return $result;
        }

        if (strlen($imgUrl) == 0) {

            return $result;
        }

        if (strlen($content) == 0) {

            return $result;
        }

        if ($category == 0) {

            return $result;
        }

        if ($currency == 0) {

            return $result;
        }

        if (!$this->isAllowAction(helper::ip_addr())) {

            return $result;
        }

        // Create preview image | Thumbnail

        $previewImgUrl = $this->createThumbnail($imgUrl);

        if (strlen($previewImgUrl) == 0) {

            $previewImgUrl = $imgUrl;
        }

        $currentTime = time();
        $ip_addr = helper::ip_addr();
        $u_agent = helper::u_agent();

        $itemUrl = helper::createLinkFromString($title);

        $stmt = $this->db->prepare("INSERT INTO items (itemUrl, appType, allowComments, fromUserId, phoneNumber, category, subCategory, itemTitle, itemDesc, itemContent, imgUrl, previewImgUrl, price, currency, area, country, city, lat, lng, createAt, ip_addr, u_agent) value (:itemUrl, :appType, :allowComments, :fromUserId, :phoneNumber, :category, :subCategory, :itemTitle, :itemDesc, :itemContent, :imgUrl, :previewImgUrl, :price, :currency, :area, :country, :city, :lat, :lng, :createAt, :ip_addr, :u_agent)");
        $stmt->bindParam(":itemUrl", $itemUrl, PDO::PARAM_STR);
        $stmt->bindParam(":appType", $appType, PDO::PARAM_INT);
        $stmt->bindParam(":allowComments", $allowComments, PDO::PARAM_INT);
        $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->bindParam(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt->bindParam(":subCategory", $subCategoryId, PDO::PARAM_INT);
        $stmt->bindParam(":itemTitle", $title, PDO::PARAM_STR);
        $stmt->bindParam(":itemDesc", $description, PDO::PARAM_STR);
        $stmt->bindParam(":itemContent", $content, PDO::PARAM_STR);
        $stmt->bindParam(":imgUrl", $imgUrl, PDO::PARAM_STR);
        $stmt->bindParam(":previewImgUrl", $previewImgUrl, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":currency", $currency, PDO::PARAM_INT);
        $stmt->bindParam(":area", $postArea, PDO::PARAM_STR);
        $stmt->bindParam(":country", $postCountry, PDO::PARAM_STR);
        $stmt->bindParam(":city", $postCity, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $postLat, PDO::PARAM_STR);
        $stmt->bindParam(":lng", $postLng, PDO::PARAM_STR);
        $stmt->bindParam(":createAt", $currentTime, PDO::PARAM_INT);
        $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);
        $stmt->bindParam(":u_agent", $u_agent, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $this->db->lastInsertId(),
                "itemUrl" => $itemUrl);

            $account = new account($this->db, $this->getRequestFrom());
            $account->setItemsCount($this->getItemsCount());
            unset($account);
        }

        return $result;
    }

    // Edit item

    public function edit($itemId, $category, $subCategoryId, $title, $imgUrl, $content, $allowComments, $price, $area = "", $country = "", $city = "", $lat = "0.000000", $lng = "0.000000", $currency = 3, $phoneNumber = "")
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $spam = new spam($this->db);
        $spam->setRequestFrom($this->getRequestFrom());

        if ($spam->getItemsCount() > 15) {

            return $result;
        }

        unset($spam);

        if (strlen($title) == 0) {

            return $result;
        }

        if (strlen($imgUrl) == 0) {

            return $result;
        }

        if (strlen($content) == 0) {

            return $result;
        }

        if ($category == 0) {

            return $result;
        }

        if ($currency == 0) {

            return $result;
        }

        // Create preview image | Thumbnail

        $previewImgUrl = $this->createThumbnail($imgUrl);

        if (strlen($previewImgUrl) == 0) {

            $previewImgUrl = $imgUrl;
        }

        $modifyAt = time();

        $stmt = $this->db->prepare("UPDATE items SET imagesCount = 0, modifyAt = (:modifyAt), phoneNumber = (:phoneNumber), area = (:area), country = (:country), city = (:city), lat = (:lat), lng = (:lng), allowComments = (:allowComments), category = (:category), subCategory = (:subCategory), itemTitle = (:itemTitle), itemContent = (:itemContent), imgUrl = (:imgUrl), previewImgUrl = (:previewImgUrl), price = (:price), currency = (:currency), moderatedAt = 0, moderatedId = 0, rejectedAt = 0, rejectedId = 0, inactiveAt = 0 WHERE id = (:itemId)");
        $stmt->bindParam(":modifyAt", $modifyAt, PDO::PARAM_INT);
        $stmt->bindParam(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(":area", $area, PDO::PARAM_STR);
        $stmt->bindParam(":country", $country, PDO::PARAM_STR);
        $stmt->bindParam(":city", $city, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $lat, PDO::PARAM_STR);
        $stmt->bindParam(":lng", $lng, PDO::PARAM_STR);

        $stmt->bindParam(":allowComments", $allowComments, PDO::PARAM_INT);
        $stmt->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt->bindParam(":subCategory", $subCategoryId, PDO::PARAM_INT);
        $stmt->bindParam(":itemTitle", $title, PDO::PARAM_STR);
        $stmt->bindParam(":itemContent", $content, PDO::PARAM_STR);
        $stmt->bindParam(":imgUrl", $imgUrl, PDO::PARAM_STR);
        $stmt->bindParam(":previewImgUrl", $previewImgUrl, PDO::PARAM_STR);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":currency", $currency, PDO::PARAM_INT);

        if ($stmt->execute()) {

            // remove all notifications about reject and approved

            $notifications = new notifications($this->db);
            $notifications->setRequestFrom($this->getRequestFrom());
            $notifications->remove(NOTIFY_TYPE_ITEM_APPROVED, $itemId); // remove all approved notifications
            $notifications->remove(NOTIFY_TYPE_ITEM_REJECTED, $itemId); // remove all rejected notifications
            unset($notifications);

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $itemId);
        }

        return $result;
    }

    // Approve item | Moderated true

    public function approve($itemId, $approveId, $notifyToId = 0)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error'] || $itemInfo['inactiveAt'] != 0) {

            return $result;
        }

        $moderatedAt = time();

        $stmt = $this->db->prepare("UPDATE items SET moderatedAt = (:moderatedAt), moderatedId = (:moderatedId), rejectedAt = 0, rejectedId = 0, inactiveAt = 0, reportsCount = 0 WHERE id = (:itemId)");
        $stmt->bindParam(":moderatedAt", $moderatedAt, PDO::PARAM_INT);
        $stmt->bindParam(":moderatedId", $approveId, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($notifyToId != 0) {

                // Create notification about approved

                $notifications = new notifications($this->db);
                $notifications->setRequestFrom($this->getRequestFrom());
                $notifications->create($notifyToId, NOTIFY_TYPE_ITEM_APPROVED, $itemId);
                unset($notifications);

                // Send Push notification

                $fcm = new fcm($this->db);
                $fcm->setRequestFrom($this->getRequestFrom());
                $fcm->setRequestTo($notifyToId);
                $fcm->setType(GCM_NOTIFY_ITEM_APPROVED);
                $fcm->setTitle("Your ad is approved by a moderator.");
                $fcm->setItemId($itemId);
                $fcm->prepare();
                $fcm->send();
                unset($fcm);
            }

            //remove all reports to item

            $reports = new reports($this->db);
            $reports->remove(REPORT_TYPE_ITEM ,$itemId);
            unset($reports);

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $itemId);
        }

        return $result;
    }

    // Reject item | Moderated false

    public function reject($itemId, $rejectId, $notifyToId = 0)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error'] || $itemInfo['rejectedAt'] != 0) {

            return $result;
        }

        $rejectAt = time();

        $stmt = $this->db->prepare("UPDATE items SET rejectedAt = (:rejectedAt), rejectedId = (:rejectedId), inactiveAt = (:inactiveAt), moderatedAt = 0, moderatedId = 0, reportsCount = 0 WHERE id = (:itemId)");
        $stmt->bindParam(":rejectedAt", $rejectAt, PDO::PARAM_INT);
        $stmt->bindParam(":rejectedId", $rejectId, PDO::PARAM_INT);
        $stmt->bindParam(":inactiveAt", $rejectAt, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($notifyToId != 0) {

                // Create notification about reject

                $notifications = new notifications($this->db);
                $notifications->setRequestFrom($this->getRequestFrom());
                $notifications->create($notifyToId, NOTIFY_TYPE_ITEM_REJECTED, $itemId);
                unset($notifications);

                // Send Push notification

                $fcm = new fcm($this->db);
                $fcm->setRequestFrom($this->getRequestFrom());
                $fcm->setRequestTo($notifyToId);
                $fcm->setType(GCM_NOTIFY_ITEM_REJECTED);
                $fcm->setTitle("Your ad has been rejected by moderator.");
                $fcm->setItemId($itemId);
                $fcm->prepare();
                $fcm->send();
                unset($fcm);
            }

            //remove all reports to item

            $reports = new reports($this->db);
            $reports->remove(REPORT_TYPE_ITEM ,$itemId);
            unset($reports);

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $itemId);
        }

        return $result;
    }

    // Make item Inactive

    public function setInactive($itemId, $inactive = true)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $inactiveAt = time();

        if (!$inactive) $inactiveAt = 0;

        $stmt = $this->db->prepare("UPDATE items SET inactiveAt = (:inactiveAt) WHERE id = (:itemId)");
        $stmt->bindParam(":inactiveAt", $inactiveAt, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "itemId" => $itemId);
        }

        return $result;
    }

    // Remove all items

    public function removeAll()
    {
        $stmt = $this->db->prepare("SELECT id FROM items WHERE fromUserId = (:fromUserId) AND removeAt = 0");
        $stmt->bindParam(':fromUserId', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $this->delete($row['id']);
            }
        }
    }

    // Delete item by id (index)

    public function delete($itemId)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error'] || $itemInfo['fromUserId'] != $this->getRequestFrom()) {

            return $result;
        }

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE items SET removeAt = (:removeAt), commentsCount = 0, reportsCount = 0, likesCount = 0 WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            // remove all notifications to item

            $notifications = new notifications($this->db);
            $notifications->setRequestFrom($this->getRequestFrom());
            $notifications->remove(NOTIFY_TYPE_LIKE, $itemId); // remove all likes notifications
            $notifications->remove(NOTIFY_TYPE_COMMENT, $itemId); // remove all comments notifications
            $notifications->remove(NOTIFY_TYPE_COMMENT_REPLY, $itemId); // remove all comments replies notifications
            $notifications->remove(NOTIFY_TYPE_ITEM_APPROVED, $itemId); // remove all approved notifications
            $notifications->remove(NOTIFY_TYPE_ITEM_REJECTED, $itemId); // remove all rejected notifications
            unset($notifications);

            //remove all reports to item

            $reports = new reports($this->db);
            $reports->remove(REPORT_TYPE_ITEM ,$itemId);
            unset($reports);

            //remove all comments to item

            //$comments = new comments($this->db);
            //$comments->remove($itemId);
            //unset($comments);

            //remove all likes to item

            $stmt = $this->db->prepare("UPDATE likes SET removeAt = (:removeAt) WHERE itemId = (:itemId) AND removeAt = 0");
            $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
            $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);
            $stmt->execute();

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS);
        }

        $account = new account($this->db, $this->getRequestFrom());
        $account->setItemsCount($this->getItemsCount());
        unset($account);

        return $result;
    }

    public function restore($itemId)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if (!$itemInfo['error']) {

            return $result;
        }

        $stmt = $this->db->prepare("UPDATE items SET removeAt = 0 WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    // Likes

    public function like($itemId)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $itemInfo = $this->info($itemId);

        if ($itemInfo['error'] || $itemInfo['removeAt'] != 0) {

            return $result;
        }

        $timeAt = time();

        if ($itemInfo['myLike']) {

            // My like exists | Delete like (unlike)

            $stmt = $this->db->prepare("UPDATE likes SET removeAt = (:removeAt) WHERE itemId = (:itemId) AND fromUserId = (:fromUserId) AND removeAt = 0");
            $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);
            $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
            $stmt->bindParam(":removeAt", $timeAt, PDO::PARAM_INT);
            $stmt->execute();

            $notifications = new notifications($this->db);
            $notifications->setRequestFrom($this->getRequestFrom());
            $notifications->removeEx($itemInfo['fromUserId'], NOTIFY_TYPE_LIKE, $itemId);
            unset($notifications);

            $itemInfo['likesCount']--;
            $itemInfo['rating'] = $itemInfo['rating'] - ITEM_RATING_LIKE_VALUE;
            $itemInfo['myLike'] = false;

        } else {

            // My like not exists | Add new like (like)

            $ip_addr = helper::ip_addr();

            $stmt = $this->db->prepare("INSERT INTO likes (toUserId, fromUserId, itemId, createAt, ip_addr) value (:toUserId, :fromUserId, :itemId, :createAt, :ip_addr)");
            $stmt->bindParam(":toUserId", $itemInfo['fromUserId'], PDO::PARAM_INT);
            $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);
            $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
            $stmt->bindParam(":createAt", $timeAt, PDO::PARAM_INT);
            $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);
            $stmt->execute();

            $itemInfo['likesCount']++;
            $itemInfo['rating'] = $itemInfo['rating'] + ITEM_RATING_LIKE_VALUE;
            $itemInfo['myLike'] = true;
        }

        $this->setLikesCount($itemInfo['id'], $itemInfo['likesCount'], $itemInfo['rating']);

        $result = array("error" => false,
                        "error_code" => ERROR_SUCCESS,
                        "likesCount" => $itemInfo['likesCount'],
                        "myLike" => $itemInfo['myLike']);

        return $result;
    }

    private function setLikesCount($itemId, $likes_count, $rating)
    {
        $stmt = $this->db->prepare("UPDATE items SET likesCount = (:likesCount), rating = (:rating) WHERE id = (:itemId)");
        $stmt->bindParam(":likesCount", $likes_count, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function getLikesCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM likes WHERE itemId = (:itemId) AND removeAt = 0");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    private function is_like_exists($itemId, $fromUserId)
    {
        $stmt = $this->db->prepare("SELECT id FROM likes WHERE fromUserId = (:fromUserId) AND itemId = (:itemId) AND removeAt = 0 LIMIT 1");
        $stmt->bindParam(":fromUserId", $fromUserId, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            return true;
        }

        return false;
    }

    // Views

    public function setViewsCount($itemId, $views_count, $rating)
    {
        $stmt = $this->db->prepare("UPDATE items SET viewsCount = (:viewsCount), rating = (:rating) WHERE id = (:itemId)");
        $stmt->bindParam(":viewsCount", $views_count, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getViewsCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT viewsCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['viewsCount'];
    }

    // Phone Number Views

    public function setPhoneNumberViewsCount($itemId, $views_count, $rating)
    {
        $stmt = $this->db->prepare("UPDATE items SET phoneViewsCount = (:phoneViewsCount), rating = (:rating) WHERE id = (:itemId)");
        $stmt->bindParam(":phoneViewsCount", $views_count, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getPhoneNumberViewsCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT phoneViewsCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['phoneViewsCount'];
    }

    // Link Shares Count

    public function setSharesCount($itemId, $shares_count, $rating)
    {
        $stmt = $this->db->prepare("UPDATE items SET sharesCount = (:sharesCount), rating = (:rating) WHERE id = (:itemId)");
        $stmt->bindParam(":sharesCount", $shares_count, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getSharesCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT sharesCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['sharesCount'];
    }

    // Reports

    public function setReportsCount($itemId, $count)
    {
        $stmt = $this->db->prepare("UPDATE items SET reportsCount = (:reportsCount) WHERE id = (:itemId)");
        $stmt->bindParam(":reportsCount", $count, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getReportsCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT reportsCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['reportsCount'];
    }

    // Images

    public function setImagesCount($itemId, $images_count)
    {
        $stmt = $this->db->prepare("UPDATE items SET imagesCount = (:imagesCount) WHERE id = (:itemId)");
        $stmt->bindParam(":imagesCount", $images_count, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getImagesCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT imagesCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['imagesCount'];
    }

    // Comments

    public function setCommentsCount($itemId, $comments_count)
    {
        $stmt = $this->db->prepare("UPDATE items SET commentsCount = (:commentsCount) WHERE id = (:itemId)");
        $stmt->bindParam(":commentsCount", $comments_count, PDO::PARAM_INT);
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCommentsCount($itemId)
    {
        $stmt = $this->db->prepare("SELECT commentsCount FROM items WHERE itemId = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row['commentsCount'];
    }

    // Get item info

    public function quickInfo($row)
    {
        $time = new language($this->db, $this->language);

        $myLike = false;

        $profileInfo = array(
            "username" => "",
            "fullname" => "",
            "verified" => false,
            "lowPhotoUrl" => "",
            "phone" => "+1234567891011",
            "online" => false,
            "location" => "");

        $location = "";

        if (strlen($row['country']) > 0) {

            $location = $row['country'];
        }

        if (strlen($row['city']) > 0) {

            if (strlen($location) != 0) {

                $location = $location.", ".$row['city'];

            } else {

                $location = $row['city'];
            }
        }

        $result = array("error" => false,
                        "error_code" => ERROR_SUCCESS,
                        "id" => $row['id'],
                        "itemUrl" => $row['itemUrl'],
                        "appType" => $row['appType'],
                        "category" => $row['category'],
                        "subcategory" => $row['subCategory'],
                        "subCategory" => $row['subCategory'],
                        "phoneNumber" => $row['phoneNumber'],
                        "price" => $row['price'],
                        "currency" => $row['currency'],
                        "categoryTitle" => "",
                        "subcategoryTitle" => "",
                        "fromUserId" => $row['fromUserId'],
                        "fromUserUsername" => $profileInfo['username'],
                        "fromUserFullname" => $profileInfo['fullname'],
                        "fromUserPhone" => $profileInfo['phone'],
                        "fromUserPhoto" => $profileInfo['lowPhotoUrl'],
                        "fromUserPhotoUrl" => $profileInfo['lowPhotoUrl'],
                        "fromUserOnline" => $profileInfo['online'],
                        "fromUserVerified" => $profileInfo['verified'],
                        "fromUserLocation" => $profileInfo['location'],
                        "itemTitle" => htmlspecialchars_decode(stripslashes($row['itemTitle'])),
                        "itemDesc" => htmlspecialchars_decode(stripslashes($row['itemDesc'])),
                        "itemContent" => stripslashes($row['itemContent']),
                        "area" => htmlspecialchars_decode(stripslashes($row['area'])),
                        "country" => htmlspecialchars_decode(stripslashes($row['country'])),
                        "city" => htmlspecialchars_decode(stripslashes($row['city'])),
                        "location" => htmlspecialchars_decode(stripslashes($location)),
                        "lat" => $row['lat'],
                        "lng" => $row['lng'],
                        "previewImgUrl" => $row['previewImgUrl'],
                        "imgUrl" => $row['imgUrl'],
                        "allowComments" => $row['allowComments'],
                        "rating" => $row['rating'],
                        "commentsCount" => $row['commentsCount'],
                        "likesCount" => $row['likesCount'],
                        "imagesCount" => $row['imagesCount'],
                        "reportsCount" => $row['reportsCount'],
                        "viewsCount" => $row['viewsCount'],
                        "phoneViewsCount" => $row['phoneViewsCount'],
                        "sharesCount" => $row['sharesCount'],
                        "myLike" => $myLike,
                        "moderatedAt" => $row['moderatedAt'],
                        "soldAt" => $row['soldAt'],
                        "inactiveAt" => $row['inactiveAt'],
                        "rejectedId" => $row['rejectedId'],
                        "rejectedAt" => $row['rejectedAt'],
                        "modifyAt" => $row['modifyAt'],
                        "removeAt" => $row['removeAt'],
                        "createAt" => $row['createAt'],
                        "date" => date("Y-m-d H:i:s", $row['createAt']),
                        "timeAgo" => $time->timeAgo($row['createAt']));

        return $result;
    }

    public function info($itemId, $url = false)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        if (!$url) {

            $stmt = $this->db->prepare("SELECT * FROM items WHERE id = (:itemId) LIMIT 1");
            $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        } else {

            $stmt = $this->db->prepare("SELECT * FROM items WHERE itemUrl = (:itemUrl) LIMIT 1");
            $stmt->bindParam(":itemUrl", $itemId, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $result = $this->quickInfo($row);

                $myLike = false;

                if ($this->requestFrom != 0) {

                    if ($this->is_like_exists($row['id'], $this->requestFrom)) {

                        $myLike = true;
                    }
                }

                $result['myLike'] = $myLike;

                if ($row['fromUserId'] != 0) {

                    $profile = new profile($this->db, $row['fromUserId']);
                    $profileInfo = $profile->getVeryShort();
                    unset($profile);

                    $result['fromUserVerified'] = $profileInfo['verified'];
                    $result['fromUserUsername'] = $profileInfo['username'];
                    $result['fromUserFullname'] = $profileInfo['fullname'];
                    $result['fromUserPhone'] = $profileInfo['phone'];
                    $result['fromUserPhoto'] = $profileInfo['lowPhotoUrl'];
                    $result['fromUserPhotoUrl'] = $profileInfo['lowPhotoUrl'];
                    $result['fromUserOnline'] = $profileInfo['online'];
                    $result['fromUserLocation'] = $profileInfo['location'];
                }

                $category = new category($this->db);
                $category->setLanguage($this->getLanguage());

                $result['categoryTitle'] = $category->getTitle($result['category']);
                $result['subcategoryTitle'] = $category->getTitle($result['subcategory']);

                unset($category);
            }
        }

        return $result;
    }

    private function isAllowAction($ip_addr)
    {
        $is_allow = true;

        $stmt = $this->db->prepare("SELECT createAt FROM items WHERE ip_addr = (:ip_addr) AND removeAt = 0 ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $new_time = time();
                $time = $new_time - $row['createAt'];

                if ($time < 10) $is_allow = false; // 10 seconds
            }
        }

        return $is_allow;
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

