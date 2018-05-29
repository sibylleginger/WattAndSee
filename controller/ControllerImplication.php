<?php
require_once File::build_path(array('model', 'ModelImplication.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ControllerImplication
{

    public static $object = 'Implication';

    /**
     * NOT WORKING
     *
     * setters?
     */
    public static function setChef() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) && isset($_POST['codeContact'])) {
                if (!ModelImplication::select($_POST['codeProjet'],$_POST['codeContact'])) {
                    echo 'Le contact n\'est pas impliqué dans le projet';
                }else {
                    $res = ModelImplication::setChefProjet($_POST['codeProjet'], $_POST['codeContact']);
                    if ($res) {
                        echo 'true';
                    } else {
                        echo $res;
                    }
                }
            }ControllerMain::erreur('Il manque des informations');
        }ControllerUser::connect();
    }
    
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) && isset($_POST['codeContact'])) {
                $res = ModelImplication::delete($_POST['codeProjet'], $_POST['codeContact']);
                if ($res){
                    echo 'true';
                }else {
                    echo $res;
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function add()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) && isset($_POST['codeContact'])) {
                $res = ModelImplication::add($_POST['codeProjet'],$_POST['codeContact'],'0');
                if ($res) {
                    echo "true";
                }else {
                    echo $res;
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}