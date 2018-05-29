<?php
require_once File::build_path(array('model', 'ModelParticipation.php'));
require_once File::build_path(array('model', 'ModelParticipant.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ControllerParticipation
{

    public static $object = 'Participation';

    /**
     * NOT WORKING
     *
     * setters?
     */
    public static function setCoordinateur() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                if (!ModelParticipation::select($_POST['codeProjet'],$_POST['codeParticipant'])) {
                    echo 'Le participant n\'est pas impliqué dans le projet';
                }else {
                    $res = ModelParticipation::setCoordinateurProjet($_POST['codeProjet'], $_POST['codeParticipant']);
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
            if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                $res = ModelParticipation::delete($_POST['codeProjet'], $_POST['codeParticipant']);
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
            if (isset($_POST['codeProjet']) && isset($_POST['codeParticipant'])) {
                $res = ModelParticipation::add($_POST['codeProjet'],$_POST['codeParticipant'],'0',0);
                if ($res) {
                    echo "true";
                }else {
                    echo $res;
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}