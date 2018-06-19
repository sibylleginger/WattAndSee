<?php
//DONE
require_once File::build_path(array('model', 'ModelNote.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelUser.php'));

/**
 * Class ControllerUser
 */
class ControllerNote
{

    /**
     * @var string nom de la table
     */
    protected static $object = 'Note';


    /**
     * Affiche tous les commentaires associés à un projet
     *
     * @var $_POST['codeProjet'] int code du projet
     * @uses ModelNote::selectAllByProjet(codeProjet)
     */
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
     * Affiche le formulaire d'ajout d'un commentaire à un projet
     *
     * @var $_GET['codeProjet'] int code du projet
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
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
            }
        } else ControllerUser::connect();
    }

    /**
     * Créé le commentaire avec les informations du formulaire
     *
     * @uses ModelNote::save(data)
     * @see ControllerNote::readAllByProjet()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['comment']) && isset($_POST['dateNote']) && isset($_POST['codeProjet']) && isset($_POST['mailUser'])) {
                    $data = array('comment' => $_POST['comment'],
                                'dateNote' => $_POST['dateNote'],
                                'codeProjet' => $_POST['codeProjet'],
                                'mailUser' => $_POST['mailUser']);
                    if (ModelNote::save($data)) {
                        ControllerNote::readAllByProjet();
                    }else ControllerMain::erreur("Impossible d'ajouter un commentaire");
                }else ControllerMain::erreur('Il manque des informations');
            }
        }else ControllerMain::connect();
    }
}
