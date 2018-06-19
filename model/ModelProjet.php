<?php
//DONE
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelDocument.php'));
require_once File::build_path(array('model', 'ModelSourceFin.php'));
require_once File::build_path(array('model', 'ModelTheme.php'));

class ModelProjet extends Model
{
    //Nom de la table
    //Table name
    protected static $object = 'Projet';
    //Clé de la table
    //Table key
    protected static $primary = 'codeProjet';
    //nombre de projets à afficher par page
    //Number of project to display per page
    protected static $valeursParPage = 30;

    //Données
    //Data
    private $codeProjet;
    /**
     * @var $statut ModelStatutProjet
     */
    private $nomProjet;
    private $description;
    private $dateDepot; //YYYY-MM-DD
    private $dateReponse; //YYYY-MM-DD
    private $statut; //accepté/refusé/déposé
    private $role; //coordinateur ou partenaire
    private $budgetTotal;
    private $budgetEDF;
    private $subventionTotal;
    private $subventionEDF;
    private $isExceptionnel;
    /**
     * @var $codeSourceFin ModelSourceFin
     */
    private $codeSourceFin;
    /**
     * @var $codeTheme ModelTheme
     */
    private $codeTheme;

    /**
     * @return mixed
     */
    public function getCodeTheme()
    {
        return $this->codeTheme;
    }

    /**
     * @return mixed
     */
    public function getBudgetTotal()
    {
        return $this->budgetTotal;
    }

    /**
     * @return mixed
     */
    public function getBudgetEDF()
    {
        return $this->budgetEDF;
    }

    /**
     * @return mixed
     */
    public function getSubventionTotal()
    {
        return $this->subventionTotal;
    }

