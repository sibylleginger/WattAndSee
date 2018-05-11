<?php
require_once File::build_path(array('model', 'ModelImplication.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ControllerImplication
{

    public static $object = 'Implication';

    /**
     * Affiche les détails d'un Implication grace à son idImplication @var $_GET ['nImplication']
     *
     * Il affiche aussi les Modules lié à cet Implication
     * S'il manque l'idImplication, l'utilisateur est redirigé vers une erreur
     * Si l'Implication n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelImplication::select()
     * @uses ModelModule::selectAllByNImplication()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nImplication'])) {
                $implication = ModelImplication::select($_GET['nImplication']);
                if (!$implication) ControllerMain::erreur("Cette implication n'existe pas");
                else {
                    $modules = ModelModule::selectAllByNImplication($implication->getNImplication());
                    $view = 'detail';
                    $pagetitle = 'Implication : ' . $implication->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Implication
     *
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $departementsXdiplome = ModelDiplome::selectAllOrganizedByDep();
            $implication = new ModelImplication();
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if ($diplome) $implication->setCodeDiplome($diplome);
                else $implication->setCodeDiplome(new ModelDiplome());
            } else $implication->setCodeDiplome(new ModelDiplome());
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
                isset($_POST['idImplication']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testImplication = ModelImplication::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idImplication']);
                if ($testImplication) ControllerMain::erreur("Cette implication existe déjà");
                else {
                    if (!ModelImplication::save(array(
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idImplication' => $_POST['idImplication'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    ))) ;
                    else {
                        $implication = ModelImplication::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idImplication']);
                        $modules = ModelModule::selectAllByNImplication($implication->getNImplication());
                        $view = 'detail';
                        $pagetitle = 'Implication : ' . $implication->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un Implication avec les champs présélectionné/déjà remplit
     *
     * @uses ModelImplication::select()
     * @uses ModelDiplome::selectAllOrganizedByDep()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nImplication'])) {
                $implication = ModelImplication::select($_GET['nImplication']);
                if (!$implication) ControllerMain::erreur("Cette implication n'existe pas");
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
            if (isset($_POST['nImplication']) &&
                isset($_POST['codeDiplome']) &&
                isset($_POST['semestre']) &&
                isset($_POST['idImplication']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance
                 */
                $testImplication = ModelImplication::selectBy($_POST['codeDiplome'], $_POST['semestre'], $_POST['idImplication']);
                if(!$testImplication || (is_a($testImplication,'ModelImplication') && $_POST['nImplication'] == $testImplication->getNImplication())) {
                    $data = array(
                        'nImplication' => $_POST['nImplication'],
                        'codeDiplome' => $_POST['codeDiplome'],
                        'semestre' => $_POST['semestre'],
                        'idImplication' => $_POST['idImplication'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if(!ModelImplication::update($data)) ControllerMain::erreur("Impossible de modifier l'implication");
                    else {
                        $implication = ModelImplication::select($_POST['nImplication']);
                        $modules = ModelModule::selectAllByNImplication($implication->getNImplication());
                        $view = 'detail';
                        $pagetitle = 'Implication : ' . $implication->nommer();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cette implication existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
    
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                if (!ModelImplication::delete($_POST['codeProjet'], $_POST['codeContact'])) ControllerMain::erreur("Impossible de supprime le contact");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function add()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                if (!ModelImplication::add($_POST['codeProjet'], $_POST['codeContact'])) ControllerMain::erreur("Impossible d'ajouter le contact");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

}