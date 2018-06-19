<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelImplication.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelContact.php'));

class ModelImplication
{

    protected static $object = 'Implication';

    private $codeProjet;
    /**
     * @var $codeStatut ModelStatutEnseignant
     */
    private $codeContact;
    private $chefProjet;
    /**
     * @return mixed
     */
    public function getChefProjet()
    {
        return $this->chefProjet;
    }

    /**
     * @return mixed
     */
    public function getCodeContact()
    {
        return $this->codeContact;
    }

    /**
     * @return mixed
     */
    public function getCodeProjet()
    {
        return $this->codeProjet;
    }

    /**
     * Retourne l'implication d'un contact à un projet, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $codeProjet int code du projet
     * @param $codeContact int code du contact
     * @return bool|ModelParticipation
     */
    public static function select($codeProjet, $codeContact)
    {
        try {
            $sql = 'SELECT * FROM Implication WHERE codeProjet=:codeProjet AND codeContact=:codeContact';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeContact' => $codeContact);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelImplication');
            $retourne = $rep->fetchAll();
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Modifie le booléen chefProjet dans la table Implication pour attribuer ou destituer le rôle de chef de projet selon la valeur initiale
     * Changes the boolean value of chefProjet in table Implication to set or unset the rôle of project leader
     *
     * @param $codeProjet int
     * @param $codeContact int
     *
     * @return bool|Exception
     *
     * @uses ModelImplication::select($codeProjet,$codeContact)
     */
    public static function setChefProjet($codeProjet, $codeContact) {
        $implication = ModelImplication::select($codeProjet,$codeContact);
        try {
            $sql = 'UPDATE Implication SET chefProjet=';
            if ($implication->getChefProjet()==1) {
                $sql .= '0 ';
            }else {
                $sql .= '1 ';
            }
            $sql .= 'WHERE codeProjet=:codeProjet AND codeContact=:codeContact';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeContact' => $codeContact);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Renvoie tous les contacts impliqué dans un projet, false s'il y a une erreur
     *
     * @param $codeProjet int code du projet
     * @return bool|array(ModelContact)
     */
    public static function selectAllByProjet($codeProjet)
    {
        try {
            $sql = 'SELECT * FROM Contact C
            JOIN Implication I ON C.codeContact = I.codeContact
            WHERE I.codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie tous les projets où le contact est impliqué, false s'il y a une erreur
     *
     * @param $codeContact int code du contact
     * @return bool|array(ModelProjet)
     */
    public static function selectAllByContact($codeContact)
    {
        try {
            $sql = 'SELECT * FROM Projet P
            JOIN Implication I ON P.codeProjet = I.codeProjet
            WHERE I.codeContact=:codeContact';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeContact' => $codeContact);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne le chef du projet, false s'il y a une erreur
     *
     * @param $codeProjet int code du projet
     * @return bool|ModelContact
     */
    public static function selectChef($codeProjet) {
        try {
            $sql = 'SELECT * FROM Contact C
            JOIN Implication I ON C.codeContact=I.codeContact
            WHERE I.chefProjet="1" AND I.codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
            if (empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Supprime l'implication d'un contact à un projet
     *
     * @param $codeProjet, $codeContact int code du projet/contact
     * @return bool|Exception
     */
    public static function delete($codeProjet, $codeContact) {
        try {
            $sql = 'DELETE FROM Implication WHERE codeProjet=:codeProjet AND codeContact=:codeContact';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeContact' => $codeContact);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Ajoute l'implication d'un contact à un projet
     *
     * @param $codeProjet, $codeContact int code du projet/contact
     * @param $chefProjet boolean rôle du contat
     * @return bool|Exception
     */
    public static function add($codeProjet, $codeContact, $chefProjet) {
        try {
            $sql = 'INSERT INTO Implication VALUES (:codeProjet,:codeContact,:chefProjet)';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeContact' => $codeContact,
                            'chefProjet' => $chefProjet);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();;
        }
    }
}