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

class msg extends db_connect
{

	private $requestFrom = 0;
    private $language = 'en';

    // add spam words to this array list

    private $SPAM_LIST_ARRAY = array(
        "069sex",
        "069sex.com",
        "sex.com",
        "I will fulfill your seхual desires");

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);
	}

    public function activeChatsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM chats WHERE removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function myActiveChatsCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM chats WHERE (fromUserId = (:userId) OR toUserId = (:userId)) AND removeAt = 0");
        $stmt->bindParam(":userId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function messagesCountByChat($chatId)
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM messages WHERE chatId = (:chatId) AND removeAt = 0");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getMessagesCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM messages WHERE removeAt = 0");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getMaxChatId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) FROM chats");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function getMaxMessageId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) FROM messages");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function createChat($fromUserId, $toUserId, $adItemId, $adItemTitle, $message = "") {

	    $spam = new spam($this->db);
	    $spam->setRequestFrom($this->getRequestFrom());

	    if ($spam->getChatsCount() > 10) {

	        return 0;
        }

	    unset($spam);

        if (strlen($message) == 0) {

            $message = "Image";
        }

        $chatId = 0;

        $currentTime = time();

        $stmt = $this->db->prepare("INSERT INTO chats (fromUserId, toUserId, message, messageCreateAt, toItemId, itemTitle, fromUserId_lastView, createAt) value (:fromUserId, :toUserId, :message, :messageCreateAt, :toItemId, :itemTitle, :fromUserId_lastView, :createAt)");
        $stmt->bindParam(":fromUserId", $fromUserId, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId", $toUserId, PDO::PARAM_INT);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);
        $stmt->bindParam(":messageCreateAt", $currentTime, PDO::PARAM_INT);
        $stmt->bindParam(":toItemId", $adItemId, PDO::PARAM_INT);
        $stmt->bindParam(":itemTitle", $adItemTitle, PDO::PARAM_STR);
        $stmt->bindParam(":fromUserId_lastView", $currentTime, PDO::PARAM_INT);
        $stmt->bindParam(":createAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $chatId = $this->db->lastInsertId();
        }

        return $chatId;
    }

    public function getChatId($fromUserId, $toUserId) {

        $chatId = 0;

        $stmt = $this->db->prepare("SELECT id FROM chats WHERE removeAt = 0 AND ((fromUserId = (:fromUserId) AND toUserId = (:toUserId)) OR (fromUserId = (:toUserId) AND toUserId = (:fromUserId))) LIMIT 1");
        $stmt->bindParam(":fromUserId", $fromUserId, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId", $toUserId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $chatId = $row['id'];
            }
        }

        return $chatId;
    }

    public function getAdChatId($fromUserId, $toUserId, $adItemId) {

        $chatId = 0;

        $stmt = $this->db->prepare("SELECT id FROM chats WHERE removeAt = 0 AND toItemId = (:adItemId) AND ((fromUserId = (:fromUserId) AND toUserId = (:toUserId)) OR (fromUserId = (:toUserId) AND toUserId = (:fromUserId))) LIMIT 1");
        $stmt->bindParam(":fromUserId", $fromUserId, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId", $toUserId, PDO::PARAM_INT);
        $stmt->bindParam(":adItemId", $adItemId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $chatId = $row['id'];
            }
        }

        return $chatId;
    }

    public function create($toUserId, $chatId,  $message = "", $imgUrl = "", $adItemId = 0, $adItemTitle = "", $listId = 0)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $new_chat = false;

        if (strlen($imgUrl) == 0 && strlen($message) == 0) {

            return $result;
        }

        if (strlen($imgUrl) != 0 && strpos($imgUrl, APP_HOST) === false) {

            return $result;
        }

        if ($this->checkSpam($message, $this->SPAM_LIST_ARRAY)) {

            return $result;
        }

        if ($chatId == 0) {

            $chatId = $this->getAdChatId($this->getRequestFrom(), $toUserId, $adItemId);

            if ($chatId == 0) {

                $chatId = $this->createChat($this->getRequestFrom(), $toUserId, $adItemId, $adItemTitle, $message);

                $new_chat = true;
            }
        }

        if ($chatId == 0) {

            return $result;
        }

        $currentTime = time();
        $ip_addr = helper::ip_addr();
        $u_agent = helper::u_agent();

        $stmt = $this->db->prepare("INSERT INTO messages (chatId, fromUserId, toUserId, message, imgUrl, createAt, ip_addr, u_agent) value (:chatId, :fromUserId, :toUserId, :message, :imgUrl, :createAt, :ip_addr, :u_agent)");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);
        $stmt->bindParam(":fromUserId", $this->requestFrom, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId", $toUserId, PDO::PARAM_INT);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);
        $stmt->bindParam(":imgUrl", $imgUrl, PDO::PARAM_STR);
        $stmt->bindParam(":createAt", $currentTime, PDO::PARAM_INT);
        $stmt->bindParam(":ip_addr", $ip_addr, PDO::PARAM_STR);
        $stmt->bindParam(":u_agent", $u_agent, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $msgId = $this->db->lastInsertId();

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS,
                            "chatId" => $chatId,
                            "newChat" => $new_chat,
                            "msgId" => $msgId,
                            "listId" => $listId,
                            "message" => array());

            $time = new language($this->db, $this->language);

            // Delete start

//            $profile = new profile($this->db,  $this->requestFrom);
//            $profileInfo = $profile->getVeryShort();
//            unset($profile);

            // Delete end

            $profileInfo = array(
                "fromUserId" => $this->requestFrom,
                "state" => 0,
                "verify" => 0,
                "verified" => 0,
                "online" => false,
                "username" => "",
                "fullname" => "",
                "lowPhotoUrl" => "");

            $itemInfo = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS,
                "id" => $msgId,
                "fromUserId" => $this->requestFrom,
                "fromUserState" => $profileInfo['state'],
                "fromUserVerified" => $profileInfo['verified'],
                "fromUserVerify" => $profileInfo['verify'],
                "fromUserOnline" => $profileInfo['online'],
                "fromUserUsername" => $profileInfo['username'],
                "fromUserFullname" => $profileInfo['fullname'],
                "fromUserPhotoUrl" => $profileInfo['lowPhotoUrl'],
                "message" => htmlspecialchars_decode(stripslashes($message)),
                "imgUrl" => $imgUrl,
                "createAt" => $currentTime,
                "seenAt" => 0,
                "date" => date("Y-m-d H:i:s", $currentTime),
                "timeAgo" => $time->timeAgo($currentTime),
                "removeAt" => 0);

            $result['message'] = $itemInfo;

            $fcm = new fcm($this->db);
            $fcm->setRequestFrom($this->getRequestFrom());
            $fcm->setRequestTo($toUserId);
            $fcm->setType(GCM_NOTIFY_MESSAGE);
            $fcm->setTitle("You have new message");
            $fcm->setItemId($chatId);
            $fcm->setMessage($itemInfo);
            $fcm->prepare();
            $fcm->send();
            unset($fcm);
        }

        return $result;
    }

    private function checkSpam($str, array $arr)
    {
        foreach($arr as $a) {

            if (stripos($str, $a) !== false) return true;
        }

        return false;
    }

    public function setLastMessageInChat_FromId($chatId, $time, $message, $image, $messageId) {

        if (strlen($message) == 0) {

            if (strlen($image) != 0) {

                $message = "Image";
            }
        }

        $stmt = $this->db->prepare("UPDATE chats SET messageId = (:messageId), message = (:message), messageCreateAt = (:messageCreateAt), fromUserId_lastView = (:fromUserId_lastView) WHERE id = (:chatId)");
        $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);
        $stmt->bindParam(":messageCreateAt", $time, PDO::PARAM_INT);
        $stmt->bindParam(":fromUserId_lastView", $time, PDO::PARAM_INT);
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function setChatLastView_FromId($chatId) {

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE chats SET fromUserId_lastView = (:fromUserId_lastView) WHERE id = (:chatId)");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);
        $stmt->bindParam(":fromUserId_lastView", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function setLastMessageInChat_ToId($chatId, $time, $message, $image, $messageId) {

        if (strlen($message) == 0) {

            if (strlen($image) != 0) {

                $message = "Image";
            }
        }

        $stmt = $this->db->prepare("UPDATE chats SET messageId = (:messageId), message = (:message), messageCreateAt = (:messageCreateAt), toUserId_lastView = (:toUserId_lastView) WHERE id = (:chatId)");
        $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->bindParam(":message", $message, PDO::PARAM_STR);
        $stmt->bindParam(":messageCreateAt", $time, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId_lastView", $time, PDO::PARAM_INT);
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function setChatLastView_ToId($chatId) {

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE chats SET toUserId_lastView = (:toUserId_lastView) WHERE id = (:chatId)");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);
        $stmt->bindParam(":toUserId_lastView", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function removeChat($chatId) {

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE chats SET removeAt = (:removeAt) WHERE id = (:chatId)");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $stmt2 = $this->db->prepare("UPDATE messages SET removeAt = (:removeAt) WHERE chatId = (:chatId)");
            $stmt2->bindParam(":chatId", $chatId, PDO::PARAM_INT);
            $stmt2->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);
            $stmt2->execute();

            $result = array("error" => false,
                            "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }


    public function delete($itemId)
    {
        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN);

        $currentTime = time();

        $stmt = $this->db->prepare("UPDATE messages SET removeAt = (:removeAt) WHERE id = (:itemId)");
        $stmt->bindParam(":itemId", $itemId, PDO::PARAM_INT);
        $stmt->bindParam(":removeAt", $currentTime, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS);
        }

        return $result;
    }

    public function getCurrentMessageIdInChat($chatId)
    {
        $stmt = $this->db->prepare("SELECT messageId FROM chats WHERE id = (:chatId) AND removeAt = 0 LIMIT 1");
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $row = $stmt->fetch();

            return $row['messageId'];
        }

        return 0;
    }

    public function getNewMessagesInChat($chatId, $fromUserId, $fromUserId_lastView, $toUserId_lastView)
    {
        $profileId = $fromUserId;

        if ($profileId == $this->getRequestFrom()) {

            $stmt = $this->db->prepare("SELECT count(*) FROM messages WHERE chatId = (:chatId) AND fromUserId <> (:fromUserId) AND createAt > (:fromUserId_lastView) AND removeAt = 0");
            $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
            $stmt->bindParam(':fromUserId', $this->requestFrom, PDO::PARAM_INT);
            $stmt->bindParam(':fromUserId_lastView', $fromUserId_lastView, PDO::PARAM_INT);

        } else {

            $stmt = $this->db->prepare("SELECT count(*) FROM messages WHERE chatId = (:chatId) AND fromUserId <> (:fromUserId) AND createAt > (:toUserId_lastView) AND removeAt = 0");
            $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
            $stmt->bindParam(':fromUserId', $this->requestFrom, PDO::PARAM_INT);
            $stmt->bindParam(':toUserId_lastView', $toUserId_lastView, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {

            return $number_of_rows = $stmt->fetchColumn();
        }

        return 0;
    }

    public function chatInfo($chatId)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("SELECT * FROM chats WHERE id = (:chatId) LIMIT 1");
        $stmt->bindParam(":chatId", $chatId, PDO::PARAM_INT);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $row = $stmt->fetch();

                $time = new language($this->db, $this->language);

                $profileId = $row['fromUserId'];

                if ($profileId == $this->getRequestFrom()) {

                    $profileId = $row['toUserId'];
                }

                $new_messages_count = 0;

                $profile = new profile($this->db, $profileId);
                $profileInfo = $profile->getVeryShort();
                unset($profile);

                $result = array("error" => false,
                                "error_code" => ERROR_SUCCESS,
                                "id" => $row['id'],
                                "fromUserId" => $row['fromUserId'],
                                "toUserId" => $row['toUserId'],
                                "fromUserId_lastView" => $row['fromUserId_lastView'],
                                "toUserId_lastView" => $row['toUserId_lastView'],
                                "itemTitle" => $row['itemTitle'],
                                "toItemId" => $row['toItemId'],
                                "withUserId" => $profileInfo['id'],
                                "withUserVerify" => $profileInfo['verify'],
                                "withUserVerified" => $profileInfo['verified'],
                                "withUserOnline" => $profileInfo['online'],
                                "withUserState" => $profileInfo['state'],
                                "withUserUsername" => $profileInfo['username'],
                                "withUserFullname" => $profileInfo['fullname'],
                                "withUserPhotoUrl" => $profileInfo['lowThumbnailUrl'],
                                "lastMessageId" => $row['messageId'],
                                "lastMessage" => $row['message'],
                                "lastMessageAgo" => $time->timeAgo($row['messageCreateAt']),
                                "lastMessageCreateAt" => $row['messageCreateAt'],
                                "newMessagesCount" => $new_messages_count,
                                "createAt" => $row['createAt'],
                                "date" => date("Y-m-d H:i:s", $row['createAt']),
                                "timeAgo" => $time->timeAgo($row['createAt']),
                                "removeAt" => $row['removeAt']);

                unset($profileInfo);
            }
        }

        return $result;
    }

    public function getNewMessagesCount()
    {
        $count = 0;

        $stmt = $this->db->prepare("SELECT id, messageCreateAt, toUserId, fromUserId, fromUserId_lastView, toUserId_lastView FROM chats WHERE (fromUserId = (:userId) OR toUserId = (:userId)) AND removeAt = 0");
        $stmt->bindParam(':userId', $this->requestFrom, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                if ($row['toUserId'] == $this->getRequestFrom()) {

                    if ($row['messageCreateAt'] > $row['toUserId_lastView']) {

                        $count++;
                    }

                } else {

                    if ($row['messageCreateAt'] > $row['fromUserId_lastView']) {

                        $count++;
                    }
                }
            }
        }

        return $count;
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
