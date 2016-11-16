<?php

namespace app\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

class ComponenteDAO extends ActiveRecord
{
    public static function tableName()
    {
        return "componentescoletarefinamento";
    }

    public static function findIdentity($id)
    {
        return ComponenteDAO::findOne(['ID'=>$id]);
    }

    public static function listAll()
    {
        return ComponenteDAO::find()->select(['ID','Nome','Criacao','Alteracao'])->groupBy("Nome")->where(["Ativo"=>"1"])->all();
    }

    public function remover()
    {
        $db = \Yii::$app->db;
        if($db->createCommand("Select count(*) as qnt From agendamentos_componentes inner join agendamentos on agendamentos.id = agendamentos_componentes.idAgendamento Where agendamentos.ativo = 1 And idComponente like '".$this->Nome."';")->queryAll()[0]['qnt']>0){
            return false;
        }
        return $db->createCommand("Update componentescoletarefinamento Set Ativo = 0 Where Nome like '".$this->Nome."'")->execute();
    }

}
