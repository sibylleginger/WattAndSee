<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelStatutEnseignant.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ModelEnseignant extends Model
{

    protected static $object = 'Enseignant';
    protected static $primary = 'codeEns';

    private $codeEns;
    /**
     * @var $codeStatut ModelStatutEnseignant
     */
    private $codeStatut;
    private $nomEns;
    private $etatService;
    /**
     * @var $codeDepartement ModelDepartement
     */
    private $codeDepartement;
    private $remarque;

    /**
     * @return mixed
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

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
    public function getCodeEns()
    {
        return $this->codeEns;
    }

    /**
     * @return mixed
     */
    public function getCodeStatut()
    {
        return $this->codeStatut;
    }

    /**
     * @param mixed $codeStatut
     */
    public function setCodeStatut($codeStatut)
    {
        $this->codeStatut = $codeStatut;
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
    public function getEtatService()
    {
        return $this->etatService;
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

    /**
     * @return float : nombres d'heures équivalent TD réalisés par un professeur
     */
    public function getNbHeuresReal()
    {
        $Tcours = ModelCours::selectAllByEns($this->getCodeEns());
        if (!$Tcours) {
            return 0;
        } else {
            $r = 0;
            foreach ($Tcours as $cours) {
                $t = $cours->getTypeCours();
                if ($t == 'CM') {
                    $d = floatval($cours->getDuree()) * 2 / 3;
                } elseif ($t == 'TP') {
                    $d = floatval($cours->getDuree()) * 1.5;
                } else {
                    $d = floatval($cours->getDuree());
                }
                $r = $r + $d;
            }
            return $r;
        }
    }

    /**
     * @return int : nombres d'heures de TD réalisés par le professeur
     */
    public function getHeuresTD($codeModule)
    {
        $sql = 'SELECT sum(duree) AS heuresTD
                FROM Cours
                WHERE codeEns = :codeEns
                AND typeCours = "TD"
                AND codeModule = :codeModule';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeEns' => $this->getCodeEns(),
            'codeModule' => $codeModule));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return intval($retourne[0]['heuresTD']);
    }

    /**
     * @return int : nombres d'heures de TP réalisés par le professeur
     */
    public function getHeuresTP($codeModule)
    {
        $sql = 'SELECT sum(duree) AS heuresTP
                FROM Cours
                WHERE codeEns = :codeEns
                AND typeCours = "TP"
                AND codeModule = :codeModule';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeEns' => $this->getCodeEns(),
            'codeModule' => $codeModule));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return intval($retourne[0]['heuresTP']);
    }

    /**
     * @return int : nombres d'heures de CM réalisés par le professeur
     */
    public function getHeuresCM($codeModule)
    {
        $sql = 'SELECT sum(duree) AS heuresCM
                FROM Cours
                WHERE codeEns = :codeEns
                AND typeCours = "CM"
                AND codeModule = :codeModule';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeEns' => $this->getCodeEns(),
            'codeModule' => $codeModule));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return intval($retourne[0]['heuresCM']);
    }

    /**
     * @return int : nombres d'heures hors TD/TP/CM réalisés par le professeur
     */
    public function getHeuresAutres($codeModule)
    {
        $sql = 'SELECT sum(duree) AS heuresAutres
                FROM Cours
                WHERE codeEns = :codeEns
                AND typeCours != "TD" 
                AND typeCours != "TP" 
                AND typeCours != "CM"
                AND codeModule = :codeModule';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeEns' => $this->getCodeEns(),
            'codeModule' => $codeModule));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return intval($retourne[0]['heuresAutres']);
    }

}