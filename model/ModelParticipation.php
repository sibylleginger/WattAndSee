<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelParticipant.php'));

class ModelParticipation
{

    protected static $object = 'Participation';

    private $codeProjet;
    private $codeParticipant;
    private $coordinateur;
    private $budget;

    /**
     * @return mixed
     */
    public function getCoordinateur()
    {
        return $this->coordinateur;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCoordinateur($coordinateur)
    {
        $this->coordinateur = $coordinateur;
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
     * @return mixed
     */
    public static function setCoordinateurProjet($codeProjet, $codeParticipant) {
        $participation = ModelParticipation::select($codeProjet,$codeParticipant);
        try {
            $sql = 'UPDATE Participation SET coordinateur=';
            if ($participation->getCoordinateur()==1) {
                $sql .= '0 ';
            }else {
                $sql .= '1 ';
            }
            $sql .= 'WHERE codeProjet=:codeProjet AND codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Renvoie tous les participants du consortium du projet, false s'il y a une erreur
     * Return all the participants of the project, false if error
     *
     * @param $codeProjet int
     * @return bool|array(ModelParticipant)
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
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie tous les projets auquel participe le participant, false s'il y a une erreur
     * Return all the projects where the participant is involved, false if error
     *
     * @param $codeParticipant int
     * @return bool|array(ModelProjet)
     */
    public static function selectByParticipant($codeParticipant)
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
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie le coordinateur du consortium du projet, false s'il y a une erreur
     * Return the coordinator of the project, false if error
     *
     * @param $codeProjet int
     * @return bool|ModelParticipant
     */
    public static function selectCoordinateur($codeProjet) {
        try {
            $sql = 'SELECT * FROM Participant C
            JOIN Participation I ON C.codeParticipant=I.codeParticipant
            WHERE I.coordinateur="1" AND I.codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelParticipant');
            $retourne = $rep->fetchAll();
            if (empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            
        }
    }

    /**
     * Delete delete the participation from the table, error message if error
     *
     * @param $codeProjet, $codeParticipant int
     * @return bool|Exception
     */
    public static function delete($codeProjet, $codeParticipant) {
        try {
            $sql = 'DELETE FROM Participation WHERE codeProjet=:codeProjet AND codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function add($codeProjet,$codeParticipant,$coordinateur,$budget) {
        try {
            $sql = 'INSERT INTO Participation VALUES (:codeProjet,:codeParticipant,:coordinateur,:budget)';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant,
                            'coordinateur' => $coordinateur,
                            'budget' => $budget);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function update($codeProjet,$codeParticipant,$coordinateur,$budget) {
        try {
            $sql = 'UPDATE Participation SET coordinateur=:coordinateur, budget=:budget
                    WHERE codeProjet=:codeProjet AND codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet,
                            'codeParticipant' => $codeParticipant,
                            'coordinateur' => $coordinateur,
                            'budget' => $budget);
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}