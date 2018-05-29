<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelProjet.php'));

class ModelTheme extends Model
{

    protected static $object = 'Theme';
    protected static $primary = 'codeTheme';

    private $codeTheme;
    /**
     * @var $codeStatut ModelStatutthème
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
     * Retourne le thème désigné par son code thème, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|Modelthème
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
     * Renvoie la liste des tous les thèmes
     * TODO implémenter une fonction de page ?
     *
     * @return bool|array(ModelTheme)
     *
     * @uses  Model::selectAll()
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        return $retourne;
    }
}