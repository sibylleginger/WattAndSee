<?php
require_once File::build_path(array('model', 'ModelConsultant.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerConsultant
{

    public static $object = 'consultant';

    /**
     * Affiche les détails d'un Consultant grace à son idConsultant @var $_GET ['nConsultant']
     *
     * Il affiche aussi les Modules lié à cet Consultant
     * S'il manqConsultant l'idConsultant, l'utilisateur est redirigé vers une erreur
     * Si l'Consultant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelConsultant::select()
     * @uses ModelModule::selectAllByNConsultant()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsultant'])) {
                $consultant = ModelConsultant::select($_GET['nConsultant']);
                if (!$consultant) ControllerMain::erreur("Ce consultant n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNConsultant($consultant->getNConsultant());
                    $view = 'detail';
                    $pagetitle = 'Consultant : ' . $consultant->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Consultant
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
            $consultant = new ModelConsultant();
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if ($diplome) $consultant->setCodeDiplome($diplome);
                else $consultant->setCodeDiplome(new ModelDiplome());
            } else $consultant->setCodeDiplome(new ModelDiplome());
            $view = 'update';
            $pagetitle = 'Création d\'un consultant';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsultant']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsultant = ModelConsultant::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsultant']);
                if ($testConsultant) ControllerMain::erreur("Ce consultant existe déjà");
                else {
                    if (!ModelConsultant::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsultant' => $_POST['idConsultant'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $consultant = ModelConsultant::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsultant']);
                        $modules = ModelModule::selectAllByNConsultant($consultant->getNConsultant());
                        $view = 'detail';
                        $pagetitle = 'Consultant : ' . $consultant->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un Consultant avec les champs présélectionné/déjà remplit
     *
     * @uses ModelConsultant::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nConsultant'])) {
                $consultant = ModelConsultant::select($_GET['nConsultant']);
                if (!$consultant) ControllerMain::erreur("Ce consultant n'existe pas");
                else {
                    $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
                    $view = 'update';
                    $pagetitle = 'Modification d\'un consultant';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nConsultant']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idConsultant']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testConsultant = ModelConsultant::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idConsultant']);
                if(!$testConsultant || (is_a($testConsultant,'ModelConsultant') && $_POST['nConsultant'] == $testConsultant->getNConsultant())) {
                    $data = array(
                        'nConsultant' => $_POST['nConsultant'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idConsultant' => $_POST['idConsultant'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelConsultant::update($data)) ControllerMain::erreur("Impossible de modifier le consultant");
                    else {
                        $consultant = ModelConsultant::select($_POST['nConsultant']);
                        $modules = ModelModule::selectAllByNConsultant($consultant->getNConsultant());
                        $view = 'detail';
                        $pagetitle = 'Consultant : ' . $consultant->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Ce consultant existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}