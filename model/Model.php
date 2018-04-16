<?php
/**
 * Created by PhpStorm.
 * User: tangu
 * Date: 15/09/2017
 * Time: 10:26
 */

require (File::build_path(array('config','Conf.php')));

class Model
{

    static public $pdo;
    protected static $object;
    protected static $primary;

    public static function Init()
    {
        try {
            self::$pdo = new PDO('mysql:host=' . Conf::getHostname() . ';dbname=' . Conf::getDatabase(), Conf::getLogin(), Conf::getPassword(), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            if (Conf::getDebug()) echo $e->getMessage();
            else ControllerMain::erreur("Impossible d'acceder a l'application, veuillez contacter un administrateur du serveur");
            die();
        }
    }


    public static function selectAll()
    {
        try {
            $sql='SELECT * FROM ' . static::$object;
            $rep=Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'Model' . ucfirst(static::$object));
            return $rep->fetchAll();
        }
        catch (Exception $e) {
            return false;
        }
    }

    public static function select($primary_value)
    {
        try {
            $sql = 'SELECT * from ' . static::$object . ' WHERE ' . static::$primary . '=:primary';
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "primary" => $primary_value
            );
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'Model' . ucfirst(static::$object));
            $tab = $req_prep->fetchAll();
            if (empty($tab)) return false;
            return $tab[0];
        }
        catch (Exception $e) {return false;}
    }

    public static function delete($primary_value)
    {
        try {
            $sql = 'DELETE FROM '.static::$object.' WHERE ' . static::$primary . '=:primary';
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "primary" => $primary_value
            );
            $req_prep->execute($values);
            return true;
        } catch (Exception $e) {
            //return false;
            echo $e->getMessage();
        }
    }

    public static function update($data)  {
        try {
            $sql = 'UPDATE ' . static::$object . ' SET ';
            foreach ($data as $cle => $element) {
                if ($cle != static::$primary) $sql = $sql . ' ' . $cle . '=:' . $cle . ',';
            }
            $sql = rtrim($sql, ',') . ' Where ' . static::$primary . '=:' . static::$primary;
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->execute($data);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public static function save($data) {
        try {
            $sql = 'INSERT INTO ' . static::$object . ' (';
            foreach ($data as $cle => $element) {
                $sql = $sql . $cle . ',';
            }
            $sql = rtrim($sql,',') . ') VALUE (';
            foreach ($data as $cle => $element) {
                $sql = $sql . ':'.$cle.',';
            }
            $sql = rtrim($sql,',').')';
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->execute($data);
        }
        catch (Exception $e) {
            if($e->getCode()==23000) {echo $e;return false;}
            else ControllerMain::erreur(27);
        }
        return true;
    }

}

Model::Init();
