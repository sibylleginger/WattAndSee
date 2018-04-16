<?php
require_once File::build_path(array('model','Model.php'));

/**
 * Class ModelClasse
 */
class ModelClasse extends Model
{

    protected static $object = 'Classe';
    protected static $primary = 'nomClasse';

    private $nomClasse;
    private $codeDiplome;
    private $effectifClasse;

}