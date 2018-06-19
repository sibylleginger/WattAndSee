<?php
//DONE
require_once File::build_path(array('model', 'ModelTheme.php'));

class ControllerTheme
{

    protected static $object = 'Theme';

    /**
     * Redirige vers le formulaire de création d'un thème
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
     * Crée un thème en récupérant les données du formulaire passé en méthode POST
     *
     * @uses ModelTheme::save()
     * @see  ControllerProjet::update()
     * @see ControllerProjet::create()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomTheme'])) {
                $data = array(
                    'nomTheme' => $_POST['nomTheme']);
                if (!ModelTheme::save($data)) ControllerMain::erreur("Impossible d'enregistrer le thème");
                elseif(($_GET['codeProjet']) != null) {
                    ControllerProjet::update();
                }else header('Location: index.php?controller=projet&action=create');
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}