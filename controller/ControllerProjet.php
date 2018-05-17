<?php

require_once File::build_path(array('model', 'ModelProjet.php'));
//require_once File::build_path(array('model', 'ModelSourceFin.php'));

class ControllerProjet
{

    protected static $object = 'Projet';

    /**
     * Affiche la liste de tous les Projets
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelProjet::selectAll();
            $view = 'list';
            $pagetitle = "Projets";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function home() {
        if (isset($_SESSION['login'])) {
            $statuts = array('Accepté', 'Refusé', 'Déposé');
            $stats = ModelProjet::statStatutEtProjet();
            $script = '
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load(\'current\', {\'packages\': [\'corechart\']});
                google.charts.setOnLoadCallback(statut);

                function statut() {
                    var data = google.visualization.arrayToDataTable([ [\'Statut projet\',\'Nombres de projets\'],
                        ';
                        $data = '';
                        foreach ($stats as $stat) {
                            $stat['statut'] = addslashes($stat['statut']);
                            $data .= "['" . $stat['statut'] . "', " . $stat['quantity'] . "],";
                        }
                        $data = rtrim($data, ',');
                        $script .= $data;
                        $script .= '
                        
                    ]);';
                    var_dump($data);
                    $script .= '
                    var options = {
                        title: \'\'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById(\'statut\'));
                    chart.draw(data, options);
                }
            </script>
            ';
            $tabTheme = ModelTheme::selectAll();
            $tabEntite = ModelEntite::selectAll();
            $view = 'home';
            $pagetitle = 'Rechercher un projet';
            require_once File::build_path(array('view', 'view.php'));
        }else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un Projet identifié par son nomProjet @var $_GET ['nomProjet']
     *
     * Il affiche aussi la liste des salles dans la Projet
     * S'il n'y a pas de nomProjet, l'utilisateur sera redirigé vers une erreur
     * Si le Projet n'existe pas, l'utilisateur sera redirigé vers une erreur
     * S'il n'y a aucune salle dans le Projet, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelProjet::select()
     * @uses ModelSalle::selectAllByProjet()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if ($projet == false) ControllerMain::erreur("Ce Projet n'existe pas");
                else {
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                    $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                    $tabDoc = ModelDocument::selectAllByProjet($projet->getCodeProjet());
                    $pagetitle = 'Projet ' . $projet->getNomProjet();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                    
                    /*else {
                        $pagetitle = 'Projet ' . $_GET['nomProjet'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }*/
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update() {
        if (isset($_GET['codeProjet'])){
            if(isset($_SESSION['login'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $tabSource = ModelSourceFin::selectAll();
                    $tabTheme = ModelTheme::selectAll();
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $view = 'update';
                    $pagetitle = 'Modification du projet';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updateContacts() {
        if (isset($_GET['codeProjet'])){
            if(isset($_SESSION['login'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $allContactEDF = ModelContact::selectAllEDF();
                    $allContactHorsEDF = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                    $allParticipant = ModelParticipant::selectAll();
                    $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                    $view = 'updateContacts';
                    $pagetitle = 'Modifier les contacts du projet';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeProjet']) &&
                isset($_POST['nom']) &&
                isset($_POST['statut']) &&
                isset($_POST['financement']) &&
                isset($_POST['dateDepot']) &&
                isset($_POST['description']) &&
                isset($_POST['theme']) &&
                isset($_POST['role'])) {
                /**
                 * Vérification existance
                 */
                $updateProjet = ModelProjet::select($_POST['codeProjet']);
                if($updateProjet && $_POST['codeProjet'] == $updateProjet->getCodeProjet()) {
                    $data = array(
                        'codeProjet' => $_POST['codeProjet'],
                        'nomProjet' => $_POST['nom'],
                        'description' => $_POST['description'],
                        'dateDepot' => $_POST['dateDepot'],
                        'dateReponse' => $_POST['dateReponse'],
                        'statut' => $_POST['statut'],
                        'role' => $_POST['role'],
                        'budgetTotal' => $_POST['budgetTotal'],
                        'budgetEDF' => $_POST['budgetEDF'],
                        'subventionTotal' => $_POST['subventionTotal'],
                        'subventionEDF' => $_POST['subventionEDF'],
                        'codeSourceFin' => $_POST['financement'],
                        'codeTheme' => $_POST['theme'],
                        
                    );
                    if(!ModelProjet::update($data)) ControllerMain::erreur("Impossible de modifier le projet");
                    else {
                        $projet = ModelProjet::select($_POST['codeProjet']);
                        $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                        $theme = ModelTheme::select($projet->getCodeTheme());
                        $tabContact = ModelImplication::selectAllByProjet($projet->getCodeProjet());
                        $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                        $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                        $view = 'detail';
                        $pagetitle = 'Projet : ' . $projet->getNomProjet();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cette unité n'existe pas");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $projet = new ModelProjet();
            //$sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabSource = ModelSourceFin::selectAll();
            $tabTheme = ModelTheme::selectAll();
            $theme = ModelTheme::select($projet->getCodeTheme());
            $view = 'update';
            $pagetitle = 'Créer un nouveau projet';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un Projet à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelProjet::save()
     * @uses ControllerProjet::readAll()
     *
     * @see ControllerProjet::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomProjet'])) {
                if (ModelProjet::save(['nomProjet' => $_POST['nomProjet']])) ControllerProjet::readAll();
                else ControllerMain::erreur("Impossible de créer le Projet");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un Projet grace à son nomProjet @var $_GET['nomProjet']
     *
     * S'il n'y a pas de nomProjet, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelProjet::delete()
     * @uses ControllerProjet::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['nomProjet'])) {
                if(ModelProjet::delete($_GET['nomProjet'])) ControllerProjet::readAll();
                else ControllerMain::erreur("Impossible de supprimer le Projet");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function searchBy() {
        if (isset($_SESSION['login'])) {
            $values = array();
            $conditions = array();
            if ($_POST['codeEntite'] != null) { 
                $values['codeEntite'] = $_POST['codeEntite'];
                $entiteCondition = "S.codeEntite=:codeEntite";
                array_push($conditions, $entiteCondition);
                if ($_POST['codeProjet'] != null) {
                    $values['codeProjet'] = $_POST['codeProjet'];
                    $codeCondition = 'S.codeProjet LIKE CONCAT(\'%\',:codeProjet,\'%\')';
                    array_push($conditions, $codeCondition);
                }
                if ($_POST['nomProjet'] != null) {
                    $values['nomProjet'] = $_POST['nomProjet'];
                    $nomCondition = 'S.nomProjet LIKE CONCAT(\'%\',:nomProjet,\'%\')';
                    array_push($conditions, $nomCondition);
                }
                if ($_POST['dateDepot'] != null) {
                    $values['dateDepot'] = $_POST['dateDepot'];
                    $dateCondition = "YEAR(S.dateDepot)=:dateDepot";
                    array_push($conditions, $dateCondition);
                }
                if ($_POST['codeTheme'] != null) {
                    $values['codeTheme'] = $_POST['codeTheme'];
                    $themeCondition = "S.codeTheme=:codeTheme";
                    array_push($conditions, $themeCondition);
                }
                if ($_POST['statut'] != null) {
                    $values['statut'] = $_POST['statut'];
                    $statutCondition = "S.statut=:statut";
                    array_push($conditions, $statutCondition);
                }
                $tab = ModelProjet::searchByEntite($values, $conditions);
                $view = 'list';
                $pagetitle = 'Projet';
                require_once File::build_path(array('view', 'view.php'));
            }elseif ($_POST['codeProjet'] != null) {
                $values['codeProjet'] = $_POST['codeProjet'];
                $codeCondition = 'codeProjet LIKE CONCAT(\'%\',:codeProjet,\'%\')';
                array_push($conditions, $codeCondition);
            }
            if ($_POST['nomProjet'] != null) {
                $values['nomProjet'] = $_POST['nomProjet'];
                $nomCondition = 'nomProjet LIKE CONCAT(\'%\',:nomProjet,\'%\')';
                array_push($conditions, $nomCondition);
            }
            if ($_POST['dateDepot'] != null) {
                $values['dateDepot'] = $_POST['dateDepot'];
                $dateCondition = "YEAR(dateDepot)=:dateDepot";
                array_push($conditions, $dateCondition);
            }
            if ($_POST['codeTheme'] != null) {
                $values['codeTheme'] = $_POST['codeTheme'];
                $themeCondition = "codeTheme=:codeTheme";
                array_push($conditions, $themeCondition);
            }
            if ($_POST['statut'] != null) {
                $values['statut'] = $_POST['statut'];
                $statutCondition = "statut=:statut";
                array_push($conditions, $statutCondition);
            }
            $tab = ModelProjet::searchBy($values, $conditions);
            var_dump($tab);
            $view = 'list';
            $pagetitle = 'Projet';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }
}
