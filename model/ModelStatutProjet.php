<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelStatutEnseignant extends Model
{

    // Nom de la table
    protected static $object = 'StatutEnseignant';
    protected static $primary = 'codeStatut';

    private $codeStatut;
    private $statut;
    private $typeStatut;
    private $nombresHeures;

    /**
     * @return mixed
     */
    public function getCodeStatut()
    {
        return $this->codeStatut;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getTypeStatut()
    {
        return $this->typeStatut;
    }

    /**
     * @return int
     */
    public function getNombresHeures()
    {
        return (int)$this->nombresHeures;
    }

    /**
     * Retourne le statut désigné par son statut et son typeStatut, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $statut string
     * @param $typeStatut string
     * @return bool|ModelStatutEnseignant
     */
    public static function selectByStatutType($statut, $typeStatut)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE statut=:statut AND typeStatut=:typeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'statut' => $statut,
                'typeStatut' => $typeStatut);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelStatutEnseignant');
            $retourne = $rep->fetchAll();
            if (empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            return false;

        }
    }

    /**
     * Retourne le nom du statut au format : 'statut typeStatut'
     *
     * @return string
     * @example 'TITULAIRES IUT PRAG'
     */
    public function nommer()
    {
        return $this->getStatut().' '.$this->getTypeStatut();
    }


}