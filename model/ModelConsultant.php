<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

/**
 * Class ModelDiplome
 */
class ModelDiplome extends Model
{

    protected static $object = 'Diplome';
    protected static $primary = 'codeDiplome';

    private $codeDiplome;
    private $codeDepartement;
    private $typeDiplome;
    private $nomDiplome;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;
    private $heuresProjet;
    private $heuresStage;

    /**
     * @var array associe la lettre qui désigne le type diplome au nom du diplome
     */
    private static $typesDiplome = array(
        "D" => "DUT",
        "U" => "DU",
        "P" => "Licence Pro",
        "A" => "Année Spéciale"
    );

    public function getNumLP()
    {
        if ($this->getTypeDiplome() == "Licence Pro") {
            if (isset($this->getTypeDiplome()[1])) return $this->getTypeDiplome()[1];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getCodeDiplome()
    {
        return $this->codeDiplome;
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
     * @return mixed | String décrivant le type de diplome
     * @uses ModelDiplome::$typesDiplome
     */
    public function getTypeDiplome()
    {
        if(isset($this->typeDiplome[0])) return self::$typesDiplome[$this->typeDiplome[0]];
        return false;
    }

    /**
     * @return mixed : caractère décrivant le diplome (A,U,D,P)
     */
    public function getLettreTypeDiplome()
    {
        return $this->typeDiplome;
    }

    /**
     * @param mixed $typeDiplome
     */
    public function setTypeDiplome($typeDiplome)
    {
        $this->typeDiplome = $typeDiplome;
    }

    /**
     * @return mixed
     */
    public function getNomDiplome()
    {
        return $this->nomDiplome;
    }

    /**
     * @return int
     */
    public function getHeuresTP()
    {
        return (int)$this->heuresTP;
    }

    /**
     * @return int
     */
    public function getHeuresTD()
    {
        return (int)$this->heuresTD;
    }

    /**
     * @return int
     */
    public function getHeuresCM()
    {
        return (int)$this->heuresCM;
    }

    /**
     * @return int
     */
    public function getHeuresProjet()
    {
        return (int)$this->heuresProjet;
    }

    /**
     * @return int
     */
    public function getHeuresStage()
    {
        return (int)$this->heuresStage;
    }

    /**
     * Return un tableau avec le numéro des semestres existant dans ce diplome
     *
     * @return array
     */
    public function getAllSemestres()
    {
        $totalUE = ModelUniteDEnseignement::selectAllByDiplome($this->getCodeDiplome());
        $sem = array();
        foreach ($totalUE as $ue) {
            $n = $ue->getSemestre();
            if (!in_array($n, $sem)) array_push($sem, $n);
        }
        return $sem;
    }

    public function getModulesBySemestre()
    {
        $resultat = array();
        $semestres = $this->getAllSemestres();
        foreach ($semestres as $semestre) {
            $ues = ModelUniteDEnseignement::selectBySemestre($semestre, $this->getCodeDiplome());
            if (is_array($ues)) {
                $resultat[$semestre] = array();
                foreach ($ues as $ue) {
                    $subresultat['ue'] = $ue;
                    $subresultat['modules'] = ModelModule::selectAllByNUE($ue->getNUE());
                    $resultat[$semestre][] = $subresultat;
                }
            }
        }
        return $resultat;
    }

    /**
     * Renvoie les Diplomes d'un département dont le code est donné en paramètre, false s'il y a une erreur
     *
     * @param $codeDepartement string(1)
     * @return bool|array(ModelDiplome)
     */
    public static function selectAllByDepartement($codeDepartement)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDepartement=:codeDepartement';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDepartement' => $codeDepartement);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDiplome');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                //$retourne[$cle]->setTypeDiplome(self::$typesDiplome[$item->getTypeDiplome()[0]]);
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie le diplome lié à son code Diplome donné en paramètre, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value string(1) : codeDiplome
     * @return bool|ModelDiplome
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        //$retourne->setTypeDiplome(self::$typesDiplome[$retourne->getTypeDiplome()[0]]);
        $retourne->setCodeDepartement(ModelDepartement::select($retourne->getCodeDepartement()));
        return $retourne;
    }

    /**
     * Renvoie le diplome lié à son codeDépartement et son typeDiplome, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $codeDepartement string(1)
     * @param $typeDiplome string
     * @return bool|ModelDiplome
     */
    public static function selectBy($codeDepartement, $typeDiplome)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDepartement=:codeDepartement AND typeDiplome=:typeDiplome';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'codeDepartement' => $codeDepartement,
                'typeDiplome' => $typeDiplome);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDiplome');
            $retourne = $rep->fetchAll();
            if (!$retourne) return false;
            $retourne = $retourne[0];
            //$retourne->setTypeDiplome(self::$typesDiplome[$retourne->getTypeDiplome()[0]]);
            $retourne->setCodeDepartement(ModelDepartement::select($retourne->getCodeDepartement()));
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie le volume horaire total du diplome @var $this
     *
     * Additionne les volumes horaires par type d'activité
     * - TP
     * - TD
     * - CM
     * - Projet
     * - Stage
     *
     * @return int
     */
    public function getVolumeHoraire()
    {
        $heuresTP = (int)$this->heuresTP;
        $heuresTD = (int)$this->heuresTD;
        $heuresCM = (int)$this->heuresCM;
        $heuresProjet = (int)$this->heuresProjet;
        $heuresStage = (int)$this->heuresStage;
        $total = $heuresTP + $heuresProjet + $heuresStage + $heuresCM + $heuresTD;
        return $total;
    }

    /**
     * Renvoie le nom du diplome de format : 'typeDiplome NomDépartememt'
     *
     * @return string
     * @example DUT Informatique
     */
    public function nommer()
    {
        return $this->getTypeDiplome() . ' ' . $this->getCodeDepartement()->getNomDepartement() . ' ' . $this->getNomDiplome();
    }

    public static function selectAllOrganizedByDep()
    {
        try {
            $departements = ModelDepartement::selectAll();
            $resultat = array();
            foreach ($departements as $departement) {
                $resultat[$departement->getNomDepartement()] = ModelDiplome::selectAllByDepartement($departement->getCodeDepartement());
            }
            return $resultat;
        } catch (Exception $e) {
            return false;
        }
    }
}