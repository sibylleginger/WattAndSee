<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));

/**
 * Class ModelNote
 */
class ModelNote extends Model
{

    /**
     * @var string nom de la table
     */
    protected static $object = 'Note';
    /**
     * @var string clé primaire
     */
    protected static $primary = 'codeNote';

    /**
     * @var null
     */
    private $codeNote;
    private $comment;
    private $dateNote;
    /**
     * @var null
     */
    private $codeProjet;
    private $mailUser;

    /**
     * @return mixed
     */
    public function getCodeNote()
    {
        return $this->codeNote;
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
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @return mixed
     */
    public function getDateNote()
    {
        return $this->dateNote;
    }
    /**
     * @return mixed
     */
    public function getMailUser()
    {
        return $this->mailUser;
    }

    /**
     * Renvoie un tableau des tous les commentaires du projet
     *
     * @param $codeProjet int code du projet
     * @return bool|array(ModelNote)
     */
    public static function selectAllByProjet($codeProjet) {
        try {
            $sql = 'SELECT * FROM Note WHERE codeProjet=:codeProjet ORDER BY dateNote DESC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelNote');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}