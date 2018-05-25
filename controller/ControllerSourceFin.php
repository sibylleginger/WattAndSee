<?php
require_once File::build_path(array('model', 'ModelSourceFin.php'));

class ControllerSourceFin
{

    protected static $object = 'sourceFin';

    /**
     * Redirige vers le centre de recherche des enseignants
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelEnseignant::selectAll()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $sourcesFin = ModelSourceFin::selectAll();
            $view = 'list';
            $pagetitle = 'Programmes de financement';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers la fiche détaillé d'un enseignant désigné par @var $_GET ['codeEns']
     *
     * Affiche aussi tous les modules dans lesquels il a enseigné
     *
     * @uses ModelEnseignant::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeSourceFin'])) {
                $sourceFin = ModelSourceFin::select($_GET['codeSourceFin']);
                if (!$sourceFin) ControllerMain::erreur("Le programme n'existe pas");
                else {
                    $tabProjet = ModelProjet::selectAllBySource($_GET['codeSourceFin']);
                    $tabContact = ModelContact::selectAllBySource($_GET['codeSourceFin']);
                    $view = 'detail';
                    $pagetitle = 'Programme : ' . $sourceFin->getNomSourceFin();
                    require_once File::build_path(array('view', 'view.php'));
                }
            }else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de création d'un enseignant
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $sourceFin = new ModelSourceFin();
            $view = 'update';
            $pagetitle = 'Créer un programme de financement';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un enseignant en récupérant les données du formulaire passé en méthode POST
     *
     * @uses ModelEnseignant::save()
     * @see  ControllerEnseignant::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomSourceFin'])) {
                $data = array(
                    'nomSourceFin' => $_POST['nomSourceFin']);
                if (!ModelSourceFin::save($data)) ControllerMain::erreur("Impossible d'enregistrer le programme");
                else ControllerSourceFin::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime l'enseignant désigné par @var $_GET ['codeEns']
     *
     * @uses ModelEnseignant::delete()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeSourceFin'])) {
                if (!ModelSourceFin::delete($_GET["codeSourceFin"])) ControllerMain::erreur("Impossible de supprimer le programme");
                else {
                    ControllerSourceFin::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de mise à jour des informations d'un enseignant
     *
     * Si l'enseignant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::select();
     * @uses ModelDepartement::selectAll()
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeSourceFin'])) {
                $sourceFin = ModelSourceFin::select($_GET['codeSourceFin']);
                if (!$sourceFin) ControllerMain::erreur("Le programme n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification de : ' . $sourceFin->getNomSourceFin();
                    require_once File::build_path(array('view', 'view.php'));
                }
            }
        } else ControllerUser::connect();
    }

    /**
     * Met à jour les informations d'un enseignant avec les informations fournies via la méthode POST
     *
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @see  ControllerEnseignant::update()
     * @uses ModelEnseignant::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeSourceFin']) && $_POST['nomSourceFin']) {
                $data = array(
                    'codeSourceFin' => $_POST['codeSourceFin'],
                    'nomSourceFin' => $_POST['nomSourceFin']);
                if (!ModelSourceFin::update($data)) ControllerMain::erreur("Impossible de modifier l'enseignant");
                else {
                    ControllerSourceFin::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche la liste des enseignants appartenant à un département (@var $_POST ['codeDepartement'])
     *
     * S'il manque le codeDepartement, l'utilisateur est redirigé vers une erreur
     * S'il n'y a aucun professeurs dans ce département, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::selectAllByDepartement()
     */
    public static function searchByDep()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDepartement'])) {
                $tab = ModelEnseignant::selectAllByDepartement($_POST['codeDepartement']);
                if (!$tab) ControllerMain::erreur("Il n'y a aucun professeurs dans ce département");
                else {
                    $view = 'list';
                    $pagetitle = 'Enseignants';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche la liste des enseignants appartenant à un statut (@var $_POST ['codeStatut'])
     *
     * S'il manque le codeStatut, l'utilisateur est redirigé vers une erreur
     * S'il n'y a aucun professeurs dans ce département, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::selectAllByStatut()
     */
    public static function searchByStatut()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeStatut'])) {
                $tab = ModelEnseignant::selectAllByStatut($_POST['codeStatut']);
                if (!$tab) ControllerMain::erreur("Il n'y a aucun professeurs avec ce statut");
                else {
                    $view = 'list';
                    $pagetitle = 'Enseignants';
                    require_once File::build_path(array('view', 'view.php'));
                }
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les details de l'enseignant grâce son code (@var $_POST ['codeEns'])
     *
     * S'il manque le codeEns, l'utilisateur est redirigé vers une erreur
     * S'il l'enseignant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::select()
     */
    public static function searchByCode()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeEns'])) {
                $ens = ModelEnseignant::select($_POST['codeEns']);
                if (!$ens) ControllerMain::erreur("Cet enseigant n'existe pas");
                else {
                    $view = 'detail';
                    $pagetitle = 'Enseignant : ' . $_POST['codeEns'];
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche la liste des enseignants ayant (@var $_POST ['npEns']) dans leur nom
     *
     * S'il manque le npEns, l'utilisateur est redirigé vers une erreur
     * S'il n'y a aucun professeurs avec ce nom, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::selectAllByName()
     */
    public static function searchByName()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['npEns'])) {
                $tab = ModelEnseignant::selectAllByName($_POST['npEns']);
                if (!$tab) ControllerMain::erreur("Il n'y a aucun professeurs avec ce nom");
                else {
                    $view = 'list';
                    $pagetitle = 'Enseignants';
                    require_once File::build_path(array('view', 'view.php'));
                }
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche la liste des cours d'un enseignant identifié par @var $_GET['codeEns']
     *
     * S'il n'y a pas de codeEns, l'utilisateur est redirigé vers une erreur
     * Si l'enseignant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::select()
     * @uses ModelCours::selectAllByEns()
     */
    public static function getListCours() {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeEns'])) {
                $ens = ModelEnseignant::select($_GET['codeEns']);
                if (!$ens) ControllerMain::erreur("L'enseignant n'existe pas");
                else {
                    $listCours = ModelCours::selectAllByEns($_GET['codeEns']);
                    $view = 'coursEnseignant';
                    $pagetitle = 'Cours effectués par : ' . $ens->getCodeEns();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}