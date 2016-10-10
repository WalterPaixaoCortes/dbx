<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db;

class ProteinaDAO extends ActiveRecord
{

    public static function tableName()
    {
        return "proteinas";
    }

    public static function findIdentity($id)
    {
        return ProteinaDAO::findOne(['id'=>$id]);
    }

    public function adicionar($nome, $estrutura, $dados = null){
        $this->nome = $nome;
        $this->estrutura = $estrutura;
        $this->dados = $dados;
        return $this->save();
    }

    public function remover()
    {
        $p = \Yii::$app->db->createCommand("Select count(*) as n from ((SELECT DISTINCT(proteina) FROM `componentescoletarefinamento` where proteina = ".$this->id.") UNION (Select DISTINCT(proteina) FROM artigos where proteina = ".$this->id.")) as a")->queryAll();
        if($p[0]['n'] > 0){
            return false;
        }
        return (ProteinaDAO::deleteAll('id = '.$this->id) > 0);
    }

    /**
     * @inheritdoc
     */
    public static function listPag($start = 0, $count = 10, $nome = '')
    {
        $where = '';
        if($nome != '') {
            $where = "where proteinas.nome like '%" . $nome . "%' ";
        }
        $q = \Yii::$app->db->createCommand('Select * from proteinas '.$where.' limit '.$count.' offset '.$start)->queryAll();
        return $q;
    }

    public static function countPags($start = 0, $count = 10, $nome = '')
    {
        $where = '';
        if($nome != '') {
            $where = "where proteinas.nome like '%" . $nome . "%' ";
        }
        $q = \Yii::$app->db->createCommand('Select count(*) as pags from proteinas '.$where)->queryAll();

        return (int)($q[0]['pags']/$count)+1;
    }
}
