<?php
require_once File::build_path(array('model', 'ModelSourceFin.php'));
//DONE
class ControllerSourceFin
{

    protected static $object = 'sourceFin';

    /**
     * Affiche tous les programmes de financement
     *
     * @uses ModelSourceFin::selectAll()
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
     * Affiche les détails d'un programme de financement avec ses projets et ses contacts
     *
     * @uses ModelSourceFin::select()
     * @uses ModelProjet::selectAllBySource(codeSourceFin)
     * @uses ModelContact::selectAllBySource(codeSourceFin)
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
     * Redirige vers le formulaire de création d'un programme
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                $sourceFin = new ModelSourceFin();
                $view = 'update';
                $pagetitle = 'Créer un programme de financement';
                require_once File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Crée un programme en récupérant les données du formulaire passé en méthode POST
     *
     * @uses ModelSourceFin::save()
     * @see  ControllerSourceFin::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['nomSourceFin'])) {
                    $data = array(
                        'nomSourceFin' => $_POST['nomSourceFin']);
                    if (!ModelSourceFin::save($data)) ControllerMain::erreur("Impossible d'enregistrer le programme");
                    else ControllerSourceFin::readAll();
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un programme
     *
     * @var $_GET['codeSourceFin'] int code du programme
     * @uses ModelSourceFin::delete()
     * @see ControllerSourceFin::readAll()
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeSourceFin'])) {
                    if (!ModelSourceFin::delete($_GET["codeSourceFin"])) ControllerMain::erreur("Impossible de supprimer le programme");
                    else {
                        ControllerSourceFin::readAll();
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de mise à jour des informations d'un programme
     *
     * @uses ModelSourceFin::select()
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeSourceFin'])) {
                    $sourceFin = ModelSourceFin::select($_GET['codeSourceFin']);
                    if (!$sourceFin) ControllerMain::erreur("Le programme n'existe pas");
                    else {
                        $view = 'update';
                        $pagetitle = 'Modification de : ' . $sourceFin->getNomSourceFin();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Met à jour les informations d'un programme avec les informations fournies via la méthode POST
     *
     * @see  ControllerSourceFin::readAll()
     * @uses ModelSourceFin::update(data)
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeSourceFin']) && $_POST['nomSourceFin']) {
                    $data = array(
                        'codeSourceFin' => $_POST['codeSourceFin'],
                        'nomSourceFin' => $_POST['nomSourceFin']);
                    if (!ModelSourceFin::update($data)) ControllerMain::erreur("Impossible de modifier le programme");
                    else {
                        ControllerSourceFin::readAll();
                    }
                } else ControllerMain::erreur("Il manque des informations");   
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }
}