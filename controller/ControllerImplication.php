<?php
//DONE
require_once File::build_path(array('model', 'ModelImplication.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ControllerImplication
{

    public static $object = 'Implication';

    /**
     * Attribue le rôle de chef de projet à un contact impliqué dans le projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeContact'] int code du contact
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelImplication::select($codeProjet,$codeContact)
     * @uses ModelImplication::setChefProjet()
     *
     * @return 'true' string|error message string
     */
    public static function setChef() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
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
            }else echo("Vous n'avez pas le droit de modifier les contacts")
        }else ControllerUser::connect();
    }
    
    /**
     * Supprime l'implication d'un contact à un projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeContact'] int code du contact
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelImplication::delete($codeProjet,$codeContact)
     *
     * @return 'true' string|error message string
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeProjet']) && isset($_POST['codeContact'])) {
                    $res = ModelImplication::delete($_POST['codeProjet'], $_POST['codeContact']);
                    if ($res){
                        echo 'true';
                    }else {
                        echo $res;
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else echo("Vous n'avez pas le droit de modifier les contacts")
        } else ControllerUser::connect();
    }

    /**
     * Ajoute un contact à un projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeContact'] int code du contact
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelImplication::add($codeProjet,$codeContact)
     *
     * @return 'true' string|error message string
     */
    public static function add()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeProjet']) && isset($_POST['codeContact'])) {
                    $res = ModelImplication::add($_POST['codeProjet'],$_POST['codeContact'],'0');
                    if ($res) {
                        echo "true";
                    }else {
                        echo $res;
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else echo("Vous n'avez pas le droit de modifier les contacts")
        } else ControllerUser::connect();
    }

}