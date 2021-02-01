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

class imglib extends db_connect
{
    private $requestFrom = 0;

    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    public function setCorrectImageOrientation($filename) {

        $imgInfo = getimagesize($filename);

        if ($imgInfo[2] == IMAGETYPE_JPEG) {

            if (function_exists('exif_read_data')) {

                $exif = @exif_read_data($filename);

                if ($exif && isset($exif['Orientation'])) {

                    $orientation = $exif['Orientation'];

                    if ($orientation != 1) {

                        $img = imagecreatefromjpeg($filename);
                        $deg = 0;

                        switch ($orientation) {

                            case 3:

                                $deg = 180;

                                break;

                            case 6:

                                $deg = 270;

                                break;

                            case 8:

                                $deg = 90;

                                break;
                        }

                        if ($deg) {

                            $img = imagerotate($img, $deg, 0);
                        }

                        imagejpeg($img, $filename, 95); // rewrite rotated image back to $filename
                    }
                }
            }
        }
    }

    public function isImageFile($filename, $png = true, $gif = true)
    {
        $imagefile = true;

        $whitelist_type = array('image/jpeg');

        if ($png) {

            $whitelist_type[] = 'image/png';
        }

        if ($gif) {

            $whitelist_type[] = 'image/gif';
        }

        if (function_exists('finfo_open')) {

            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);

            if (!$fileinfo) {

                $imagefile  = false; // Uploaded file is not a valid image

            } else {

                if (!in_array(finfo_file($fileinfo, $filename), $whitelist_type)) {

                    $imagefile  = false; // Uploaded file is not a valid image
                }
            }

        } else {

            //@ - for hide warning when image not valid

            if (!@getimagesize($filename)) {

                $imagefile  = false; // Uploaded file is not a valid image
            }
        }

