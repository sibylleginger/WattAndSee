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

    /**
     * Retourne un tableau avec les statuts et le nombre de projets par statut
     */
    public static function statStatutEtProjet($codeEntite)
    {
        $entite = ModelEntite::select($codeEntite);
        try {
            $sql = 'SELECT statut as prim, count(codeProjet) as quantity
                    FROM ProjetSearch
                    WHERE nomEntite=:nomEntite
                    GROUP BY statut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('nomEntite' => $entite->getNomEntite());
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function statNbProjet($startG,$endG,$statuts,$codeEntite)
    {
        $entite = ModelEntite::select($codeEntite);
        try {
            $sql = 'SELECT DATE_FORMAT(dateDepot, "%Y") as prim, statut as bar, count(codeProjet) as quantity
                    FROM ProjetSearch P
                    WHERE';
            foreach ($statuts as $key => $value) {
                $sql .= ' (nomEntite=:nomEntite AND dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut'.$key. ') OR';
                
            }
            $sql = rtrim($sql, ' OR');
            $sql .= ' GROUP BY DATE_FORMAT(dateDepot,"%Y"), statut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('startG' => $startG,
                            'endG' => $endG,
                            'nomEntite' => $entite->getNomEntite());
            foreach ($statuts as $key => $value) {
                $values['statut'.$key] = $value;
            }
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $sql;
        }
    }

    public static function statMontantProjet($startG,$endG,$statut,$montants,$codeEntite) //$sort = %Y pour année
    {
        $entite = ModelEntite::select($codeEntite);
        try {
            $sql = 'SELECT DATE_FORMAT(dateDepot, "%Y") as prim';
            foreach ($montants as $key => $value) {
                $sql .= ', SUM('.$value.') as value'.$key;
            }
            $sql .= ' FROM ProjetSearch P
                    WHERE (nomEntite=:nomEntite AND dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut)';
            $sql .= ' GROUP BY DATE_FORMAT(dateDepot, "%Y")';
            $rep = Model::$pdo->prepare($sql);
            $values = array('startG' => $startG,
                            'endG' => $endG,
                            'statut' => $statut,
                            'nomEntite' => $entite->getNomEntite());
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $sql;
        }
    }

}