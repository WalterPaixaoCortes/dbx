<?php

namespace app\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

class ComponenteRefinamentoDAO extends ComponenteDAO
{
    private $tipo = 'ref';

    public static function tableName()
    {
        return "componentescoletarefinamento";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return ComponenteRefinamentoDAO::findOne(['ID'=>$id]);
    }

    /**
     * @inheritdoc
     */
    public static function listAll()
    {
        return ComponenteRefinamentoDAO::find()->select(['ID','Nome','Criacao','Alteracao'])->groupBy("Nome")->where(['tipo'=>'ref', "Ativo"=>"1"])->all();
    }

    public function adicionar($nome){
        $db = \Yii::$app->db;
        try {
            $db->createCommand("INSERT INTO componentescoletarefinamento (Nome, Tipo, Criacao, Alteracao) VALUES ('" . $nome . "', '" . $this->tipo . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);")->execute();
        }catch (Exception $e){
            return false;
        }
        return true;
    }

}
