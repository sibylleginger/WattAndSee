<?php

require_once File::build_path(array('model', 'ModelDocument.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerUser
 */
class ControllerDocument
{

    /**
     * @var string
     */
    protected static $object = 'Document';

    /**
     * Affiche tous les utilisateurs
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelDocument::selectAll();
            if ($tab == false) {
                ControllerMain::erreur("Il n'y a pas de documents");
            } else {
                $view = 'list';
                $pagetitle = 'Liste des documents';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else {
            ControllerMain::connect();
        }
    }

    public static function readAllByProjet() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                $projet = ModelProjet::select($_POST['codeProjet']);
            }elseif (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
            }
            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabDoc = ModelDocument::selectAllByProjet($projet->getCodeProjet());
            $view = 'list';
            $pagetitle = 'Documents du projet';
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
            $projet = ModelProjet::select($_GET['codeProjet']);
            $view = 'create';
            $pagetitle = 'Ajout d\'un nouveau document';
            $document = new ModelDocument();
            require File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé l'utilisateur
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            $allDocNames = ModelDocument::selectAllNames();
            foreach ($allDocNames as $value) {
                if ($_FILES['namePJ']['name'] == $value) {
                    ControllerMain::erreur('Un document avec le même nom existe déja');
                }
            }if ($_FILES['namePJ']['error'] == 2) {
                ControllerMain::erreur("Le document dépasse la taille maximale autorisée");
            }else {
                //This is the directory where images will be saved
                $target = "./docs/";
                $target = $target . basename( $_FILES['namePJ']['name']);
                if(move_uploaded_file($_FILES['namePJ']['tmp_name'], $target)) {
                    //This gets all the other information from the form
                    $data = array('namePJ' => $_FILES['namePJ']['name'],
                                    'titre' => $_POST['titre'],
                                    'codeProjet' => $_POST['codeProjet']);
                    if(ModelDocument::save($data)) {
                        ControllerNote::readAllByProjet();
                    }else ControllerMain::erreur('Impossible d\'ajouter un fichier');
                } else {
                    //Gives and error if its not
                    ControllerMain::erreur("Sorry, there was a problem uploading your file.");
                }
            }
        }else ControllerUser::connect();
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
