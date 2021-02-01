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

class helper extends db_connect
{

    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    static function isValidURL($url) {

        return preg_match('|^(http(s)?://)?[a-z0-9-]+\.(.[a-z0-9-]+)+(:[0-9]+)?(/.*)?$|i', $url);
    }

    static function truncate($str, $len)
    {
        $tail = max(0, $len-10);
        $trunk = substr($str, 0, $tail);
        $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len-$tail))));

        return $trunk;
    }

    static function createClickableLinks($matches)
    {
        $title = $face = $matches[0];

        $face = helper::truncate($face, 50);

        $matches[0] = str_replace( "www.", "http://www.", $matches[0] );
        $matches[0] = str_replace( "http://http://www.", "http://www.", $matches[0] );
        $matches[0] = str_replace( "https://http://www.", "https://www.", $matches[0] );

        return "<a title=\"$title\" class=\"posted_link\" target=\"_blank\" href=\"$matches[0]\">$face</a>";
    }

    static function processText($text)
    {
        $text = preg_replace_callback('@(?<=^|(?<=[^a-zA-Z0-9-_\.//]))((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@', "helper::createClickableLinks", $text);

        return $text;
    }

    static function processCommentText($text)
    {
        $text = preg_replace_callback('@(?<=^|(?<=[^a-zA-Z0-9-_\.//]))((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@', "helper::createClickableLinks", $text);

        return $text;
    }

    static function processMsgText($text)
    {
        $text = preg_replace_callback('@(?<=^|(?<=[^a-zA-Z0-9-_\.//]))((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@', "helper::createClickableLinks", $text);

        return $text;
    }

    static function transliterateString($txt) {

        $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');

        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
    }

    static function createLinkFromString($string) {

        $string = helper::transliterateString($string);

        $string = str_replace(', ', '-', $string); // Replaces all commas with hyphens.
        $string = str_replace(',', '-', $string); // Replaces all commas with hyphens.
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        if (strlen($string) == 0) $string = helper::generateHash(7);

        $string = strtolower($string);

        $string = $string."-".helper::generateHash(5).".html";

        $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

        return $string;
    }

    public function getUserId($username)
    {
        $username = helper::clearText($username);
        $username = helper::escapeText($username);

        $stmt = $this->db->prepare("SELECT id FROM users WHERE login = (:username) LIMIT 1");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch();

            return $row['id'];
        }

        return 0;
    }

    public function getUserIdByFacebook($fb_id)
    {
        $fb_id = helper::clearText($fb_id);
        $fb_id = helper::escapeText($fb_id);

        $stmt = $this->db->prepare("SELECT id FROM users WHERE fb_id = (:fb_id) LIMIT 1");
        $stmt->bindParam(":fb_id", $fb_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch();

            return $row['id'];
        }

        return 0;
    }

    public function getUserIdByFacebookIdHash($fb_id_hash)
    {
        $fb_id_hash = helper::clearText($fb_id_hash);
        $fb_id_hash = helper::escapeText($fb_id_hash);

        $stmt = $this->db->prepare("SELECT id FROM users WHERE fb_id_hash = (:fb_id_hash) LIMIT 1");
        $stmt->bindParam(":fb_id_hash", $fb_id_hash, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch();

            return $row['id'];
        }

        return 0;
    }

    public function getUserIdByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = (:email) LIMIT 1");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch();

            return $row['id'];
        }

        return 0;
    }

    public function getRestorePoint($hash)
    {
        $hash = helper::clearText($hash);
        $hash = helper::escapeText($hash);

        $result = array("error" => true,
                        "error_code" => ERROR_UNKNOWN);

        $stmt = $this->db->prepare("SELECT * FROM restore_data WHERE hash = (:hash) AND removeAt = 0 LIMIT 1");
        $stmt->bindParam(":hash", $hash, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch();

            $result = array('error'=> false,
                            'error_code' => ERROR_SUCCESS,
                            'accountId' => $row['accountId'],
                            'hash' => $row['hash'],
                            'email' => $row['email']);
        }

        return $result;
    }

    public function isPhoneExists($user_phone)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE phone = (:phone) LIMIT 1");
        $stmt->bindParam(':phone', $user_phone, PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                return true;
            }
        }

        return false;
    }

    public function isEmailExists($user_email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = (:email) LIMIT 1");
        $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                return true;
            }
        }

        return false;
    }

    public function isLoginExists($username)
    {
        $username = helper::clearText($username);
        $username = helper::escapeText($username);

        if (file_exists("html/page.".$username.".inc.php") || is_dir("html/".$username)) {

            return true;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE login = (:username) LIMIT 1");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                return true;
            }
        }

        return false;
    }

    public function isAdminExists($username)
    {
        $username = helper::clearText($username);
        $username = helper::escapeText($username);

        $stmt = $this->db->prepare("SELECT id FROM admins WHERE username = (:username) LIMIT 1");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                return true;
            }
        }

        return false;
    }

    static function verify_pcode_curl($pcode, $itemId)
    {
        if (!APP_PCODE) {

            return $result = array("verify" => true);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, 'http://www.envato.ifsoft.co.uk/?pcode='.$pcode."&itemId=".$itemId);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }

    static function isCorrectFullname($fullname)
    {
        if (strlen($fullname) > 0) {

            return true;
        }

        return false;
    }

    static function isCorrectPhoneNew($phone_number)
    {
        if (preg_match("/^\+?(?:[0-9] ?){4,14}[0-9]$/", $phone_number)) {

            return true;
        }

        return false;
    }

    static function isCorrectPhone($phone)
    {
        if (preg_match("/^\+(?:[0-9] ?){6,14}[0-9]$/", $phone)) {

            return true;
        }

        return false;
    }

    static function isCorrectLogin($username)
    {
        if (preg_match("/^([a-zA-Z]{4,24})?([a-zA-Z][a-zA-Z0-9_]{4,24})$/i", $username)) {

            return true;
        }

        return false;
    }

    static function isCorrectPassword($password)
    {

        if (preg_match('/^[a-z0-9_\d$@$!%*?&]{6,20}$/i', $password)) {

            return true;
        }

        return false;
    }

    static function isCorrectEmail($email)
    {
        if (preg_match('/[0-9a-z_-]+@[-0-9a-z_^\.]+\.[a-z]{2,3}/i', $email)) {

            return true;
        }

        return false;
    }

    static function getLang($language)
    {
        $languages = array("en",
                           "ru",
                           "id");

        $result = "en";

        foreach($languages as $value) {

            if ($value === $language) {

                $result = $language;

                break;
            }
        }

        return $result;
    }

    static function getContent($url_address) {

        if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_exec')) {

            $curl = curl_init($url_address);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);

            $result = @curl_exec($curl);

            curl_close($curl);

        } else {

            ini_set('default_socket_timeout', 5);

            $result = @file_get_contents($url_address);
        }

        return $result;
    }

    static function clearText($text)
    {
        $text = trim($text);
        $text = strip_tags($text);
        $text = htmlspecialchars($text);

        return $text;
    }

    static  function escapeText($text)
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $text = $mysqli->real_escape_string($text);

        return $text;
    }

    static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    static function isFloat($num) {

        return is_float($num) || is_numeric($num) && ((float) $num != (int) $num);
    }

    static function clearInt($value)
    {
        $value = intval($value);

        if ($value < 0) {

            $value = 0;
        }

        return $value;
    }

    static function ip_addr()
    {
        (string) $ip_addr = 'undefined';

        if (isset($_SERVER['REMOTE_ADDR'])) $ip_addr = $_SERVER['REMOTE_ADDR'];

        return $ip_addr;
    }

    static function u_agent()
    {
        (string) $u_agent = 'undefined';

        if (isset($_SERVER['HTTP_USER_AGENT'])) $u_agent = $_SERVER['HTTP_USER_AGENT'];

        return $u_agent;
    }

    static function generateSocialIdHash($social_id)
    {
        return md5(md5($social_id).CLIENT_SECRET);
    }

    static function generateId($n = 2)
    {
        $key = '';
        $pattern = '123456789';
        $counter = strlen($pattern) - 1;

        for ($i = 0; $i < $n; $i++) {

            $key .= $pattern{rand(0, $counter)};
        }

        return $key;
    }

    static function generateHash($n = 7)
    {
        $key = '';
        $pattern = '123456789abcdefg';
        $counter = strlen($pattern) - 1;

        for ($i = 0; $i < $n; $i++) {

            $key .= $pattern{rand(0, $counter)};
        }

        return $key;
    }

    static function generateSalt($n = 3)
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
        $counter = strlen($pattern)-1;

        for ($i=0; $i<$n; $i++) {

            $key .= $pattern{rand(0,$counter)};
        }

        return $key;
    }

    static function declOfNum($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $number.' '.$titles[ ($number%100>4 && $number%100<20) ? 2 : $cases[($number%10<5) ? $number%10:5] ];
    }

    static function newAuthenticityToken()
    {

        $authenticity_token = md5(uniqid(rand(), true));

        if (isset($_SESSION)) {

            $_SESSION['authenticity_token'] = $authenticity_token;
        }
    }

    static function getAuthenticityToken()
    {
        if (isset($_SESSION) && isset($_SESSION['authenticity_token'])) {

            return $_SESSION['authenticity_token'];

        } else {

            return NULL;
        }
    }
}

