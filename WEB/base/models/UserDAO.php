<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserDAO extends ActiveRecord implements \yii\web\IdentityInterface
{

    public static function tableName()
    {
        return "usuarios";
    }

    public static function findIdentity($id)
    {
        return UserDAO::find()->where(['id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return UserDAO|null
     */
    public static function findByUsername($username)
    {
        return UserDAO::find()->where(['username'=>$username])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password."DBX_Senha_MD5_2016");
    }
}
