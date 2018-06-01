<?php
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ControllerEntite
{
    protected static $object = 'Entite';

    /**
     * Redirige vers le centre de recherche des enseignants
     *
     * @uses ModelDepartement::selectAll()
     * @uses ModelEnseignant::selectAll()
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tabEntite = ModelEntite::selectAll();
            $view = 'list';
            $pagetitle = 'Entités EDF';
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
            if (isset($_GET['codeEntite'])) {
                $entite = ModelEntite::select($_GET['codeEntite']);
                if (!$entite) ControllerMain::erreur("Le programme n'existe pas");
                else {
                    //STATS
                    $statuts = array('Accepté','Refusé','Déposé','En cours de montage');
                    $statSP = ModelEntite::statStatutEtProjet($entite->getCodeEntite());
                    $statPD = ModelEntite::statNbProjet('2014-01-01',date('Y-m-d'),array('Accepté','Déposé','Refusé'),$entite->getCodeEntite());
                    $statMP = ModelEntite::statMontantProjet('2014-01-01',date('Y-m-d'),'Accepté',array('subventionEDF'),$entite->getCodeEntite());
                    $statAMP = ModelEntite::statMontantProjet('2014-01-01',date('Y-m-d'),'Accepté',array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),$entite->getCodeEntite());
                    $years = array();
                    for ($i=2014; $i <= date('Y'); $i++) { 
                        array_push($years, $i);
                    }
                    $graph1 = ControllerProjet::scriptAM(1,'pie',$statuts,null,$statSP,'Répartition des projets en fonction de leur statut','Nombre de projets');
                    $graph2 = ControllerProjet::scriptAM(2,'serial',$years,array('Accepté','Refusé','Déposé'),$statPD,'Nombre de projet déposés depuis 2014','Nombre de projets');
                    $graph3 = ControllerProjet::scriptAM(3,'serial',$years,array('subventionEDF'),$statMP,'Montant des subventions EDF','Montant en €');
                    $graph4 = ControllerProjet::scriptAM(4,'serial',$years,array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),$statAMP,'Montant des budget et subventions','Montant en €');
                    $tabContact = ModelContact::selectAllByEntite($entite->getCodeEntite());
                    $script = ControllerProjet::$introScript.$graph1.$graph2.$graph3.$graph4.'</script>';
                    $view = 'detail';
                    $pagetitle = 'Entité : ' . $entite->getNomEntite();
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
            if($_SESSION['is_admin']) {
                $entite = new ModelEntite();
                $view = 'update';
                $pagetitle = 'Créer un programme de financement';
                require_once File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
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
            if($_SESSION['is_admin']) {
                if (isset($_POST['nomEntite'])) {
                    $data = array(
                        'nomEntite' => $_POST['nomEntite']);
                    if (!ModelEntite::save($data)) ControllerMain::erreur("Impossible d'enregistrer le programme");
                    else ControllerEntite::readAll();
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
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
            if($_SESSION['is_admin']) {
                if (isset($_GET['codeEntite'])) {
                    if (!ModelEntite::delete($_GET["codeEntite"])) ControllerMain::erreur("Impossible de supprimer le programme");
                    else {
                        ControllerEntite::readAll();
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
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
            if($_SESSION['is_admin']) {
                if (isset($_GET['codeEntite'])) {
                    $entite = ModelEntite::select($_GET['codeEntite']);
                    if (!$entite) ControllerMain::erreur("Le programme n'existe pas");
                    else {
                        $view = 'update';
                        $pagetitle = 'Modification de : ' . $entite->getNomEntite();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
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
            if($_SESSION['is_admin']) {
                if (isset($_POST['codeEntite']) && $_POST['nomEntite']) {
                    $data = array(
                        'codeEntite' => $_POST['codeEntite'],
                        'nomEntite' => $_POST['nomEntite']);
                    if (!ModelEntite::update($data)) ControllerMain::erreur("Impossible de modifier l'enseignant");
                    else {
                        ControllerEntite::readAll();
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }
}