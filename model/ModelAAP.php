<?php

require_once File::build_path(array('model', 'Model.php'));

/**
 * was ModelBatiment
 */
class ModelAAP extends Model
{

    protected static $object = 'AAP';
    protected static $primary = 'codeAAP';

    private $codeAAP;
    private $nomAAP;
    private $codeSource;
    private $TRL;
    private $dateDepot;
    private $nbProjet;
    private $tauxSub;
    private $description;
    private $subMax;
    private $budget;
    private $nbPartenaires;
    private $nbPays;
    private $linkAAP;
    //$comment ?

    /**
     * @return mixed
     */
    public function getLinkAAP()
    {
        return $this->linkAAP;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setLinkAAP($linkAAP)
    {
        $this->linkAAP = $linkAAP;
    }

    /**
     * @return mixed
     */
    public function getNbPays()
    {
        return $this->npPays;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setNbPays($npPays)
    {
        $this->npPays = $npPays;
    }    

    /**
     * @return mixed
     */
    public function getNbPartenaires()
    {
        return $this->npPartenaires;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setNbPartenaires($npPartenaires)
    {
        $this->npPartenaires = $npPartenaires;
    }

    /**
     * @return mixed
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return mixed
     */
    public function getSubMax()
    {
        return $this->subMax;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setSubMax($subMax)
    {
        $this->subMax = $subMax;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTauxSub() {
        return $this->tauxSub;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setTauxSub($tauxSub) {
        $this->tauxSub = $tauxSub;
    }

    /**
     * @return mixed
     */
    public function getNbProjet() {
        return $this->nbProjet;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setNbProjet($nbProjet) {
        $this->nbProjet = $nbProjet;
    }

    /**
     * @return mixed
     */
    public function getMontantMaxSub() {
        return $this->montantMaxSub;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setMontantMaxSub($montantMaxSub) {
        $this->montantMaxSub = $montantMaxSub;
    }

    /**
     * @return mixed
     */
    public function getDateDepot() {
        return $this->dateDepot;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setDateDepot($dateDepot) {
        $this->dateDepot = $dateDepot;
    }

    /**
     * @return mixed
     */
    public function getTRL() {
        return $this->TRL;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setTRL($TRL) {
        $this->TRL = $TRL;
    }

    /**
     * @return mixed
     */
    public function getCodeSource() {
        return $this->codeSource;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setCodeSource($codeSource) {
        $this->codeSource = $codeSource;
    }

    /**
     * @return mixed
     */
    public function getNomAAP() {
        return $this->nomAAP;
    }

    /**
     * @param mixed $nomAAP
     */
    public function setNomAAP($nomAAP) {
        $this->nomAAP = $nomAAP;
    }

    /**
     * @return mixed
     */
    public function getCodeAAP() {
        return $this->codeAAP;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setCodeAAP($codeAAP) {
        $this->codeAAP = $codeAAP;
    }




}