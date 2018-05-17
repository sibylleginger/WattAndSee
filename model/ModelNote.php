<?php

require_once File::build_path(array('model', 'Model.php'));

/**
 * Class ModelUser
 */
class ModelNote extends Model
{

    /**
     * @var string
     */
    protected static $object = 'Note';
    /**
     * @var string
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
     * @param mixed $activated
     */
    public function setCodeNote($codeNote)
    {
        $this->codeNote = $codeNote;
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
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @param mixed $activated
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    /**
     * @return mixed
     */
    public function getDateNote()
    {
        return $this->dateNote;
    }
    /**
     * @param mixed $activated
     */
    public function setDateNote($dateNote)
    {
        $this->dateNote = $dateNote;
    }
    /**
     * @return mixed
     */
    public function getMailUser()
    {
        return $this->mailUser;
    }
    /**
     * @param mixed $activated
     */
    public function setMailUser($mailUser)
    {
        $this->mailUser = $mailUser;
    }


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