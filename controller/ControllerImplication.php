<?php
require_once File::build_path(array('model', 'ModelImplication.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ControllerImplication
{

    public static $object = 'Implication';

    /**
     * Attribue le rôle de chef de projet à un contact de EDF de code @var $_POST['codeContact'] impliqué dans le projet de code @var $_POST['codeProjet']. Retourne 'true' ou false si erreur
     * Set the role of projet leader to a contact of id @var $_POST['codeContact'] involved in the project of id @var $_POST['codeProject']. Return 'true' or false if error.  
     *
     * @uses ModelImplication::select($codeProjet,$codeContact)
     * @uses ModelImplication::setChefProjet()
     *
     * @return 'true' string|error message string
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
            }else echo('Il manque des informations');
        }else ControllerUser::connect();
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