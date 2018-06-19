<?php
//DONE
require_once File::build_path(array('model', 'ModelContact.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerContact
 */
class ControllerContact
{

    /**
     * @var string
     */
    protected static $object = 'Contact';


    /**
     * Affiche la liste de tous les contacts
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
     * Affiche les details d'un contact et les projets auxquels il est impliqué
     * Si le contact n'existe pas, l'utilisateur sera redirigé vers une erreur
     *
     * @var $_GET ['codeContact'] int code du contact
     * @uses ModelContact::select()
     * @uses ModelImplication::selectAllByContact(codeContact)
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
                    $pagetitle = 'Contact ' . $contact->getNomContact();
                    $view = 'detail';
                    require_once File::build_path(array('view', 'view.php'));
                }
            } else ControllerMain::erreur("Il manque des informations");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de mise à jour des informations d'un contact
     *
     * @var  $_GET['codeContact'] int code du contact
     * @uses ModelContact::select();
     */
    public static function update() {
        if(isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeContact'])){
                    $contact = ModelContact::select($_GET['codeContact']);
                    if (!$contact) ControllerMain::erreur("Ce contact n'existe pas");
                    else {
                        $tabImplication = ModelImplication::selectAllByContact($contact->getCodeContact());
                        $tabProjet = ModelProjet::selectAll();
                        $entite = ModelEntite::select($contact->getCodeEntite());
                        $tabEntite = ModelEntite::selectAll();
                        $tabDepartement = ModelDepartement::selectAll();
                        $tabSourceFin = ModelSourceFin::selectAll();
                        $departement = ModelDepartement::select($contact->getCodeDepartement());
                        $view = 'update';
                        $pagetitle = 'Modification du Contact';
                        require_once File::build_path(array('view', 'view.php'));
                    }
                }else ControllerMain::erreur('Il manque des informations');
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }else ControllerUser::connect();
            
    }

    /**
     * Met à jour les informations d'un contact avec les informations fournies via la méthode POST
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @var $_POST['codeContact'] int code du contact
     * @uses ModelContact::update(data)
     * @see ControllerContact::readAll()
     */
    public static function updated()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
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
                            'mail' => $_POST['mail'],
                            'telephone' => $_POST['telephone'],
                            'affiliation' => $_POST['affiliation']);
                        if ($_POST['codeSourceFin'] != '') {
                            $data['codeSourceFin'] = $_POST['codeSourceFin'];
                            if (!ModelContact::update($data)) ControllerMain::erreur("Impossible de modifier le contact");
                            else {
                                $contact = ModelContact::select($_POST['codeContact']);
                                $sourceFin = ModelSourceFin::select($contact->getCodeSourceFin());
                                $entite = ModelEntite::select($contact->getCodeEntite());
                                $departement = ModelDepartement::select($contact->getCodeDepartement());
                                $tabProjet = ModelImplication::selectAllByContact($_GET['codeContact']);
                                $pagetitle = 'Contact ' . $contact->getNomContact();
                                $view = 'detail';
                                require_once File::build_path(array('view', 'view.php'));
                            }
                        }else {
                            if ($_POST['codeEntite'] != '') {
                                $data['codeEntite'] = $_POST['codeEntite'];
                            }
                            if ($_POST['codeDepartement'] != '') {
                                $data['codeDepartement'] = $_POST['codeDepartement'];
                            }
                            if (!ModelContact::update($data)) ControllerMain::erreur("Impossible de modifier le contact");
                            else ControllerContact::readAll();
                        }
                    } else ControllerMain::erreur("Ce contact n'existe pas");
                } else ControllerMain::erreur("Il manque des informations");
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Redirige vers le formulaire de création d'un contact
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                $contact = new ModelContact();
                if (isset($_GET['codeSourceFin'])) {
                    $codeSourceFin = $_GET['codeSourceFin'];
                }elseif (isset($_GET['codeProjet'])) {
                    $codeProjet = $_GET['codeProjet'];
                }
                $tabImplication = array();
                $tabProjet = ModelProjet::selectAll();
                $tabEntite = ModelEntite::selectAll();
                $tabSourceFin = ModelSourceFin::selectAll();
                $tabDepartement = ModelDepartement::selectAll();
                $view = 'update';
                $pagetitle = 'Créer un nouveau contact';
                require_once File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Crée un Contact à partir des informations du formulaire via la méthode POST et si un code de projet est précisé, il automatiquement impliqué dans le projet
     *
     * @uses ModelContact::save()
     * @uses ModelContact::select(codeContact)
     * @uses ModelImplication::add(codeProjet,codeContact,chefProjet)
     *
     * @see ControllerContact::readAll()
     * @see ControllerSourceFin::read()
     * @see ControllerProjet::updateContacts()
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if($_SESSION['is_admin']) {
                if (isset($_POST['nomContact']) &&
                    isset($_POST['prenomContact'])) {
                    $data = array('nomContact' => $_POST['nomContact'],
                                'prenomContact' => $_POST['prenomContact'],
                                'mail' => $_POST['mail'],
                                'telephone' => $_POST['telephone'],
                                'affiliation' => $_POST['affiliation']);
                    if (isset($_GET['codeSourceFin'])) {
                        $data['codeSourceFin'] = $_GET['codeSourceFin'];
                        if (!ModelContact::save($data)) ControllerMain::erreur("Impossible de créer le contact");
                        else {
                            ControllerSourceFin::read();
                        }
                    }else {
                        $data['codeEntite'] = $_POST['codeEntite'];
                        if ($_POST['codeDepartement'] != '') {
                            $data['codeDepartement'] = $_POST['codeDepartement'];
                        }
                        if (isset($_GET['codeProjet'])) {
                            $codeContact = ModelContact::save($data);
                            if (!$codeContact) ControllerMain::erreur("Impossible de créer le contact");
                            if(!ModelContact::select($codeContact)) ControllerMain::erreur("Impossible de créer le contact");
                            if (isset($_POST['chefProjet'])) {
                                if (!ModelImplication::add($_GET['codeProjet'],$codeContact,$_POST['chefProjet'])) {
                                    ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                                }else {
                                    header('Location: index.php?controller=projet&action=updateContacts&codeProjet='.$_GET['codeProjet']);
                                }
                            }else {
                                if (!ModelImplication::add($_GET['codeProjet'],$codeContact,0)) {
                                    ControllerMain::erreur('Impossible d\'ajouter le contact au projet');
                                }else {
                                    header('Location: index.php?controller=projet&action=updateContacts&codeProjet='.$_GET['codeProjet']);
                                }
                            }   
                        }else {
                            ControllerContact::readAll();
                        }
                    }
                } else ControllerMain::erreur('Il manque des informations');
            } else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        } else ControllerUser::connect();
    }

    /**
     * Supprime un contact
     * S'il n'y a pas de codeContact, l'utilisateur sera redirigé vers une erreur
     * Si la suppression ne fonctionne pas, l'utilisateur sera redirigé vers une erreur
     *
     * @var $_GET['codeContact'] int code du contact
     * @uses ModelContact::delete()
     * @uses ControllerContact::readAll()
     */
    public static function delete()
    {
        if(isset($_SESSION['login'])) {
            if($_SESSION['is_admin']) {
                if(isset($_GET['codeContact'])) {
                    if(ModelContact::delete($_GET['codeContact'])) ControllerContact::readAll();
                    else ControllerMain::erreur("Impossible de supprimer le contact");
                } else ControllerMain::erreur("Il manque des informations");
            } else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Modifie le champ codeSourceFin pour l'impliquer ou enlever son implication dans un programme
     * S'il manque des information, l'utilisateur est redirigé vers une erreur
     * Si la maj ne marche pas, l'utilisateur est redirigé vers une erreur
     *
     * @var $_POST['codeContact'] int code du contact
     * @uses ModelContact::update(data)
     * @return 'true'|message d'erreur (string)
     */
    public static function updateSourceFin()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_POST['codeSourceFin']) && isset($_POST['codeContact'])) {
                    $contact = ModelContact::select($_POST['codeContact']);
                    if (!$contact) {
                        echo 'Le contact n\'existe pas';
                    }else {
                        if ($contact->getCodeSourceFin() != null) {
                            $codeSourceFin = null;
                        }else {
                            $codeSourceFin = $_POST['codeSourceFin'];
                        }
                        $data = array('codeContact' => $_POST['codeContact'],
                                    'codeSourceFin' => $codeSourceFin);
                        $res = ModelContact::update($data);
                        if ($res) {
                            echo 'true';
                        }else {
                            echo $res;
                        }
                    }
                } else echo("Il manque des informations");
            } else echo('Vous n\'avez pas le droit de modifier les contacts');
        } else ControllerUser::connect();
    }
}