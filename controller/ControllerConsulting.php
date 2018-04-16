<?php
require_once File::build_path(array('model', 'ModelConsulting.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerConsulting
{

    public static $object = 'consulting';

    /**
     * Affiche les détails d'un Consulting grace à son idConsulting @var $_GET ['nConsulting']
     *
     * Il affiche aussi les Modules lié à cet Consulting
     * S'il manque l'idConsulting, l'utilisateur est redirigé vers une erreur
     * Si le Consulting n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelConsulting::select()
     * @uses ModelModule::selectAllByNConsulting()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsulting'])) {
                $consulting = ModelConsulting::select($_GET['nConsulting']);
                if (!$consulting) ControllerMain::erreur("Le consulting n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNConsulting($consulting->getNConsulting());
                    $view = 'detail';
                    $pagetitle = 'Consulting : ' . $consulting->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Consulting
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
            $consulting = new ModelConsulting();
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if ($diplome) $consulting->setCodeDiplome($diplome);
                else $consulting->setCodeDiplome(new ModelDiplome());
            } else $consulting->setCodeDiplome(new ModelDiplome());
            $view = 'update';
            $pagetitle = 'Création d\'un consulting';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsulting']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsulting = ModelConsulting::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsulting']);
                if ($testConsulting) ControllerMain::erreur("Le consulting existe déjà");
                else {
                    if (!ModelConsulting::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsulting' => $_POST['idConsulting'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $consulting = ModelConsulting::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsulting']);
                        $modules = ModelModule::selectAllByNConsulting($consulting->getNConsulting());
                        $view = 'detail';
                        $pagetitle = 'Consulting : ' . $consulting->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un Consulting avec les champs présélectionné/déjà remplit
     *
     * @uses ModelConsulting::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsulting'])) {
                $consulting = ModelConsulting::select($_GET['nConsulting']);
                if (!$consulting) ControllerMain::erreur("Le consulting n'existe pas");
                else {
                    $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
                    $view = 'update';
                    $pagetitle = 'Modification du consulting';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nConsulting']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsulting']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsulting = ModelConsulting::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsulting']);
                if(!$testConsulting || (is_a($testConsulting,'ModelConsulting') && $_POST['nConsulting'] == $testConsulting->getNConsulting())) {
                    $data = array(
                        'nConsulting' => $_POST['nConsulting'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsulting' => $_POST['idConsulting'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelConsulting::update($data)) ControllerMain::erreur("Impossible de modifier le consulting");
                    else {
                        $consulting = ModelConsulting::select($_POST['nConsulting']);
                        $modules = ModelModule::selectAllByNConsulting($consulting->getNConsulting());
                        $view = 'detail';
                        $pagetitle = 'Consulting : ' . $consulting->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Le consulting existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}