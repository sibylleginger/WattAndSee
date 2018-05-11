<?php

require_once File::build_path(array('model', 'ModelContact.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

/**
 * Class ControllerExtraction
 */
class ControllerContact
{

    /**
     * @var string
     */
    protected static $object = 'Contact';


    /**
     * Envoie vers la page d'importation du fichier .csv
     */
     public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelContact::selectAll();
            $view = 'list';
            $pagetitle = "Contacts";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un Contact identifié par son nomContact @var $_GET ['nomContact']
     *
     * Il affiche aussi la liste des salles dans la Contact
     * S'il n'y a pas de nomContact, l'utilisateur sera redirigé vers une erreur
     * Si le Contact n'existe pas, l'utilisateur sera redirigé vers une erreur
     * S'il n'y a aucune salle dans le Contact, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelContact::select()
     * @uses ModelSalle::selectAllByContact()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeContact'])) {
                $Contact = ModelContact::select($_GET['codeContact']);
                if ($Contact == false) ControllerMain::erreur("Ce Contact n'existe pas");
                else {
                    $entite = ModelEntite::select($Contact->getCodeEntite());
                    $departement = ModelDepartement::select($Contact->getCodeDepartement());
                    $tabProjet = ModelImplication::selectAllByContact($_GET['codeContact']);
                    //$tabParticipant = ModelParticipation::selectAllByConsortium($Contact->getCodeConsortium());
                    $pagetitle = 'Contact ' . $Contact->getNomContact();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                    
                    /*else {
                        $pagetitle = 'Contact ' . $_GET['nomContact'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }*/
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update() {
        if (isset($_GET['codeContact'])){
            if(isset($_SESSION['login'])) {
                $Contact = ModelContact::select($_GET['codeContact']);
                if (!$Contact) ControllerMain::erreur("Ce contact n'existe pas");
                else {
                    $sourceFin = ModelSourceFin::select($Contact->getCodeSourceFin());
                    $tabSource = ModelSourceFin::selectAll();
                    $tabTheme = ModelTheme::selectAll();
                    $theme = ModelTheme::select($Contact->getCodeTheme());
                    $view = 'update';
                    $pagetitle = 'Modification du Contact';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeContact']) &&
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
                $updateContact = ModelContact::select($_POST['codeContact']);
                if(!$updateContact || (is_a($updateContact,'Contact') && $_POST['codeContact'] == $updateContact->getCodeContact())) {
                    $data = array(
                        'codeContact' => $_POST['codeContact'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idUE' => $_POST['idUE'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelUniteDEnseignement::update($data)) ControllerMain::erreur("Impossible de modifier l'unité d'enseignement");
                    else {
                        $ue = ModelUniteDEnseignement::select($_POST['nUE']);
                        $modules = ModelModule::selectAllByNUE($ue->getNUE());
                        $view = 'detail';
                        $pagetitle = 'UE : ' . $ue->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cette unité d'enseignement existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $Contact = new ModelContact();
            //$sourceFin = ModelSourceFin::select($Contact->getCodeSourceFin());
            $tabEntite = ModelEntite::selectAll();
            $tabDepartement = ModelDepartement::selectAll();
            $view = 'update';
            $pagetitle = 'Créer un nouveau contact';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un Contact à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelContact::save()
     * @uses ControllerContact::readAll()
     *
     * @see ControllerContact::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomContact'])) {
                if (ModelContact::save(['nomContact' => $_POST['nomContact']])) ControllerContact::readAll();
                else ControllerMain::erreur("Impossible de créer le Contact");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un Contact grace à son nomContact @var $_GET['nomContact']
     *
     * S'il n'y a pas de nomContact, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelContact::delete()
     * @uses ControllerContact::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['nomContact'])) {
                if(ModelContact::delete($_GET['nomContact'])) ControllerContact::readAll();
                else ControllerMain::erreur("Impossible de supprimer le Contact");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}