<?php
//DONE
require_once File::build_path(array('model', 'ModelParticipation.php'));
require_once File::build_path(array('model', 'ModelParticipant.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ControllerParticipation
{

    public static $object = 'Participation';

    /**
     * Attribue le rôle de coordinateur à un participant du consortium du projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeParticipant'] int code du participant
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelParticipation::select($codeProjet,$codeParticipant)
     * @uses ModelParticipation::setCoordinateurProjet($codeProjet,$codeParticipant)
     *
     * @return 'true' string|error message string
     */
    public static function setCoordinateur() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                    if (!ModelParticipation::select($_POST['codeProjet'],$_POST['codeParticipant'])) {
                        echo 'Le participant n\'est pas impliqué dans le consortium';
                    }else {
                        $res = ModelParticipation::setCoordinateurProjet($_POST['codeProjet'], $_POST['codeParticipant']);
                        if ($res) {
                            echo 'true';
                        } else {
                            echo $res;
                        }
                    }
                }else echo('Il manque des informations');
            }else echo("Vous n'avez pas le droit de modifier les participations")
        }else ControllerUser::connect();
    }
    
    /**
     * Supprime l'implication d'un participant à un projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeParticipant'] int code du participant
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelParticipation::delete($codeProjet,$codeParticipant)
     *
     * @return 'true' string|error message string
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                    $res = ModelParticipation::delete($_POST['codeProjet'],$_POST['codeParticipant']);
                    if ($res) {
                        echo "true";
                    }else {
                        echo $res;
                    }
                } else echo("Il manque des informations");
            }else echo('Vous n\'avez pas le droit de modifier les participations');
        } else ControllerUser::connect();
    }

    /**
     * Ajoute un participant au consortium d'un projet. Retourne 'true' ou message si erreur 
     *
     * @var $_POST['codeParticipant'] int code du participant
     * @var $_POST['codeProjet'] int code du projet 
     * @uses ModelParticipation::add($codeProjet,$codeContact)
     *
     * @return 'true' string|error message string
     */
    public static function add()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                    $res = ModelParticipation::add($_POST['codeProjet'],$_POST['codeParticipant'],0,0);
                    if ($res) {
                        echo "true";
                    }else {
                        echo $res;
                    }
                } else echo("Il manque des informations");
            }else echo('Vous n\'avez pas le droit de modifier les participations');
        } else ControllerUser::connect();
    }

}