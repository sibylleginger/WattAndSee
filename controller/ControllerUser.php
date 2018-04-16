<?php

require_once File::build_path(array('model', 'ModelUser.php'));
require_once File::build_path(array('lib', 'Security.php'));

/**
 * Class ControllerUser
 */
class ControllerUser
{

    /**
     * @var string
     */
    protected static $object = 'user';

    /**
     * Affiche tous les utilisateurs
     */
    public static function readAll()
    {
        if (isset($_SESSION['login']) && $_SESSION['is_admin']) {
            $tab = ModelUser::selectAll();
            if ($tab == false) {
                ControllerMain::erreur("Il n'y a pas d'utilisateurs");
            } else {
                $view = 'list';
                $pagetitle = 'Liste utilisateurs';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else {
            ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
    }

    /**
     * Affiche les details d'un utilisateur
     */
    public static function read()
    {
        if (isset($_GET['mailUser']) && isset($_SESSION['login']) && $_SESSION['is_admin']) {
            $mail = $_GET['mailUser'];
            $user = ModelUser::select($mail);
            if ($user == false) {
                ControllerMain::erreur('L\'utilisateur n\'existe pas');
            } else {
                $view = 'detail';
                $pagetitle = 'Utilisateur : ' . htmlspecialchars($user->getMailUser());
                require_once File::build_path(array('view', 'view.php'));
            }
        } elseif (isset($_SESSION['login'])) {
            $user = ModelUser::select($_SESSION['login']);
            if ($user == false) {
                session_destroy();
                ControllerMain::erreur("Votre compte a été supprimé");
            } else {
                $view = 'detail';
                $pagetitle = 'Mon Compte';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
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
        if (isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_GET['mailUser'] == $_SESSION['login'])) {
            $view = 'update';
            $pagetitle = 'Création d\'un nouvel utilisateur';
            $p = new ModelUser();
            require File::build_path(array('view', 'view.php'));
        } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
    }

    /**
     * Créé l'utilisateur
     */
    public static function created()
    {
        if (isset($_POST['mailUser']) &&
            isset($_POST['passwordUser']) &&
            isset($_POST['passwordUser2']) &&
            isset($_SESSION['login']) &&
            ($_SESSION['is_admin'] || $_GET['mailUser'] == $_SESSION['login'])) {
            if (is_string($_POST['mailUser']) &&
                is_string($_POST['passwordUser']) &&
                is_string($_POST['passwordUser2'])) {
                if (!filter_var($_POST['mailUser'], FILTER_VALIDATE_EMAIL)) {
                    ControllerMain::erreur("Adresse mail invalide");
                } elseif (ModelUser::select($_POST['mailUser']) != false) ControllerMain::erreur('Cette adresse mail est déjà utilisé dans le site');
                else {
                    if ($_POST['passwordUser'] == $_POST['passwordUser2']) {
                        $data = array(
                            'mailUser' => $_POST['mailUser'],
                            'passwordUser' => Security::chiffrer($_POST['passwordUser'])
                        );
                        if (!ModelUser::save($data)) {
                            ControllerMain::erreur("Impossible d'inscrire l'utilisateur");
                        } else {
                            ControllerUser::connect();
                        }
                    } else {
                        ControllerUser::create();
                    }
                }
            } else {
                ControllerMain::erreur("Il manque des informations");
            }
        } else {
            ControllerMain::erreur("Les informations ne sont pas valides");
        }
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

    /**
     * Affiche le formulaire de connexion
     */
    public static function connect()
    {
        if (!isset($_SESSION['login'])) {
            $view = 'connect';
            $pagetitle = 'Connexion';
            $mauvais_mdp = false;
            require File::build_path(array('view', 'view.php'));
        } else ControllerMain::erreur("Vous êtes déjà connecté");
    }


    /**
     * Connecte l'utilisateur s'il a donné les bons identifiants
     */
    public static function connected()
    {
        if (isset($_POST['login']) &&
            isset($_POST['mdp'])) {
            if (is_string($_POST['login']) &&
                is_string($_POST['mdp'])) {
                if (ModelUser::checkPassword($_POST['login'], Security::chiffrer($_POST['mdp']))) {
                    $user = ModelUser::select($_POST['login']);
                    $_SESSION['login'] = $user->getMailUser();
                    $_SESSION['is_admin'] = $user->getAdmin();
                    if (isset($_POST['save'])) setcookie('login', $_POST['login'], time() + 7257600); // 12 semaines
                    $view = 'detail';
                    $pagetitle = 'Mon profil';
                    require_once File::build_path(array('view', 'view.php'));
                } else {
                    $view = 'connect';
                    $pagetitle = 'Connexion';
                    $mauvais_mdp = true;
                    require File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Les informations ne sont pas valide");
        } else ControllerMain::erreur("Il manque des informations");
    }

    /**
     * Déconnecte un utilisateur
     *
     * Redirige vers l'accueil du site (Inteface de connexion)
     */
    public static function deconnect()
    {
        session_destroy();
        header('Location: index.php');
    }

    /**
     * Met à jour un utilisateur
     *
     * Redirige vers la liste des utilisateurs
     */
    public static function setAdmin()
    {
        if (isset($_GET['mailUser']) &&
            isset($_SESSION['login']) &&
            $_SESSION['is_admin']) {
            if (ModelUser::setAdmin($_GET['mailUser'])) {
                ControllerUser::readAll();
            } else ControllerMain::erreur("Impossible de donner les droits administrateur");
        } else ControllerMain::erreur("Vous n'avez pas le droit de réaliser cette action");
    }

}
