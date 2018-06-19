<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelEntite.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ModelContact extends Model
{
    /**
     * @var $object nom de la table
     */
    protected static $object = 'Contact';
    /**
     * @var $primary clé primaire
     */
    protected static $primary = 'codeContact';

    private $codeContact;
    private $nomContact;
    private $prenomContact;
    private $mail;
    private $affiliation;
    private $telephone;

    private $codeSourceFin;
    private $codeEntite;
    private $codeDepartement;

    /**
     * @return mixed
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
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
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
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
     * @return mixed
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getCodeSourceFin()
    {
        return $this->codeSourceFin;
    }

    /**
     * Retourne un contact, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value int code du contact
     * @return bool|ModelContact
     *
     * @uses  Model::select()
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        return $retourne;
    }

    /**
     * Créé un nouveau contact et retourne son codeContact, false si la requête n'a pas fonctionnée
     *
     * @param $data array() valeurs des champs du contact
     * @return bool|int
     *
     * @uses  Model::save()
     */
    public static function save($data) {
        if (parent::save($data)) {
            return Model::$pdo->lastInsertId();
        }else return false;
    }

    /**
     * Renvoie tous les contacts n'appartenant pas à un programme de financement, false s'il y a une erreur
     *
     * @return bool|array(ModelContact)
     */
    public static function selectAllHorsSF()
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeSourceFin IS NULL ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie tous les contacts n'appartenant pas à une entité EDF, false s'il y a une erreur
     *
     * @return bool|array(ModelContact)
     */
    public static function selectAllHorsEDF()
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEntite IS NULL ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }  

    /**
     * Renvoie tous les contacts appartenant à un programme de financement, false s'il y a une erreur
     *
     * @param $codeSourceFin int code du programme de financment
     * @return bool|array(ModelContact)
     */
    public static function selectAllBySource($codeSourceFin)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeSourceFin=:codeSourceFin ORDER BY nomContact ASC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeSourceFin' => $codeSourceFin);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelContact');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }
}