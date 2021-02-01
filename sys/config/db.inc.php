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

$C = array();
$B = array();

$B['APP_DEMO'] = false;                                    //true = enable demo version mode (only for Admin panel)
$B['APP_HTTPS'] = false;                                   //true = you use https; false = you use http
$B['APP_ALLOW_API_REQUESTS'] = true;                       //true = allow api requests for apps
$B['APP_EMOJI_SUPPORT'] = true;                            //true = enable emoji in text | database set to "SET NAMES utf8mb4"
$B['APP_MYSQLI_EXTENSION'] = true;                         //true = if on the server installed mysqli extension, false = if not installed mysqli extension
$B['APP_ADMIN_PANEL'] = "admin";                           //folder name to admin panel access. Do not change, if you do not understand why it is needed
                                                           // Examples for APP_ADMIN_PANEL constant:
                                                           // a) if APP_ADMIN_PANEL = "admin", then the authorization in admin panel is: yousite.com/admin/login
                                                           // b) if APP_ADMIN_PANEL = "cpanel", then authorization in admin panel is: yousite.com/cpanel/login
$B['APP_USE_CLIENT_SECRET'] = true;                        //true = protection against bot registration using hash generation is enabled

$B['WEB_UNDER_CONSTRUCTION'] = false;                      //true = show only under construction page | Api for app will be work
$B['WEB_ALLOW_LOGIN'] = true;                              //true = allow users login to site
$B['WEB_ALLOW_SIGNUP'] = true;                             //true = allow users signup on site
$B['WEB_ALLOW_AUTHORIZATION'] = true;                      //true = allow users authorizations on site
$B['WEB_ALLOW_SOCIAL_AUTHORIZATION'] = true;               //false = Do not show buttons Login/Signup with Facebook (or others networks) | true = allow display buttons Login/Signup with Facebook and etc.
$B['WEB_SHOW_ONLY_MODERATED_ADS_BY_DEFAULT'] = true;       //true = Do not show unmoderated ads | false = allow display all ads by default | users can change this value in filters

$B['APP_MESSAGES_COUNTERS'] = true;                         //true = show new messages counters in chats list

// Max file sizes for uploaded images

$B['FILE_COVER_MAX_SIZE'] = 3145728;                        //Maximum file size in bytes | 3145728 = 3mb
$B['FILE_PHOTO_MAX_SIZE'] = 3145728;                        //Maximum file size in bytes | 3145728 = 3mb
$B['FILE_ITEM_MAX_SIZE'] = 3145728;                         //Maximum file size in bytes | 3145728 = 3mb

// Data for the title of the website and copyright

$B['APP_NAME'] = "snb.today";                            //
$B['APP_TITLE'] = "Sell and Buy Today - Classifieds website"; // Title in browser tab
$B['APP_YEAR'] = "2020";                                 // Year in footer

// Your domain name (host)! See comments! Carefully!
// For xampp use APP_HOST constant value = "localhost"

$B['APP_HOST'] = "avaskmapp.xyz"; // your domain name (WARNING - without http://, https:// and www), for example: yourdomain.com

// Links to GOOGLE Play and Apple App Store | Set constant values to empty if not using

$B['GOOGLE_PLAY_LINK'] = "https://play.google.com/store/apps/details?id=ru.ifsoft.mymarketplace";
$B['APPLE_APP_STORE_LINK'] = "";

$B['FACEBOOK_PAGE_LINK'] = "https://www.facebook.com/snb.today";

// Client ID. For identify Apps | Example: 12567 (see documentation. section: faq)

$B['CLIENT_ID'] = 1; // Integer. Must be the same in the app config (Constants.java or/and Constants.swift) and in this config (db.inc.php)

// Client Secret. For generate hashes
$B['CLIENT_SECRET'] = "Af_0W1+8v91h_YMhYT*&7="; // Characters. Must be the same in the app config (Constants.java or/and Constants.swift) and in this config (db.inc.php)

