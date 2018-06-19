<?php
//DONE
require_once File::build_path(array('model', 'ModelDocument.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ControllerUser
 */
class ControllerDocument
{

    /**
     * Nom de la table @var string
     */
    protected static $object = 'Document';

    /**
     * Affiche tous les documents
     * Displays all the documents
     */
    public static function readAll()
    {
        if (isset($_SESSION['login'])) {
            $tab = ModelDocument::selectAll();
            if ($tab == false) {
                ControllerMain::erreur("Il n'y a pas de documents");
            } else {
                $view = 'list';
                $pagetitle = 'Liste des documents';
                require_once File::build_path(array('view', 'view.php'));
            }
        } else {
            ControllerUser::connect();
        }
    }

    /**
     * Affiche tous les documents associés à un projet
     * Displays all the documents of a project
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
            if (!$projet) {
                ControllerMain::erreur('Le projet n\'existe pas');
            }
            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
            $tabDoc = ModelDocument::selectAllByProjet($projet->getCodeProjet());
            $view = 'list';
            $pagetitle = 'Documents du projet';
            require_once File::build_path(array('view', 'view.php'));
        }else ControllerUser::connect();
    }

    /**
     * Supprime le document associé au projet
     * Deletes the document of the project
     *
     * @var $_GET['codeDocument'] string nom du fichier
     * @var $_POST['codeProjet'] int code du projet
     */
    public static function delete()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_GET['codeDocument']) && isset($_GET['codeProjet'])) {
                    if (!ModelDocument::select($_GET['codeDocument'])) {
                        ControllerMain::erreur('Le document n\'existe pas');
                    }else {
                        if (!ModelDocument::delete($_GET['codeDocument'])) {
                            ControllerMain::erreur('Impossible de supprimer le document');
                        }else {
                            $projet = ModelProjet::select($_GET['codeProjet']);
                            $sourceFin = ModelSourceFin::select($projet->getCodeSourceFin());
                            $tabDoc = ModelDocument::selectAllByProjet($projet->getCodeProjet());
                            $view = 'list';
                            $pagetitle = 'Documents du projet';
                            require_once File::build_path(array('view', 'view.php'));
                        }
                    }
                }else ControllerMain::erreur('Il manque des informations');
            }else ControllerMain::erreur("Vous n'avez pas le droit de voir cette page");
        }else ControllerUser::connect();
    }

    /**
     * Affiche le formulaire d'importation d'un document 
     * Displays the form to upload a document
     */
    public static function create()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                $projet = ModelProjet::select($_GET['codeProjet']);
                $view = 'create';
                $pagetitle = 'Ajout d\'un nouveau document';
                $document = new ModelDocument();
                require File::build_path(array('view', 'view.php'));
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        } else ControllerUser::connect();
    }

    /**
     * Crée un nouveau document pour le projet
     * Create a new document for the project
     *
     * @var $_FILES['namePJ'] string nom du fichier
     * @var $_POST['codeProjet'] int code du projet
     */
    public static function created()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['is_admin']) {
                if (isset($_FILES['namePJ'])) {
                    $allDocNames = ModelDocument::selectAllNames();
                    foreach ($allDocNames as $value) {
                        if ($_FILES['namePJ']['name'] == $value['namePJ']) {
                            ControllerMain::erreur('Un document avec le même nom existe déja');
                        }
                    }if ($_FILES['namePJ']['error'] == 2 || $_FILES['namePJ']['error'] == 1) {
                        ControllerMain::erreur("Le document dépasse la taille maximale autorisée");
                    }else {
                        //This is the directory where images will be saved
                        $target = "./docs/";
                        $target = $target . htmlspecialchars(basename( $_FILES['namePJ']['name']));
                        if(move_uploaded_file($_FILES['namePJ']['tmp_name'], $target)) {
                            //This gets all the other information from the form
                            $data = array('namePJ' => $_FILES['namePJ']['name'],
                                        'titre' => $_POST['titre'],
                                        'codeProjet' => $_POST['codeProjet']);
                            if(ModelDocument::save($data)) {
                                ControllerDocument::readAllByProjet();
                            }else ControllerMain::erreur('Impossible d\'ajouter un fichier');
                        } else {
                            //Gives and error if its not
                            ControllerMain::erreur("Impossible d'ajouter le document, le format n'est pas autorisé");
                        }
                    }
                }else ControllerMain::erreur('Impossible d\'ajouter le document');
            }else ControllerMain::erreur('Vous n\'avez pas le droit de voir cette page');
        }else ControllerUser::connect();
    }
}
