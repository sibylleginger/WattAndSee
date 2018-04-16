<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelEntite extends Model
{

    // Nom de la table
    protected static $object = 'Entite';
    protected static $primary = 'codeEntite';

    // Données
    private $codeEntite;
    private $nomEntite;

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
    public function getNomEntite()
    {
        return $this->nomEntite;
    }

    /**
     * @return mixed
     */
    public function setNomEntite($nomEntite)
    {
        $this->nomEntite = $nomEntite;
    }    


    /**
     * Renvoie l'entite avec son code donné en paramètre, false s'il y a une erreur
     *
     * @param $primary_value string codeEntite
     * @return bool|ModelEntite
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if(!$retourne) return false;
        return $retourne;
    }

    /**
     * Retourne toutes les Entités, false s'il y a une erreur
     *
     * @return bool|array(ModelEntite)
     */
    public static function selectAll()
    {
        $retourne= parent::selectAll();
        foreach ($retourne as $cle => $item) {
        }
        return $retourne;
    }

    /**
     * Retourne l'objet Entite avec son nom donné en paramètre, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $nomEntite string
     * @return bool|ModelEntite
     */
    public static function selectByName($nomEntite)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE nomEntite=:nomEntite';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'nomEntite' => $nomEntite);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEntite');
            $retourne = $rep->fetchAll();
            if(empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

}