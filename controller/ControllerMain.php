<?php

class ControllerMain
{
    protected static $object = 'main';

    /**
     * Affiche une page d'erreur
     *
     * @param string $erreur : message d'erreur
     */
    public static function erreur($erreur = '')
    {
        if (isset($_SESSION['login'])) {
            $view = 'erreur';
            $pagetitle = 'Erreur';
            require File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche la page d'accueil du site
     */
    public static function home()
    {
        if (isset($_SESSION['login'])) {
            $view = 'home';
            $pagetitle = 'Accueil';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }
}