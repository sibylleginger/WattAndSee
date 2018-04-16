<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ModelCours
 */
class ModelConsortium extends Model
{

    protected static $object = 'Consortium';
    protected static $primary = 'idConsortium';

    private $idConsortium;
    private $acronyme;
    private $nomConsortium;
    private $remarque;

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

    /**
     * @param mixed
     */
    public function setNomConsortium($nomConsortium)
    {
        $this->nomConsortium = $nomConsortium;
    }

    /**
     * @return mixed
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * @param mixed
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;
    }

    public static function selectAllByParticipant($codeParticipant)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEns=:codeEns';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeEns' => $codeEns);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelCours');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setNumSalle(ModelSalle::select($item->getNomBatiment(),$item->getNumSalle()));
                $retourne[$cle]->setCodeEns(ModelEnseignant::select($item->getCodeEns()));
                $retourne[$cle]->setCodeModule(ModelModule::select($item->getCodeModule()));
                // Setter objet classe
                //$retourne[$cle]->setNomClasse(ModelClasse::select($item->getNomClasse()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }
}