<?php

require_once File::build_path(array('model', 'ModelDeadLine.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerUser
 */
class ControllerDeadLine
{

    /**
     * @var string
     */
    protected static $object = 'DeadLine';


    public static function readAll() {
        if(isset($_SESSION['login'])) {
            ModelDeadLine::updateTable();
            $tab = ModelDeadLine::selectAll();
            if (!$tab) {
                ControllerMain::erreur('Il n\'y a pas d\'évènement');
            }
            $dates = ModelDeadLine::selectDates();
            $view = 'calendrier';
            $pagetitle = 'Calendrier';
            require_once File::build_path(array('view','view.php' ));
        }else ControllerUser::connect();
    }

    public static function readAllByProjet() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                $projet = ModelProjet::select($_POST['codeProjet']);
            }elseif (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
            }
            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabComment = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
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
            if (isset($_POST['codeDeadLine'])) {
                if (!ModelDeadLine::delete($_POST['codeDeadLine'])) {
                    echo 'Impossible de supprimer la date d\'échéance';
                    exit();
                }else {
                    echo 'true';
                    exit();
                }
            }else echo 'Il manque des informations';
        } else ControllerUser::connect();

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
            $dateDeadLine = date('Y-m-d');
            $projet = ModelProjet::select($_GET['codeProjet']);
            if (!$projet) {
                ControllerMain::error('Le projet n\'existe pas');
            }
            $view = 'create';
            $pagetitle = 'Ajouter une échéance sur le projet';
            $deadLine = new ModelDeadLine();
            require File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé l'utilisateur
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomDeadLine']) && isset($_POST['dateDeadLine']) && isset($_POST['codeProjet'])) {
                $data = array('dateDeadLine' => $_POST['dateDeadLine'],
                            'nomDeadLine' => $_POST['nomDeadLine'],
                            'codeProjet' => $_POST['codeProjet']);
                if (ModelDeadLine::save($data)) {
                    ControllerProjet::read();   
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
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomDeadLine']) &&
                isset($_POST['dateDeadLine']) &&
                isset($_POST['codeProjet'])) {
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
            } else ControllerMain::erreur("Les informations ne sont pas valides");
        } else ControllerMain::erreur("Il manque des informations");
    }

    

}
