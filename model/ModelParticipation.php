<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));
require_once File::build_path(array('model', 'ModelParticipant.php'));

class ModelParticipation extends Model
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
    public static function selectAllByProjet($codeProjet)
    {
        try {
            $sql = 'SELECT codeParticipant FROM ' . self::$object . ' WHERE codeProjet=:codeProjet';
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

    

}