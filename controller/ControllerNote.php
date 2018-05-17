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
        if (isset($_GET['mailUser']) &&
            isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_GET['mailUser'] == $_SESSION['login'])) {
            $mail = $_GET['mailUser'];
            $user = ModelUser::select($mail);
            if ($user == false) {
                ControllerMain::erreur("Cet utilisateur n'existe pas");
            } else {
                $view = 'confirm';
                $pagetitle = 'Confirmation de la suppression';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");

    }

    /**
     * Supprime l'utilisateur
     */
    public static function deleted()
    {
        if (isset($_GET['mailUser']) &&
            isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_GET['mailUser'] == $_SESSION['login'])) {
            $mail = $_GET['mailUser'];
            $user = ModelUser::delete($mail);
            if ($user == false) {
                ControllerMain::erreur("Cet utilisateur n'existe pas");
            } else {
                header('Location: index.php');
            }
        } else {
            ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
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

    /**
     * Affiche le formulaire pour mettre à jour les informations d'un utilisateur
     */
    public static function update()
    {
        if (isset($_GET['mailUser']) &&
            isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_GET['mailUser'] == $_SESSION['login'])) {
            $p = ModelUser::select($_GET['mailUser']);
            if (!$p) ControllerMain::erreur("Cet utilisateur n'existe pas");
            else {
                $view = 'update';
                $pagetitle = 'Modification du profil';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
    }

    /**
     * Met à jour les informations d'un utilisateur
     */
    public static function updated()
    {
        if (isset($_POST['mailUser']) &&
            isset($_POST['passwordUser']) &&
            isset($_POST['passwordUser2']) &&
            isset($_POST['ancienMail']) &&
            isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_POST['mailUser'] == $_SESSION['login'])) {
            if (is_string($_POST['mailUser']) &&
                is_string($_POST['passwordUser']) &&
                is_string($_POST['passwordUser2'])) {
                if ($_POST['passwordUser'] == $_POST['passwordUser2']) {
                    $data = array(
                        "mailUser" => $_POST['mailUser'],
                        "passwordUser" => Security::chiffrer($_POST['passwordUser']),
                        "ancienMail" => $_POST['ancienMail']
                    );
                    if (!ModelUser::update($data)) {
                        ControllerMain::erreur("Impossible d'enregistrer les modifications");
                    } else {
                        $view = 'detail';
                        $pagetitle = 'Profil';
                        $user = ModelUser::select($_POST['mailUser']);
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Les 2 mots de passes ne sont pas identiques");
            } else ControllerMain::erreur("Les informations ne sont pas valide");
        } else ControllerMain::erreur("Il manque des informations");
    }

    

}
