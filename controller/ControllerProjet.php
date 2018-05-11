<?php

require_once File::build_path(array('model', 'ModelProjet.php'));
//require_once File::build_path(array('model', 'ModelSourceFin.php'));

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
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $consortium = ModelConsortium::select($projet->getCodeConsortium());
                    $tabParticipant = ModelParticipant::selectAllByConsortium($consortium->getCodeConsortium());
                    $pagetitle = 'Projet ' . $projet->getNomProjet();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                    
                    /*else {
                        $pagetitle = 'Projet ' . $_GET['nomProjet'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }*/
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update() {
        if (isset($_GET['codeProjet'])){
            if(isset($_SESSION['login'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $tabSource = ModelSourceFin::selectAll();
                    $tabTheme = ModelTheme::selectAll();
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $view = 'update';
                    $pagetitle = 'Modification du projet';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updateContacts() {
        if (isset($_GET['codeProjet'])){
            if(isset($_SESSION['login'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $allContactEDF = ModelContact::selectAllEDF();
                    $allContactHorsEDF = ModelContact::selectAllHorsEDF();
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $tabParticipant = ModelParticipation::selectAllByConsortium($projet->getCodeConsortium());
                    $allParticipant = ModelParticipant::selectAll();
                    $consortium = ModelConsortium::select($projet->getCodeConsortium());
                    $tabParticipant = ModelParticipant::selectAllByConsortium($consortium->getCodeConsortium());
                    $view = 'updateContacts';
                    $pagetitle = 'Modifier les contacts du projet';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) &&
                isset($_POST['nom']) &&
                isset($_POST['statut']) &&
                isset($_POST['financement']) &&
                isset($_POST['dateDepot']) &&
                isset($_POST['description']) &&
                isset($_POST['theme']) &&
                isset($_POST['role'])) {
                /**
                 * Vérification existance
                 */
                $updateProjet = ModelProjet::select($_POST['codeProjet']);
                if(!$updateProjet || $_POST['codeProjet'] == $updateProjet->getCodeProjet()) {
                    $data = array(
                        'codeProjet' => $_POST['codeProjet'],
                        'nomProjet' => $_POST['nom'],
                        'description' => $_POST['description'],
                        'dateDepot' => $_POST['dateDepot'],
                        'dateReponse' => $_POST['dateReponse'],
                        'statut' => $_POST['statut'],
                        'role' => $_POST['role'],
                        'budgetTotal' => $_POST['budgetTotal'],
                        'budgetEDF' => $_POST['budgetEDF'],
                        'subventionTotal' => $_POST['subventionTotal'],
                        'subventionEDF' => $_POST['subventionEDF'],
                        'isExceptionnel' => $_POST['isExceptionnel'],
                        'codeSourceFin' => $_POST['financement'],
                        'codeTheme' => $_POST['theme'],
                        
                    );
                    if(!ModelProjet::update($data)) ControllerMain::erreur("Impossible de modifier le projet");
                    else {
                        $projet = ModelProjet::select($_POST['codeProjet']);
                        $tabContact = ModelImplication::selectAllByProjet($_POST['codeProjet']);
                        $tabParticipant = ModelParticipation::selectAllByConsortium($projet->getCodeConsortium());
                        $sourceFin = ModelSourceFin::select($_POST['financement']);
                        $theme = ModelTheme::select($_POST['theme']);
                        $view = 'detail';
                        $pagetitle = 'Projet : ' . $updateProjet->getNomProjet();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cette unité d'enseignement existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $projet = new ModelProjet();
            //$sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabSource = ModelSourceFin::selectAll();
            $tabTheme = ModelTheme::selectAll();
            $theme = ModelTheme::select($projet->getCodeTheme());
            $view = 'update';
            $pagetitle = 'Créer un nouveau projet';
            require_once File::build_path(array('view', 'view.php'));
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
