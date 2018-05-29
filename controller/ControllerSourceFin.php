<?php
require_once File::build_path(array('model', 'ModelSourceFin.php'));

class ControllerSourceFin
{

    protected static $object = 'sourceFin';

    /**
     * Redirige vers le centre de recherche des enseignants
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelEnseignant::selectAll()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $sourcesFin = ModelSourceFin::selectAll();
            $view = 'list';
            $pagetitle = 'Programmes de financement';
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
            if (isset($_GET['codeSourceFin'])) {
                $sourceFin = ModelSourceFin::select($_GET['codeSourceFin']);
                if (!$sourceFin) ControllerMain::erreur("Le programme n'existe pas");
                else {
                    $tabProjet = ModelProjet::selectAllBySource($_GET['codeSourceFin']);
                    $tabContact = ModelContact::selectAllBySource($_GET['codeSourceFin']);
                    $view = 'detail';
                    $pagetitle = 'Programme : ' . $sourceFin->getNomSourceFin();
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
            $sourceFin = new ModelSourceFin();
            $view = 'update';
            $pagetitle = 'Créer un programme de financement';
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
            if (isset($_POST['nomSourceFin'])) {
                $data = array(
                    'nomSourceFin' => $_POST['nomSourceFin']);
                if (!ModelSourceFin::save($data)) ControllerMain::erreur("Impossible d'enregistrer le programme");
                else ControllerSourceFin::readAll();
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
            if (isset($_GET['codeSourceFin'])) {
                if (!ModelSourceFin::delete($_GET["codeSourceFin"])) ControllerMain::erreur("Impossible de supprimer le programme");
                else {
                    ControllerSourceFin::readAll();
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
            if (isset($_GET['codeSourceFin'])) {
                $sourceFin = ModelSourceFin::select($_GET['codeSourceFin']);
                if (!$sourceFin) ControllerMain::erreur("Le programme n'existe pas");
                else {
                    $view = 'update';
                    $pagetitle = 'Modification de : ' . $sourceFin->getNomSourceFin();
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
            if (isset($_POST['codeSourceFin']) && $_POST['nomSourceFin']) {
                $data = array(
                    'codeSourceFin' => $_POST['codeSourceFin'],
                    'nomSourceFin' => $_POST['nomSourceFin']);
                if (!ModelSourceFin::update($data)) ControllerMain::erreur("Impossible de modifier le programme");
                else {
                    ControllerSourceFin::readAll();
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}