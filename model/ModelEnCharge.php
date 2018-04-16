<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelMembreEDF.php'));

class ModelEnCharge extends ModelMembreEDF
{

    protected static $object = 'EnCharge';
    protected static $primary = 'codeEnCharge';

    private $codeEnCharge;


    /**
     * @return mixed
     */
    public function getCodeEnCharge()
    {
        return $this->codeEnCharge;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeEnCharge($codeEnCharge)
    {
        $this->codeEnCharge = $codeEnCharge;
    }

    /**
     * Retourne le module désigné par son codeModule, false s'il n'existe pas ou qu'il y a une erreur
     *
     * @param $primary_value codeModule
     * @return bool|ModelModule
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        $retourne->setNUE(ModelUniteDEnseignement::select($retourne->getNUE()));
        return $retourne;
    }

    /**
     * Retourne tous les modules qui existent, false s'il y a une erreur
     *
     * @return bool|array(ModelModule)
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        if (!$retourne) return false;
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
        }
        return $retourne;
    }

    /**
     * Retourne tous les modules d'un UE désigné par son nUE, false s'il y a une erreur
     *
     * @param $nue int numéro d'unité d'enseignement
     * @return bool|array(ModelModule)
     */
    public static function selectAllByNUE($nue)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nUE=:nUE ORDER BY numModule';
            $rep = Model::$pdo->prepare($sql);
            $values = array('nUE' => $nue);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne le module désigné par son UE et son numéro de module, false s'il n'existe pas ou qu'il y a une erreur
     *
     * @param $nUE int numéro d'unité d'enseignement
     * @param $numModule string numéro de module
     * @return bool|ModelModule
     */
    public static function selectBy($nUE, $numModule)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nUE=:nUE AND numModule=:numModule';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'nUE' => $nUE,
                'numModule' => $numModule);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
            $retourne = $rep->fetchAll();
            if (empty($retourne)) return false;
            $retourne[0]->setNUE(ModelUniteDEnseignement::select($retourne[0]->getNUE()));
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return int Volume horaire totale du module
     */
    public function getVolumeHoraire()
    {
        return $this->getHeuresTD() + $this->getHeuresCM() + $this->getHeuresTP();
    }

    /**
     * @return string code du module du format : 'M nSemestre nUE nModule'
     * @example 'M3301'
     */
    public function nommer()
    {
        if ($this->getNumModule() < 10) $nM = '0' . $this->getNumModule();
        else $nM = $this->getNumModule();
        return 'M' . $this->getNUE()->nommer() . $nM;
    }

    /**
     * Retourne un tableau avec les différents modules enseigné par un enseignant identifié par $codeEns organisé par départements
     *
     * @example Un element de ce tableau a cette structure :
     * array(2) {
     *      ['nomDepartement'] => Nom du département concerné
     *      ['modules'] => array de @see ModelModule enseigné par l'enseignant et du département concerné
     * }
     *
     * @param $codeEns
     * @return boolean|array
     */
    public static function selectDepAndModulesByEns($codeEns)
    {
        try {
            $resultat = array();
            $sql = '  SELECT DISTINCT 
                        D.codeDepartement,
                        nomDepartement
                      FROM Cours C
                        JOIN Module M ON C.codeModule = M.codeModule
                        JOIN UniteDEnseignement E ON M.nUE = E.nUE
                        JOIN Diplome D ON E.codeDiplome = D.codeDiplome
                        JOIN Departement D2 ON D.codeDepartement = D2.codeDepartement
                      WHERE C.codeEns = :codeEns';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeEns' => $codeEns);
            $rep->execute($values);
            $departements = $rep->fetchAll(PDO::FETCH_ASSOC);
            foreach ($departements as $departement) {
                $codeDep = $departement['codeDepartement'];
                $modules['nomDepartement']=$departement['nomDepartement'];
                $sql = '  SELECT DISTINCT
                            M.codeModule,
                            M.nUE,
                            numModule,
                            nomModule,
                            M.heuresCM,
                            M.heuresTD,
                            M.heuresTP
                          FROM Module M
                            JOIN Cours C ON M.codeModule = C.codeModule
                            JOIN UniteDEnseignement E ON M.nUE = E.nUE
                            JOIN Diplome D ON E.codeDiplome = D.codeDiplome
                          WHERE codeEns = :codeEns
                          AND codeDepartement = :codeDep';
                $rep = Model::$pdo->prepare($sql);
                $values = array(
                    'codeEns' => $codeEns,
                    'codeDep' => $codeDep);
                $rep->execute($values);
                $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
                $liste = $rep->fetchAll();
                foreach ($liste as $cle => $item) {
                    $liste[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
                }
                $modules['modules']=$liste;
                array_push($resultat,$modules);
            }
            return $resultat;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }
}