<?php
require_once File::build_path(array('model', 'ModelReporting.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ControllerReporting
{

    protected static $object = 'Reporting';

    /**
     * Affiche les détails d'un diplome identifié grace à @var $_GET ['codeDiplome']
     *
     * Affiche aussi les UE et les modules appartenant à ce diplome
     *
     * S'il n'y a pas de codeDiplome, l'utilisateur est redirigé vers une erreur
     * Si le diplome n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelDiplome::select()
     * @uses ModelUniteDEnseignement::selectAllByDiplome();
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if (!$diplome) ControllerMain::erreur('Le diplome n\' existe pas');
                else {
                    $tab = $diplome->getModulesBySemestre();
                    $view = 'detail';
                    $pagetitle = $diplome->nommer();
                    $pagetitle = htmlspecialchars($pagetitle);
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }

    /**
     * Renvoie vers le formulaire de création d'un diplome
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelDepartement::select()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $diplome = new ModelDiplome();
            if(isset($_GET['codeDepartement'])) {
                $departement = ModelDepartement::select($_GET['codeDepartement']);
                if($departement) $diplome->setCodeDepartement($departement);
            }
            $view = 'update';
            $departements = ModelDepartement::selectAll();
            $pagetitle = 'Création d\'un diplome';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créé un diplome
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une page d'erreur
     * Si le diplome existe déjà, l'utilisateur sera redirigé vers une page d'erreur
     * Si la création échoue, l'utilisateur sera redirigé vers une page d'erreur
     *
     * @uses ModelDiplome::selectBy()
     * @uses ModelDiplome::save()
     * @uses ControllerDepartement::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDepartement']) &&
                isset($_POST['typeDiplome']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM']) &&
                isset($_POST['heuresProjet']) &&
                isset($_POST['heuresStage'])) {
                /**
                 * Verification pour les LP
                 */
                if ($_POST['typeDiplome'] == 'P') {
                    if (isset($_POST['numLP'])) {
                        $typeDiplome = $_POST['typeDiplome'] . $_POST['numLP'];
                    } else $typeDiplome = false;
                } else $typeDiplome = $_POST['typeDiplome'];
                if ($typeDiplome) {
                    /**
                     * Verification existance du diplome
                     * S'il existe déjà on renvoit une erreur
                     * Sinon on continue
                     */
                    $testDiplome = ModelDiplome::selectBy($_POST['codeDepartement'], $typeDiplome);
                    if (!$testDiplome) {
                        /**
                         * nomDiplome
                         * S'il y a un nomDiplome on l'assigne à @var $nomDiplome
                         * Sinon on assigne '' à @var $nomDiplome
                         */
                        if (isset($_POST['nomDiplome'])) $nomDiplome = $_POST['nomDiplome'];
                        else $nomDiplome = '';
                        /**
                         * Enregistrement
                         * @uses ModelDiplome::save()
                         * Si ça marche on renvoit vers la liste des départements,
                         * Sinon on renvoit vers une erreur
                         */
                        if (!ModelDiplome::save(array(
                            'codeDepartement' => $_POST['codeDepartement'],
                            'typeDiplome' => $typeDiplome,
                            'nomDiplome' => $nomDiplome,
                            'heuresTP' => $_POST['heuresTP'],
                            'heuresTD' => $_POST['heuresTD'],
                            'heuresCM' => $_POST['heuresCM'],
                            'heuresProjet' => $_POST['heuresProjet'],
                            'heuresStage' => $_POST['heuresStage']
                        ))) ControllerMain::erreur("Impossible de créer le diplome");
                        else {
                            ControllerDepartement::readAll();
                        }
                    } else ControllerMain::erreur("Ce diplome existe déjà");
                } else ControllerMain::erreur("Veuillez renseigner le numéro de la License Pro");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Renvoie vers le formulaire pré-remplis de modification d'un diplome identifié par @var $_GET ['codeDiplome']
     *
     * S'il n'y a pas de codeDiplome, l'utilisateur sera redirigé vers une erreur
     * Si le diplome n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelDiplome::select()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeDiplome'])) {
                $diplome = ModelDiplome::select($_GET['codeDiplome']);
                if (!$diplome) ControllerMain::erreur("Le diplome n'existe pas");
                else {
                    $view = 'update';
                    $departements = ModelDepartement::selectAll();
                    $pagetitle = 'Création d\'un diplome';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Modifie un diplome déjà existant
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une page d'erreur
     * Si le diplome existe déjà, l'utilisateur sera redirigé vers une page d'erreur
     * Si la création échoue, l'utilisateur sera redirigé vers une page d'erreur
     *
     * @uses ModelDiplome::select()
     * @uses ModelDiplome::selectBy()
     * @uses ModelDiplome::save()
     * @uses ControllerDepartement::readAll()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeDiplome']) &&
                isset($_POST['codeDepartement']) &&
                isset($_POST['typeDiplome']) &&
                isset($_POST['heuresTP']) &&
                isset($_POST['heuresTD']) &&
                isset($_POST['heuresCM']) &&
                isset($_POST['heuresProjet']) &&
                isset($_POST['heuresStage'])) {
                $testDiplome = ModelDiplome::select($_POST['codeDiplome']);
                if (is_a($testDiplome,'ModelDiplome') && $_POST['codeDiplome']!=$testDiplome->getCodeDiplome()) ControllerMain::erreur("Ce diplome n'existe pas");
                else {
                    /**
                     * Verification pour les LP
                     */
                    if ($_POST['typeDiplome'] == 'P') {
                        if (isset($_POST['numLP'])) {
                            $typeDiplome = $_POST['typeDiplome'] . $_POST['numLP'];
                        } else $typeDiplome = false;
                    } else $typeDiplome = $_POST['typeDiplome'];
                    if ($typeDiplome) {
                        /**
                         * Verification existance du diplome
                         * S'il existe déjà on renvoit une erreur
                         * Sinon on continue
                         */
                        $testDiplome = ModelDiplome::selectBy($_POST['codeDepartement'], $typeDiplome);
                        if (!$testDiplome || (is_a($testDiplome,'ModelDiplome') && $_POST['codeDiplome']=$testDiplome->getCodeDiplome())) {
                            /**
                             * nomDiplome
                             * S'il y a un nomDiplome on l'assigne à @var $nomDiplome
                             * Sinon on assigne '' à @var $nomDiplome
                             */
                            if (isset($_POST['nomDiplome'])) $nomDiplome = $_POST['nomDiplome'];
                            else $nomDiplome = '';
                            /**
                             * Enregistrement
                             * @uses ModelDiplome::save()
                             * Si ça marche on renvoit vers la liste des départements,
                             * Sinon on renvoit vers une erreur
                             */
                            $data = array(
                                'codeDiplome' => $_POST['codeDiplome'],
                                'codeDepartement' => $_POST['codeDepartement'],
                                'typeDiplome' => $typeDiplome,
                                'nomDiplome' => $nomDiplome,
                                'heuresTP' => $_POST['heuresTP'],
                                'heuresTD' => $_POST['heuresTD'],
                                'heuresCM' => $_POST['heuresCM'],
                                'heuresProjet' => $_POST['heuresProjet'],
                                'heuresStage' => $_POST['heuresStage']
                            );
                            if (ModelDiplome::update($data) == false) ControllerMain::erreur("Impossible de créer le diplome");
                            else {
                                ControllerDepartement::readAll();
                            }
                        } else ControllerMain::erreur("Ce diplome existe déjà");
                    } else ControllerMain::erreur("Veuillez renseigner le numéro de la License Pro");
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}