<?php
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerUniteDEnseignement
{

    public static $object = 'uniteDEnseignement';

    /**
     * Affiche les détails d'un UE grace à son idUE @var $_GET ['nUE']
     *
     * Il affiche aussi les Modules lié à cet UE
     * S'il manque l'idUE, l'utilisateur est redirigé vers une erreur
     * Si l'UE n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelUniteDEnseignement::select()
     * @uses ModelModule::selectAllByNUE()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cet unité d'enseignement n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNUE($ue->getNUE());
                    $view = 'detail';
                    $pagetitle = 'UE : ' . $ue->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un UE
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
            $ue = new ModelUniteDEnseignement();
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if ($diplome) $ue->setCodeDiplome($diplome);
                else $ue->setCodeDiplome(new ModelDiplome());
            } else $ue->setCodeDiplome(new ModelDiplome());
            $view = 'update';
            $pagetitle = 'Création d\'une unité d\'enseignement';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idUE']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testUe = ModelUniteDEnseignement::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idUE']);
                if ($testUe) ControllerMain::erreur("Cette unité d'enseignement existe déjà");
                else {
                    if (!ModelUniteDEnseignement::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idUE' => $_POST['idUE'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $ue = ModelUniteDEnseignement::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idUE']);
                        $modules = ModelModule::selectAllByNUE($ue->getNUE());
                        $view = 'detail';
                        $pagetitle = 'UE : ' . $ue->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un UE avec les champs présélectionné/déjà remplit
     *
     * @uses ModelUniteDEnseignement::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cet unité d'enseignement n'existe pas");
                else {
                    $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
                    $view = 'update';
                    $pagetitle = 'Modification d\'une unité d\'enseignement';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nUE']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idUE']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testUe = ModelUniteDEnseignement::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idUE']);
                if(!$testUe || (is_a($testUe,'ModelUniteDEnseignement') && $_POST['nUE'] == $testUe->getNUE())) {
                    $data = array(
                        'nUE' => $_POST['nUE'],
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

}