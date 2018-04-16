<?php

require_once File::build_path(array('model', 'ModelProjet.php'));

class ControllerProjet
{

    protected static $object = 'Projet';

    /**
     * Affiche la liste de tous les Projets
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelProjet::selectAll();
            $view = 'list';
            $pagetitle = "Projets";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un Projet identifié par son nomProjet @var $_GET ['nomProjet']
     *
     * Il affiche aussi la liste des salles dans la Projet
     * S'il n'y a pas de nomProjet, l'utilisateur sera redirigé vers une erreur
     * Si le Projet n'existe pas, l'utilisateur sera redirigé vers une erreur
     * S'il n'y a aucune salle dans le Projet, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelProjet::select()
     * @uses ModelSalle::selectAllByProjet()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if ($projet == false) ControllerMain::erreur("Ce Projet n'existe pas");
                else {
                    $tabEDF = ModelMembreEDF::selectAllByProjet($_GET['codeProjet']);
                    $tabParticipant = ModelParticipation::selectAllByProjet($_GET['codeProjet']);
                    if ($tab == false) ControllerMain::erreur('Aucun membre de EDF impliqué dans ce Projet');
                    else {
                        $pagetitle = 'Projet ' . $_GET['nomProjet'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Crée un Projet à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelProjet::save()
     * @uses ControllerProjet::readAll()
     *
     * @see ControllerProjet::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomProjet'])) {
                if (ModelProjet::save(['nomProjet' => $_POST['nomProjet']])) ControllerProjet::readAll();
                else ControllerMain::erreur("Impossible de créer le Projet");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un Projet grace à son nomProjet @var $_GET['nomProjet']
     *
     * S'il n'y a pas de nomProjet, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelProjet::delete()
     * @uses ControllerProjet::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['nomProjet'])) {
                if(ModelProjet::delete($_GET['nomProjet'])) ControllerProjet::readAll();
                else ControllerMain::erreur("Impossible de supprimer le Projet");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}
