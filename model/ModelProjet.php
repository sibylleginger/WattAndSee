<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelStatutProjet.php'));
require_once File::build_path(array('model', 'ModelAAP.php'));

class ModelProjet extends Model
{
    //WAS Projet
    protected static $object = 'Projet';
    protected static $primary = 'codeProjet';

    private $codeProjet;
    /**
     * @var $codeStatut ModelStatutProjet
     */
    private $nomProjet;
    private $suivi;
    private $etat;
    private $description;
    /**
     * @var $codeAAP ModelAAP
     */
    private $codeAAP;
    private $codeStatut;
    //private $codeType;
    private $codeImplication;
    private $codeConsortium;
    private $codeReporting;
    private $codeEnCharge;
    private $codeChef;
    private $codeMembreEDF;
    private $codeReferent;
    private $codeConsultant;
    private $codeTemperature;
    private $motsCles;

    /**
     * @return mixed
     */
    public function getmotsCles()
    {
        return $this->motsCles;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setmotsCles($motsCles)
    {
        $this->motsCles = $motsCles;
    }

    /**
     * @return mixed
     */
    public function getCodeTemperature()
    {
        return $this->codeTemperature;
    }

    /**
     * @param mixed $codeTemperature
     */
    public function setCodeTemperature($codeTemperature)
    {
        $this->codeTemperature = $codeTemperature;
    }

    /**
     * @return mixed
     */
    public function getCodeConsultant()
    {
        return $this->codeConsultant;
    }

    /**
     * @param mixed $codeConsultant
     */
    public function setCodeConsultant($codeConsultant)
    {
        $this->codeConsultant = $codeConsultant;
    }

    /**
     * @return mixed
     */
    public function getCodeReferent()
    {
        return $this->codeReferent;
    }

    /**
     * @param mixed $codeReferent
     */
    public function setCodeReferent($codeReferent)
    {
        $this->codeReferent = $codeReferent;
    }

    /**
     * @return mixed
     */
    public function getCodeMembreEDF()
    {
        return $this->codeMembreEDF;
    }

    /**
     * @param mixed $codeMembreEDF
     */
    public function setCodeMembreEDF($codeMembreEDF)
    {
        $this->codeMembreEDF = $codeMembreEDF;
    }

    /**
     * @return mixed
     */
    public function getCodeChef()
    {
        return $this->codeChef;
    }

    /**
     * @param mixed $codeChef
     */
    public function setCodeChef($codeChef)
    {
        $this->codeChef = $codeChef;
    }

    /**
     * @return mixed
     */
    public function getCodeEnCharge()
    {
        return $this->codeEnCharge;
    }

    /**
     * @param mixed $codeEnCharge
     */
    public function setCodeEnCharge($codeEnCharge)
    {
        $this->codeEnCharge = $codeEnCharge;
    }

    /**
     * @return mixed
     */
    public function getCodeReporting()
    {
        return $this->codeReporting;
    }

    /**
     * @param mixed $codeReporting
     */
    public function setCodeReporting($codeReporting)
    {
        $this->codeReporting = $codeReporting;
    }

    /**
     * @return mixed
     */
    public function getCodeConsortium()
    {
        return $this->codeConsortium;
    }

    /**
     * @param mixed $CodeConsortium
     */
    public function setCodeConsortium($codeConsortium)
    {
        $this->codeConsortium = $codeConsortium;
    }

    /**
     * @return mixed
     */
    public function getSuivi()
    {
        return $this->suivi;
    }

    /**
     * @param mixed $suivi
     */
    public function setSuivi($suivi)
    {
        $this->suivi = $suivi;
    }

    /**
     * @return mixed
     */
    public function getCodeImplication()
    {
        return $this->codeImplication;
    }

    /**
     * @param mixed $codeImplication
     */
    public function setCodeImplication($codeImplication)
    {
        $this->codeImplication = $codeImplication;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCodeAAP()
    {
        return $this->codeAAP;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setCodeAAP($codeAAP)
    {
        $this->codeAAP = $codeAAP;
    }

    /**
     * @return mixed
     */
    public function getcodeProjet()
    {
        return $this->codeProjet;
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
    public function getNomProjet()
    {
        return $this->nomProjet;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * Retourne le projet désigné par son code Projet, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|ModelProjet
     *
     * @uses  Model::select()
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        $retourne->setCodeStatut(ModelStatutProjet::select($retourne->getCodeStatut()));
        $retourne->setCodeAAP(ModelAAP::select($retourne->getCodeAAP()));
        $retourne->setCodeImplication(ModelImplication::select($retourne->getCodeImplication()));
        $retourne->setCodeConsortium(ModelConsortium::select($retourne->getCodeConsortium()));
        $retourne->setCodeReporting(ModelReporting::select($retourne->getCodeReporting()));
        $retourne->setCodeEnCharge(ModelEnCharge::select($retourne->getCodeEnCharge()));
        $retourne->setCodeChef(ModelChef::select($retourne->getCodeChef()));
        $retourne->setCodeMembreEDF(ModelMembreEDF::select($retourne->getCodeMembreEDF()));
        $retourne->setCodeReferent(ModelReferent::select($retourne->getCodeReferent()));
        $retourne->setCodeConsultant(ModelConsultant::select($retourne->getCodeConsultant()));
        $retourne->setCodeTemperature(ModelTemperature::select($retourne->getCodeTemperature()));
        return $retourne;
    }

    /**
     * @deprecated
     * Renvoie la liste des tous les Projets
     * TODO implémenter une fonction de page ?
     *
     * @return bool|array(ModelProjet)
     *
     * @uses  Model::selectAll()
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setCodeStatut(ModelStatutProjet::select($retourne[$cle]->getCodeStatut()));
            $retourne[$cle]->setCodeAAP(ModelAAP::select($item->getCodeAAP()));
            $retourne[$cle]->setCodeImplication(ModelImplication::select($retourne[$cle]->getCodeImplication()));
            $retourne[$cle]->setCodeConsortium(ModelConsortium::select($retourne[$cle]->getCodeConsortium()));
            $retourne[$cle]->setCodeReporting(ModelReporting::select($retourne[$cle]->getCodeReporting()));
            $retourne[$cle]->setCodeEnCharge(ModelEnCharge::select($retourne[$cle]->getCodeEnCharge()));
            $retourne[$cle]->setCodeChef(ModelChef::select($retourne[$cle]->getCodeChef()));
            $retourne[$cle]->setCodeMembreEDF(ModelMembreEDF::select($retourne[$cle]->getCodeMembreEDF()));
            $retourne[$cle]->setCodeReferent(ModelReferent::select($retourne[$cle]->getCodeReferent()));
            $retourne[$cle]->setCodeConsultant(ModelConsultant::select($retourne[$cle]->getCodeConsultant()));
            $retourne[$cle]->setCodeTemperature(ModelTemperature::select($retourne[$cle]->getCodeTemperature()));
        }
        return $retourne;
    }

    /**
     * Renvoie tous les Projets appartenant à un AAP, false s'il y a une erreur
     *
     * @param $codeAAP string(1)
     * @return bool|array(ModelProjet)
     */
    public static function selectAllByAAP($codeAAP)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeAAP=:codeAAP';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeAAP' => $codeAAP);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutProjet::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeAAP(ModelAAP::select($item->getCodeAAP()));
                $retourne[$cle]->setCodeImplication(ModelImplication::select($retourne[$cle]->getCodeImplication()));
                $retourne[$cle]->setCodeConsortium(ModelConsortium::select($retourne[$cle]->getCodeConsortium()));
                $retourne[$cle]->setCodeReporting(ModelReporting::select($retourne[$cle]->getCodeReporting()));
                $retourne[$cle]->setCodeEnCharge(ModelEnCharge::select($retourne[$cle]->getCodeEnCharge()));
                $retourne[$cle]->setCodeChef(ModelChef::select($retourne[$cle]->getCodeChef()));
                $retourne[$cle]->setCodeMembreEDF(ModelMembreEDF::select($retourne[$cle]->getCodeMembreEDF()));
                $retourne[$cle]->setCodeReferent(ModelReferent::select($retourne[$cle]->getCodeReferent()));
                $retourne[$cle]->setCodeConsultant(ModelConsultant::select($retourne[$cle]->getCodeConsultant()));
                $retourne[$cle]->setCodeTemperature(ModelTemperature::select($retourne[$cle]->getCodeTemperature()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie tous les Projet appartenant à un statut, false s'il y a une erreur
     *
     * @param $codeStatut string (techniquement c'est un string mais c'est un nombre)
     * @return bool|array(ModelProjeteigant)
     */
    public static function selectAllByStatut($codeStatut)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeStatut=:codeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeStatut' => $codeStatut);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutProjet::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeAAP(ModelAAP::select($item->getCodeAAP()));
                $retourne[$cle]->setCodeImplication(ModelImplication::select($retourne[$cle]->getCodeImplication()));
                $retourne[$cle]->setCodeConsortium(ModelConsortium::select($retourne[$cle]->getCodeConsortium()));
                $retourne[$cle]->setCodeReporting(ModelReporting::select($retourne[$cle]->getCodeReporting()));
                $retourne[$cle]->setCodeEnCharge(ModelEnCharge::select($retourne[$cle]->getCodeEnCharge()));
                $retourne[$cle]->setCodeChef(ModelChef::select($retourne[$cle]->getCodeChef()));
                $retourne[$cle]->setCodeMembreEDF(ModelMembreEDF::select($retourne[$cle]->getCodeMembreEDF()));
                $retourne[$cle]->setCodeReferent(ModelReferent::select($retourne[$cle]->getCodeReferent()));
                $retourne[$cle]->setCodeConsultant(ModelConsultant::select($retourne[$cle]->getCodeConsultant()));
                $retourne[$cle]->setCodeTemperature(ModelTemperature::select($retourne[$cle]->getCodeTemperature()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne tous les Projets avec un nom/prenom proche de $npProjet
     * TODO supprimer l'attribut prénom
     *
     * @param $npProjet string nom/prenom d'un Projet
     * @return bool|array(ModelProjet)
     */
    public static function selectAllByMotCle($npProjet)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nomProjet LIKE CONCAT(\'%\',:npProjet,\'%\')';
            $rep = Model::$pdo->prepare($sql);
            $values = array('npProjet' => $npProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutProjet::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeAAP(ModelAAP::select($item->getCodeAAP()));
                $retourne[$cle]->setCodeImplication(ModelImplication::select($retourne[$cle]->getCodeImplication()));
                $retourne[$cle]->setCodeConsortium(ModelConsortium::select($retourne[$cle]->getCodeConsortium()));
                $retourne[$cle]->setCodeReporting(ModelReporting::select($retourne[$cle]->getCodeReporting()));
                $retourne[$cle]->setCodeEnCharge(ModelEnCharge::select($retourne[$cle]->getCodeEnCharge()));
                $retourne[$cle]->setCodeChef(ModelChef::select($retourne[$cle]->getCodeChef()));
                $retourne[$cle]->setCodeMembreEDF(ModelMembreEDF::select($retourne[$cle]->getCodeMembreEDF()));
                $retourne[$cle]->setCodeReferent(ModelReferent::select($retourne[$cle]->getCodeReferent()));
                $retourne[$cle]->setCodeConsultant(ModelConsultant::select($retourne[$cle]->getCodeConsultant()));
                $retourne[$cle]->setCodeTemperature(ModelTemperature::select($retourne[$cle]->getCodeTemperature()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les statuts et le nombre de projets par statut
     */
    public static function statStatutEtProjet()
    {
        try {
            $sql = 'SELECT
                      statut,
                      count(codeProjet) as quantity
                    FROM StatutProjet
                      JOIN Projet P ON StatutProjet.codeStatut = P.codeStatut
                    GROUP BY P.codeStatut,statut;';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $e;
        }
    }

    //EN COURS
    /**
     * @return float : nombres d'heures équivalent TD réalisés par un professeur
     */
    public function getNbHeuresReal()
    {
        $Tcours = ModelCours::selectAllByProjet($this->getcodeProjet());
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
     * @return date : échéance dépot du projet
     */
    public function getDateDepot()
    {
        $sql = 'SELECT dateDepot
                FROM AAP
                JOIN projet P ON AAP.codeAAP = P.codeAAP
                WHERE P.codeAAP=:codeAAP';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->getcodeProjet(),
            'codeAAP' => $this->codeAAP));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }

    /**
     * @return string : statut du projet
     */
    public function getStatut()
    {
        $sql = 'SELECT nomStatut
                FROM statutProjet, projet P
                JOIN projet P ON statutProjet.codeStatut = P.codeStatut
                WHERE P.codeStatut=:codeStatut';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->getcodeProjet(),
            'codeStatut' => $this->codeStatut));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }

    /**
     * @return string : nom du statut du projet
     */
    public function getTemperature()
    {
        $sql = 'SELECT nomTemperature
                FROM temperature
                JOIN projet P ON temperature.codeTemperature = P.codeTemperature
                WHERE P.codeTemperature=:codeTemperature';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->getcodeProjet(),
            'codeTemperature' => $this->codeTemperature));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }

    /**
     * @return string : implicationde EDF dans le projet
     */
    public function getImplication()
    {
        $sql = 'SELECT nomImplication
                FROM implication
                JOIN projet P ON implication.codeImplication = P.codeImplication
                WHERE P.codeImplication=:codeImplication';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->getcodeProjet(),
            'codeStatut' => $this->codeStatut));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }

}