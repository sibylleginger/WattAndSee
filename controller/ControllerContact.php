<?php

require_once File::build_path(array('model', 'ModelContact.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerExtraction
 */
class ControllerContact
{

    /**
     * @var string
     */
    protected static $object = 'Contact';


    /**
     * Envoie vers la page d'importation du fichier .csv
     */
     public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelContact::selectAll();
            $view = 'list';
            $pagetitle = "Contacts";
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Affiche le details d'un Contact identifié par son nomContact @var $_GET ['nomContact']
     *
     * Il affiche aussi la liste des salles dans la Contact
     * S'il n'y a pas de nomContact, l'utilisateur sera redirigé vers une erreur
     * Si le Contact n'existe pas, l'utilisateur sera redirigé vers une erreur
     * S'il n'y a aucune salle dans le Contact, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelContact::select()
     * @uses ModelSalle::selectAllByContact()
     */
    public static function read()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_GET['codeContact'])) {
                $contact = ModelContact::select($_GET['codeContact']);
                if ($contact == false) ControllerMain::erreur("Ce Contact n'existe pas");
                else {
                    $sourceFin = ModelSourceFin::select($contact->getCodeSourceFin());
                    $entite = ModelEntite::select($contact->getCodeEntite());
                    $departement = ModelDepartement::select($contact->getCodeDepartement());
                    $tabProjet = ModelImplication::selectAllByContact($_GET['codeContact']);
                    //$tabParticipant = ModelParticipation::selectAllByConsortium($Contact->getCodeConsortium());
                    $pagetitle = 'Contact ' . $contact->getNomContact();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                    
                    /*else {
                        $pagetitle = 'Contact ' . $_GET['nomContact'];
                        $view = 'detail';
                        require_once File::build_path(array('view', 'view.php'));
                    }*/
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function update() {
        if (isset($_GET['codeContact'])){
            if(isset($_SESSION['login'])) {
                $contact = ModelContact::select($_GET['codeContact']);
                if (!$contact) ControllerMain::erreur("Ce contact n'existe pas");
                else {
                    $entite = ModelEntite::select($contact->getCodeEntite());
                    $tabEntite = ModelEntite::selectAll();
                    $tabDepartement = ModelDepartement::selectAll();
                    $tabSourceFin = ModelSourceFin::selectAll();
                    $departement = ModelDepartement::select($contact->getCodeDepartement());
                    $view = 'update';
                    $pagetitle = 'Modification du Contact';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }
            
    }

    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['codeContact']) &&
                isset($_POST['nomContact']) &&
                isset($_POST['prenomContact'])) {
                /**
                 * Vérification existance
                 */
                $updateContact = ModelContact::select($_POST['codeContact']);
                if($_POST['codeContact'] == $updateContact->getCodeContact()) {

                    $data = array(
                        'codeContact' => $_POST['codeContact'],
                        'nomContact' => $_POST['nomContact'],
                        'prenomContact' => $_POST['prenomContact'],
                        'mail' => $_POST['mail']);
                    if ($_POST['codeSourceFin'] != '') {
                        $data['codeSourceFin'] = $_POST['codeSourceFin'];
                        if (!ModelContact::update($data)) ControllerMain::erreur("Impossible de créer le contact");
                        else {
                            $contact = ModelContact::select($_POST['codeContact']);
                            $sourceFin = ModelSourceFin::select($contact->getCodeSourceFin());
                            $entite = ModelEntite::select($contact->getCodeEntite());
                            $departement = ModelDepartement::select($contact->getCodeDepartement());
                            $tabProjet = ModelImplication::selectAllByContact($_GET['codeContact']);
                            //$tabParticipant = ModelParticipation::selectAllByConsortium($Contact->getCodeConsortium());
                            $pagetitle = 'Contact ' . $contact->getNomContact();
                            $view = 'detail';
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    }else {
                        $data['codeEntite'] = $_POST['codeEntite'];
                        if ($_POST['codeDepartement'] != '') {
                            $data['codeDepartement'] = $_POST['codeDepartement'];
                        }
                        if (isset($_GET['codeProjet'])) {
                            $codeContact = ModelContact::save($data);
                            if (!$codeContact) ControllerMain::erreur("Impossible de créer le contact");
                            if(!ModelContact::select($codeContact)) ControllerMain::erreur(var_dump($codeContact));
                            if (isset($_POST['chefProjet'])) {
                                if (!ModelImplication::add($_GET['codeProjet'],$codeContact,$_POST['chefProjet'])) {
                                    ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }else {
                                if (!ModelImplication::add($_GET['codeProjet'],$codeContact,0)) {
                                    ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                                }else {
                                    ControllerProjet::updateContacts();
                                }
                            }   
                        }else {
                            ControllerContact::readAll();
                        }
                    }
                    if ($_POST['codeSourceFin'] != '') {
                        $data['codeSourceFin'] = $_POST['codeSourceFin'];
                    }else {
                        $data['codeEntite'] = $_POST['codeEntite'];
                        if ($_POST['codeDepartement'] != '') {
                            $data['codeDepartement'] = $_POST['codeDepartement'];
                        }
                    }
                    if(!ModelContact::update($data)) ControllerMain::erreur("Impossible de modifier le contact");
                    else {
                        $tabProjet = ModelImplication::selectAllByContact($_POST['codeContact']);
                        $contact = ModelContact::select($_POST['codeContact']);
                        $entite = ModelEntite::select($_POST['codeEntite']);
                        $departement = ModelDepartement::select($_POST['codeDepartement']);
                        $view = 'detail';
                        $pagetitle = 'Contact : ' . $contact->getPrenomContact(). ' ' .$contact->getPrenomContact();
                        require_once File::build_path(array('view', 'view.php'));
                    }
                } else ControllerMain::erreur("Cette unité d'enseignement existe déjà");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    public static function create()
    {
        if (isset($_SESSION['login'])) {
            $contact = new ModelContact();
            if (isset($_GET['codeSourceFin'])) {
                $codeSourceFin = $_GET['codeSourceFin'];
            }else {
                $codeProjet = $_GET['codeProjet'];
            }
            //$sourceFin = ModelSourceFin::select($Contact->getCodeSourceFin());
            $tabEntite = ModelEntite::selectAll();
            $tabSourceFin = ModelSourceFin::selectAll();
            $tabDepartement = ModelDepartement::selectAll();
            $view = 'update';
            $pagetitle = 'Créer un nouveau contact';
            require_once File::build_path(array('view', 'view.php'));
        } else ControllerUser::connect();
    }

    /**
     * Crée un Contact à partir des informations du formulaire via la méthode POST
     *
     * @uses ModelContact::save()
     * @uses ControllerContact::readAll()
     *
     * @see ControllerContact::readAll()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['nomContact']) &&
                isset($_POST['prenomContact'])) {
                $data = array('nomContact' => $_POST['nomContact'],
                            'prenomContact' => $_POST['prenomContact'],
                            'mail' => $_POST['mail']);
                if ($_POST['codeSourceFin'] != '') {
                    $data['codeSourceFin'] = $_POST['codeSourceFin'];
                    if (!ModelContact::save($data)) ControllerMain::erreur("Impossible de créer le contact");
                    elseif(isset($_GET['codeSourceFin']))  require_once ControllerSourceFin::read();
                    else ControllerContact::readAll();
                }else {
                    $data['codeEntite'] = $_POST['codeEntite'];
                    if ($_POST['codeDepartement'] != '') {
                        $data['codeDepartement'] = $_POST['codeDepartement'];
                    }
                    if (isset($_GET['codeProjet'])) {
                        $codeContact = ModelContact::save($data);
                        if (!$codeContact) ControllerMain::erreur("Impossible de créer le contact");
                        if(!ModelContact::select($codeContact)) ControllerMain::erreur(var_dump($codeContact));
                        if (isset($_POST['chefProjet'])) {
                            if (!ModelImplication::add($_GET['codeProjet'],$codeContact,$_POST['chefProjet'])) {
                                ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                            }else {
                                ControllerProjet::updateContacts();
                            }
                        }else {
                            if (!ModelImplication::add($_GET['codeProjet'],$codeContact,0)) {
                                ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                            }else {
                                ControllerProjet::updateContacts();
                            }
                        }   
                    }else {
                        ControllerContact::readAll();
                    }
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un Contact grace à son nomContact @var $_GET['nomContact']
     *
     * S'il n'y a pas de nomContact, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @uses ModelContact::delete()
     * @uses ControllerContact::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if(isset($_GET['codeContact'])) {
                if(ModelContact::delete($_GET['codeContact'])) ControllerContact::readAll();
                else ControllerMain::erreur("Impossible de supprimer le Contact");
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }
}