<?php
/**
 * Created by PhpStorm.
 * User: tangu
 * Date: 20/10/2017
 * Time: 11:21
 */

class File
{

    public static function build_path($path_array) {
        // $ROOT_FOLDER (sans slash à la fin) vaut
        // "/home/ann2/votre_login/public_html/TD5" à l'IUT
        $DS = DIRECTORY_SEPARATOR;
        $ROOT_FOLDER = __DIR__ . $DS . "..";
        //$ROOT_FOLDER = "C://wamp64/www/td5";
        return $ROOT_FOLDER. $DS . join($DS, $path_array);
    }

}