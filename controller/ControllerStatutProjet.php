<?php
require_once File::build_path(array('model', 'ModelStatutEnseignant.php'));

/**
 * Class ControllerStatutEnseignant
 */
class ControllerStatutEnseignant
{

    protected static $object = 'statutEnseignant';

    /**
     * Affiche la liste de tous les status enseignant
     *
     * Affiche une erreur s'il n'y a pas de statuts enseignant
     *
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $statuts = ModelStatutEnseignant::selectAll();
            if (!$statuts) ControllerMain::erreur("Il n'y a pas de statuts enseignant");
            else {
                $view = 'list';
                $pagetitle = 'Statuts Enseignant';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else ControllerUser::connect();
    }

    /**
     * Affiche les détails du Statut désigné par son codeStatut @var $_GET ['codeStatut']
     *
     * S'il n'y a pas de codeStatut, l'utilisateur est redirigé vers une erreur
     * Si le statut n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelStatutEnseignant::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeStatut'])) {
                $statut = ModelStatutEnseignant::select($_GET['codeStatut']);
                if (!$statut) ControllerMain::erreur("Ce statut n'existe pas");
                else {
                    $view = 'detail';
                    $pagetitle = 'Statut : ' . $statut->nommer();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un statut enseignant grace à son codeStatut @var $_GET ['codeStatut']
     *
     * S'il n'y a pas de codeStatut, l'utilisateur est redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelStatutEnseignant::delete()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeStatut'])) {
                if (!ModelStatutEnseignant::delete($_GET['codeStatut'])) ControllerMain::erreur("Impossible de supprimer ce statut");
                else ControllerStatutEnseignant::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de creation d'un statut Enseignant
     */
    public static function create()
    {
        if (isset($_SESSION["login"])) {
            $statut = new ModelStatutEnseignant();
            $view = 'update';
            $pagetitle = 'Création d\'un nouveau statut';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un statut enseignant avec les informations fournies par le formulaire
     *
     * S'il manque des informations, l'utilisateur sera redirigé vers une erreur
     * Si la création ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelStatutEnseignant::selectByStatutType()
     * @uses ModelStatutEnseignant::save()
     *
     * @see  ControllerStatutEnseignant::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['statut']) &&
                isset($_POST['typeStatut']) &&
                isset($_POST['nombresHeures'])) {
                $test = ModelStatutEnseignant::selectByStatutType($_POST['statut'], $_POST['typeStatut']);
                if (!$test) {
                    if (!ModelStatutEnseignant::save(array(
                        'statut' => $_POST['statut'],
                        'typeStatut' => $_POST['typeStatut'],
                        'nombresHeures' => $_POST['nombresHeures']
                    ))) ControllerMain::erreur("Impossible de créer ce statut");
                    else ControllerStatutEnseignant::readAll();
                } else ControllerMain::erreur("Ce statut existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de maj d'un statut désigné par son codeStatut @var $_GET ['codeStatut']
     *
     * S'il n'y a pas de codeStatut, l'utilisateur sera redirigé vers une erreur
     * Si le statut n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelStatutEnseignant::select()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeStatut'])) {
                $statut = ModelStatutEnseignant::select($_GET['codeStatut']);
                if (!$statut) ControllerMain::erreur("Ce statut n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Création d\'un nouveau statut';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Met à jour un statut identifié grace à son code statut @var $_POST['codeStatut']
     *
     * S'il manque des informations l'utilisateur sera redirigé vers une erreur
     * Si le statut existe déjà, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelStatutEnseignant::select()
     * @uses ModelStatutEnseignant::selectByStatutType()
     * @uses ModelStatutEnseignant::update()
     *
     * @see ControllerStatutEnseignant::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeStatut']) &&
                isset($_POST['statut']) &&
                isset($_POST['typeStatut']) &&
                isset($_POST['nombresHeures'])) {
                $test = ModelStatutEnseignant::selectByStatutType($_POST['statut'], $_POST['typeStatut']);
                $statut = ModelStatutEnseignant::select($_POST['codeStatut']);
                if (!$test || $statut==$test) {
                    if (!ModelStatutEnseignant::update(array(
                        'codeStatut' => $_POST['codeStatut'],
                        'statut' => $_POST['statut'],
                        'typeStatut' => $_POST['typeStatut'],
                        'nombresHeures' => $_POST['nombresHeures']
                    ))) ControllerMain::erreur("Impossible de modifier ce statut");
                    else ControllerStatutEnseignant::readAll();
                } else ControllerMain::erreur("Ce statut existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}