        return $imagefile;
    }

    public function isWidthHeight($filename, $minWidth = 300, $minHeight = 300)
    {
        $fileinfo = @getimagesize($filename);

        // $fileinfo[0] = width
        // $fileinfo[1] = height

        if ($fileinfo[0] < $minWidth || $fileinfo[1] < $minHeight) {

            return false;

        } else {

            return true;
        }
    }

    public function createImage($filename, $resize = true, $correctOrientation = false, $maxWidth = 800)
    {
        $result = array("error" => true,
                        "error_code" => ERROR_SUCCESS,
                        "filename" => "");

        $new_filename = TEMP_PATH.$this->getRequestFrom().'_'.helper::generateHash(3).'_'.basename($filename); // create new for file

        if ($correctOrientation) {

            $this->setCorrectImageOrientation($filename);
        }

        if ($resize) {

            // Set max width. default max width 800px

            if (!$this->img_resize($filename, $new_filename, $maxWidth, 0)) {

                rename($filename, $new_filename);

            } else {

                unlink($filename);
            }

        } else {

            rename($filename, $new_filename);
        }

        if (file_exists($new_filename)) {

            $result['error'] = false;
            $result['filename'] = $new_filename;
        }

        return $result;
    }

    public function createItemImg($filename, $resize = true, $correctOrientation = false)
    {
        $result = $this->createImage($filename, $resize, $correctOrientation, 800);

        if (!$result['error']) {

            $cdn = new cdn($this->db);

            $result = $cdn->uploadItemImg($result['filename']);

            unset($cdn);
        }

        return $result;
    }

    public function createItemImgThumbnail($filename)
    {
        $big_thumbnail = TEMP_PATH."t_".basename($filename); // name for thumbnail file

        // Create big thumbnail

        $thumbnail = new thumbnail($this->db, $filename, 255);

        if ($thumbnail->getMimeType() == IMAGETYPE_JPEG) {

            imagejpeg($thumbnail->getImgData(), $big_thumbnail, 100);

        } else {

            imagepng($thumbnail->getImgData(), $big_thumbnail);
        }

        unset($thumbnail);

        // Upload image

        $cdn = new cdn($this->db);

        $result = $cdn->uploadItemImg($big_thumbnail);

        return $result;
    }

    public function createCoverImg($filename, $resize = true, $correctOrientation = false)
    {
        $result = $this->createImage($filename, $resize, $correctOrientation, 800);

        if (!$result['error']) {

            $cdn = new cdn($this->db);

            $result = $cdn->uploadCoverImg($result['filename']);

            unset($cdn);
        }

        return $result;
    }

    public function createChatImg($filename, $resize = true, $correctOrientation = false)
    {
        $result = $this->createImage($filename, $resize, $correctOrientation, 800);

        if (!$result['error']) {

            $cdn = new cdn($this->db);

            $result = $cdn->uploadChatImg($result['filename']);

            unset($cdn);
        }

        return $result;
    }

    public function createPhotoImg($filename, $resize = true, $correctOrientation = false)
    {
        $result = $this->createImage($filename, $resize, $correctOrientation, 800);

        if (!$result['error']) {

            $origin_img = $result['filename'];
            $big_thumbnail = TEMP_PATH.$this->getRequestFrom().'_512_'.helper::generateHash(3).'_'.basename($filename);
            $low_thumbnail = TEMP_PATH.$this->getRequestFrom().'_256_'.helper::generateHash(3).'_'.basename($filename);

            // Create big thumbnail

            $thumbnail = new thumbnail($this->db, $origin_img, 512);

            if ($thumbnail->getMimeType() == IMAGETYPE_JPEG) {

                imagejpeg($thumbnail->getImgData(), $big_thumbnail, 100);

            } else {

                imagepng($thumbnail->getImgData(), $big_thumbnail);
            }

            unset($thumbnail);

            // Create low thumbnail

            $thumbnail = new thumbnail($this->db, $origin_img, 256);

            if ($thumbnail->getMimeType() == IMAGETYPE_JPEG) {

                imagejpeg($thumbnail->getImgData(), $low_thumbnail, 100);

            } else {

                imagepng($thumbnail->getImgData(), $low_thumbnail);
            }

            unset($thumbnail);

            // Upload images

            $cdn = new cdn($this->db);

            $response = $cdn->uploadPhotoImg($origin_img);

            if (!$response['error']) {

                $result['normalPhotoUrl'] = $response['fileUrl'];
                $result['originPhotoUrl'] = $response['fileUrl'];
            }

            $response = $cdn->uploadPhotoImg($big_thumbnail);

            if (!$response['error']) {

                $result['bigPhotoUrl'] = $response['fileUrl'];
            }

            $response = $cdn->uploadPhotoImg($low_thumbnail);

            if (!$response['error']) {

                $result['lowPhotoUrl'] = $response['fileUrl'];
            }
        }

        return $result;
    }

    /***********************************************************************************
    Функция img_resize(): генерация thumbnails
    Параметры:
    $src             - имя исходного файла
    $dest            - имя генерируемого файла
    $width, $height  - ширина и высота генерируемого изображения, в пикселях
    Необязательные параметры:
    $rgb             - цвет фона, по умолчанию - белый
    $quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
     ***********************************************************************************/
    public function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
    {

        if (!file_exists($src)) return false;

        $size = getimagesize($src);

        if ($size === false) return false;

        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = 'imagecreatefrom'.$format;

        if (!function_exists($icfunc)) return false;

        $x_ratio = $width  / $size[0];
        $y_ratio = $height / $size[1];

        if ($height == 0) {

            $y_ratio = $x_ratio;
            $height  = $y_ratio * $size[1];

        } elseif ($width == 0) {

            $x_ratio = $y_ratio;
            $width   = $x_ratio * $size[0];
        }

        $ratio       = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width)   / 2);
        $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        // если не нужно увеличивать маленькую картинку до указанного размера
        if ($size[0] < $new_width && $size[1] < $new_height) {

            $width = $new_width = $size[0];
            $height = $new_height = $size[1];
        }

        $isrc  = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);

        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

        $i = strrpos($dest,'.');
        if (!$i) return '';
        $l = strlen($dest) - $i;
        $ext = substr($dest,$i+1,$l);

        switch ($ext) {

            case 'jpeg':
            case 'jpg':
                imagejpeg($idest, $dest, $quality);
                break;
            case 'gif':
                imagegif($idest, $dest);
                break;
            case 'png':
                imagepng($idest, $dest);
                break;
        }

        imagedestroy($isrc);
        imagedestroy($idest);

        return true;
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
