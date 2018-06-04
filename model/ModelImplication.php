<?php
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
     * @param mixed $codeDepartement
     */
    public function setCodeContact($codeContact)
    {
        $this->codeContact = $codeContact;
    }

    /**
     * @return mixed
     */
    public function getCodeProjet()
    {
        return $this->codeProjet;
    }

    /**
     * @param mixed $codeStatut
     */
    public function setCodeProjet($codeProjet)
    {
        $this->codeProjet = $codeProjet;
    }

    /**
     * Retourne l'enseignant désigné par son code Enseignant, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|ModelEnseignant
     *
     * @uses  Model::select()
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
     * @return bool
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
            return false;
        }
    }

    /**
     * @deprecated
     * Renvoie la liste des toutes les implications
     *
     * @return bool|array(ModelImplication)
     *
     * @uses  Model::selectAll()
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
            $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
        }
        return $retourne;
    }

    /**
     * Renvoie tous les enseignants appartenant à un département, false s'il y a une erreur
     *
     * @param $codeDepartement string(1)
     * @return bool|array(ModelEnseignant)
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
            
        }
    }

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