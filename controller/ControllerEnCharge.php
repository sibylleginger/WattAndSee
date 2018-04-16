<?php

require_once File::build_path(['model', 'ModelEnCharge.php']);

class ControllerEnCharge
{

    protected static $object = 'EnCharge';

    /**WAS SALLE
     * Affiche les détails d'une personne de classe grace à @var$_GET['nomBatiment'] et @var $_GET['numEnCharge']
     *
     * S'il n'y a pas le nomBatiment ou le numEnCharge, l'utilisateur est redirigé vers une erreur
     * Si la personne n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @uses ModelEnCharge::select()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['nomBatiment']) && $_GET['numEnCharge']) {
                $enCharge = ModelEnCharge::select($_GET['nomBatiment'], $_GET['numEnCharge']);
                if (!$enCharge) ControllerMain::erreur('La personne n\'existe pas');
                else {
                    $view = 'detail';
                    $pagetitle = 'Personne en charge : '. $_GET['nomBatiment'] . '_' . $_GET['numEnCharge'];
                    require_once File::build_path(array('view','view.php'));
                }
            } else ControllerMain::erreur('Il manque des informations');
        } else ControllerUser::connect();
    }


}