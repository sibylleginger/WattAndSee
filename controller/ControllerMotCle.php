<?php
require_once File::build_path(array('model', 'ModelAAP.php'));
require_once File::build_path(array('model', 'ModelDiplome.php'));

class ControllerAAP
{

    private static $object = 'ModelAAP';

    /** WAS DEPARTEMENT
     * Affiche une liste de tous les AAP
     *
     * Affiche une erreur s'il n'y a pas de AAP
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelAAP::selectAll();
            if (!$tab) ControllerMain::erreur("Il n'y a pas d'appels à projets'");
            else {
                $view = 'list';
                $pagetitle = 'Appels à projets';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les détils d'un AAP grace à son code @var $_GET ['codeAAP']
     *
     * Affiche aussi les diplomes appartenant à ce AAP
     *
     * S'il n'y a pas de codeAAP, l'utilisateur est redirigé vers une erreur
     * Si le AAP n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelAAP::select()
     * @uses ModelProjet::selectAllByAAP()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeAAP'])) {
                $aap = ModelAAP::select($_GET['codeAAP']);
                if (!$dep) ControllerMain::erreur("Le AAP n'existe pas");
                else {
                    $tab = ModelProjet::selectAllByAAP($_GET['codeAAP']);
                    $view = 'detail';
                    $pagetitle = 'AAP : ' . $dep->getNomAAP();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un AAP
     *
     * @uses ModelBatiment::selectAll()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $aap = new ModelAAP();
            $sources = ModelSourceFin::selectAll();
            $view = 'update';
            $pagetitle = 'Nouveau appel à projets';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé le AAP à partir des informations fournies grace au formulaire de création
     *
     * S'il manque des informations, l'utilisateur est redirigé vers une erreur
     * Si la création échoue, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelAAP::save()
     * @uses ControllerAAP::readAll()
     *
     * @see  ControllerAAP::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeAAP']) &&
                isset($_POST['nomAAP']) &&
                isset($_POST['nomSource'])) {
                if (!ModelAAP::save(array(
                    'codeAAP' => $_POST['codeAAP'],
                    'nomAAP' => $_POST['nomAAP'],
                    'nomSource' => $_POST['nomSource']
                ))) ControllerMain::erreur("Impossible de créer l'appel à projets");
                else {
                    ControllerAAP::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de maj d'un AAP identifié par son codeAAP @var $_GET ['codeAAP']
     *
     * S'il manque le codeAAP, l'utilisateur est redirigé vers une erreur
     * Si le AAP n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelAAP::select()
     * @uses ModelSource::selectAll()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeAAP'])) {
                $aap = ModelAAP::select($_GET['codeAAP']);
                if (!$dep) ControllerMain::erreur("Le AAP n'existe pas");
                else {
                    $sources = ModelSourceFin::selectAll();
                    $view = 'update';
                    $pagetitle = 'Nouvel appel à projets';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Modifie le AAP dans la BDD grâce aux informations dans @var $_POST
     *
     * S'il manque des informations, l'utilisateur est redirigé vers une erreur
     * Si la maj ne fonctionne pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelAAP::update()
     * @uses ControllerAAP::readAll()
     *
     * @see ControllerAAP::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeAAP']) &&
                isset($_POST['nomAAP']) &&
                isset($_POST['nomSource'])) {
                if(!ModelAAP::update(array(
                    'codeAAP' => $_POST['codeAAP'],
                    'nomAAP' => $_POST['nomAAP'],
                    'nomSource' => $_POST['nomSource']
                ))) ControllerMain::erreur("Impossible de modifier l'appel à projets");
                else ControllerAAP::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime le AAP grace à son codeAAP @var $_GET['codeAAP']
     *
     * S'il n'y a pas de codeAAP, l'utilisateur est redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelAAP::delete()
     * @uses ControllerAAP::readAll()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if(isset($_GET['codeAAP'])) {
                if(!ModelAAP::delete($_GET["codeAAP"])) ControllerMain::erreur("Impossible de supprimer ce département");
                else ControllerAAP::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}