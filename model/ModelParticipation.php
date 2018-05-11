<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelConsortium.php'));
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
    public static function select($codeConsortium, $codeParticipant)
    {
        try {
            $sql = 'SELECT * FROM Participation
            WHERE codeConsortium=:codeConsortium AND codeContact=:codeContact';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeConsortium' => $codeConsortium,
                            'codeContact' => $codeParticipant);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelParticipation');
            $retourne = $rep->fetchAll();
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
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
    public static function selectAllByConsortium($codeConsortium)
    {
        try {
            $sql = 'SELECT * FROM Participant C
            JOIN Participation P ON C.codeParticipant = P.codeParticipant
            WHERE P.codeConsortium=:codeConsortium';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeConsortium' => $codeConsortium);
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
            $sql = 'SELECT * FROM Consortium C
            JOIN Participation P ON C.codeConsortium = P.codeConsortium
            WHERE P.codeParticipant=:codeParticipant';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeParticipant' => $codeParticipant);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelConsortium');
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

    

}