    /**
     * @return mixed
     */
    public function getSubventionEDF()
    {
        return $this->subventionEDF;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCodeSourceFin()
    {
        return $this->codeSourceFin;
    }

    /**
     * @return mixed
     */
    public function getcodeProjet()
    {
        return $this->codeProjet;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getNomProjet()
    {
        return $this->nomProjet;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return mixed
     */
    public function getDateDepot()
    {
        return $this->dateDepot;
    }

    /**
     * @return mixed
     */
    public function getDateReponse()
    {
        return $this->dateReponse;
    }

    /**
     * @return mixed
     */
    public static function getNbP()
    {
        return self::$valeursParPage;
    }

    /**
     * Retourne le projet désigné par son code projet, false s'il y a une erreur ou qu'il n'existe pas
     *
     * @param $primary_value
     * @return bool|ModelProjet
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
     * Ajoute un nouvel élément dans la table Projet. Retourne le code du projet enregistré ou false s'il y une erreur
     * Adds a new element in the Projet table. Returns le code of the saved project or false if there's an error
     *
     * @param $data array([column_name][value_column]) données du projet
     * @return bool|codeProjet int
     *
     * @uses  Model::save()
     */
    public static function save($data) {
        if (parent::save($data)) {
            return Model::$pdo->lastInsertId();
        }else return false;
    }

    /**
     * Renvoie la liste de tous les projets
     * Returns all the projects
     *
     * @return bool|array(ModelProjet)
     *
     * @uses  Model::selectAll()
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        return $retourne;
    }

    /**
     * Renvoie la liste des projets de la page demandée
     * Returns the project list corresponding to the page number
     *
     * @param $p int numéro de la page
     * @return bool|array(ModelProjet)
     *
     * @see ModelProjet::$valeursParPage
     */
    public static function selectByPage($p)
    {
        try {
            $debut = ($p - 1) * self::$valeursParPage;
            $sql = 'SELECT * FROM Projet ORDER BY nomProjet ASC LIMIT ' . $debut . ' , ' . self::$valeursParPage;
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Renvoie la liste des tous les projets de la source de financement
     * Returns all the projects of the funding program
     *
     * @param $codeSourceFin int code du programme
     * @return bool|array(ModelProjet)
     */
    public static function selectAllBySource($codeSourceFin)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeSourceFin=:codeSourceFin ORDER BY nomProjet ASC';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeSourceFin' => $codeSourceFin);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne tous les projets dont les caractéristiques correspondent aux conditions, dans la table Projet
     * Return all the projects corresponding to the conditions, in the table Projet
     *
     * @param $conditions array string, SQL conditions
     * @param $data array of values of the conditions
     * @return false|array(ModelProjet)
     */
    public static function searchBy($data, $conditions) {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE ';
            foreach ($conditions as $key => $value) {
                if ($key == count($conditions)-1) {
                    $sql .= $value;
                }else $sql .= $value . ' AND ';
            }
            $sql .= ' ORDER BY nomProjet';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute($data);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne tous les projets dont les caractéristiques correspondent aux conditions, dans la view ProjetSearch
     * Return all the projects corresponding to the conditions, in the view ProjetSearch
     *
     * @param $conditions array string, SQL conditions
     * @param $data array of values of the conditions
     * @return false|array(ModelProjet)
     */
    public static function searchByEntite($data, $conditions) {
        try {
            $sql = 'SELECT * FROM Projet P
            JOIN ProjetSearch S ON P.codeProjet = S.codeProjet
            WHERE ';
            foreach ($conditions as $key => $value) {
                if ($key == count($conditions)-1) {
                    $sql .= $value;
                }else $sql .= $value . ' AND ';
            }
            $sql .= ' ORDER BY P.nomProjet';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute($data);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les statuts et le nombre de projets par statut
     * Return a table with the status and the number of projects per status
     *
     * @return bool|array([prim][quantity])
     */
    public static function statStatutEtProjet()
    {
        try {
            $sql = 'SELECT P.statut as prim, count(P.codeProjet) as quantity
                    FROM Projet P
                    GROUP BY P.statut,statut;';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les entités et le nombre de projets par entités avec le même statut
     * Return a table with the entities and the number of projects per entity, with the same status
     *
     * @param $statut string statut des projets
     * @return bool|array([prim][quantity])
     */
    public static function statEntiteEtProjet($statut)
    {
        try {
            $sql = 'SELECT PS.nomEntite as prim, count(PS.codeProjet) as quantity
                    FROM ProjetSearch PS
                    WHERE statut=:statut
                    GROUP BY PS.nomEntite;';
            $rep = Model::$pdo->prepare($sql);
            $values = array('statut' => $statut);
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les programmes de financement et le nombre de projets par programme, avec le même statut
     * Return a table with the funding programs and the number of projects per program, with the same status
     *
     * @param $statut string
     * @return bool|array([prim][quantity])
     */
    public static function statProgrammeEtProjet($statut)
    {
        try {
            $sql = 'SELECT S.nomSourceFin as prim, count(P.codeProjet) as quantity
                    FROM Projet P, SourceFin S
                    WHERE P.statut=:statut AND P.codeSourceFin=S.codeSourceFin
                    GROUP BY S.nomSourceFin;';
            $rep = Model::$pdo->prepare($sql);
            $values = array('statut' => $statut);
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * Retourne un tableau avec les entités et le total du montant de tous les projets par entité, avec le même statut
     * Return a table with the entities and the projects' amount per entity, with the same status
     *
     * @param $statut/$montant, string statut/montant des projets
     * @return bool|array([prim][quantity])
     */
    public static function statEntiteEtMontant($montant,$statut)
    {
        try {
            $sql = 'SELECT PS.nomEntite as prim, SUM(PS.'.$montant.') as quantity
                    FROM ProjetSearch PS
                    WHERE statut=:statut
                    GROUP BY PS.nomEntite;';
            $rep = Model::$pdo->prepare($sql);
            $values = array('statut' => $statut);
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec l'année de dépot, le statut des projets et le nombre de projets par statut et par année
     * Return a table with the submission year, the projects' status and the number of projects per status and per year 
     *
     * @param $startG/$endG date début/fin, $statuts array(string) statuts des projets
     * @return bool|array([prim][bar][quantity])
     */
    public static function statNbProjet($startG,$endG,$statuts)
    {
        try {
            $sql = 'SELECT DATE_FORMAT(dateDepot, "%Y") as prim, statut as bar, count(codeProjet) as quantity
                    FROM Projet P
                    WHERE';
            foreach ($statuts as $key => $value) {
                $sql .= ' (dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut'.$key. ') OR';
                
            }
            $sql = rtrim($sql, ' OR');
            $sql .= ' GROUP BY DATE_FORMAT(dateDepot,"%Y"), statut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('startG' => $startG,
                            'endG' => $endG);
            foreach ($statuts as $key => $value) {
                $values['statut'.$key] = $value;
            }
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec l'année de dépot et le total de chaque montants des projets avec le même statut par année de dépot
     * @param exceptionnel est un booléen qui permet d'inclure les montants des projets exceptionnels ou non.
     * Return a table with the submission year and the projects' amounts, with the same status per year.
     * @param exceptionnel is a boolean which allows to include the exceptionnal projects.
     *
     * @param $startG/$endG date début/fin, $statut string statut des projets, $montants array(string) montants des projets
     * @return bool|array([prim][valueX])
     */
    public static function statMontantProjet($startG,$endG,$statut,$montants,$exceptionnel)
    {
        try {
            $sql = 'SELECT DATE_FORMAT(dateDepot, "%Y") as prim';
            foreach ($montants as $key => $value) {
                $sql .= ', SUM('.$value.') as value'.$key;
            }
            $sql .= ' FROM Projet P
                    WHERE dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut';
            if ($exceptionnel == false) {
                $sql .= ' AND isExceptionnel=0';
            }
            $sql .= ' GROUP BY DATE_FORMAT(dateDepot, "%Y")';
            $rep = Model::$pdo->prepare($sql);
            $values = array('startG' => $startG,
                            'endG' => $endG,
                            'statut' => $statut);
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les statuts, et le total de chaque montants des projets répartis par statut.
     * @param exceptionnel est un booléen qui permet d'inclure les montants des projets exceptionnels ou non.
     * Return a table with the status, and the amounts per status.
     * @param exceptionnel is a boolean which allows to include the exceptionnal projects.
     *
     * @param $startG/$endG date, $statuts array(string), $montants array(string), $exceptionnel boolean
     * @return bool|array([prim][valueX])
     */
    public static function statMontantStatutProjet($startG,$endG,$statuts,$montants,$exceptionnel)
    {
        try {
            $sql = 'SELECT statut as prim';
            foreach ($montants as $key => $value) {
                $sql .= ', SUM('.$value.') as value'.$key;
            }
            $sql .= ' FROM Projet P
                    WHERE';
            foreach ($statuts as $key => $value) {
                if ($exceptionnel == false) {
                    $sql .= ' (isExceptionnel=0 AND dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut'.$key. ') OR';
                }else {
                    $sql .= ' (dateDepot<=:endG AND dateDepot>=:startG AND statut=:statut'.$key. ') OR';
                }
            }
            $sql = rtrim($sql, ' OR');
            $sql .= ' GROUP BY statut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('startG' => $startG,
                            'endG' => $endG);
            foreach ($statuts as $key => $value) {
                $values['statut'.$key] = $value;
            }
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }
}