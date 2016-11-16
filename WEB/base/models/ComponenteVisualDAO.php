<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class ComponenteVisualDAO extends ActiveRecord
{

    public static function tableName()
    {
        return "componentesvisuais";
    }

    public static function findIdentity($id)
    {
        return ComponenteVisualDAO::findOne(['ID'=>$id]);
    }

    public static function listAll()
    {
        return ComponenteVisualDAO::find()->all();
    }

    public function remover()
    {
        if(Yii::$app->db->createCommand("Select count(*) as count from componentescoletarefinamento where componentevisual = ".$this->ID)->queryAll()[0]['count'] > 0){
            return false;
        }
        return (ComponenteVisualDAO::deleteAll('ID = '.$this->ID) > 0);
    }

}