// Firebase settings | For sending FCM (Firebase Cloud Messages) | http://ifsoft.co.uk/help/how_to_generate_sender_id_and_api_key/

$B['FIREBASE_API_KEY'] = "AAAAz7GwS2o:APA91bH222pr2p-eS1e6DFUBsdfsdfsdfsdf";
$B['FIREBASE_SENDER_ID'] = "3454563563456";

// Google maps API Key

$B['GOOGLE_MAPS_API_KEY'] = "AIzaSyBsrjTEwsdfduP26fgAKZ-wmNSFhoZxsa23468d0";

// Facebook settings | For login/signup with facebook | http://ifsoft.co.uk/help/how_to_create_facebook_application_and_get_app_id_and_app_secret/

$B['FACEBOOK_APP_ID'] = "234234234234234";
$B['FACEBOOK_APP_SECRET'] = "429aesdf9bb1e938ergdb88b23466bf1a742cdff5";

// SMTP Settings | For password recovery | Data for SMTP can ask your hosting provider |

$B['SMTP_HOST'] = 'mysite.com';                              //SMTP host | Specify main and backup SMTP servers
$B['SMTP_DEBUG'] = 0;                                        //SMTP Debug
$B['SMTP_AUTH'] = true;                                      //SMTP auth (Enable SMTP authentication)
$B['SMTP_SECURE'] = 'tls';                                   //SMTP secure (Enable TLS encryption, `ssl` also accepted)
$B['SMTP_PORT'] = 587;                                       //SMTP port (TCP port to connect to)
$B['SMTP_EMAIL'] = 'support@mysite.com';                     //SMTP email
$B['SMTP_USERNAME'] = 'support@mysite.com';                  //SMTP username
$B['SMTP_PASSWORD'] = 'mysmtppassword';                      //SMTP password

// Database | Please edit database data
// If you use xampp, set values for DB_HOST = "localhost", DB_USER = "root" and for DB_NAME = "you database name"

$B['DB_HOST'] = "localhost";                                //localhost or your db host
$B['DB_USER'] = "avaskmap_classify";                             //your db user
$B['DB_PASS'] = "avaskmap_classify";                         //your db password
$B['DB_NAME'] = "avaskmap_classify";                             //your db name

// Languages. For more information see documentation, section: Adding a new language (WEB SITE)

$LANGS = array();
$LANGS['English'] = "en";
$LANGS['Indonesian'] = "in";
$LANGS['Русский'] = "ru";

// Additional information. It does not affect the work applications and website

$B['APP_VERSION'] = "1";
$C['APP_COMPANY_URL'] = "http://codecanyon.net/user/qascript/portfolio?ref=qascript";
$B['APP_SUPPORT_EMAIL'] = "raccoonsquare@gmail.com";
$B['APP_AUTHOR'] = "Demyanchuk Dmitry";
$B['APP_VENDOR'] = "ifsoft.co.uk";

// Paths to folders for storing images. Do not change!

$B['TEMP_PATH'] = "tmp/";                                //don`t edit this option
$B['TMP_PATH'] = "tmp/";                                 //don`t edit this option
$B['COVER_PATH'] = "cover/";                             //don`t edit this option
$B['PHOTO_PATH'] = "photo/";                             //don`t edit this option
$B['CHAT_IMAGE_PATH'] = "chat/";                         //don`t edit this option
$B['ITEMS_PHOTO_PATH'] = "items/";                       //don`t edit this option
$B['CATEGORIES_PHOTO_PATH'] = "categories/";             //don`t edit this option

// Some calculations for constants. Do not change!

if ($B['APP_HTTPS']) {

    $B['APP_URL'] = "https://".$B['APP_HOST'];

} else {

    $B['APP_URL'] = "http://".$B['APP_HOST'];
}

$B['APP_PCODE'] = false;
$B['APP_ACCOUNT_ID'] = 1;