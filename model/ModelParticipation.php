<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelParticipant.php'));

class ModelParticipation
{

    protected static $object = 'Participation';

    private $codeProjet;
    private $codeParticipant;
    private $budget;

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
    public function getCodeParticipant()
    {
        return $this->codeParticipant;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeParticipant($codeParticipant)
    {
        $this->codeParticipant = $codeParticipant;
    }

    /**
     * @return mixed
     */
    public function getCodeProjet()
    {
        return $this->codeProjet;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $codeStatut
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * Retourne l'enseignant désigné par son code Enseignant, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|ModelEnseignant
     *
     * @uses  Model::select()
     */
    public static function select($codeProjet, $codeParticipant)
    {
        try {
            $sql = 'SELECT * FROM Participation
            WHERE codeProjet=:codeProjet AND codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelParticipation');
            $retourne = $rep->fetchAll();
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }



    /**
     * Renvoie tous les enseignants appartenant à un département, false s'il y a une erreur
     *
     * @param $codeDepartement string(1)
     * @return bool|array(ModelEnseignant)
     */
    public static function selectAllByProjet($codeProjet)
    {
        try {
            $sql = 'SELECT * FROM Participant C
            JOIN Participation P ON C.codeParticipant = P.codeParticipant
            WHERE P.codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelParticipant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                //$retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                //$retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function selectAllByParticipant($codeParticipant)
    {
        try {
            $sql = 'SELECT * FROM Projet C
            JOIN Participation P ON C.codeProjet = P.codeProjet
            WHERE P.codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeParticipant' => $codeParticipant);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                //$retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                //$retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function add($codeProjet, $codeParticipant) {
        try {
            $sql = 'INSERT INTO Participation VALUES (:codeProjet,:codeParticipant,0,0)';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'Participation');
            $result = mysql_query($sql);
            if(isset($result)) {
               echo "YES";
            } else {
               return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    

}