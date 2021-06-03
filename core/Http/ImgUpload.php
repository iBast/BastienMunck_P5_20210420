<?php

namespace Core\Http;

class ImgUpload
{
    private $directory;
    public $redim = true;
    public $redim_height = 400;
    public $redim_width = 400;

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

                    $taille = getimagesize($_FILES[$key][self::DIR_TEMPORARY]);
                    $largeur = $taille[0];
                    $hauteur = $taille[1];
                    $largeur_miniature = $this->redim_width;
                    $hauteur_miniature = $hauteur / $largeur * $this->redim_width;

                    $img = \imagecreatefromjpeg($_FILES[$key][self::DIR_TEMPORARY]);
                    $im_miniature = \imagecreatetruecolor(
                        $largeur_miniature,
                        $hauteur_miniature
                    );


                    $retour = $name . '.' . $extension;

                    if (!\imagecopyresampled($im_miniature, $img, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur)) {
                        $retour = 'erreur creation miniature'  . ' (imagecopyresampled ' . $destination . ')';
                    } elseif (!\imagejpeg($im_miniature, $destination, 90)) {
                        $retour = 'erreur image' . ' (imagejpeg '  . $destination . ')';
                    }
                } catch (\InvalidArgumentException $ex) {
                    $retour =  $ex->getMessage();
                }
            }
        }

        return $retour;
    }
}
