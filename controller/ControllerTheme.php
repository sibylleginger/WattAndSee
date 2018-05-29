<?php
require_once File::build_path(array('model', 'ModelTheme.php'));

class ControllerTheme
{

    protected static $object = 'Theme';

    /**
     * Redirige vers le centre de recherche des enseignants
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelEnseignant::selectAll()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tabTheme = ModelTheme::selectAll();
            $view = 'list';
            $pagetitle = 'Themes';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers la fiche détaillé d'un enseignant désigné par @var $_GET ['codeEns']
     *
     * Affiche aussi tous les modules dans lesquels il a enseigné
     *
     * @uses ModelEnseignant::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeTheme'])) {
                $theme = ModelTheme::select($_GET['codeTheme']);
                if (!$theme) ControllerMain::erreur("Le thème n'existe pas");
                else {
                    $tabProjet = ModelProjet::selectAllByTheme($_GET['codeTheme']);
                    $view = 'detail';
                    $pagetitle = 'Liste des projets du thème ' . $theme->getNomTheme();
                    require_once File::build_path(array('view', 'view.php'));
                }
            }else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de création d'un enseignant
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $theme = new ModelTheme();
            $view = 'update';
            $pagetitle = 'Créer un nouveau thème de projet';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un enseignant en récupérant les données du formulaire passé en méthode POST
     *
     * @uses ModelEnseignant::save()
     * @see  ControllerEnseignant::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomTheme'])) {
                $data = array(
                    'nomTheme' => $_POST['nomTheme']);
                if (!ModelTheme::save($data)) ControllerMain::erreur("Impossible d'enregistrer le thème");
                else ControllerTheme::readAll();
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime l'enseignant désigné par @var $_GET ['codeEns']
     *
     * @uses ModelEnseignant::delete()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeTheme'])) {
                if (!ModelTheme::delete($_GET["codeTheme"])) ControllerMain::erreur("Impossible de supprimer le thème");
                else {
                    ControllerTheme::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de mise à jour des informations d'un enseignant
     *
     * Si l'enseignant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnseignant::select();
     * @uses ModelDepartement::selectAll()
     * @uses ModelStatutEnseignant::selectAll()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeTheme'])) {
                $theme = ModelTheme::select($_GET['codeTheme']);
                if (!$theme) ControllerMain::erreur("Le thème n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification de : ' . $theme->getNomTheme();
                    require_once File::build_path(array('view', 'view.php'));
                }
            }
        } else ControllerUser::connect();
    }

    /**
     * Met à jour les informations d'un enseignant avec les informations fournies via la méthode POST
     *
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @see  ControllerEnseignant::update()
     * @uses ModelEnseignant::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeTheme']) && $_POST['nomTheme']) {
                $data = array(
                    'codeTheme' => $_POST['codeTheme'],
                    'nomTheme' => $_POST['nomTheme']);
                if (!ModelTheme::update($data)) ControllerMain::erreur("Impossible de modifier le thème");
                else {
                    ControllerTheme::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}