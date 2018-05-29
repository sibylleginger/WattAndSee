<?php

require_once File::build_path(array('model', 'ModelNote.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelUser.php'));

/**
 * Class ControllerUser
 */
class ControllerNote
{

    /**
     * @var string
     */
    protected static $object = 'Note';


    public static function readAllByProjet() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                $projet = ModelProjet::select($_POST['codeProjet']);
            }elseif (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
            }
            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabComment = ModelNote::selectAllByProjet($projet->getCodeProjet());
            $view = 'list';
            $pagetitle = 'Commentaires du projet';
            require_once File::build_path(array('view', 'view.php'));
        }else ControllerUser::connect();
    }

    /**
     * Affiche la page de confirmation de suppression
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeNote'])) {
                    if (!ModelNote::select($_GET['codeNote'])) {
                        ControllerMain::erreur('Le commentaire n\'existe pas');
                    }else {
                        if (!ModelNote::delete($_GET['codeNote'])) {
                            ControllerMain::erreur('Impossible de supprimer le commentaire');
                        }else {
                            $projet = ModelProjet::select($_GET['codeProjet']);
                            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                            $tabComment = ModelNote::selectAllByProjet($projet->getCodeProjet());
                            $view = 'list';
                            $pagetitle = 'Commentaires du projet';
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    }
                }else ControllerMain::erreur('Il manque des informations');
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }else ControllerUser::connect();

    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $dateNote = date('Y-m-d');
            $user = ModelUser::select($_SESSION['login']);
            $projet = ModelProjet::select($_GET['codeProjet']);
            if (!$projet) {
                ControllerMain::error('Le projet n\'existe pas');
            }
            $view = 'create';
            $pagetitle = 'Ajouter un nouveau commentaire sur le projet';
            $note = new ModelNote();
            require File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé l'utilisateur
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['comment']) && isset($_POST['dateNote']) && isset($_POST['codeProjet']) && isset($_POST['mailUser'])) {
                $data = array('comment' => $_POST['comment'],
                            'dateNote' => $_POST['dateNote'],
                            'codeProjet' => $_POST['codeProjet'],
                            'mailUser' => $_POST['mailUser']);
                if (ModelNote::save($data)) {
                    /*$projet = ModelProjet::select($_POST['codeProjet']);
                    $controller = 'projet';
                    $view = 'detail';
                    $pagetitle = 'Projet: '. $projet->getNomProjet();
                    require_once File::build_path(array('view', 'view.php'));*/
                    ControllerNote::readAllByProjet();
                }else ControllerMain::erreur("Impossible d'ajouter un commentaire");
            }else ControllerMain::erreur('Il manque des informations');
        }else ControllerMain::connect();
    }
}
