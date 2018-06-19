<?php
//DONE
require_once File::build_path(array('model', 'ModelParticipant.php'));
require_once File::build_path(array('model', 'ModelParticipation.php'));

class ControllerParticipant
{

    public static $object = 'Participant';

    /**
     * Affiche les détails d'un participant et les projets où il a participé
     *
     * S'il manque le codeParticipant, l'utilisateur est redirigé vers une erreur
     * Si le participant n'existe pas, l'utilisateur est redirigé vers une erreur
     *
     * @var $_GET['codeParticipant'] int code du participant
     * @uses ModelParticipant::select(codeParticipant)
     * @uses ModelParticipation::selectByParticipant()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeParticipant'])) {
                $participant = ModelParticipant::select($_GET['codeParticipant']);
                if (!$participant) ControllerMain::erreur("Ce participant n'existe pas");
                else {
                    $tabProjet = ModelParticipation::selectByParticipant($participant->getCodeParticipant());
                    $view = 'detail';
                    $pagetitle = $participant->getNomParticipant();
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Affiche la liste de tous les participants
     */
     public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelParticipant::selectAll();
            $view = 'list';
            $pagetitle = "Participants aux consortiums";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire de création d'un participant
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                $participant = new ModelParticipant();
                if (isset($_GET['codeProjet'])) {
                    $codeProjet = $_GET['codeProjet'];
                    $participation = new ModelParticipation();
                }
                $view = 'update';
                $pagetitle = 'Ajout d\'un nouveau participant';
                require_once File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Créé un participant à partir des informations du formulaire via la méthode POST et si un code de projet est précisé, il automatiquement impliqué dans le consortium du projet
     *
     * @uses ModelParticipant::save()
     * @uses ModelParticipation::add(codeProjet,codeParticipant,coordinateur,budget)
     *
     * @see ControllerParticipant::readAll()
     * @see ControllerProjet::updateContacts()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if($_SESSION['is_admin']) {
                if (isset($_POST['nomParticipant'])) {
                    $data = array('nomParticipant' => $_POST['nomParticipant'],
                                'nationalite' => $_POST['nationalite'],
                                'mailParticipant' => $_POST['mailParticipant'],
                                'affiliation' => $_POST['affiliation']);
                    $codeParticipant = ModelParticipant::save($data);
                    if (!$codeParticipant) ControllerMain::erreur("Impossible de créer le participant");
                    if (isset($_GET['codeProjet'])) {
                            if (isset($_POST['coordinateur'])) {
                                if (!ModelParticipation::add($_GET['codeProjet'],$codeParticipant,$_POST['coordinateur'],$_POST['budget'])) {
                                    ControllerMain::erreur('Impossible d\'ajouter le participant au projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }else {
                                if (!ModelParticipation::add($_GET['codeProjet'],$codeParticipant,0,$_POST['budget'])) {
                                    ControllerMain::erreur('Impossible d\'ajouter le participant au projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }   
                    }else {
                        ControllerParticipant::readAll();
                    }
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un participant
     * S'il n'y a pas de codeParticipant, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @var $_GET['codeParticipant'] int code du participant
     * @uses ModelParticipant::delete(codeParticipant)
     * @uses ControllerParticipant::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if(isset($_GET['codeParticipant'])) {
                    if(ModelParticipant::delete($_GET['codeParticipant'])) ControllerParticipant::readAll();
                    else ControllerMain::erreur("Impossible de supprimer le participant");
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Afficher le formulaire de maj d'un participant
     *
     * @uses ModelParticipant::select(codeParticipant)
     * @uses ModelParticipation::select(codeProjet,codeParticipant)
     */
    public static function update()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeParticipant'])) {
                    $participant = ModelParticipant::select($_GET['codeParticipant']);
                    if (!$participant) ControllerMain::erreur("Ce participant n'existe pas");
                    else {
                        if (isset($_GET['codeProjet'])) {
                            $participation = ModelParticipation::select($_GET['codeProjet'],$participant->getCodeParticipant());
                        }
                        $view = 'update';
                        $pagetitle = 'Modification d\'un participant à un consortium';
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Il manque des informations");
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Met à jour les informations d'un participant avec les informations fournies via la méthode POST et si un code de projet est précisé, il automatiquement impliqué dans le consortium du projet
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @var $_POST['codeParticipant'] int code du participant
     * @uses ModelParticipant::update(data)
     * @uses ModelParticipation::update(codeProjet,codeParticipant,coordinateur,budget)
     * @see ControllerParticipant::readAll()
     * @see ControllerProjet::updateContacts()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if($_SESSION['is_admin']) {
                if (isset($_POST['codeParticipant']) && isset($_POST['nomParticipant'])) {
                    $data = array('codeParticipant' => $_POST['codeParticipant'],
                                'nomParticipant' => $_POST['nomParticipant'],
                                'nationalite' => $_POST['nationalite'],
                                'mailParticipant' => $_POST['mailParticipant'],
                                'affiliation' => $_POST['affiliation']);
                    if (!ModelParticipant::update($data)) ControllerMain::erreur("Impossible de créer le participant");
                    if (isset($_GET['codeProjet'])) {
                            if (isset($_POST['coordinateur'])) {
                                if (!ModelParticipation::update($_GET['codeProjet'],$_POST['codeParticipant'],$_POST['coordinateur'],$_POST['budget'])) {
                                    ControllerMain::erreur('Impossible de modifier le participant du projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }else {
                                if (!ModelParticipation::update($_GET['codeProjet'],$_POST['codeParticipant'],0,$_POST['budget'])) {
                                    ControllerMain::erreur('Impossible de modifier le participant du projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }   
                    }else {
                        ControllerParticipant::readAll();
                    }
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

}