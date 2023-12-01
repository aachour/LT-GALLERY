
    <?php

    class CropAvatar {
        private $src;
        private $data;
        private $dir;
        private $dst;
        private $type;
        private $extension;
        private $msg;
        private $image_directory;
        private $image_width;
        private $image_height;

        
        
        function __construct($src, $data, $file, $avatar_directory, $avatar_width, $avatar_height){

            //print_r($data);
            
            $dataArray = json_decode($data,true);
            //print_r($dataArray);
            
            $tmpWidth=round(@$dataArray["width"]);
            $tmpHeight=round(@$dataArray["height"]);
            
            $this->image_directory=$avatar_directory;
            if($avatar_width!=""){
                $this->image_width=$avatar_width;
            }else{
                $this->image_width=$tmpWidth;
            }
            if($avatar_height!=""){
                $this->image_height=$avatar_height;
            }else{
                $this->image_height=$tmpHeight;
            }
            
            $this -> setData($data);
            $this -> setSrc($src,$this -> data);
            $this -> setFile($file, $this -> data);
            $this -> crop($this -> src, $this -> dst, $this -> data);
        }
        
        
        private function setSrc($src,$data) {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
            $this -> src = $src;
            $this -> type = $type;
            $this -> extension = image_type_to_extension($type);
            $this -> setDst($data);
            }
        }
        }

        private function setData($data) {
        if (!empty($data)) {
            $this -> data = json_decode(stripslashes($data));
        }
        }

        private function setFile($file,$data) {
        $errorCode = $file['error'];

        if ($errorCode === UPLOAD_ERR_OK) {
            $type = exif_imagetype($file['tmp_name']);

            if ($type) {
            $extension = image_type_to_extension($type);
            $src = '../../'.$this->image_directory.'/originals/' . date('YmdHis') . '.original' . $extension;
            if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

                if (file_exists($src)) {
                unlink($src);
                }

                $result = move_uploaded_file($file['tmp_name'], @$src);

                if ($result) {
                $this -> src = $src;
                $this -> type = $type;
                $this -> extension = $extension;
                $this -> setDst($data);
                } else {
                $this -> msg = 'Failed to save file'.$src;
                }
            } else {
                $this -> msg = 'Please upload image with the following types: JPG, PNG, GIF';
            }
            } else {
            $this -> msg = 'Please upload image file';
            }
        } else {
            $this -> msg = $this -> codeToMessage($errorCode);
        }
        }

        private function setDst($data) {
        //$this -> dst = '../'.$data -> directory_folder.'/images/' . date('YmdHis') . '.png';
        $this -> dst = '../../'.$this->image_directory.'/images/' . date('YmdHis') . '.png';
        
        }

        private function crop($src, $dst, $data) {
        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this -> type) {
            case IMAGETYPE_GIF:
                $src_img = imagecreatefromgif($src);
                break;

            case IMAGETYPE_JPEG:
                $src_img = imagecreatefromjpeg($src);
                break;

            case IMAGETYPE_PNG:
                $src_img = imagecreatefrompng($src);
                break;
            }

            if (!$src_img) {
            $this -> msg = "Failed to read the image file";
            return;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data -> rotate;

            // Rotate the source image
            if (is_numeric($degrees) && $degrees != 0) {
            // PHP's degrees is opposite to CSS's degrees
            $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

            imagedestroy($src_img);
            $src_img = $new_img;

            $deg = abs($degrees) % 180;
            $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

            $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
            $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

            // Fix rotated image miss 1px issue when degrees < 0
            $src_img_w -= 1;
            $src_img_h -= 1;
            }

            $tmp_img_w = $data -> width;
            $tmp_img_h = $data -> height;
            $dst_img_w = $this->image_width;
            $dst_img_h = $this->image_height;
            

            $src_x = $data -> x;
            $src_y = $data -> y;

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
            $src_x = $src_w = $dst_x = $dst_w = 0;
            } else if ($src_x <= 0) {
            $dst_x = -$src_x;
            $src_x = 0;
            $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
            } else if ($src_x <= $src_img_w) {
            $dst_x = 0;
            $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
            $src_y = $src_h = $dst_y = $dst_h = 0;
            } else if ($src_y <= 0) {
            $dst_y = -$src_y;
            $src_y = 0;
            $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
            } else if ($src_y <= $src_img_h) {
            $dst_y = 0;
            $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
            }

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            $dst_x=(int)($dst_x);
            $dst_y=(int)($dst_y);
            $src_x=(int)($src_x);
            $src_y=(int)($src_y);
            $dst_w=(int)($dst_w);
            $dst_h=(int)($dst_h);
            $src_w=(int)($src_w);
            $src_h=(int)($src_h);
            
            $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

            if ($result) {
            if (!imagepng($dst_img, $dst)) {
                $this -> msg = "Failed to save the cropped image file";
            }
            } else {
            $this -> msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
        }

        private function codeToMessage($code) {
        $errors = array(
            UPLOAD_ERR_INI_SIZE =>'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE =>'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL =>'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE =>'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR =>'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE =>'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION =>'File upload stopped by extension',
        );

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return 'Unknown upload error';
        }

        public function getResult() {
        return !empty($this -> data) ? $this -> dst : $this -> src;
        }

        public function getMsg() {
        return $this -> msg;
        }
    }

    $crop = new CropAvatar(
        isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
        isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
        isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null,
        isset($_POST['avatar_directory']) ? $_POST['avatar_directory'] : null,
        isset($_POST['avatar_width']) ? $_POST['avatar_width'] : null,
        isset($_POST['avatar_height']) ? $_POST['avatar_height'] : null
    );

    $response = array(
        'state'  => 200,
        'message' => $crop -> getMsg(),
        'result' => $crop -> getResult()
    );

    echo json_encode($response);


    //echo memory_get_usage() . "\n"; // 36640