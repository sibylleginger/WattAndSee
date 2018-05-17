<?php

require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ModelUser
 */
class ModelDocument extends Model
{

    /**
     * @var string
     */
    protected static $object = 'Document';
    /**
     * @var string
     */
    protected static $primary = 'namePJ';

    /**
     * @var null
     */
    private $namePJ;
    private $titre;
    /**
     * @var null
     */
    private $codeProjet;

    /**
     * @return mixed
     */
    public function getNamePJ()
    {
        return $this->namePJ;
    }

    /**
     * @return mixed
     */
    public function getCodeProjet()
    {
        return $this->codeProjet;
    }
    /**
     * @param mixed $activated
     */
    public function setNamePJ($namePJ)
    {
        $this->namePJ = $namePJ;
    }
    /**
     * @param mixed $activated
     */
    public function setCodeProjet($codeProjet)
    {
        $this->codeProjet = $codeProjet;
    }
    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }
    /**
     * @param mixed $activated
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public static function selectAllByProjet($codeProjet) {
        try {
            $sql = 'SELECT * FROM Document WHERE codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDocument');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}