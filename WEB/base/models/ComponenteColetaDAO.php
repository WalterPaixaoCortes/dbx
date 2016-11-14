<?php

namespace app\models;

use yii\base\Exception;
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

    /**
     * @inheritdoc
     */
    public static function listAll()
    {
        return ComponenteColetaDAO::find()->select(['ID','Nome','Criacao','Alteracao'])->groupBy("Nome")->where(['tipo'=>'col', "Ativo"=>"1"])->all();
    }

    /**
     * @inheritdoc
     */
    public function remover()
    {
        $db = \Yii::$app->db;
        if($db->createCommand("Select count(*) as qnt From agendamentos_componentes Where idComponente like '".$this->Nome."';")->queryAll()[0]['qnt']>0){
            return false;
        }
        return $db->createCommand("Update componentescoletarefinamento Set Ativo = 0 Where Nome like '".$this->Nome."'")->execute();
    }

    public function adicionar($nome, $tipo, $proteinas){
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            foreach ($proteinas as $p){
                $db->createCommand("INSERT INTO componentescoletarefinamento (Nome, Tipo, Configuracao, Criacao, Alteracao) VALUES ('" . $nome . "', '" . $tipo . "','".$p."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);")->execute();
            }

            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            return false;
        }
        return true;
    }

}
