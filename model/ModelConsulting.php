<?php
require_once File::build_path(array('model', 'Model.php'));

/**
 * Class ModelErreurExport
 */
class ModelErreurExport extends Model
{

    protected static $object = 'ErreurExport';
    protected static $primary = 'idErreur';
    protected static $valeursParPage = 20;

    private $idErreur;
    private $nomEns;
    private $codeEns;
    private $departementEns;
    private $statut;
    private $typeStatut;
    private $dateCours;
    private $duree;
    private $activitee;
    private $typeActivitee;
    private $typeErreur;

    /**
     * @return mixed
     */
    public function getTypeErreur()
    {
        return $this->typeErreur;
    }

    /**
     * @return mixed
     */
    public function getIdErreur()
    {
        return $this->idErreur;
    }

    /**
     * @return mixed
     */
    public function getNomEns()
    {
        return $this->nomEns;
    }

    /**
     * @return mixed
     */
    public function getCodeEns()
    {
        return $this->codeEns;
    }

    /**
     * @return mixed
     */
    public function getDepartementEns()
    {
        return $this->departementEns;
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
     * @return mixed
     */
    public function getDateCours()
    {
        return $this->dateCours;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @return mixed
     */
    public function getActivitee()
    {
        return $this->activitee;
    }

    /**
     * @return mixed
     */
    public function getTypeActivitee()
    {
        return $this->typeActivitee;
    }

    /**
     * @deprecated
     * renvoie @see ModelErreurExport::$valeursParPage de la page donnée en paramètre
     *
     * @param $p int
     * @return bool|array(ModelErreurExport)
     */
    public static function selectByPage($p)
    {
        try {
            $debut = ($p - 1) * self::$valeursParPage;
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE typeErreur != "departementEns" AND typeErreur != "statut" AND typeErreur != "Département invalide" ORDER BY ' . self::$primary . ' DESC LIMIT ' . $debut . ' , ' . self::$valeursParPage;
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelErreurExport');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie le nombre d'erreurs
     *
     * @return int
     */
    public static function getNbErr()
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM ' . self::$object;
            if (Model::$pdo == NULL) return 0;
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return (int)$retourne[0]['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getNbErrAutres()
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM ' . self::$object . ' WHERE typeErreur != "departementEns" AND typeErreur != "statut" AND typeErreur != "Département invalide"';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return (int)$retourne[0]['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Renvoie le nombre de page maximales (calculé avec @see ModelErreurExport::$valeursParPage
     *
     * @return float
     */
    public static function getNbP()
    {
        return ceil(self::getNbErrAutres() / self::$valeursParPage);
    }

    /**
     * @deprecated
     *
     * Renvoie toutes les erreurs par type d'erreur, false s'il y a une erreur
     *
     * @param $typeErreur string
     * @return bool|array(ModelErreurExport)
     */
    public static function selectByType($typeErreur)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE typeErreur=:typeErreur';
            $rep = Model::$pdo->prepare($sql);
            $value = ['typeErreur' => $typeErreur];
            $rep->execute($value);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelErreurExport');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie tous les status posant problèmes, false s'il y a une erreur
     *
     * @return bool|array(statut,typeStatut)
     */
    public static function selectAllStatuts()
    {
        try {
            $sql = 'SELECT DISTINCT statut,typeStatut FROM ' . self::$object . ' WHERE typeErreur="statut"';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie les idErreurs liées au statut donné en paramètre, false s'il y a une erreur
     *
     * @param $statut string
     * @param $typeStatut string
     * @return bool|array(idErreur)
     */
    public static function selectIdErreurStatut($statut, $typeStatut)
    {
        try {
            $sql = 'SELECT idErreur FROM ' . self::$object . ' WHERE statut=:statut AND typeStatut=:typeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'statut' => $statut,
                'typeStatut' => $typeStatut
            );
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retourne)) return false;
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie les nom des départements invalides des enseignants, false s'il y a une erreur
     *
     * @return bool|array(departementEns)
     */
    public static function selectAllDepEns()
    {
        try {
            $sql = 'SELECT DISTINCT departementEns FROM ' . self::$object . ' WHERE typeErreur="departementEns"';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie les idErreurs liées au départementEns donné en paramètre, false s'il y a une erreur
     *
     * @param $departementEns string
     * @return bool|array(idErreur)
     */
    public static function selectIdErreurDepEns($departementEns)
    {
        try {
            $sql = 'SELECT idErreur FROM ' . self::$object . ' WHERE departementEns=:departementEns';
            $rep = Model::$pdo->prepare($sql);
            $values = ['departementEns' => $departementEns];
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retourne)) return false;
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie les codes d'activité qui posent problème, false s'il y a une erreur
     *
     * @return bool|array(activitee)
     */
    public static function selectAllDepInv()
    {
        try {
            $sql = 'SELECT DISTINCT activitee FROM ' . self::$object . ' WHERE typeErreur="Département invalide"';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie les idErreurs liées aux département invalides dans les codes d'activité, false s'il y a une erreur
     *
     * @param $codeActivite
     * @return bool|array(idErreur)
     */
    public static function selectIdErreursDepInv($codeActivite)
    {
        try {
            $sql = 'SELECT idErreur FROM ' . self::$object . ' WHERE activitee=:activitee';
            $rep = Model::$pdo->prepare($sql);
            $values = ['activitee' => $codeActivite];
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            if (empty($retourne)) return false;
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne le nombre d'erreur formaté pour le badge dans la nav
     *
     * Le badge ne peut pas avoir plus de 2 caractères, donc si le nombre d'erreurs
     * est supérieur à 9, je return +9, sinon je return le nombre d'erreurs
     *
     * @return int|string
     *
     * @uses ModelErreurExport::getNbErr()
     */
    public static function getBadge()
    {
        $nbErr = ModelErreurExport::getNbErr();
        if ($nbErr > 9) return '+9';
        return $nbErr;
    }
}