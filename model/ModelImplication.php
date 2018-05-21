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
        return $this->remarque;
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
     * @return mixed
     */
    public function setChefProjet($boolean)
    {
        $this->chefProjet = $boolean;
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
     * @deprecated
     * Renvoie la liste des tous les enseignants
     * TODO implémenter une fonction de page ?
     *
     * @return bool|array(ModelEnseigant)
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
            foreach ($retourne as $cle => $item) {
                //$retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                //$retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
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
            foreach ($retourne as $cle => $item) {
                //$retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                //$retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
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
            return false;
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

    /**
     * Renvoie tous les enseignant appartenant à un statut, false s'il y a une erreur
     *
     * @param $codeStatut string (techniquement c'est un string mais c'est un nombre)
     * @return bool|array(ModelEnseigant)
     */
    public static function selectAllByStatut($codeStatut)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeStatut=:codeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeStatut' => $codeStatut);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEnseignant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne tous les enseignants avec un nom/prenom proche de $npEns
     * TODO supprimer l'attribut prénom
     *
     * @param $npEns string nom/prenom d'un enseigant
     * @return bool|array(ModelEnseignant)
     */
    public static function selectAllByName($npEns)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nomEns LIKE CONCAT(\'%\',:npEns,\'%\')';
            $rep = Model::$pdo->prepare($sql);
            $values = array('npEns' => $npEns);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEnseignant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les statuts et le nombre de professeurs par statuts
     */
    public static function statStatutEtEnseignant()
    {
        try {
            $sql = 'SELECT
                      statut,
                      count(codeEns) as quantity
                    FROM StatutEnseignant
                      JOIN Enseignant E ON StatutEnseignant.codeStatut = E.codeStatut
                    GROUP BY E.codeStatut,statut;';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $e;
        }
    }

}