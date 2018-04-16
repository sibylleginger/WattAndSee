<?php

require_once File::build_path(array('model', 'ModelMembreEDF.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

/**
 * Class ControllerExtraction
 */
class ControllerMembreEDF
{

    /**
     * @var string
     */
    protected static $object = 'MembreEDF';

    /**
     * Envoie vers la page d'importation du fichier .csv
     */
    public static function extract()
    {
        if (isset($_SESSION['login'])) {
            $view = 'extract';
            $pagetitle = 'Importation des données';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();

    }

    /**
     * Recupere le fichier .csv envoyé par @see ControllerExtraction::extract()
     *
     * Le fichier récupéré est lu, transformé en array
     * Puis on rentre les valeurs dans la BDD
     * Finalement on affiche l'interface de résolution des erreurs
     *
     * @uses  Extraction::csvToArray()
     * @uses  Extraction::ArrayToBDD()
     * @uses  ControllerExtraction::home()
     */
    public static function extracted()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_FILES['extract'])) {
                $array = Extraction::csvToArray($_FILES['extract']["tmp_name"]);
                Extraction::ArrayToBDD($array);
                ControllerExtraction::home();
            } else ControllerMain::erreur("Veuillez fournir un fichier");
        } else ControllerUser::connect();
    }

    /**
     * Affiche l'interface de résolution des erreurs d'importation
     *
     * Dans cette interface il y a 4 possibilités :
     *
     * - Statut : @see ControllerExtraction::solveStatuts()
     * - Departement Enseignant @see ControllerExtraction::solveDepEns()
     * - Departement Invalide @see ControllerExtraction::solveDepInv()
     * - Autre : @see ControllerExtraction::readAll()
     *
     */
    public static function home()
    {
        if (isset($_SESSION['login'])) {
            $view = 'home';
            $pagetitle = 'Erreurs';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche toutes les erreurs qui ne corrspondent pas à un des 3 types d'erreurs
     *
     * - Statut
     * - Departement Enseignant
     * - Departemenent invalide
     *
     * @see ControllerExtraction::home()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['p'])) {
                $p = intval($_GET['p']);
                if ($p > ModelErreurExport::getNbP()) $p = ModelErreurExport::getNbP();
                if ($p <= 0) $p = 1;
            } else $p = 1;
            $max = ModelErreurExport::getNbP();
            $tab = ModelErreurExport::selectByPage($p);
            $view = 'error';
            $pagetitle = 'Erreur';
            require_once File::build_path(array("view", "view.php"));
        } else ControllerUser::connect();
    }

    /**
     * @deprecated
     */
    public static function tentative()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['idErreur'])) {
                $erreur = ModelErreurExport::select($_GET['idErreur']);
                if (!$erreur) ControllerMain::erreur("L'erreur n'exite pas..");
                else {
                    if (Extraction::erreurToBD($erreur)) {
                        ControllerExtraction::readAll();
                    } else {
                        ControllerExtraction::readAll();
                    }
                }
            }
        } else ControllerUser::connect();
    }

    /**
     * Redirection vers les 3 types d'erreurs @see ControllerExtraction::home()
     *
     * Dans cette interface il y a 4 possibilités :
     *
     * - Statut :
     * - Departement Enseignant
     * - Departement Invalide
     * - Autre : TODO
     *
     * @uses  ControllerExtraction::solveStatuts()
     * @uses  ControllerExtraction::solveDepEns()
     * @uses  ControllerExtraction::solveDepInv()
     */
    public static function readAllType()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['typeErreur'])) {
                $redirct = $_POST['typeErreur'];
                switch ($redirct) {
                    case 'statut':
                        ControllerExtraction::solveStatuts();
                        break;
                    case 'departementEns':
                        ControllerExtraction::solveDepEns();
                        break;
                    case 'Département invalide':
                        ControllerExtraction::solveDepInv();
                        break;
                    case 'autre':
                        ControllerExtraction::readAll();
                        break;
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche les erreurs liées aux statuts invalides/inexistants
     *
     * @uses ModelErreurExport::selectAllStatuts()
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function solveStatuts()
    {
        if (isset($_SESSION['login'])) {
            $statuts = ModelErreurExport::selectAllStatuts();
            if (!$statuts) ControllerMain::erreur("Il n'y a pas de statuts invalides");
            else {
                $modelStatuts = ModelStatutEnseignant::selectAll();
                $view = 'solveStatut';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les erreurs liées aux Départements des enseignants invalide
     *
     * @uses ModelErreurExport::selectAllDepEns()
     * @uses ModelDepartement::selectAll()
     */
    public static function solveDepEns()
    {
        if (isset($_SESSION['login'])) {
            $depEns = ModelErreurExport::selectAllDepEns();
            if (!$depEns) ControllerMain::erreur("Il n'y a pas de départements d'enseignant invalides");
            else {
                $dep = ModelDepartement::selectAll();
                $view = 'solveDepEns';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les erreurs liées aux Département invalides dans les code d'activitées
     *
     * @uses ModelErreurExport::selectIdErreursDepInv()
     * @uses ModelDepartement::selectAll()
     */
    public static function solveDepInv()
    {
        if (isset($_SESSION['login'])) {
            $depInv = ModelErreurExport::selectAllDepInv();
            if (!$depInv) ControllerMain::erreur("Il n'y a pas de départements invalides");
            else {
                $dep = ModelDepartement::selectAll();
                $view = 'solveDepInv';
                $pagetitle = 'Resolution erreurs de statuts';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }


    /**
     * Résout les erreurs liées aux stage
     *
     * Récupére les informations du formulaire de @see ControllerExtraction::solveStatuts()
     *
     * @uses ModelErreurExport::selectIdErreurStatut()
     * @uses ModelStatutEnseignant::save()
     * @uses ModelErreurExport::update()
     * @uses Extraction::erreurToBD()
     * @uses ControllerExtraction::solveStatuts()
     */
    public static function solvedStatuts()
    {
        if (isset($_SESSION['login'])) {
            foreach ($_POST as $cle => $item) {
                /**
                 * @var $statut [0] est le statut
                 * @var $statut [1] est le type statut
                 */
                $cle = str_replace("_", " ", $cle);
                $statut = explode('/', $cle);
                if ($item != 'rien') {
                    $idErreurs = ModelErreurExport::selectIdErreurStatut($statut[0], $statut[1]);
                    if (!$idErreurs) ;
                    else {
                        if ($item == 'nouveau') {
                            // Créer nouveau statut
                            ModelStatutEnseignant::save(array(
                                'statut' => $statut[0],
                                'typeStatut' => $statut[1]
                            ));
                        } else {
                            // Changer le statut des erreurs par celui selectionné par l'utilisateur
                            foreach ($idErreurs as $idErreur) {
                                ModelErreurExport::update(array(
                                    'idErreur' => $idErreur['idErreur'],
                                    'statut' => $statut[0],
                                    'typeStatut' => $statut[1]
                                ));
                            }
                        }
                        // Refaire entrer les valeurs dans la bdd
                        foreach ($idErreurs as $idErreur) {
                            Extraction::erreurToBD(ModelErreurExport::select($idErreur['idErreur']));
                        }
                    }
                }
            }
            ControllerExtraction::solveStatuts();
        } else ControllerUser::connect();
    }

    /**
     * Résout les erreurs liées aux département des enseignants qui n'existent pas
     *
     * Récupére les informations du formulaire de @see ControllerExtraction::solveDepEns()
     *
     * @uses ModelErreurExport::selectIdErreurDepEns()
     * @uses ModelErreurExport::update()
     * @uses Extraction::erreurToBD()
     * @uses ControllerExtraction::solveDepEns()
     */
    public static function solvedDepEns()
    {
        if (isset($_SESSION['login'])) {
            foreach ($_POST as $cle => $item) {
                /**
                 * @var $cle string : departementEns
                 * @var $item string : a pour valeurs
                 * - rien
                 * - un code Département
                 */
                $cle = str_replace("_", " ", $cle);
                if ($item != 'rien') {
                    $idErreurs = ModelErreurExport::selectIdErreurDepEns($cle);
                    if (!$idErreurs) ;
                    else {
                        // Changer le département des enseignants concernés
                        foreach ($idErreurs as $idErreur) {
                            ModelErreurExport::update(array(
                                'idErreur' => $idErreur['idErreur'],
                                'departementEns' => $item
                            ));
                        }
                        // Refaire entrer les valeurs dans la bdd
                        foreach ($idErreurs as $idErreur) {
                            Extraction::erreurToBD(ModelErreurExport::select($idErreur['idErreur']));
                        }
                    }
                }
            }
            ControllerExtraction::solveDepEns();
        } else ControllerUser::connect();
    }

    /**
     * Résout les erreurs liées aux département des codes d'activités qui n'existent pas
     *
     * Récupére les informations du formulaire de @see ControllerExtraction::solveDepInv()
     *
     * @uses ModelErreurExport::selectIdErreursDepInv()
     * @uses ModelErreurExport::update()
     * @uses Extraction::erreurToBD()
     * @uses ControllerExtraction::solveDepInv()
     */
    public static function solvedDepInv()
    {
        if (isset($_SESSION['login'])) {
            foreach ($_POST as $cle => $item) {
                /**
                 * @var $cle string : code d'activité
                 * @var $item string : a pour valeurs
                 * - rien
                 * - un code Département
                 */
                $cle = str_replace("_", " ", $cle);
                if ($item != 'rien') {
                    $idErreurs = ModelErreurExport::selectIdErreursDepInv($cle);
                    if (!$idErreurs) ;
                    else {
                        // Changer le code d'activité
                        if (isset($cle[2]))
                            $cle[2] = $item; // Changement du code Département
                        foreach ($idErreurs as $idErreur) {
                            ModelErreurExport::update(array(
                                'idErreur' => $idErreur['idErreur'],
                                'activitee' => $cle
                            ));
                        }
                        // Refaire entrer les valeurs dans la bdd
                        foreach ($idErreurs as $idErreur) {
                            Extraction::erreurToBD(ModelErreurExport::select($idErreur['idErreur']));
                        }
                    }
                }
            }
            ControllerExtraction::solveDepInv();
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de modification d'une erreur
     *
     * Si cette erreur n'est pas résolue
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['idErreur'])) {
                $erreur = ModelErreurExport::select($_GET['idErreur']);
                if (!$erreur) ControllerMain::erreur("Cette erreur n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification d\'une erreur';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['idErreur']) &&
                isset($_POST['nomEns']) &&
                isset($_POST['codeEns']) &&
                isset($_POST['departementEns']) &&
                isset($_POST['statut']) &&
                isset($_POST['typeStatut']) &&
                isset($_POST['dateCours']) &&
                isset($_POST['duree']) &&
                isset($_POST['activitee']) &&
                isset($_POST['typeActivitee'])) {
                $data = array(
                    'idErreur' => $_POST['idErreur'],
                    'nomEns' => $_POST['nomEns'],
                    'codeEns' => $_POST['codeEns'],
                    'departementEns' => $_POST['departementEns'],
                    'statut' => $_POST['statut'],
                    'typeStatut' => $_POST['typeStatut'],
                    'dateCours' => $_POST['dateCours'],
                    'duree' => $_POST['duree'],
                    'activitee' => $_POST['activitee'],
                    'typeActivitee' => $_POST['typeActivitee']
                );
                if(ModelErreurExport::update($data)) ControllerExtraction::readAll();
                else ControllerMain::erreur("Impossible de modifier l'erreur");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}