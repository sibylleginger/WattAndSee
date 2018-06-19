<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

/**
 * Class ModelDocument
 */
class ModelDocument extends Model
{

    /**
     * @var string nom de la table
     */
    protected static $object = 'Document';
    /**
     * @var string nom de la clé
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
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Renvoie un tableau des tous les documents du projet
     *
     * @param $codeProjet int code du projet
     * @return bool|array(ModelDocument)
     */
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

    /**
     * Renvoie un tableau du nom de chaque fichier téléchargés
     *
     * @return bool|array([namePJ])
     */
    public static function selectAllNames() {
        try {
            $sql = 'SELECT namePJ FROM Document';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_ASSOC);
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}