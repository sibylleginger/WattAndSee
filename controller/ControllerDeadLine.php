<?php
//DONE
require_once File::build_path(array('model', 'ModelDeadLine.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerDeadLine
 */
class ControllerDeadLine
{

    /**
     * @var string nom de la table
     */
    protected static $object = 'DeadLine';


    /**
     * Envoie toutes les échéance sur la page du calendrier
     *
     * @uses ModelDeadLine::selectAll()
     * @uses ModelDeadLin::selectDates()
     */
    public static function readAll() {
        if(isset($_SESSION['login'])) {
            ModelDeadLine::updateTable();
            $tab = ModelDeadLine::selectAll();
            if (!$tab) {
                ControllerMain::erreur('Il n\'y a pas d\'évènement');
            }
            $dates = ModelDeadLine::selectDates();
            $view = 'calendrier';
            $pagetitle = 'Calendrier';
            require_once File::build_path(array('view','view.php' ));
        }else ControllerUser::connect();
    }

    /**
     * Affiche toutes les échéances associés à un projet
     *
     * @var $_POST['codeProjet'] int code du projet
     */
    public static function readAllByProjet() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet'])) {
                $projet = ModelProjet::select($_POST['codeProjet']);
            }elseif (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
            }
            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabComment = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
            $view = 'list';
            $pagetitle = 'Commentaires du projet';
            require_once File::build_path(array('view', 'view.php'));
        }else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'une échéance pour un projet
     *
     * @var $_GET['codeProjet']
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                $dateDeadLine = date('Y-m-d');
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) {
                    ControllerMain::error('Le projet n\'existe pas');
                }
                $view = 'create';
                $pagetitle = 'Ajouter une échéance sur le projet';
                $deadLine = new ModelDeadLine();
                require File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Créé une échéance pour un projet
     *
     * @var $_POST['codeProjet']
     * @uses ModelDeadLine::save(data)
     * @see ControllerProjet::read()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['nomDeadLine']) && isset($_POST['dateDeadLine']) && isset($_POST['codeProjet'])) {
                    $data = array('dateDeadLine' => $_POST['dateDeadLine'],
                                'nomDeadLine' => $_POST['nomDeadLine'],
                                'codeProjet' => $_POST['codeProjet']);
                    if (ModelDeadLine::save($data)) {
                        ControllerProjet::read();   
                    }else ControllerMain::erreur("Impossible d'ajouter une échéance");
                }else ControllerMain::erreur('Il manque des informations');
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }else ControllerMain::connect();
    }
}
