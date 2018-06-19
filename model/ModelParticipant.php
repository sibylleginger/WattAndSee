<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelParticipation.php'));

class ModelParticipant extends Model
{
    /**
     * @var $object nom de la table
     */
    protected static $object = 'Participant';
    /**
     * @var $object clé primaire
     */
    protected static $primary = 'codeParticipant';

    private $codeParticipant;
    private $nomParticipant;
    private $nationalite;
    private $affiliation;
    private $typeOrga;
    private $mailParticipant;


    /**
     * @return mixed
     */
    public function getMailParticipant()
    {
        return $this->mailParticipant;
    }

    /**
     * @return mixed
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * @return mixed
     */
    public function getCodeParticipant()
    {
        return $this->codeParticipant;
    }

    /**
     * @return mixed
     */
    public function getNomParticipant()
    {
        return $this->nomParticipant;
    }

    /**
     * @return mixed
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * @return mixed
     */
    public function getTypeOrga()
    {
        return $this->typeOrga;
    }

    /**
     * Retourne un bouléen selon si le participant est le coordinateur du projet
     * 
     * @param $codeProjet int code du projet
     */
    public function isCoordinateur($codeProjet) {
        $coordinateur = ModelParticipation::selectCoordinateur($codeProjet);
        if (!$coordinateur) {
            return false;
        }elseif ($coordinateur->getCodeParticipant() == $this->codeParticipant) {
            return true;
        }else return false;
    }

    /**
     * Créé un nouveau participant et retourne son codeParticipant, false si la requête n'a pas fonctionnée
     *
     * @param $data array() valeurs des champs du participant
     * @return bool|int
     *
     * @uses  Model::save()
     */
    public static function save($data) {
        if (parent::save($data)) {
            return Model::$pdo->lastInsertId();
        }else return false;
    }

    /**
     * Renvoie tous les participant du consortium d'un projet, false s'il y a une erreur
     *
     * @param $codeProjet int code du projet
     * @return bool|array(ModelParticipant)
     */
    public static function selectAllByProjet($codeProjet)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' P
            JOIN Participation C ON C.codeContact = P.codeParticipant
            WHERE C.codeProjet=:codeProjet';
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