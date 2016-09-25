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
        return ComponenteColetaDAO::findOne(['ID'=>$id]);
    }

    /**
     * @inheritdoc
     */
    public static function listAll()
    {
        return ComponenteColetaDAO::find()->where(['tipo'=>'col'])->all();
    }

    /**
     * @inheritdoc
     */
    public function remover()
    {
        return (ComponenteColetaDAO::deleteAll('ID = '.$this->ID) > 0);
    }

}
