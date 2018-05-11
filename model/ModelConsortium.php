<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ModelCours
 */
class ModelConsortium extends Model
{

    protected static $object = 'Consortium';
    protected static $primary = 'codeConsortium';

    private $codeConsortium;
    private $codeProjet;
    private $acronyme;

    /**
     * @return int
     */
    public function getCodeConsortium()
    {
        return $this->codeConsortium;
    }

    /**
     * @param int
     */
    public function setCodeConsortium($codeConsortium)
    {
        $this->codeConsortium = $codeConsortium;
    }

    /**
     * @return mixed
     */
    public function getAcronyme()
    {
        return $this->acronyme;
    }

    /**
     * @param mixed
     */
    public function setAcronyme($acronyme)
    {
        $this->acronyme = $acronyme;
    }

    /**
     * @return mixed
     */
    public function getNomConsortium()
    {
        return $this->nomConsortium;
    }

    public static function selectByProjet($codeProjet) {
        try {
            $sql = 'SELECT * FROM Consortium C
            JOIN Participation P ON P.codeConsortium = C.codeConsortium
            WHERE P.codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
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

    public static function select($primary_value)
        {
            $retourne = parent::select($primary_value);
            if (!$retourne) return false;
            return $retourne;
        }
}