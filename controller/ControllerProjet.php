<?php
//DONE
require_once File::build_path(array('model', 'ModelProjet.php'));
//require_once File::build_path(array('model', 'ModelSourceFin.php'));

class ControllerProjet
{

    protected static $object = 'Projet';

    /*
     * Bibliothèques JS à importer pour visualiser les statistiques
     */
    public static $introScript = '<script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script type="text/javascript">';

    /**
     * Retourne la fonction JS makeChart pour créer un graphique
     *
     * @var $idGraph int identifiant du graphique
     * @var $type string type du graphique
     * @var $tabCategorie array(string) valeurs de l'axe des abscisses
     * @var $tabBar array(string) noms des différentes barres du graphique
     * @var $tabValues array() tableau des données du graphique
     * @var $title string titre du graphique
     * @var $yAxis string titre de l'axe des ordonnées
     * @return string
     */
    public static function scriptAM($idGraph,$type,$tabCategorie,$tabBar,$tabValues,$title,$yAxis) {
        $function = '
        AmCharts.makeChart("graph'.$idGraph.'",
            {
                "type": "'.$type.'",';
        if ($type == 'serial') {
            $function .= '"categoryField": "category",
            "startDuration": 1,
                "categoryAxis": {
                    "gridPosition": "start"
                },
                "trendLines": [],
                "graphs": [';
            if (isset($tabBar)) {
                foreach ($tabBar as $key => $value) {
                    $id = $key+1;
                    $function .= '{
                        "balloonText": "'.$value.': [[value]]",
                        "fillAlphas": 1,
                        "id": "AmGraph-'.$id.'",
                        "title": "'.$value.'",
                        "type": "column",
                        "valueField": "column-'.$id.'"
                    },';
                }
                $function = rtrim($function, ',');
                $function .= '],';
            }else {
                $function .= '{
                        "balloonText": "[[title]] [[value]]",
                        "fillAlphas": 1,
                        "id": "AmGraph-1",
                        "title": "Statut",
                        "type": "column",
                        "valueField": "column-1"
                    }],';
            }
        }else {
            $function .= '"balloonText": "[[title]] [[value]] ([[percents]]%)",
                "titleField": "category",
                "valueField": "column-1",';
        }
        $function .= '
                "export": {
                    "enabled": true
                },
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                        "title": "'.$yAxis.'"
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "legend": {
                    "enabled": true
                },
                "titles": [
                    {
                        "id": "Title-1",
                        "size": 15,
                        "text": "'.$title.'"
                    }
                ],';
                $data = '"dataProvider": [';
                foreach ($tabCategorie as $keyC => $categorie) {
                    $data .= '{
                        "category": "'.$categorie.'",';
                    if (isset($tabBar)) {
                        foreach ($tabBar as $keyB => $bar) {
                            $id = $keyB+1;
                            foreach ($tabValues as $keyV => $value) {
                                if ($value['prim']==$categorie) {
                                    if (isset($value['bar'])) {
                                        if ($value['bar']==$bar) {
                                            $data .= '"column-'.$id.'": "'.$value['quantity'].'",';
                                        }
                                    }elseif (isset($value['quantity'])) {
                                        $data .= '"column-'.$id.'": "'.$value['quantity'].'",';
                                    }else $data .= '"column-'.$id.'": "'.$value['value'.$keyB].'",';
                                }
                            }
                        }
                    }else {
                        foreach ($tabValues as $key => $value) {
                            if ($value['prim']==$categorie) {
                                $data .= '"column-1": "'.$value['quantity'].'",';
                            }
                        }
                    }
                    $data = rtrim($data, ',');
                    $data .= '},';
                }
                $data = rtrim($data, ',');
                $data .= ']})';
                $function .= $data;
                return $function;
    }

