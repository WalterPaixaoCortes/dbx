<?php

namespace app\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

class ComponenteColetaDAO extends ComponenteDAO
{

    private $tipo = 'col';

    public static function tableName()
    {
        return "componentescoletarefinamento";
    }

    public static function findIdentity($id)
    {
        return ComponenteColetaDAO::findOne(['ID'=>$id]);
    }

    public function configuracaoComponente(){
        $db = \Yii::$app->db;
        return $db->createCommand("Select Nome, proteina, componenteVisual, Configuracao From componentescoletarefinamento Where Nome like '".$this->Nome."' ")->queryAll();
    }

    public function atualizarConfiguracaoComponente($proteinas, $visual){
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try{
            $db->createCommand("UPDATE componentescoletarefinamento SET componenteVisual = ".($visual>0?$visual:"NULL").", proteina = NULL Where nome like '".$this->Nome."';")->execute();
            foreach ($proteinas as $p) {
                $cmd = "UPDATE componentescoletarefinamento SET proteina = (Select id From proteinas where proteinas.nome like '".$p."' limit 1) where nome like '".$this->Nome."' AND Configuracao like '".$p."';";
                $db->createCommand($cmd)->execute();
            }
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
        return true;
    }

    public static function listAll()
    {
        return ComponenteColetaDAO::find()->select(['ID','Nome','Criacao','Alteracao'])->groupBy("Nome")->where(['tipo'=>'col', "Ativo"=>"1"])->all();
    }

    public function adicionar($nome, $proteinas){
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            foreach ($proteinas as $p){
                $db->createCommand("INSERT INTO componentescoletarefinamento (Nome, Tipo, Configuracao, Criacao, Alteracao) VALUES ('" . $nome . "', '" . $this->tipo . "','".$p."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);")->execute();
            }

            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
        return true;
    }

}
