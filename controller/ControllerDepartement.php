<?php
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ControllerDepartement
{

    protected static $object = 'departement';

    /** WAS MODULE
     * Affiche les details d'un Departement identifié grace à @var $_GET ['codeDepartement']
     *
     * S'il n'y a pas de codeDepartement, l'utilisateur est redirigé vers une erreur
     * Si le Departement n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDepartement::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDepartement'])) {
                $departement = ModelDepartement::select($_GET['codeDepartement']);
                if (!$departement) ControllerMain::erreur("Le departement n'existe pas");
                else {
                    $view = 'detail';
                    $pagetitle = 'Departement : ' . $departement->nommer() . ' : ' . $departement->getNomDepartement();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un Departement associé à une unité d'enseignement d'un diplome identifié par @var $_GET ['nUE']
     *
     * S'il n'y a pas de nUE, l'utilisateur sera redirigé vers une erreur
     * Si l'unité d'enseignement n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelUniteDEnseignement::select()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nUE'])) {
                $ue = ModelUniteDEnseignement::select($_GET['nUE']);
                if (!$ue) ControllerMain::erreur("Cette unité d'enseignement n'existe pas");
                else {
                    $departement = new ModelDepartement();
                    $departement->setNUE($ue);
                    $view = 'update';
                    $pagetitle = 'Création d\'un nouveau departement';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Créé un Departement à partir des informations fournis en méthode POST via @see ControllerDepartement::create()
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une erreur
     * Si le Departement exist déjà, l'utilisateur sera redirigé vers une erreur
     * Si l'enregistrement echoue, l'utilisateur sera redirigé vers une erreur
     * Sinon l'utilisateur vera les détails du nouveau Departement fraichement créé
     *
     * @uses ModelDepartement::save()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nUE']) &&
                isset($_POST['nomDepartement']) &&
                isset($_POST['numDepartement']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance de ce Departement
                 */
                $testDepartement = ModelDepartement::selectBy($_POST['nUE'], $_POST['numDepartement']);
                if ($testDepartement) ControllerMain::erreur("Ce departement existe déjà");
                else {
                    /**
                     * Enregistrement dans la base de donnée
                     * @uses ModelDepartement::save()
                     */
                    $data = array(
                        'nUE' => $_POST['nUE'],
                        'numDepartement' => $_POST['numDepartement'],
                        'nomDepartement' => $_POST['nomDepartement'],
                        'heuresTP' => $_POST['heuresTP'],
                        'heuresTD' => $_POST['heuresTD'],
                        'heuresCM' => $_POST['heuresCM']
                    );
                    if (!ModelDepartement::save($data)) ControllerMain::erreur("Impossible de créer le departement");
                    else {
                        $departement = ModelDepartement::selectBy($_POST['nUE'], $_POST['numDepartement']);
                        $view = 'detail';
                        $pagetitle = 'Departement : ' . $departement->nommer() . ' : ' . $departement->getNomDepartement();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de modification d'un Departement identifié par @var $_GET ['codeDepartement']
     *
     * S'il n'y a pas de codeDepartement, l'utilisateur sera redirigé vers une erreur
     * Si le Departement n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelDepartement::select()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDepartement'])) {
                $departement = ModelDepartement::select($_GET['codeDepartement']);
                if (!$departement) ControllerMain::erreur("Ce departement n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification d\'un departement';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Modifie un Departement grace aux informations du formulaire @see ControllerDepartement::update() envoyé via la méthode POST
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une erreur
     * Si le Departement identifié par @var $_POST['codeDepartement'] n'existe pas, l'utilisateur sera redirigé vers une erreur
     * Si un Departement similaire existe, l'utilisateur sera redirigé vers une erreur
     * Si la modification echoue, l'utilisateur sera redirigé vers une erreur
     * Sinon il sera redirigé vers les détails du Departement modifié
     *
     * @uses ModelDepartement::select()
     * @uses ModelDepartement::selectBy()
     * @uses ModelDepartement::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDepartement']) &&
                isset($_POST['nomDepartement']) &&
                isset($_POST['numDepartement']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM'])) {
                /**
                 * Vérification existance d'un Departement similaire
                 */
                $departement = ModelDepartement::select($_POST['codeDepartement']);
                if(!$departement) ControllerMain::erreur("Ce departement n'existe pas");
                else {
                    $testDepartement = ModelDepartement::selectBy($departement->getNUE()->getNUE(),$_POST['numDepartement']);
                    if(!$testDepartement || $testDepartement=$departement) {
                        /**
                         * Enregistrement dans la base de donnée
                         * @uses ModelDepartement::save()
                         */
                        $data = array(
                            'codeDepartement' => $_POST['codeDepartement'],
                            'numDepartement' => $_POST['numDepartement'],
                            'nomDepartement' => $_POST['nomDepartement'],
                            'heuresTP' => $_POST['heuresTP'],
                            'heuresTD' => $_POST['heuresTD'],
                            'heuresCM' => $_POST['heuresCM']
                        );
                        if (!ModelDepartement::update($data)) ControllerMain::erreur("Impossible de modifier le departement");
                        else {
                            $departement = ModelDepartement::select($_POST['codeDepartement']);
                            $view = 'detail';
                            $pagetitle = 'Departement : ' . $departement->nommer() . ' : ' . $departement->getNomDepartement();
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    } else ControllerMain::erreur("Ce département existe déjà");
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}