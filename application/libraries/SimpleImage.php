<?php

/*
 * File: SimpleImage.php
 * Author: Simon Jarvis
 * Copyright: 2006 Simon Jarvis
 * Date: 08/11/06
 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
 * 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
 * GNU General Public License for more details: 
 * http://www.gnu.org/licenses/gpl.html
 *
 */

class SimpleImage {

    var $image;
    var $image_type;

    function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type=IMAGETYPE_JPEG, $compression=90, $permissions=null) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {           
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
        imagedestroy($this->image);
    }
    
    function save_with_default_imagetype($filename, $compression=90, $permissions=null) {
        if ($this->image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {                  
            imagepng($this->image, $filename);
        }
        
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
        imagedestroy($this->image);
    }
    
    function output($image_type=IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    function getWidth() {
        return imagesx($this->image);
    }

    function getHeight() {
        return imagesy($this->image);
    }

    function resizeToHeight($height, $upscale = false) {
        if ($height > $this->getHeight() && $upscale == false) {
            return array('w' => $this->getWidth(), 'h' => $this->getHeight());
        }
        $ratio = $height / $this->getHeight();
        $width = round($this->getWidth() * $ratio);
        $this->resize($width, $height);
        return array('w' => $width, 'h' => $height);
    }

    function resizeToWidth($width, $upscale = false) {
        //no resize 
        if ($width > $this->getWidth() && $upscale == false) {
            return array('w' => $this->getWidth(), 'h' => $this->getHeight());
        }
        $ratio = $width / $this->getWidth();
        $height = round($this->getHeight() * $ratio);
        $this->resize($width, $height);
        return array('w' => $width, 'h' => $height);
    }

    function resizeToFit($maxwidth, $maxheight) {
        if ($this->getWidth() > $this->getHeight()) {
            $this->resizeToWidth($maxwidth);
        }else
            $this->resizeToHeight($maxheight);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function crop($x, $y, $w, $h) {
        $new_image = imagecreatetruecolor($w, $h);
        //echo $this->getHeight();
        imagecopyresampled($new_image, $this->image, 0, 0, $x, $y, $w, $h, $w, $h);
        $this->image = $new_image;
    }

    
    function resize($width, $height, $forcesize='n') {

        /* optional. if file is smaller, do not resize. */
        if ($forcesize == 'n') {
            if ($width > $this->getWidth() && $height > $this->getHeight()) {
                $width = $this->getWidth();
                $height = $this->getHeight();
            }
        }

        $new_image = imagecreatetruecolor($width, $height);
        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG)) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

        $this->image = $new_image;
    }

    function resizeToThumb($thumbw, $thumbh, $align ="center") {
        $w = $this->getWidth();
        $h = $this->getHeight();
        $nw = $nh = 0;
        $thumb_ratio = $thumbw / $thumbh;
        $pix_radio = $w / $h;
        if ($thumb_ratio <= $pix_radio) {
            //echo 'hoz';
            $this->resizeToThumbHorizontal($thumbw, $thumbh, $align);
        } else {
            $this->resizeToThumbVertical($thumbw, $thumbh, $align);
        }
        return array('w' => $thumbw, 'h' => $thumbh);
    }

    function resizeToThumbVertical($thumbw, $thumbh, $align = "center") {
        $nw = $this->getWidth();
        $nh = intval(($thumbh * $nw) / $thumbw);
        if ($align == "center") {
            $src_y = intval(($this->getHeight() - $nh) / 2);
        } else {
            $src_y = 0; // align top
        }
        $new_image = imagecreatetruecolor($thumbw, $thumbh);
        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG)) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $thumbw, $thumbh, $transparent);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, $src_y, $thumbw, $thumbh, $nw, $nh);
        $this->image = $new_image;
    }

    function resizeToThumbHorizontal($thumbw, $thumbh, $align= "center") {
        $nh = $this->getHeight();
        $nw = floor(($thumbw * $nh) / $thumbh);
        if ($align == "center") {
            $src_x = floor(($this->getWidth() - $nw) / 2);
        } else {
            $src_x = 0;
        }
        $new_image = imagecreatetruecolor($thumbw, $thumbh);
        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG)) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $thumbw, $thumbh, $transparent);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, $src_x, 0, $thumbw, $thumbh, $nw, $nh);
        $this->image = $new_image;
    }

    function addWaterMark($fileWaterMark) {
        //$new_image_resized = imagecreatetruecolor($new_width, $new_height);
        //imagecopyresampled($new_image_resized,$sourcefile , 0, 0, 0, 0, $new_width, $new_height, $this->getWidth(), $this->getHeight());

        $water_mark_file = imagecreatefrompng($fileWaterMark);
        $water_mark_file_width = imagesx($water_mark_file);
        $water_mark_file_height = imagesy($water_mark_file);

        $final_image = imagecreatetruecolor($this->getWidth(), $this->getHeight() + $water_mark_file_height);
        $final_image_height = imagesy($final_image);

        imagecopy($final_image, $this->image, 0, 0, 0, 0, $this->getWidth(), $this->getHeight());
        imagecopy($final_image, $water_mark_file, 0, $final_image_height - $water_mark_file_height, 0, 0, $water_mark_file_width, $water_mark_file_height);
        $this->image = $final_image;
    }

}