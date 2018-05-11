<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ModelTheme extends Model
{

    protected static $object = 'Theme';
    protected static $primary = 'codeTheme';

    private $codeTheme;
    /**
     * @var $codeStatut ModelStatutEnseignant
     */
    private $nomTheme;
     /**
     * @return mixed
     */
    public function getCodeTheme()
    {
        return $this->codeTheme;
    }

    /**
     * @param mixed $codeStatut
     */
    public function setCodeTheme($codeTheme)
    {
        $this->codeTheme = $codeTheme;
    }

    /**
     * @return mixed
     */
    public function getNomTheme()
    {
        return $this->nomTheme;
    }

    /**
     * @return mixed
     */
    public function setNomTheme($nomTheme)
    {
        $this->nomTheme = $nomTheme;
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
        return $retourne;
    }
}