<?php

require_once File::build_path(array('model', 'Model.php'));

/**
 * Class ModelUser
 */
class ModelDeadLine extends Model
{

    /**
     * @var string
     */
    protected static $object = 'DeadLine';
    /**
     * @var string
     */
    protected static $primary = 'codeDeadLine';

    /**
     * @var null
     */
    private $codeDeadLine;
    private $dateDeadLine;
    private $nomDeadLine;
    /**
     * @var null
     */
    private $codeProjet;

    /**
     * @return mixed
     */
    public function getCodeDeadLine()
    {
        return $this->codeDeadLine;
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
    public function setCodeDeadLine($codeDeadLine)
    {
        $this->codeDeadLine = $codeDeadLine;
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
    public function getNomDeadLine()
    {
        return $this->nomDeadLine;
    }
    /**
     * @param mixed $activated
     */
    public function setNomDeadLin($nomDeadLine)
    {
        $this->nomDeadLine = $nomDeadLine;
    }
    /**
     * @return mixed
     */
    public function getDateDeadLine()
    {
        return $this->dateDeadLine;
    }
    /**
     * @param mixed $activated
     */
    public function setDateDeadLine($dateDeadLine)
    {
        $this->dateDeadLine = $dateDeadLine;
    }

    public static function selectAllByProjet($codeProjet) {
        try {
            $sql = 'SELECT * FROM DeadLine WHERE codeProjet=:codeProjet';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeProjet' => $codeProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDeadLine');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function updateTable() {
        try {
            $sql = 'DELETE FROM DeadLine WHERE dateDeadLine<=:dateDeadLine';
            $rep = Model::$pdo->prepare($sql);
            $values = array('dateDeadLine' => date('Y-m-d'));
            $rep->execute($values);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne toutes les dates disctinctes où il y a une échéance
     * Return all the distinct dates where there is a deadline
     *
     * @return bool|array(ModelDeadLine) with only field 'dateDeadLine' format: 'YYY-MM-DD'
     */
    public static function selectDates() {
        try {
            $sql = 'SELECT DISTINCT dateDeadLine FROM DeadLine ORDER BY dateDeadLine ASC';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDeadLine');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne toutes les échéances dont la date est égale à $dateDeadLine
     * Return all the deadlines where dateDeadLine is equal to $dateDeadLine
     *
     * @param $dateDeadLine string, format: 'YYYY-MM-DD'
     * @return bool|array(ModelDeadLine)
     */
    public static function selectByDate($dateDeadLine) {
        try {
            $sql = 'SELECT * FROM DeadLine WHERE dateDeadLine=:dateDeadLine ORDER BY dateDeadLine ASC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('dateDeadLine' => $dateDeadLine);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDeadLine');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}