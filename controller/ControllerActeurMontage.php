<?php
require_once File::build_path(array('model', 'ModelActeurMontage.php'));
require_once File::build_path(array('model', 'ModelModule.php'));

class ControllerActeurMontage
{

    public static $object = 'ActeurMontage';

    /** WAS UNITE D'ENSEIGNEMENT
     * Affiche les détails d'un Acteur grace à son idActeur @var $_GET ['nActeur']
     *
     * Il affiche aussi les Modules(projets???) lié à cet Acteur
     * S'il manque l'idActeur, l'utilisateur est redirigé vers une erreur
     * Si l'Acteur n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelActeurMontage::select()
     * @uses ModelModule::selectAllByNActeur()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nActeur'])) {
                $acteur = ModelActeurMontage::select($_GET['nActeur']);
                if (!$acteur) ControllerMain::erreur("Cet acteur n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNActeur($acteur->getNActeur());
                    $view = 'detail';
                    $pagetitle = 'Acteur : ' . $acteur->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Acteur
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
            $acteur = new ModelActeurMontage();
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if ($diplome) $acteur->setCodeDiplome($diplome);
                else $acteur->setCodeDiplome(new ModelDiplome());
            } else $acteur->setCodeDiplome(new ModelDiplome());
            $view = 'update';
            $pagetitle = 'Création d\'un acteur';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idActeur']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testActeur = ModelActeurMontage::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idActeur']);
                if ($testActeur) ControllerMain::erreur("Cet acteur existe déjà");
                else {
                    if (!ModelActeurMontage::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idActeur' => $_POST['idActeur'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $acteur = ModelActeurMontage::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idActeur']);
                        $modules = ModelModule::selectAllByNActeur($acteur->getNActeur());
                        $view = 'detail';
                        $pagetitle = 'Acteur : ' . $acteur->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un Acteur avec les champs présélectionné/déjà remplit
     *
     * @uses ModelActeurMontage::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nActeur'])) {
                $acteur = ModelActeurMontage::select($_GET['nActeur']);
                if (!$acteur) ControllerMain::erreur("Cet acteur n'existe pas");
                else {
                    $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
                    $view = 'update';
                    $pagetitle = 'Modification d\'un acteur';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nActeur']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idActeur']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testActeur = ModelActeurMontage::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idActeur']);
                if(!$testActeur || (is_a($testActeur,'ModelActeurMontage') && $_POST['nActeur'] == $testActeur->getNActeur())) {
                    $data = array(
                        'nActeur' => $_POST['nActeur'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idActeur' => $_POST['idActeur'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelActeurMontage::update($data)) ControllerMain::erreur("Impossible de modifier l'acteur");
                    else {
                        $acteur = ModelActeurMontage::select($_POST['nActeur']);
                        $modules = ModelModule::selectAllByNActeur($acteur->getNActeur());
                        $view = 'detail';
                        $pagetitle = 'Acteur : ' . $acteur->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cet acteur existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}