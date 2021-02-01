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

    class update extends db_connect
    {
        public function __construct($dbo = NULL)
        {
            parent::__construct($dbo);

        }

        // Add emoji support | modify tables charset

        // Emoji for profile/account

        function setProfileFullnameEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE users charset = utf8mb4, MODIFY COLUMN fullname VARCHAR(150) CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        function setProfileBioEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE users charset = utf8mb4, MODIFY COLUMN status VARCHAR(500) CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        // Emoji for items

        function setItemsTitleEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE items charset = utf8mb4, MODIFY COLUMN itemTitle VARCHAR(800) CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        function setItemDetailsEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE items charset = utf8mb4, MODIFY COLUMN itemContent TEXT CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        function setCommentEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE comments charset = utf8mb4, MODIFY COLUMN comment VARCHAR(800) CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        function setChatEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE messages charset = utf8mb4, MODIFY COLUMN message VARCHAR(800) CHARACTER SET utf8mb4");
            $stmt->execute();
        }

        function setDialogsEmojiSupport()
        {
            $stmt = $this->db->prepare("ALTER TABLE chats charset = utf8mb4, MODIFY COLUMN message VARCHAR(800) CHARACTER SET utf8mb4");
            $stmt->execute();
        }
    }