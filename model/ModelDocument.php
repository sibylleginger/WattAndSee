<?php

require_once File::build_path(array('model', 'Model.php'));

/**
 * Class ModelUser
 */
class ModelUser extends Model
{

    /**
     * @var string
     */
    protected static $object = 'User';
    /**
     * @var string
     */
    protected static $primary = 'mailUser';

    /**
     * @var null
     */
    private $mailUser;
    /**
     * @var null
     */
    private $passwordUser;
    /**
     * @var null
     */
    private $admin;

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return mixed
     */
    public function getMailUser()
    {
        return $this->mailUser;
    }

    /**
     * @return mixed
     */
    public function getPasswordUser()
    {
        return $this->passwordUser;
    }

    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    /**
     * ModelUser constructor.
     * @param null $mail
     * @param null $password
     * @param null $admin
     */
    public function __construct($mail = null, $password = null, $admin = null)
    {
        if (!is_null($admin) && !is_null($mail) && !is_null($password)) {
            $this->admin = $admin;
            $this->mailUser = $mail;
            $this->passwordUser = $password;
        }
    }

    /**
     * Vérifie la correspondance de login/mdp_chiffré avec les informations de la BDD
     * true si les valeurs correspondent, false sinon
     *
     * @param $login string
     * @param $mot_de_passe_chiffre string
     * @return bool
     */
    public static function checkPassword($login, $mot_de_passe_chiffre)
    {
        $user = ModelUser::select($login);
        if (!$user) return false;
        if ($user->getPasswordUser() == $mot_de_passe_chiffre) {
            return true;
        }
        return false;
    }

    /**
     * Met à jour les informations de l'utilisateur, return true si ça marche, false sinon
     *
     * @param $data array avec les inforamtions à maj
     * @return bool
     */
    public static function update($data)
    {
        try {
            $sql = 'UPDATE User SET mailUser=:mailUser , passwordUser=:passwordUser WHERE mailUser=:ancienMail';
            $rep = Model::$pdo->prepare($sql);
            $rep->execute($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Met un utilisateur (identifié par son mail) administrateur, à utiliser avec précaution
     *
     * @param $mailUser string
     * @return bool
     */
    public static function setAdmin($mailUser)
    {
        try {
            $sql = 'UPDATE User SET admin=1 WHERE mailUser=:mailUser';
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "mailUser" => $mailUser
            );
            $req_prep->execute($values);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}