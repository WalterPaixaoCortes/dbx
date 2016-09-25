<?php

namespace app\models;

use yii\db\ActiveRecord;

class ComponenteColetaDAO extends ActiveRecord
{

    public static function tableName()
    {
        return "componentescoletarefinamento";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return UserDAO::find()->where(['ID' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function listAll()
    {
        return ComponenteColetaDAO::find()->where(['tipo'=>'col'])->all();
    }

}
