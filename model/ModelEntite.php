<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));

class ModelEntite extends Model
{

    // Nom de la table
    //Table name
    protected static $object = 'Entite';
    //clé de la table
    //table key
    protected static $primary = 'codeEntite';

    // Données
    // Data
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
     * Renvoie l'entite avec son code donné en paramètre, false s'il y a une erreur
     * Return the entity whose code is the argument of the function, false is there's an error
     *
     * @param $primary_value string codeEntite
     * @return bool|ModelEntite
     *
     * @uses Model::select()
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if(!$retourne) return false;
        return $retourne;
    }

    /**
     * Retourne toutes les entités, false s'il y a une erreur
     * Return all entities, false if there's an error
     *
     * @return bool|array(ModelEntite)
     *
     * @uses Model::selectAll()
     */
    public static function selectAll()
    {
        $retourne= parent::selectAll();
        foreach ($retourne as $cle => $item) {
        }
        return $retourne;
    }

    /**
     * Retourne un tableau avec les statuts et le nombre de projets par statut associés à une entité
     * Return a table with the status and the number of projects per status linked to an entity
     *
     * @param $codeEntite int codeEntite
     * @return bool|array([prim][quantity])
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
            return $false;
        }
    }

    /**
     * Retourne un tableau avec l'année de dépot, le statut des projets et le nombre de projets par statut et par année. Les projets sont associés à une entité
     * Return a table with the submission year, the projects' status and the number of projects per status and per year. The projects are linked to an entity
     *
     * @param $codeEntite int code de l'entite, $starG/$endG date début/fin, $statuts array(string)
     * @return bool|array([prim][bar][quantity])
     */
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
            return false;
        }
    }

    /**
     * Retourne un tableau avec l'année de dépot et le total des montants des projets par année de dépot. Les projets sont associés à  une entité, et on le même statut
     * Return a table with the submission year and the projects' amounts per year. The projects are linked to an entity, and have the same statuts
     *
     * @param $codeEntite int code de l'entité, $starG/$endG date début/fin, $montants array(string) montants à calculer, $statut string
     * @return bool|array([prim][valueX]...)
     */
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
            return false;
        }
    }

}