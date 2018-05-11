<?php
require_once File::build_path(array('model', 'ModelConsortium.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ControllerConsortium
{

    public static $object = 'consortium';

    /**
     * Affiche les détails d'un Consortium grace à son idConsortium @var $_GET ['nConsortium']
     *
     * Il affiche aussi les Modules lié à ce Consortium
     * S'il manque l'idConsortium, l'utilisateur est redirigé vers une erreur
     * Si le Consortium n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelConsortium::select()
     * @uses ModelModule::selectAllByNConsortium()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsortium'])) {
                $consortium = ModelConsortium::select($_GET['nConsortium']);
                if (!$consortium) ControllerMain::erreur("Ce consortium n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNConsortium($consortium->getNConsortium());
                    $view = 'detail';
                    $pagetitle = 'Consortium : ' . $consortium->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Consortium
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $tabProjet = ModelProjet::selectAll();
            $consortium = new ModelConsortium();
            $view = 'update';
            $pagetitle = 'Création d\'un consortium';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsortium']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsortium = ModelConsortium::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsortium']);
                if ($testConsortium) ControllerMain::erreur("Ce consortium existe déjà");
                else {
                    if (!ModelConsortium::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsortium' => $_POST['idConsortium'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $consortium = ModelConsortium::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsortium']);
                        $modules = ModelModule::selectAllByNConsortium($consortium->getNConsortium());
                        $view = 'detail';
                        $pagetitle = 'Consortium : ' . $consortium->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un Consortium avec les champs présélectionné/déjà remplit
     *
     * @uses ModelConsortium::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsortium'])) {
                $consortium = ModelConsortium::select($_GET['nConsortium']);
                if (!$consortium) ControllerMain::erreur("Ce consortium n'existe pas");
                else {
                    $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
                    $view = 'update';
                    $pagetitle = 'Modification d\'un consortium';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nConsortium']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsortium']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsortium = ModelConsortium::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsortium']);
                if(!$testConsortium || (is_a($testConsortium,'ModelConsortium') && $_POST['nConsortium'] == $testConsortium->getNConsortium())) {
                    $data = array(
                        'nConsortium' => $_POST['nConsortium'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsortium' => $_POST['idConsortium'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelConsortium::update($data)) ControllerMain::erreur("Impossible de modifier le consortium");
                    else {
                        $consortium = ModelConsortium::select($_POST['nConsortium']);
                        $modules = ModelModule::selectAllByNConsortium($consortium->getNConsortium());
                        $view = 'detail';
                        $pagetitle = 'Consortium : ' . $consortium->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Ce consortium existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}