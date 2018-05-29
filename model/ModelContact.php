<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ModelContact extends Model
{

    protected static $object = 'Contact';
    protected static $primary = 'codeContact';

    private $codeContact;
    private $nomContact;
    private $prenomContact;
    private $mail;
    private $codeSourceFin;

    /**
     * @var $codeEntite ModelEntite
     */
    private $codeEntite;
    /**
     * @var $codeDepartement ModelDepartement
     */
    private $codeDepartement;

    /**
     * @return mixed
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeDepartement($codeDepartement)
    {
        $this->codeDepartement = $codeDepartement;
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
    public function getCodeEntite()
    {
        return $this->codeEntite;
    }

    /**
     * @param mixed $codeEntite
     */
    public function setCodeEntite($codeEntite)
    {
        $this->codeEntite = $codeEntite;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $codeEntite
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getNomContact()
    {
        return $this->nomContact;
    }

    /**
     * @return mixed
     */
    public function getPrenomContact()
    {
        return $this->prenomContact;
    }

    /**
     * @param mixed $codeEntite
     */
    public function setCodeSourceFin($codeSourceFin)
    {
        $this->codeSourceFin = $codeSourceFin;
    }

    /**
     * @return mixed
     */
    public function getCodeSourceFin()
    {
        return $this->codeSourceFin;
    }

    /**
     * Retourne l'enseignant désigné par son code Enseignant, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|ModelEnseignant
     *
     * @uses  Model::select()
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        return $retourne;
    }

    public static function save($data) {
        if (parent::save($data)) {
            return Model::$pdo->lastInsertId();
        }else return false;
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
        return $retourne;
    }

    /**
     * Renvoie tous les enseignants appartenant à un département, false s'il y a une erreur
     *
     * @param $codeDepartement string(1)
     * @return bool|array(ModelEnseignant)
     */
    public static function selectAllEDF()
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEntite IS NOT NULL ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
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

    public static function selectAllHorsEDF()
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEntite IS NULL ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
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

    public static function selectAllBySource($codeSourceFin)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeSourceFin=:codeSourceFin ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeSourceFin' => $codeSourceFin);
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

    /**
     * Renvoie tous les enseignant appartenant à un statut, false s'il y a une erreur
     *
     * @param $codeEntite string (techniquement c'est un string mais c'est un nombre)
     * @return bool|array(ModelEnseigant)
     */
    public static function selectAllByStatut($codeEntite)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeStatut=:codeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeStatut' => $codeEntite);
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

    public static function selectAllByEntite($codeEntite)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEntite=:codeEntite ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeEntite' => $codeEntite);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
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