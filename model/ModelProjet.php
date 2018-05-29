<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelDocument.php'));
require_once File::build_path(array('model', 'ModelSourceFin.php'));
require_once File::build_path(array('model', 'ModelTheme.php'));

class ModelProjet extends Model
{
    //WAS Projet
    protected static $object = 'Projet';
    protected static $primary = 'codeProjet';
    protected static $valeursParPage = 30;

    private $codeProjet;
    /**
     * @var $statut ModelStatutProjet
     */
    private $nomProjet;
    private $description;
    private $dateDepot;
    private $dateReponse;
    private $statut; //accepté/refusé/déposé
    private $role; //coordinateur ou partenaire
    private $budgetTotal;
    private $budgetEDF;
    private $subventionTotal;
    private $subventionEDF;
    private $isExceptionnel;
    /**
     * @var $codeAAP ModelAAP
     */
    //private $codeAAP;
    //ou
    private $codeSourceFin;

    //private $codeType;
    //private $codeContactEDF;
    //private $codeContactExterne;
    private $codeConsultant;
    private $codeTheme;

    /**
     * @return mixed
     */
    public function getCodeTheme()
    {
        return $this->codeTheme;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setCodeTheme($codeTheme)
    {
        $this->codeTheme = $codeTheme;
    }

    /**
     * @return mixed
     */
    public function getCodeConsultant()
    {
        return $this->codeConsultant;
    }

    /**
     * @param mixed $codeConsultant
     */
    public function setCodeConsultant($codeConsultant)
    {
        $this->codeConsultant = $codeConsultant;
    }

    /**
     * @return mixed
     */
    public function getBudgetTotal()
    {
        return $this->budgetTotal;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setBudgetTotal($budgetTotal)
    {
        $this->budgetTotal = $budgetTotal;
    }

    /**
     * @return mixed
     */
    public function getBudgetEDF()
    {
        return $this->budgetEDF;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setBudgetEDF($budgetEDF)
    {
        $this->budgetEDF = $budgetEDF;
    }

    /**
     * @return mixed
     */
    public function getSubventionTotal()
    {
        return $this->subventionTotal;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setSubventionTotal($subventionTotal)
    {
        $this->subventionTotal = $subventionTotal;
    }

    /**
     * @return mixed
     */
    public function getSubventionEDF()
    {
        return $this->subventionEDF;
    }

    /**
     * @param mixed $codeAAP
     */
    public function setSubventionEDF($subventionEDF)
    {
        $this->subventionEDF = $subventionEDF;
    }

    /**
     * @return mixed
     
    public function getContactEDF()
    {
        return $this->codeContactEDF;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
     * @param mixed $codeAAP
     */
    public function setCodeSourceFin($codeSourceFin)
    {
        $this->codeSourceFin = $codeSourceFin;
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
     * @param mixed $statut
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
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
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getDateDepot()
    {
        return $this->dateDepot;
    }

    /**
     * @param mixed $etat
     */
    public function setDateDepot($dateDepot)
    {
        $this->dateDepot = $dateDepot;
    }

    /**
     * @return mixed
     */
    public function getDateReponse()
    {
        return $this->dateReponse;
    }

    /**
     * @param mixed $etat
     */
    public function setDateReponse($dateReponse)
    {
        $this->dateReponse = $dateReponse;
    }

    /**
     * @return mixed
     */
    public static function getNbP()
    {
        return self::$valeursParPage;
    }

    /**
     * Retourne le projet désigné par son code Projet, false s'il y a une erreur ou qu'il n'existe pas
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
        //$retourne->setCodeSourceFin(ModelSourceFin::select($retourne->getCodeSourceFin()));
            //$retourne->setCodeConsortium(ModelConsortium::select($retourne->getCodeConsortium()));
            //$retourne->setCodeCo(ModelReporting::select($retourne->getCodeReporting()));
            //$retourne->setCodeChef(ModelChef::select($retourne->getCodeChef()));
            //$retourne->setCodeConsultant(ModelConsultant::select($retourne->getCodeConsultant()));
            //$retourne->setCodeTheme(ModelImplication::select($retourne->getCodeTheme()));
        return $retourne;
    }

    /**
     * @deprecated
     * Renvoie la liste des tous les Projets
     * TODO implémenter une fonction de page ?
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
     * @deprecated
     * renvoie @see ModelProjet::$valeursParPage de la page donnée en paramètre
     *
     * @param $p int
     * @return bool|array(ModelProjet)
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

    public static function countBySource($codeSourceFin) {
        try {
            $sql = 'SELECT * FROM Projets WHERE codeSourceFin=:codeSourceFin';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeSourceFin' => $codeSourceFin);
            $rep->execute($values);
            var_dump($rep);
            return $rep->rowCount();
        } catch (Exception $e) {
            return false;
        }
    }

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
     * Retourne tous les Projets avec un nom/prenom proche de $npProjet
     * TODO supprimer l'attribut prénom
     *
     * @param $npProjet string nom/prenom d'un Projet
     * @return bool|array(ModelProjet)
     */
    public static function selectAllByMotCle($npProjet)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nomProjet LIKE CONCAT(\'%\',:npProjet,\'%\')';
            $rep = Model::$pdo->prepare($sql);
            $values = array('npProjet' => $npProjet);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProjet');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne->setCodeAAP(ModelAAP::select($retourne->getCodeAAP()));
                //$retourne->setCodeConsortium(ModelConsortium::select($retourne->getCodeConsortium()));
                $retourne->setCodeReporting(ModelReporting::select($retourne->getCodeReporting()));
                $retourne->setCodeChef(ModelChef::select($retourne->getCodeChef()));
                $retourne->setCodeConsultant(ModelConsultant::select($retourne->getCodeConsultant()));
                $retourne->setCodeTheme(ModelImplication::select($retourne->getCodeTheme()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un tableau avec les statuts et le nombre de projets par statut
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
            return $e;
        }
    }

    /**
     * Retourne un tableau avec les entités et le nombre de projets par entités
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
            return $e;
        }
    }

    public static function statEntiteEtMontant($statut)
    {
        try {
            $sql = 'SELECT PS.nomEntite as prim, SUM(PS.subventionEDF) as quantity
                    FROM ProjetSearch PS
                    WHERE statut=:statut
                    GROUP BY PS.nomEntite;';
            $rep = Model::$pdo->prepare($sql);
            $values = array('statut' => $statut);
            $rep->execute($values);
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne;
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function statNbProjet($startG,$endG,$statuts) //$sort = %Y pour année
    {
        try {
            $sql = 'SELECT DATE_FORMAT(dateDepot, "%Y") as prim, statut, count(codeProjet) as quantity
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
            return $sql;
        }
    }

    public static function statMontantProjet($startG,$endG,$statut,$montants,$exceptionnel) //$sort = %Y pour année
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
            return $sql;
        }
    }

    //EN COURS

    /**
     * @return date : échéance dépot du projet
        DEPENDS IF AAP OR NOT
     
    public function getDateDepot()
    {
        $sql = 'SELECT dateDepot
                FROM AAP
                JOIN projet P ON AAP.codeAAP = P.codeAAP
                WHERE P.codeAAP=:codeAAP';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->getcodeProjet(),
            'codeAAP' => $this->codeAAP));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }*/

    /**
     * @return string : nom du statut du projet
     
    public function getDateNotification()
    {
        $sql = 'SELECT dateReponse
                FROM Reporting
                JOIN Projet P ON Reporting.codeReporting = P.codeReporting
                WHERE P.codeReporting=:codeReporting';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->codeProjet,
            'codeReporting' => $this->codeReporting));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }*/

    /**
     * @return string : implicationde EDF dans le projet
     
    public function getProgrammeFin()
    {
        $sql = 'SELECT nomSource
                FROM SourceFinancement
                JOIN Projet P ON SourceFinancement.codeSource = P.codeSourceFin
                WHERE P.codeSourceFin=:codeSourceFin
                AND P.codeProjet=:codeProjet';
        $rep = Model::$pdo->prepare($sql);
        $rep->execute(array(
            'codeProjet' => $this->codeProjet,
            'statut' => $this->statut));
        $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $retourne;
    }*/

}