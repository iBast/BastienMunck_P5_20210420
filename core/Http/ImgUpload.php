<?php

namespace Core\Http;

class ImgUpload
{
    private $directory;
    public $redim = true;
    public $redim_height = 200;
    public $redim_width = 200;

    const DIR_TEMPORARY = 'tmp_name';

    public function __construct($directory)
    {
        $this->directory = $directory;
        if (!is_dir('../public/img/' .  $this->directory)) {
            mkdir('../public/img/' .  $this->directory);
        }
    }

    public function resizeImage($key, $name)
    {
        $retour = '';
        if (isset($_FILES[$key]['name'])) {
            if ($_FILES[$key]['error'] == '1') {
                $retour = 'erreur upload';
            } elseif (isset($_FILES[$key][self::DIR_TEMPORARY]) && $_FILES[$key]['type'] == 'image/jpeg') {
                try {
                    $destination = '../public/img/' .  $this->directory . '/' . $name . '.jpg';
                    $temp = explode(".", $destination);
                    $extension = end($temp);
                    //suppression de la photo si elle est déjà présente
                    if (\file_exists($destination)) {
                        \unlink($destination);
                    }
                    $img = \imagecreatefromjpeg($_FILES[$key][self::DIR_TEMPORARY]);
                    $size = min(imagesx($img), imagesy($img));
                    if (imagesx($img) * 1.2 < imagesy($img)) {
                        $img_min = \imagecrop($img, ['x' => 0, 'y' => $size / 2, 'width' => $size, 'height' => $size]);
                    } elseif (imagesx($img) > imagesy($img)  * 1.2) {
                        $img_min = \imagecrop($img, ['x' => $size / 2, 'y' => 0, 'width' => $size, 'height' => $size]);
                    } else {
                        $img_min = \imagecrop($img, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
                    }
                    if ($img_min !== FALSE) {
                        \imagejpeg($img_min, $destination);
                        \imagedestroy($img_min);
                    }
                    \imagedestroy($img);

                    $retour = $name . '.' . $extension;
                } catch (\InvalidArgumentException $ex) {
                    $retour =  $ex->getMessage();
                }
            }
        }

        return $retour;
    }
}