    /**
     * Affiche la liste de tous les Projets de la page et les options du formulaire de recherche d'un projet
     * 
     * @uses ModelProjet::getNbP() int nombre de projets par page
     * @uses ModelProjet::selectByPage(p)
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['p'])) {
                $p = intval($_GET['p']);
                if ($p > ModelProjet::getNbP()) $p = ModelProjet::getNbP();
                if ($p <= 0) $p = 1;
            } else $p = 1;
            $max = ModelProjet::getNbP();
            $tab = ModelProjet::selectByPage($p);
            $tabTheme = ModelTheme::selectAll();
            $tabEntite = ModelEntite::selectAll();
            $statuts = array('Accepté', 'Refusé', 'Déposé', 'En cours de montage');
            $view = 'list';
            $pagetitle = "Projets";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Retourne le tableau de tous les Projets
     *
     * @uses ModelProjet::selectAll()
     */
    public static function selectAll()
    {
        echo json_encode(ModelProjet::selectAll());
    }

    /**
     * Créé et affiche les statistiques fixes sur la page statistiques avec le formulaire de création
     *
     * @uses ModelProjet::statStatutEtProjet()
     * @uses ModelProjet::statMontantProjet()
     * @uses ModelProjet::statEntiteEtProjet()
     * @uses ModelProjet::statEntiteEtMontant()
     * @uses ModelProjet::statProgrammeEtProjet()
     * @uses ModelProjet::statNbProjet()
     * @uses ModelProjet::statMontantStatutProjet()
     * @uses ControllerProjet::scriptAM()
     */
    public static function stats() {
        if (isset($_SESSION['login'])) {
            $tabTheme = ModelTheme::selectAll();
            $tabEntite = ModelEntite::selectAll();
            $years = array(2014,2015,2016,2017,2018);  
            $statuts = array('Accepté', 'Refusé', 'Déposé', 'En cours de montage');
            $statSP = ModelProjet::statStatutEtProjet();
            $script1 = ControllerProjet::scriptAM(1,'pie',$statuts,null,$statSP,'Répartition des projets selon leur statut','Nombre de projets');
            $statME = ModelProjet::statMontantProjet('0000-00-00',date('Y-m-d'),'Accepté',array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),true);
            $script2 = ControllerProjet::scriptAM(2,'serial',$years,array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),$statME,'Montants des budgets et subventions obtenues pour les projets acceptés','Montant en €');
            $statEP = ModelProjet::statEntiteEtProjet('Accepté');
            $tabNomEntite3 = array();
            foreach ($statEP as $key => $value) {
                array_push($tabNomEntite3, $value['prim']);
            }
            $script3 = ControllerProjet::scriptAM(3,'pie',$tabNomEntite3,null,$statEP,'Répartition des projets acceptés par entité EDF','Nombre de projets');
            $statEM = ModelProjet::statEntiteEtMontant('subventionEDF','Accepté',false);
            $tabNomEntite4 = array();
            foreach ($statEM as $key => $value) {
                array_push($tabNomEntite4, $value['prim']);
            }
            $script4 = ControllerProjet::scriptAM(4,'pie',$tabNomEntite4,null,$statEM,'Montant des subventions EDF des projets acceptés par entité','Montant du budget EDF');
            $statPP = ModelProjet::statProgrammeEtProjet('Accepté');
            $tabNomSourceFin5 = array();
            foreach ($statPP as $key => $value) {
                array_push($tabNomSourceFin5, $value['prim']);
            }
            $script5 = ControllerProjet::scriptAM(5,'pie',$tabNomSourceFin5,null,$statPP,'Répartition des projets acceptés par programme de financement','Nombre de projets');
            $statAP = ModelProjet::statNbProjet('2014-01-01',date('Y-m-d'),array('Accepté','Refusé','Déposé'));
            $script6 = ControllerProjet::scriptAM(6,'serial',$years,array('Accepté','Refusé','Déposé'),$statAP,'Nombre de projets déposés par an','Nombre de projets');
            $statMSE = ModelProjet::statMontantProjet('0000-00-00',date('Y-m-d'),'Accepté',array('subventionEDF'),false);
            $script7 = ControllerProjet::scriptAM(7,'serial',$years,array('subventionEDF'),$statMSE,'Montant des subventions obtenues par EDF pour les projets acceptés','Montant en €');
            $statMSB = ModelProjet::statMontantStatutProjet('0000-00-00',date('Y-m-d'),array('Accepté','Refusé','Déposé'),array('budgetEDF','subventionEDF'),false);
            $script8 = ControllerProjet::scriptAM(8,'serial',array('Accepté','Refusé','Déposé'),array('budgetEDF','subventionEDF'),$statMSB,'Montant des subventions et des budgets obtenus par EDF selon le statut du projet', 'Montant en €');
            $script = ControllerProjet::$introScript.$script1.$script2.$script3.$script4.$script5.$script6.$script7.$script8.'</script>';
            $view = 'stats';
            $pagetitle = 'Statistiques';
            require_once File::build_path(array('view', 'view.php'));
        }else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un Projet
     *
     * Il affiche aussi les liste des contacts du projet, les échéances
     *
     * @var $_GET['codeProjet'] int code du projet
     * @uses ModelProjet::select(codeProjet)
     * @uses ModelImplication::selectAllByProjet(codeProjet)
     * @uses ModelContact::selectAllBySource(codeSourceFin)
     * @uses ModelParticipation::selectAllByProjet(codeProjet)
     * @uses ModelDeadLin::selectAllByProjet(codeProjet)
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if ($projet == false) ControllerMain::erreur("Ce Projet n'existe pas");
                else {
                    $tabDeadLine = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
                    $chef = ModelImplication::selectChef($projet->getCodeProjet());
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                    $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                    $pagetitle = 'Projet ' . $projet->getNomProjet();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de mise à jour des informations d'un projet
     *
     * @var  $_GET['codeProjet'] int code du projet
     * @uses ModelProjet::select();
     */
    public static function update() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if(isset($_GET['codeProjet'])) {
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
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }else ControllerUser::connect();
            
    }

    /**
     * Affiche tous les contacts/participants d'un projet par catégorie, et tous les contacts/participants de la base de données.
     * Si le Projet n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @var $_GET['codeProjet'] int code du projet
     * @uses ModelProjet::select()
     * @uses ModelImplication::selectAllByProjet()
     * @uses ModelImplication::selectChef()
     * @uses ModelContact::selectAllEDF()
     * @uses ModelContact::selectAllHorsEDF()
     * @uses ModelContact::selectAllBySource()
     * @uses ModelParticipant::selectAll()
     * @uses ModelParticipation::selectAllByProjet()
     */
    public static function updateContacts() {
        if (isset($_SESSION['login']) && $_SESSION['is_admin']){
            if(isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $chef = ModelImplication::selectChef($projet->getCodeProjet());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $allContactEDF = ModelContact::selectAllHorsSF();
                    $allContactHorsEDF = ModelContact::selectAllHorsEDF();
                    $allContactSource = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                    $allParticipant = ModelParticipant::selectAll();
                    $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                    $view = 'updateContacts';
                    $pagetitle = 'Modifier les contacts du projet <a href="index.php?controller=projet&action=read&codeProjet='.$projet->getCodeProjet().'">'.$projet->getNomProjet().'</a>';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        }else ControllerUser::connect();
            
    }

    /**
     * Met à jour les informations d'un projet avec les informations fournies via la méthode POST
     *
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @var $_POST['codeProjet'] int code du projet
     * @uses ModelProjet::update()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
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
                        if (isset($_POST['isExceptionnel'])) {
                            $data['isExceptionnel'] = $_POST['isExceptionnel'];
                        }
                        if(!ModelProjet::update($data)) ControllerMain::erreur("Impossible de modifier le projet");
                        else {
                            $projet = ModelProjet::select($_POST['codeProjet']);
                            $tabDeadLine = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
                            $chef = ModelImplication::selectChef($projet->getCodeProjet());
                            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                            $theme = ModelTheme::select($projet->getCodeTheme());
                            $tabContact = ModelImplication::selectAllByProjet($projet->getCodeProjet());
                            $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                            $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                            $view = 'detail';
                            $pagetitle = 'Projet : ' . $projet->getNomProjet();
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    } else ControllerMain::erreur("Ce projet n'existe pas");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de création d'un projet
     *
     * @uses ModelSourceFin::selectAll()
     * @uses ModelTheme::selectAll()
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_SESSION['is_admin'])) {
                $projet = new ModelProjet();
                $tabSource = ModelSourceFin::selectAll();
                $tabTheme = ModelTheme::selectAll();
                $theme = ModelTheme::select($projet->getCodeTheme());
                $view = 'update';
                $pagetitle = 'Créer un nouveau projet';
                require_once File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Crée un Projet à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelProjet::save()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_SESSION['is_admin'])) {
                if (isset($_POST['nom']) &&
                    isset($_POST['statut']) &&
                    isset($_POST['financement']) &&
                    isset($_POST['dateDepot']) &&
                    isset($_POST['description']) &&
                    isset($_POST['theme']) &&
                    isset($_POST['role'])) {

                    if ($_POST['dateDepot'] == '') {
                        $dateDepot = null;
                    }else {
                        $dateDepot = $_POST['dateDepot'];
                    }
                    if ($_POST['dateReponse'] == '') {
                        $dateReponse = null;
                    }else {
                        $dateReponse = $_POST['dateReponse'];
                    }

                    $data = array(
                            'nomProjet' => $_POST['nom'],
                            'description' => $_POST['description'],
                            'dateDepot' => $dateDepot,
                            'dateReponse' => $dateReponse,
                            'statut' => $_POST['statut'],
                            'role' => $_POST['role'],
                            'budgetTotal' => $_POST['budgetTotal'],
                            'budgetEDF' => $_POST['budgetEDF'],
                            'subventionTotal' => $_POST['subventionTotal'],
                            'subventionEDF' => $_POST['subventionEDF'],
                            'codeSourceFin' => $_POST['financement'],
                            'codeTheme' => $_POST['theme'],
                            
                        );
                    $codeProjet = ModelProjet::save($data);
                    if (isset($codeProjet))  {
                        $projet = ModelProjet::select($codeProjet);
                        $tabDeadLine = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
                        $chef = ModelImplication::selectChef($projet->getCodeProjet());
                        $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                        $theme = ModelTheme::select($projet->getCodeTheme());
                        $tabContact = ModelImplication::selectAllByProjet($projet->getCodeProjet());
                        $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                        $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                        $view = 'detail';
                        $pagetitle = 'Projet : ' . $projet->getNomProjet();
                        require_once File::build_path(array('view', 'view.php'));
                    }else ControllerMain::erreur("Impossible de créer le Projet");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Supprime un Projet
     *
     * S'il n'y a pas de projet, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelProjet::delete()
     * @see ControllerProjet::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if (isset($_SESSION['is_admin'])) {
                if(isset($_GET['codeProjet'])) {
                    if(ModelProjet::delete($_GET['codeProjet'])) ControllerProjet::readAll();
                    else ControllerMain::erreur("Impossible de supprimer le Projet");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Recherche les projets correspondants grâce aux conditions du formulaire par la methode POST
     *
     * S'il n'y a pas de codeEntite, @uses ModelProjet::searchBy()
     * Sinon, @uses ModelProjet::searchByEntite()
     */
    public static function searchBy() {
        if (isset($_SESSION['login'])) {
            $values = array();
            $conditions = array();
            if ($_POST['codeEntite'] != null) { //Si codeEntité est rempli, rechercher dans la view ProjetSearch
                $values['codeEntite'] = $_POST['codeEntite'];
                //associe la condition sql à la requête de l'utilisateur et la stocke dans un tableau
                $entiteCondition = "S.codeEntite=:codeEntite";
                array_push($conditions, $entiteCondition);
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
            }elseif ($_POST['nomProjet'] != null) { //Sinon, recherche dans la table Projet
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
            $tabTheme = ModelTheme::selectAll();
            $tabEntite = ModelEntite::selectAll();
            $tab = ModelProjet::searchBy($values, $conditions);
            $view = 'list';
            $pagetitle = 'Projet';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Créer le graphique correspondant grâce aux données du formulaire par la methode POST
     *
     * @uses ControllerProjet::scriptAM()
     * @uses ControllerProjet::$introScript
     */
    public static function createBarGraph() {
        $type = $_POST['type'];
        if ($type == 'pie') {
            $bar = null;
        }
        $xAxis = $_POST['xAxis'];
        $title = $_POST['titre'];
        $yAxis = $_POST['yAxis'];
        $statuts = $_POST['statut'];
        $start = $_POST['start'].'-01-01';
        $end = $_POST['end'].'-12-31';
        $tabCategorie = array();
        if ($_POST['data']==1) {
            switch ($xAxis) {
                case 1:
                    if ($type == 'serial') {
                        $bar = array('Statut');
                    }
                    $tab = ModelProjet::statStatutEtProjet();
                    foreach ($tab as $key => $value) {
                        array_push($tabCategorie, $value['prim']);
                    }
                    break;
                case 2:
                    if ($type == 'serial') {
                        $bar = array('Entité');
                    }
                    $tab = ModelProjet::statEntiteEtProjet($statuts[0]);
                    foreach ($tab as $key => $value) {
                        array_push($tabCategorie, $value['prim']);
                    }
                    break;
                case 3:
                    if ($type == 'serial') {
                        $bar = array('Programme de financement');
                    }
                    $tab = ModelProjet::statProgrammeEtProjet($statuts[0]);
                    foreach ($tab as $key => $value) {
                        array_push($tabCategorie, $value['prim']);
                    }
                    break;
                case 4:
                    $bar = $statuts;
                    $tab = ModelProjet::statNbProjet($start,$end,$statuts);
                    for ($i=$_POST['start']; $i <= $_POST['end']; $i++) { 
                        array_push($tabCategorie, $i);
                    }
                    break;
                default:
                    ControllerMain::erreur('Erreur dans la création du graphique');
                    break;
            }
        }elseif ($_POST['data']==2) {
            $montants = $_POST['montant'];
            $bar = $montants;
            if (isset($_POST['exceptionnel'])) {
                $exceptionnel = true;
            }else {
                $exceptionnel = false;
            }
            switch ($xAxis) {
                case 1:
                    $tab = ModelProjet::statMontantStatutProjet($start,$end,$statuts,$montants,$exceptionnel);
                    $tabCategorie = $statuts;
                    break;
                case 2:
                    $tab = ModelProjet::statEntiteEtMontant($montants[0],$statuts[0],$exceptionnel);
                    foreach ($tab as $key => $value) {
                        array_push($tabCategorie, $value['prim']);
                    }
                    break;
                case 4:
                    $tab = ModelProjet::statMontantProjet($start,$end,$statuts[0],$montants,$exceptionnel);
                    for ($i=$_POST['start']; $i <= $_POST['end']; $i++) { 
                        array_push($tabCategorie, $i);
                    }
                    break;
                default:
                    ControllerMain::erreur('Erreur dans la création du graphique');
                    break;
            }
        }
        $scriptNewGraph = ControllerProjet::scriptAM(1,$type,$tabCategorie,$bar,$tab,$title,$yAxis);
        $script = ControllerProjet::$introScript.$scriptNewGraph.'</script>';
                    
        $view = 'new';
        $pagetitle = $_POST['titre'];
        require_once File::build_path(array('view', 'view.php'));
    }
}
