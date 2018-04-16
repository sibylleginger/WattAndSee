<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelMembreEDF.php'));

class ModelReferent extends ModelMembreEDF
{

    protected static $object = 'Referent';
    protected static $primary = 'codeReferent';

    private $codeReferent;


    /**
     * @return mixed
     */
    public function getCodeReferent()
    {
        return $this->codeReferent;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeReferent($codeReferent)
    {
        $this->codeReferent = $codeReferent;
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
        $retourne->setCodeStatut(ModelStatutEnseignant::select($retourne->getCodeStatut()));
        $retourne->setCodeDepartement(ModelDepartement::select($retourne->getCodeDepartement()));
        return $retourne;
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
    public static function selectAllByDepartement($codeDepartement)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDepartement=:codeDepartement';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDepartement' => $codeDepartement);
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


}