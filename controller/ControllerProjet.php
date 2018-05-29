<?php

require_once File::build_path(array('model', 'ModelProjet.php'));
//require_once File::build_path(array('model', 'ModelSourceFin.php'));

class ControllerProjet
{

    protected static $object = 'Projet';

    public static $introScript = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load(\'current\', {packages: [\'corechart\', \'bar\']});
        google.charts.load(\'current\', {\'packages\': [\'corechart\']});';

    public static function scriptBarNbProjet($i,$tabStatuts,$title,$column1,$start,$end,$tabValues)  {
        $fonction = 'google.charts.setOnLoadCallback(graph'.$i.');
                function graph'.$i.'() {
                    var data = new google.visualization.DataTable();
                    data.addColumn(\'number\', \'Date de dépot\');
                    ';
        foreach ($tabStatuts as $key => $value) {
            $fonction .= 'data.addColumn(\'number\', \'Projets '.$value.'s\');
                    data.addColumn({type: \'string\', role: \'annotation\'});
                    ';
        }                       
        $data = 'data.addRows([';
        for ($y=$start; $y <= $end; $y++) { 
            $row = "[" . $y . ", ";
            $t = 0;
            foreach ($tabStatuts as $keyS => $statut) {
                foreach ($tabValues as $key => $value) {
                    if ($value['prim']==$y) {
                        if ($value['statut']==$statut){
                            $row .= $value['quantity'].",'".$value['quantity']."',";                            
                        }else {
                            $row .= "0, '0', ";
                        }
                        
                        $t++;
                    }
                }
            }
            if ($t < count($tabStatuts)) {
                switch ($t) {
                    case 0:
                        foreach ($tabStatuts as $value) {
                            $row .= "0, '0', ";
                        }
                        break;
                    case 1:
                        foreach ($tabStatuts as $key => $value) {
                            if ($key >= count($tabStatuts)-1) {
                                break;
                            }else {
                                $row .= "0, '0', ";
                            }
                        }
                        break;
                    case 2:
                        $row .= "0, '0', ";
                        break;
                }
            }
            $row = rtrim($row, ',');
            $row .= '],';
            $data .= $row;
            $row='';
        }
        $data = rtrim($data, ',');
        $fonction .= $data;
        $fonction .= "]);
                    var options = {
                        title: '".$title."',
                        annotations: {
                          textStyle: {
                            fontSize: 14,
                            color: '#000',
                            auraColor: 'none'
                          }
                        },
                        hAxis: {
                            title: 'Date de dépot',
                            format: '####',
                            viewWindow: {
                                min:".$start."-1 ,
                                max:".$end."+1
                            }
                        },
                        vAxis: {
                            title: '".$column1."'
                        }
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('graphBar".$i."'));

                    // Wait for the chart to finish drawing before calling the getImageURI() method.
                    google.visualization.events.addListener(chart, 'ready', function () {
                        var button = document.getElementById('saveBar".$i."');
                        var encoding = (chart.getImageURI()).slice(15);
                        button.innerHTML = '<a download=\"image.png\" href=\"data:application/octet-stream;' + encoding + '\"><i class=\"material-icons\">save</i></a>';
                        console.log(button.innerHTML);
                    });

                    chart.draw(data, options);
                  }";
        return $fonction;
    }

    public static function scriptBar($i,$tabColumns,$title,$column1,$start,$end,$tabValues)  {
        $fonction = 'google.charts.setOnLoadCallback(graph'.$i.');
                function graph'.$i.'() {
                    var data = new google.visualization.DataTable();
                    data.addColumn(\'number\', \'Date de dépot\');
                    ';
        foreach ($tabColumns as $key => $value) {
            $fonction .= 'data.addColumn(\'number\', \'Montant '.$value.'\');
                    ';
        }                        
        $data = 'data.addRows([';
        foreach ($tabValues as $ligne) {
            $row='';
            $row .= "[" . $ligne['prim'] . ", ";
            foreach ($tabColumns as $keyC => $column) {
                $row .= $ligne['value'.$keyC].", ";
            }
            $row = rtrim($row, ', ');
            $row .= '],';
            $data .= $row;
        }
        $data = rtrim($data, ',');
        $fonction .= $data;
        $fonction .= "]);
                    var options = {
                        title: '".$title."',
                        hAxis: {
                            title: 'Date de dépot',
                            format: '####',
                            viewWindow: {
                                min:".$start."-1 ,
                                max:".$end."+1
                            }
                        },
                        vAxis: {
                            title: '".$column1."'
                        },
                        chartArea: {
                            width: '75%'
                        }
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('graphBar".$i."'));

                    // Wait for the chart to finish drawing before calling the getImageURI() method.
                    google.visualization.events.addListener(chart, 'ready', function () {
                        var button = document.getElementById('saveBar".$i."');
                        var encoding = (chart.getImageURI()).slice(15);
                        button.innerHTML = '<a download=\"image.png\" href=\"data:application/octet-stream;' + encoding + '\"><i class=\"material-icons\">save</i></a>';
                        console.log(button.innerHTML);
                    });

                    chart.draw(data, options);
                  }";
        return $fonction;
    }

    public static function scriptPie($i,$title,$column1,$column2,$tabValues) {
        $fonction = 'google.charts.setOnLoadCallback(pie'.$i.');

                function pie'.$i.'() {
                    var data = google.visualization.arrayToDataTable([ [\''.$column1.'\',\''.$column2.'\'],
                        ';
                        $data = '';
                        foreach ($tabValues as $stat) {
                            $data .= "['" . $stat['prim'] . "', " . $stat['quantity'] . "],";
                        }
                        $data = rtrim($data, ',');
                        $fonction .= $data;
                        $fonction .= '
                        
                    ]);
                    var options = {
                        title: \''.$title.'\'
                    };

                    var chart = new google.visualization.PieChart(document.getElementById(\'graphPie'.$i.'\'));

                    // Wait for the chart to finish drawing before calling the getImageURI() method.
                    google.visualization.events.addListener(chart, \'ready\', function () {
                        var button = document.getElementById(\'savePie'.$i.'\');
                        var encoding = (chart.getImageURI()).slice(15);
                        button.innerHTML = \'<a download="image.png" href="data:application/octet-stream;\' + encoding + \'"><i class="material-icons">save</i></a>\';
                        console.log(button.innerHTML);
                    });

                    chart.draw(data, options);
                }';
        return $fonction;
    }
    /**
     * Affiche la liste de tous les Projets
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

    public static function stats() {
        if (isset($_SESSION['login'])) {
            $statuts = array('Accepté', 'Refusé', 'Déposé', 'En cours de montage');
            $statSP = ModelProjet::statStatutEtProjet();
            $scriptPie1 = ControllerProjet::scriptPie(1,'Répartition des projets par statut','Statut du projet','Nombre de projets',$statSP);
            $statEP = ModelProjet::statEntiteEtProjet('Accepté');
            $scriptPie2 = ControllerProjet::scriptPie(2,'Répartition des projets acceptés par entité EDF','Entité du chef de projet','Nombre de projets',$statEP);
            $statEM = ModelProjet::statEntiteEtMontant('Accepté');
            $scriptPie3 = ControllerProjet::scriptPie(3,'Montant des subventions EDF des projets acceptés par entité','Entité du chef de projet','Montant du budget EDF',$statEM);
            $statAP = ModelProjet::statNbProjet('2014-01-01',date('Y-m-d'),array('Accepté'));
            $scriptBar1 = ControllerProjet::scriptBarNbProjet(1,array('Accepté'),'Nombre de projets acceptés par an','Nombre de projets acceptés',2014,date('Y'),$statAP);
            $statPD = ModelProjet::statNbProjet('0000-00-00',date('Y-m-d'),array('Déposé'));
            $statPA = ModelProjet::statNbProjet('0000-00-00',date('Y-m-d'),array('Accepté'));
            $statMSE = ModelProjet::statMontantProjet('0000-00-00',date('Y-m-d'),'Accepté',array('subventionEDF'),false);
            $statME = ModelProjet::statMontantProjet('0000-00-00',date('Y-m-d'),'Accepté',array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),true);
            $scriptBar2 = ControllerProjet::scriptBarNbProjet(2,array('Déposé'),'Nombre de projets déposés par an','Nomde de projets déposés',2014, date('Y'),$statPD);
            $scriptBar4 = ControllerProjet::scriptBar(4,array('Accepté'),'Montant des subventions obtenues par EDF pour les projets acceptés','Montant en €',2014, date('Y'),$statMSE);
            $scriptBar5 = ControllerProjet::scriptBar(5,array('budgetTotal','budgetEDF','subventionTotal','subventionEDF'),'Montant des budget et subventions obtenues pour les projets acceptés','Montant en €',2014, date('Y'),$statME);
            $tabTheme = ModelTheme::selectAll();
            $tabEntite = ModelEntite::selectAll();
            $script = ControllerProjet::$introScript.$scriptPie1.$scriptPie2.$scriptPie3.$scriptBar1.$scriptBar2.$scriptBar4.$scriptBar5.'</script>';
            $view = 'stats';
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
                    $tabDeadLine = ModelDeadLine::selectAllByProjet($projet->getCodeProjet());
                    $chef = ModelImplication::selectChef($projet->getCodeProjet());
                    $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                    $theme = ModelTheme::select($projet->getCodeTheme());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $tabContactProgramme = ModelContact::selectAllBySource($projet->getCodeSourceFin());
                    $tabParticipant = ModelParticipation::selectAllByProjet($projet->getCodeProjet());
                    $tabDoc = ModelDocument::selectAllByProjet($projet->getCodeProjet());
                    $pagetitle = 'Projet ' . $projet->getNomProjet();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update() {
        if (isset($_SESSION['login']) && $_SESSION['is_admin']){
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
        }ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
            
    }

    public static function updateContacts() {
        if (isset($_SESSION['login']) && $_SESSION['is_admin']){
            if(isset($_GET['codeProjet'])) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                if (!$projet) ControllerMain::erreur("Ce projet n'existe pas");
                else {
                    $chef = ModelImplication::selectChef($projet->getCodeProjet());
                    $tabContact = ModelImplication::selectAllByProjet($_GET['codeProjet']);
                    $allContactEDF = ModelContact::selectAllEDF();
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
                    } else ControllerMain::erreur("Cette unité n'existe pas");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

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
     * @uses ControllerProjet::readAll()
     *
     * @see ControllerProjet::readAll()
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

                    $data = array(
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
            if (isset($_SESSION['is_admin'])) {
                if(isset($_GET['codeProjet'])) {
                    if(ModelProjet::delete($_GET['codeProjet'])) ControllerProjet::readAll();
                    else ControllerMain::erreur("Impossible de supprimer le Projet");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
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
            }elseif ($_POST['nomProjet'] != null) {
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
            $statuts = array('Accepté', 'Refusé', 'Déposé', 'En cours de montage');
            $tab = ModelProjet::searchBy($values, $conditions);
            $view = 'list';
            $pagetitle = 'Projet';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    public static function createBarGraph() {
        $statuts = $_POST['statut'];
        $start = $_POST['start'].'-01-01';
        $end = $_POST['end'].'-12-31';
        if ($_POST['graph']=='pie') {
            
        }
        if ($_POST['data']==1) {
            $tab = ModelProjet::statNbProjet($start,$end,$statuts);
            $scriptNewGraph = ControllerProjet::scriptBarNbProjet(1,$statuts,$_POST['titre'],'Nombre de projets',$_POST['start'],$_POST['end'],$tab);
        }elseif ($_POST['data']==2) {
            $montants = $_POST['montant'];
            if (isset($_POST['exceptionnel'])) {
                $tab = ModelProjet::statMontantProjet($start,$end,$statuts[0],$montants, true);
            }else {
                $tab = ModelProjet::statMontantProjet($start,$end,$statuts[0],$montants, false);
            }
            $scriptNewGraph = ControllerProjet::scriptBar(1,$montants,$_POST['titre'], 'Montant en €', $_POST['start'], $_POST['end'],$tab);
        }
        $script = ControllerProjet::$introScript.$scriptNewGraph.'</script>';
                    
        $view = 'new';
        $pagetitle = $_POST['titre'];
        require_once File::build_path(array('view', 'view.php'));
    }
}
